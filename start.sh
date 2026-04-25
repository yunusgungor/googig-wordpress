#!/bin/sh

# PHP-FPM'i arka planda başlat
php-fpm82 -D

# Nginx cache klasörünü hazırla
mkdir -p /dev/shm/nginx-cache
chown -R nobody:nobody /dev/shm/nginx-cache

# Nginx'i ön planda başlat (Kapsayıcının ayakta kalması için)
nginx -g "daemon off;"
