FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev

RUN chown -R 1000:www-data storage bootstrap/cache
RUN chown -R 1000:www-data /var/www/html/storage/framework

RUN chmod -R ug+rwx storage bootstrap/cache

#RUN chmod -R 777 /var/www/html/storage  \
#    /var/www/html/bootstrap/cache
