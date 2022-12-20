# NerdyGadgets

A beautiful webshop that just works™ on my machine.


## Project structure
Please see https://github.com/php-pds/skeleton

## Dependencies
- A web server (apache is preferred)
- PHP (tested with version 8.1.11)
- mysqli php extension
- intl php extension
- Composer

## Setup
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

Copy the .env.example file to .env and update the variables.

### Make sure the web server root is set to public/ and not to the project root.

## Testing
Given below is the shell command that can be used to connect to the primary database in case you want to perform manual operations.
```bash
$ sudo mariadb --host='nerdygadgets.shop' --port=33646 --user='nerd' --password='[PASSWORD]' 'nerdygadgets'
```

