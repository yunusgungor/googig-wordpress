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

# Sistem Cron'u başlat (WP-Cron için)
# Her 15 dakikada bir wp-cron.php çalıştır
(crontab -l 2>/dev/null; echo "*/15 * * * * /var/www/html/cron-wp.sh") | crontab -
crond

# Nginx'i ön planda başlat
nginx -g "daemon off;"
