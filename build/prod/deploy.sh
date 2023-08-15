#!/bin/sh

set -e

REMOTE_BRANCH="$(git branch --show-current)"
echo "Remote Branch = $REMOTE_BRANCH"
echo "Argument = $1"

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
(docker compose exec irc-app php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true

    # Update codebase
    git fetch origin "$1"
    git pull origin "$1"

    # Install dependencies based on lock file
    docker compose exec irc-app composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    docker compose exec irc-app php artisan migrate

    # Clear cache
    docker compose exec irc-app php artisan optimize

    # Reload PHP
    docker restart irc-app

# Waiting for service to run
sleep 3

# If service is not running, notify admins
if [ "$( docker container inspect -f '{{.State.Running}}' irc-app )" = "false" ]; then
    echo "Service is down!"
    # TODO: Notify admins

    exit 112
fi

# Exit maintenance mode
docker compose exec irc-app php artisan up

echo "Application deployed!"