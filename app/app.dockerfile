FROM php:8.0-fpm

RUN apt-get update && apt-get install -y libzip-dev

# Extension mysql driver for mysql
RUN docker-php-ext-install pdo_mysql mysqli

RUN chown -R www-data:www-data /var/www

# # Add `www-data` to group `appuser`
# RUN addgroup --gid 1000 appuser; \
#   adduser --uid 1000 --gid 1000 --disabled-password appuser; \
#   adduser www-data appuser;

# RUN chmod -R 760 /var/www/storage

# # Set www-data to have UID 1000
# RUN usermod -u 1000 www-data;