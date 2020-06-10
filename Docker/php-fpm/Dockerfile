FROM php:7.3.18-fpm-alpine3.11

## https://github.com/docker-library/php/issues/344#issuecomment-364843883
## composerは別コンテナにしてもいいかも
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir /var/www/src
WORKDIR /var/www/src