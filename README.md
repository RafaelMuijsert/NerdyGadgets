# NerdyGadgets

A beautiful webshop that Just Works™ on my machine.

## Dependencies
- A web server (apache is preferred)
- PHP (tested with version 8.1.11)
- mysqli php extension

## Setup

Install the given database from the official Windesheim GitLab.
Run the following commands in a mariadb shell:
  CREATE USER IF NOT EXISTS 'nerd'@'localhost' IDENTIFIED BY 'NerdyGadgets69420!@'
  GRANT ALL PRIVILEGES ON nerdygadgets.* TO 'nerd'@'localhost';

Yes that's a plaintext password.



