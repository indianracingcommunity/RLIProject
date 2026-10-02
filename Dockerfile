ARG PHP_VERSION
FROM php:$PHP_VERSION-fpm

# Debian bullseye security updates have been removed from the mirrors, so fetch them from a snapshot instead
RUN if grep -q bullseye /etc/os-release; then \
        sed -i 's#^deb http://deb.debian.org/debian-security #deb [check-valid-until=no] http://snapshot.debian.org/archive/debian-security/20260901T000000Z #' /etc/apt/sources.list; \
    fi

RUN apt-get update -y && apt-get install -y git curl unzip libxslt-dev \
        libzip-dev libpng-dev libgmp-dev zlib1g-dev libffi-dev

RUN docker-php-ext-install pdo_mysql bcmath xsl
RUN docker-php-ext-install calendar exif ffi gd
# zend_test in PHP 8.0.30+ includes libxml headers but its build config does not add their path
RUN CPPFLAGS="-I/usr/include/libxml2" docker-php-ext-install gettext gmp pcntl zend_test
RUN docker-php-ext-install shmop sockets sysvmsg sysvsem sysvshm zip

ARG PROJECT_DIR
WORKDIR $PROJECT_DIR

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]