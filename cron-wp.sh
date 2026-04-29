#!/bin/sh
# WordPress Cron İşlemlerini Çalıştır
# Bu script sistem cron tarafından her 15 dakikada bir çalıştırılmalıdır

# WP-CLI ile cron çalıştır (daha az RAM tüketir)
if command -v wp >/dev/null 2>&1; then
    cd /var/www/html
    wp cron event run --due-now --allow-root 2>&1 | logger -t wp-cron
else
    # WP-CLI yoksa curl ile çalıştır
    curl -s http://localhost/wp-cron.php?doing_wp_cron >/dev/null 2>&1
fi
