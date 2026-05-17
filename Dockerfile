FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN echo "upload_max_filesize=20M" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size=25M" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/uploads.ini