ARG PHP_VERSION
FROM php:$PHP_VERSION-fpm
RUN apt-get update -y && apt-get install -y git curl libxslt-dev \
        libzip-dev libpng-dev libgmp-dev zlib1g-dev libffi-dev

RUN docker-php-ext-install pdo_mysql bcmath xsl
RUN docker-php-ext-install calendar exif ffi gd
RUN docker-php-ext-install gettext gmp pcntl zend_test
RUN docker-php-ext-install shmop sockets sysvmsg sysvsem sysvshm zip

ARG PROJECT_DIR
WORKDIR $PROJECT_DIR

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer