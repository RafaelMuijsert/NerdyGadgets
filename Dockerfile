FROM debian:latest
RUN apt update -y && apt upgrade -y
RUN apt install php php-mysql apache2 -y
COPY ./config/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/nerdygadgets
RUN echo 'extension=mysqli' | tee -a /etc/php/7.4/apache2/php.ini
EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]
