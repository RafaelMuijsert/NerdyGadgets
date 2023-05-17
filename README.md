# NerdyGadgets

A beautiful and complete webshop


## Project structure
We used [this](https://github.com/php-pds/skeleton) skeleton to structure our project.

## Getting started
There are two ways of setting up a development environment for NerdyGadgets:
1. Using Docker
2. Manual setup

Regardless of the method you prefer, you must first configure a couple environment variables. 
Head to the project root and copy the provided `.env.example` file to `.env` 

Then simply edit the variables inside `.env` to fit your needs.

### Using Docker
Setting up a development environment using Docker is very easy. Simply navigate to the project root and run the following shell command:
```bash
$ docker compose -f docker-compose.dev.yaml up --build
```
This will take care of setting up the environment. Any changes made will be immediately reflected since the project root is mounted as a volume.

### Manual setup
To configure a development environment manually, you must first install the following dependencies:
- A web server (apache is recommended)
- PHP (tested with version 7.4+) with the following extensions: mysqli, intl
- Composer

Navigate to the project root and install the required PHP dependencies
```bash
$ composer install
```
Configure the web server so that the document root is pointed to public/

## Deployment using docker-compose (recommended)
Provided below are a couple of example docker-compose files.
Remember to create a .env file containing all deployment-specific variables. 
It is recommended that you copy the .env.example file found in the project root.
#### NerdyGadgets
```yaml
version: "3.3"
services:
  nerdygadgets:
    build: 'https://github.com/RafaelMuijsert/NerdyGadgets.git#main'
    restart: always
    ports:
      - 80:80
    env_file:
      - .env
```
#### With MariaDB:
```yaml
version: "3.3"
services:
  nerdygadgets:
    build: 'https://github.com/RafaelMuijsert/NerdyGadgets.git#main'
    restart: always
    ports:
      - 80:80
    env_file:
      - .env

  db:
    image: mariadb
    restart: always
    ports:
      - 33646:3306
    environment:
      MARIADB_RANDOM_ROOT_PASSWORD: 'true'
    volumes:
      - ./db:/var/lib/mysql
```
