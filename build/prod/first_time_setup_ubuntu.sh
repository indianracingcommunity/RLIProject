#!/bin/sh

set -e

# Install Docker
for pkg in docker.io docker-doc docker-compose podman-docker containerd runc; 
    do sudo apt-get remove -y $pkg;
done

sudo apt-get update -y
sudo apt-get install -y ca-certificates curl gnupg

sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch="$(dpkg --print-architecture)" signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  "$(. /etc/os-release && echo "$VERSION_CODENAME")" stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update -y
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Permission setup post docker install
sudo groupadd docker || true
sudo usermod -aG docker $USER || true

# Check if .env & database have been added
DB_DATABASE=$(awk '/DB_DATABASE=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
APP_ENV=$(awk '/APP_ENV=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
if [ -z "$DB_DATABASE" ] || [ ! -d "../../setup/$APP_ENV/db/$DB_DATABASE" ]
then
  echo 'Environment Variable and/or Database not setup'
  exit 1
fi

# Create DB Backup folder
mkdir -p ../../storage/backups
mkdir -p ../../storage/signups

SERVER_NAME='irc-server';
CERTBOT_DATA_PATH="../../setup/$APP_ENV/certbot"
WEBSITE_EMAIL=$(awk '/WEBSITE_EMAIL=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
WEBSITE_DOMAIN=$(awk '/WEBSITE_DOMAIN=/' ../../.env | awk '{split($0,a,"="); print a[2]}');

mkdir -p $CERTBOT_DATA_PATH
if [ ! -e "$CERTBOT_DATA_PATH/conf/options-ssl-nginx.conf" ] || [ ! -e "$CERTBOT_DATA_PATH/conf/ssl-dhparams.pem" ]; then
  echo "Downloading recommended TLS parameters ..."
  mkdir -p "$CERTBOT_DATA_PATH/conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot-nginx/certbot_nginx/_internal/tls_configs/options-ssl-nginx.conf > "$CERTBOT_DATA_PATH/conf/options-ssl-nginx.conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot/certbot/ssl-dhparams.pem > "$CERTBOT_DATA_PATH/conf/ssl-dhparams.pem"
fi

echo "Creating dummy certificate for $WEBSITE_DOMAIN ..."
CERTBOT_DOCKER_PATH="/etc/letsencrypt/live/$WEBSITE_DOMAIN"
mkdir -p "$CERTBOT_DATA_PATH/conf/live/$WEBSITE_DOMAIN"
docker compose run --rm --entrypoint "\
  openssl req -x509 -nodes -newkey rsa:4096 -days 1\
    -keyout '$CERTBOT_DOCKER_PATH/privkey.pem' \
    -out '$CERTBOT_DOCKER_PATH/fullchain.pem' \
    -subj '/CN=localhost'" certbot
echo

echo "Starting docker containers ..."
docker compose -f ../../docker-compose.yml up $SERVER_NAME --build -d

echo "Deleting dummy certificate for $WEBSITE_DOMAIN ..."
docker compose run --rm --entrypoint "\
  rm -Rf /etc/letsencrypt/live/$WEBSITE_DOMAIN && \
  rm -Rf /etc/letsencrypt/archive/$WEBSITE_DOMAIN && \
  rm -Rf /etc/letsencrypt/renewal/$WEBSITE_DOMAIN.conf" certbot

docker compose run --rm --entrypoint "\
  certbot certonly --webroot -w /var/www/certbot \
    -d $WEBSITE_DOMAIN \
    --email $WEBSITE_EMAIL \
    --rsa-key-size 4096 \
    --agree-tos --non-interactive \
    --force-renewal" certbot

echo "Reloading nginx ..."
docker compose exec $SERVER_NAME nginx -s reload

# Deploy latest changes
REMOTE_BRANCH="$(git branch --show-current)"
./deploy.sh $REMOTE_BRANCH

# Setup crons
echo "Setting up crons"
PROJECT_DIR=$(awk '/PROJECT_DIR=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
# Run cron: Every hour
crontab -l | { cat; echo "0 * * * * cd $PROJECT_DIR && \
    php artisan schedule:run >> /dev/null 2>&1"; } | crontab -

# Run cron: At 04:00, on day 5 of the month
crontab -l | { cat; echo "0 4 5 * * cd $PROJECT_DIR && \
    docker compose run --rm --entrypoint \"certbot renew --non-interactive\" certbot && \
    docker compose exec $SERVER_NAME nginx -s reload >> /dev/null 2>&1"; } | crontab -