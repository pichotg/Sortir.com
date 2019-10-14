FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip \
    gnupg gnupg1 gnupg2 \
    zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl

COPY php.ini /etc/php/7.2.3/php.ini
COPY php-fpm-pool.conf /etc/php/7.2.3/pool.d/www.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m

RUN rm -rf /var/lib/apt/lists/*

WORKDIR /home/root/sortir.com/

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install argon2 libargon2-0 libargon2-0-dev iputils-ping -y

EXPOSE 9000
CMD ["php-fpm"]
