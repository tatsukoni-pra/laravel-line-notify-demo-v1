#!/bin/sh
cd /var/www/

# composer setup
echo "start composer setup"
echo -e "nameserver 8.8.8.8\noptions ndots:0" > /etc/resolv.conf
composer clear-cache
composer install
composer dump-autoload
echo -e "nameserver 127.0.0.11\noptions ndots:0" > /etc/resolv.conf
echo "finish composer setup"

# laravel application setup
echo "start laravel application setup"
if [ ! -f .env ]; then
    echo "create .env file"
    cp .env.example .env
fi
ENV_APP_KEY_VALUE=`cat .env | grep -E '^APP_KEY=.*' | sed s/APP_KEY=//`
if [ -z $ENV_APP_KEY_VALUE ]; then
    echo "generate APP_KEY"
    php artisan key:generate --force
fi
chmod -R 777 storage/
php artisan cache:clear
php artisan config:clear
php artisan ide-helper:generate
# php artisan ide-helper:models -N
php artisan migrate
echo "finish laravel application setup"
