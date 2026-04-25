#!/bin/bash

# FPM'in çalışacağı varsayılan config dosyası yoksa oluştur
if [ ! -f /usr/local/etc/php-fpm.conf ]; then
    echo "[global]" > /usr/local/etc/php-fpm.conf
    echo "include=/usr/local/etc/php-fpm.d/*.conf" >> /usr/local/etc/php-fpm.conf
fi

# PHP-FPM'i arka planda başlat
php-fpm -D

# Nginx'i ön planda başlat (Kapsayıcının ayakta kalması için)
nginx -g "daemon off;"
