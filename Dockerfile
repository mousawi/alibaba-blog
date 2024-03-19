FROM php:8.2-fpm

ARG user
ARG uid

RUN apt update

RUN apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zlib1g-dev \
    libzip-dev \
    zip

COPY --from=node:20-slim /usr/local/bin /usr/local/bin
COPY --from=node:20-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install intl zip pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

COPY . /var/www

COPY ./docker-compose/install-app /usr/local/bin/install-app
RUN chmod +x /usr/local/bin/install-app

USER $user
