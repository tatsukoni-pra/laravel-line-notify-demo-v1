#!/bin/sh
cd /var/www/

# setup variables
target_package=$1
target_env=$2

# composer require
echo "start composer require"
echo -e "nameserver 8.8.8.8\noptions ndots:0" > /etc/resolv.conf
composer clear-cache
if [ -n "$target_env" ] && [ "$target_env" = "dev" ]; then
    composer require "$target_package" --dev
else
    composer require "$target_package"
fi
composer dump-autoload
echo -e "nameserver 127.0.0.11\noptions ndots:0" > /etc/resolv.conf
echo "finish composer require"
