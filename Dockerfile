FROM php:8.2-apache

RUN apt-get update && apt-get install -y unzip curl git libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli intl \
    && a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

COPY . /var/www/html/
WORKDIR /var/www/html/

RUN git config --global --add safe.directory /var/www/html

# Jalankan composer install
RUN composer install --no-interaction --prefer-dist

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Ubah DocumentRoot Apache ke folder public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN bash -c 'sed -ri "s!/var/www/html!$APACHE_DOCUMENT_ROOT!g" /etc/apache2/sites-available/000-default.conf'
