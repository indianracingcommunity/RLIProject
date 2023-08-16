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
if [ -z "$DB_DATABASE" ] || [ ! -d "../../setup/prod/db/$DB_DATABASE" ]
then
  echo 'Environment Variable and/or Database not setup'
  exit 1
fi

# Start the server
docker compose -f ../../docker-compose.yml up --build -d

# Deploy latest changes
REMOTE_BRANCH="$(git branch --show-current)"
./deploy.sh $REMOTE_BRANCH