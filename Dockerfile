FROM php:8.1.0RC4-apache
RUN apt-get update && apt-get install -q -y ssmtp mailutils
COPY ssmtp.conf /etc/ssmtp/ssmtp.conf
RUN docker-php-ext-install mysqli
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini
RUN if command -v a2enmod >/dev/null 2>&1; then \
    a2enmod rewrite headers \
    ;fi
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
