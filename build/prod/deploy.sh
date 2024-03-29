#!/bin/sh

IRC_APP="irc-app"
SERVER_NAME="irc-server"
deploy() {
    REMOTE_BRANCH="$(git branch --show-current)"

    # Check if branch argument is missing
    if [ -z "$1" ]; then
        echo "Branch of repository not supplied as argument"
        exit 2
    fi

    # Check if branch argument is the same as the branch present in remote env.
    if [ "$1" != "$REMOTE_BRANCH" ]; then
        echo "Remote branch not matching the branch being pushed"
        exit 22
    fi

    echo "Deploying application ..."

    # Enter maintenance mode
    (docker compose exec $IRC_APP php artisan down) || true

        # Update codebase
        git fetch origin "$1"
        git pull origin "$1"

        # Install dependencies based on lock file
        docker compose exec $IRC_APP composer install --no-interaction --no-dev --no-scripts --prefer-dist --optimize-autoloader

        # Migrate database
        docker compose exec $IRC_APP php artisan migrate

        # Clear cache
        docker compose exec $IRC_APP php artisan optimize:clear

        # Reload PHP
        docker restart $IRC_APP

    # Waiting for service to run
    sleep 3

    # Reload Nginx
    docker compose exec $SERVER_NAME nginx -s reload

    # Exit maintenance mode
    docker compose exec $IRC_APP php artisan up

    echo "Application deployed!"
}

deploy $1
# If service is not running, notify admins
if [ "$?" -ne 0 ] || [ "$( docker container inspect -f '{{.State.Running}}' $IRC_APP )" = "false" ] || \
   [ "$( docker container inspect -f '{{.State.Running}}' $SERVER_NAME )" = "false" ]; then
    echo "Service is down!"

    # Retrieve environment variables
    DISCORD_BOT_KEY=$(awk '/DISCORD_BOT_KEY=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
    APP_ENV=$(awk '/APP_ENV=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
    ADMINS_NOTIFICATION_CHANNEL=$(awk '/ADMINS_NOTIFICATION_CHANNEL=/' ../../.env | awk '{split($0,a,"="); print a[2]}');
    if [ -z "$DISCORD_BOT_KEY" ] || [ -z "$ADMINS_NOTIFICATION_CHANNEL" ]; then
        echo "Discord credentials or notification channel missing."
        exit 3
    fi

    # Publish Discord notification to Admin
    curl -o /dev/null -s \
        -d "{\"content\":\"RLIProject Service environment: $APP_ENV is down!\"}" \
        -H "Content-Type: application/json" -H "Authorization: Bot $DISCORD_BOT_KEY" \
        -X POST "https://discord.com/api/channels/$ADMINS_NOTIFICATION_CHANNEL/messages"

    echo "Admins notified"

    exit 112
fi