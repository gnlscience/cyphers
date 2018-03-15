FROM richarvey/nginx-php-fpm:php7
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default.confd