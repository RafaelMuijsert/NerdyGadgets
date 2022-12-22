# NerdyGadgets

A beautiful and complete webshop


## Project structure
Please see https://github.com/php-pds/skeleton

## Dependencies
- A web server (apache is recommended)
- PHP (tested with version 7.4+) with the following extensions: mysqli, intl
- Composer

## Setup
Copy the .env.example file to .env and update the variables.

### Development with Docker
To set up a development-ready environment with Docker, simply navigate to the project root and run the following command:
```bash
$ docker compose -f docker-compose.dev.yaml up --build
```

### Manual setup
Edit php.ini and add the following line under [PHP]:
```
extension=intl
```
If you are using XAMPP, the mysqli extension should be enabled by default. 
If this is not the case, or if you are hosting the server a different way, repeat the above step with the mysqli extension.

Lastly, install the composer dependencies by navigating to the project root and running the following command:
```bash
$ composer install
```

Make sure the web server root is set to public/ and not to the project root.

### Using docker-compose (recommended)
Provided below are a couple of example docker-compose files.
Don't forget to create a .env file containing all deployment-specific variables. 
It is recommended that you copy the .env.example file found in the project root.
#### NerdyGadgets
```yaml
version: "3.3"
services:
  nerdygadgets:
    build: 'https://github.com/hemmeDev/NerdyGadgets.git#main'
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
    build: 'https://github.com/hemmeDev/NerdyGadgets.git#main'
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

## Testing
Given below is the shell command that can be used to connect to the primary database in case you want to perform manual operations.
```bash
$ sudo mariadb --host='nerdygadgets.shop' --port=33646 --user='nerd' --password='[PASSWORD]' 'nerdygadgets'
```

