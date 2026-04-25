#!/bin/sh

# PHP-FPM'i başlat
php-fpm82 -D
if [ $? -ne 0 ]; then
    echo "PHP-FPM başlatılamadı!"
    exit 1
fi

# Nginx cache klasörünü hazırla
mkdir -p /dev/shm/nginx-cache
chown -R nobody:nobody /dev/shm/nginx-cache

# Nginx'i ön planda başlat
nginx -g "daemon off;"
