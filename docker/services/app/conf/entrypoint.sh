#!/bin/bash

set -e

DOCKER_USER=${DOCKER_USER:-ubuntu}


#sed -i "s|__USER__|${DOCKER_USER}|g" /etc/supervisor/supervisor-workers.conf

# Roda composer install como o usuário do Laravel
if [ ! -d "vendor" ]; then
#  composer install --no-interaction --prefer-dist --optimize-autoloader
  composer install --no-interaction --prefer-dist
  chown -R ${DOCKER_USER}:${DOCKER_USER} /var/www/vendor
fi

# Roda migrations também como o usuário do Laravel
#php artisan migrate --force

#supervisord -c /etc/supervisor/supervisor-workers.conf

chown -R $DOCKER_USER:$DOCKER_USER /var/www/storage /var/www/bootstrap/cache
exec php-fpm -F