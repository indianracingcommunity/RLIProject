FROM ubuntu:latest
COPY setup /usr/

ARG DEBIAN_FRONTEND=noninteractive
RUN apt update
RUN apt install nginx mariadb-server curl git nano \
    php7.4 php7.4-cli php7.4-json php7.4-common php7.4-mysql \
    php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml \
    php7.4-bcmath php7.4-gmp php7.4-fpm phpmyadmin -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update --1

RUN service mysql start && mysql -sfu root < /usr/mysql_secure_installation.sql
RUN service mysql start && mysql -sfu root < /usr/mysql_user.sql
RUN service mysql start && mysql -sfu root --database=ircproject < /usr/prod.sql

# RUN mkdir -p /var/www/RLIProject
# COPY . /var/www/RLIProject

# RUN chown -R www-data:www-data /var/www/RLIProject/
# RUN chmod -R 755 /var/www/RLIProject/

# COPY setup/default /etc/nginx/sites-available/default
# COPY setup/nginx.conf /etc/nginx/nginx.conf
# COPY setup/php.ini /etc/php/7.4/fpm/php.ini
# COPY setup/.env /var/www/RLIProject/.env

# WORKDIR /var/www/RLIProject
# RUN composer install

EXPOSE 8000
ENTRYPOINT [ "/bin/sh" ]

# R=$(docker run -dt -p 916:80 rli/v28) && docker exec $R /bin/sh /usr/service_run.sh > /dev/null 2>&1