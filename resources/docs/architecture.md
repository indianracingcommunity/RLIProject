# Tech Stack
## Backend:
1. PHP - 8.0.18
1. Laravel - v6.20.44
1. ImageMagick - v2.7.2
1. Tesseract OCR - v2.12.0
1. Oracle - aarch64 (arm64v8)
1. CloudFlare - Proxy

## Frontend
1. HTML
1. Tailwind CSS v1.5.1
1. jQuery v3.5.1

<br>

# Code Structure

![IRC Code Structure](./code-structure.svg)

## Build
* Docker
    * Dockerfile -> [Dockerfile](../../Dockerfile)
    * Dev container -> [.devcontainer/devcontainer.json](../../.devcontainer/devcontainer.json)
    * Docker compose - Dev -> [docker-compose.dev.yml](../../docker-compose.dev.yml)
    * Docker compose Test -> [docker-compose.test.yml](../../docker-compose.test.yml)
    * Docker compose Prod -> [docker-compose.yml](../../docker-compose.yml)
* Workflows
    * CI - Run Tests -> [.github/workflows/build.yml](../../.github/workflows/build.yml)
    * CD - Deploy to Prod -> [.github/workflows/deploy.yml](../../.github/workflows/deploy.yml)
* Build configs & Scripts
    * for Prod -> [build/prod](../../build/prod/)
        * Nginx config -> [default](../../build/prod/default)
        * PHP config -> [php.ini](../../build/prod/php.ini)
        * Continuous Deployment script -> [deploy.sh](../../build/prod/deploy.sh)
        * First time setup script -> [first_time_setup_ubuntu.sh](../../build/prod/first_time_setup_ubuntu.sh)
        * DB user permissions & import script -> [mysql_user.sh](../../build/prod/mysql_user.sh)
    * for Test -> [build/testing](../../build/testing/)
* Linter config -> [.phpcs.xml](../../.phpcs.xml)
* Setup
    * DB -> setup/{APP_ENV}/db
    * SSL Certificates -> setup/{APP_ENV}/certbot
* Environment file -> .env
## Backend
* Composer file -> [composer.json](../../composer.json)
* PHPUnit -> [phpunit.xml](../../phpunit.xml)
* App
    * Models -> [app/](../../app/)
    * Actions -> [app/Actions](../../app/Actions/)
    * Console -> [app/Console](../../app/Console/)
    * Middleware -> [app/Http/Middleware](../../app/Http/Middleware)
    * Controllers -> [app/Http/Controllers](../../app/Http/Controllers)
* Database
    * Migrations -> [database/migrations](../../database/migrations)
    * Factories -> [database/factories](../../database/factories)
    * Seeds -> [database/seeds](../../database/seeds)
* Routes
    * Web -> [routes/web.php](../../routes/web.php)
    * API -> [routes/api.php](../../routes/api.php)
## Frontend
* Package file -> [package.json](../../package.json)
* Tailwind config -> [tailwind.config.js](../../tailwind.config.js)
* Public assets -> [public](../../public/)
* Storage -> [storage](../../storage/)
    * Signups -> storage/signups
    * DB backups -> storage/backups
* CSS scripts -> [public/css](../../public/css)
* Views -> [resources/views](../../resources/views)

## Docs
* Readme -> [readme.md](../../readme.md)
* License -> [license.md](../../license.md)
* Setup -> [resources/docs/setup.md](./setup.md)
* Architecture -> [resources/docs/architecture.md](./architecture.md)
* Linting -> [resources/docs/lint.md](./lint.md)
* Modules -> [resources/docs/modules.md](./modules.md)
* Environment example -> [.env.example](../../.env.example)

