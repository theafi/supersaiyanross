FROM php:8.2-apachel
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY pwd /var/www/html/
CMD [ "apache2-foreground", "ls /var/www/html/"]