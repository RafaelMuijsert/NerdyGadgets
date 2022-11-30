# NerdyGadgets

A beautiful webshop that just works™ on my machine.


## Project structure
Please see https://github.com/php-pds/skeleton

## Dependencies
- A web server (apache is preferred)
- PHP (tested with version 8.1.11)
- mysqli php extension

## Setup

Install the given database from the official Windesheim GitLab.
Run the following commands in a mariadb shell:
```sql
CREATE USER IF NOT EXISTS 'nerd'@'localhost' IDENTIFIED BY 'NerdyGadgets69420!@'
GRANT ALL PRIVILEGES ON nerdygadgets.* TO 'nerd'@'localhost';
```
Or alternatively, run the database_user.sql file found in setup

Make sure the web server is pointed to the public/ directory and not to the project root.


