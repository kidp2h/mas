FROM php:8.1.0RC4-apache
RUN apt-get update -y &&  apt-get upgrade -y && apt-get install -q -y ssmtp mailutils git libzip-dev zip unzip
COPY ssmtp.conf /etc/ssmtp/ssmtp.conf

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && docker-php-ext-install zip
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini
RUN if command -v a2enmod >/dev/null 2>&1; then \
    a2enmod rewrite headers \
    ;fi
RUN mkdir -p /var/www/html/app/public/resources/uploads
RUN mkdir -p /var/www/html/app/public/resources/uploads/settings
RUN chmod 777 /var/www/html/app/public/resources/uploads
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
