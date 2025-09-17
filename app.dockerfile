FROM php:8.2-fpm

#COPY ./app/composer.lock /var/www

WORKDIR /var/www

RUN apt-get -o Acquire::Check-Valid-Until=false update && apt-get install -y \
    nginx \
    build-essential \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

COPY ./app /var/www
#COPY --chown=www:www ./app /var/www
#COPY ./app/.env.staging /var/www/.env

USER root

RUN chmod -R 777 storage/
#RUN chmod -R 777 bootstrap/cache

COPY ./supervisord /etc/supervisor/conf.d

EXPOSE 9000
CMD ["php-fpm"]