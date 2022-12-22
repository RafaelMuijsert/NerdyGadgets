FROM debian:latest
RUN apt update -y && apt upgrade -y
RUN apt install php php-intl php-mysql composer apache2 -y
COPY ./config/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/nerdygadgets
RUN composer install -d /var/www/nerdygadgets
RUN phpenmod mysqli intl
EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]