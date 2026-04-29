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

# Her 5 dakikada bir Autoptimize cache izinlerini düzelt
# (Autoptimize cache clear sonrası root:root olma sorununu önler)
(crontab -l 2>/dev/null; echo "*/5 * * * * chown -R nobody:nobody /var/www/html/wp-content/cache && chmod -R 775 /var/www/html/wp-content/cache") | crontab -

crond

# WordPress eklenti yapılandırmasını arka planda başlat
# (WordPress kurulumu tamamlandıktan sonra çalışacak)
(sleep 30 && /var/www/html/setup-plugins.sh > /var/log/setup-plugins.log 2>&1) &

# Nginx'i ön planda başlat
nginx -g "daemon off;"
