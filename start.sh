#!/bin/sh

# PHP-FPM'i arka planda başlat
php-fpm82 -D

# Nginx'i ön planda başlat (Kapsayıcının ayakta kalması için)
nginx -g "daemon off;"
