FROM php:8.3-fpm

ENV TZ=Europe/Kiev

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    supervisor \
    cron \
    && cp /usr/share/zoneinfo/${TZ} /etc/localtime \
    && pecl install redis \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev

RUN chmod -R gu+w storage

RUN chmod -R guo+w storage

COPY provisioning/supervisor.d /etc/supervisor/conf.d

COPY provisioning/init-tasks.sh /opt/init-tasks.sh
RUN chmod +x /opt/init-tasks.sh

COPY provisioning/tasks.sh /opt/tasks.sh
RUN chmod +x /opt/tasks.sh
