FROM php:8.1.0RC4-apache
RUN docker-php-ext-install mysqli
RUN if command -v a2enmod >/dev/null 2>&1; then \
    a2enmod rewrite headers \
    ;fi
