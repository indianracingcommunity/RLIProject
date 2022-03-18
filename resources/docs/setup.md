# Project Setup

## Pre-requisites
1. Reach out to the Website Team for `.env` & `db` files
1. Download and install [Docker](https://docs.docker.com/engine/install/) for development

## Steps
1. Open the project with VSCode (recommended)
1. Install the Remote - Containers extension (ms-vscode-remote.remote-containers).
1. Click on the prompt on the bottom right to start the project with Remote Container.
1. Run `composer install` to install dependencies
1. You are good to go! The app is hosted to `http://localhost:8000`

## Usage
The project has been setup with Docker Compose. You can modify the [`docker-compose.dev.yml`](../../docker-compose.dev.yml) file to play around with the ports and services of the build. <br>
**Avoid pushing changes to this file on upstream**

1. Create a feature branch and create PRs whenever building a new feature.
1. If there is a change or error in build or state of any of the services, you can restart the project with `Ctrl+Shift+P -> Rebuild Container`
1. The project has been setup with a [linter](./lint.md). Files will show up in red when saved if it does not conform to the coding standard.
1. Use `Ctrl+Shift+P -> Format Document` to correct any resolvable errors by PHPCBF. If there are problems that persist, reach out to the team to appropriately resolve the problems.
1. Use `Ctrl+Shift+P -> Conventional Commits` when commiting code. It follows a standardized format, which will help in automating and adding to the Changelog.
1. Excalidraw for VS Code is enabled in the devcontainer. Feel free to add diagrams in the `resources/docs` folder.
1. Use `Ctrl+Shift+P -> Export to SVG` to export your excalidraw drawing to SVG, which you can then add to an .md file.
1. Use `Ctrl+Shift+P -> Remote: Close Remote Connection` to shutdown all containers.
