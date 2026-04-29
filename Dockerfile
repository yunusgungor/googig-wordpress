FROM alpine:3.19

# Gerekli bağımlılıkları Alpine paket yöneticisinden (apk) hazır binary olarak kur.
# Bu sayede 'checking for stdint.h' veya herhangi bir derleme bekleme derdi SIFIRA iner.
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-mysqli \
    php82-pdo_mysql \
    php82-opcache \
    php82-gd \
    php82-zip \
    php82-exif \
    php82-pecl-swoole \
    php82-pecl-redis \
    php82-zlib \
    php82-curl \
    php82-mbstring \
    php82-xml \
    php82-phar \
    php82-session \
    php82-ctype \
    php82-tokenizer \
    php82-fileinfo \
    php82-xmlreader \
    php82-xmlwriter \
    php82-simplexml \
    php82-bcmath \
    php82-intl \
    php82-iconv \
    php82-dom \
    nginx \
    curl \
    unzip

# Opcache, Zstd ve JIT Ayarları (Elite Performance)
RUN echo "opcache.enable=1" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.memory_consumption=256" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.jit_buffer_size=128M" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.jit=tracing" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.interned_strings_buffer=16" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.max_accelerated_files=20000" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.revalidate_freq=60" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.fast_shutdown=1" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.enable_file_override=1" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.validate_timestamps=1" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "zend.enable_gc=Off" >> /etc/php82/conf.d/custom-gc.ini && \
    echo "realpath_cache_size=4096K" >> /etc/php82/conf.d/custom-performance.ini && \
    echo "realpath_cache_ttl=600" >> /etc/php82/conf.d/custom-performance.ini

# PHP-FPM Havuzu (Elite Performance - %300 Kapasite Artışı)
RUN rm -f /etc/php82/php-fpm.d/www.conf && \
    { \
        echo '[www]'; \
        echo 'user = nobody'; \
        echo 'group = nobody'; \
        echo 'listen = 127.0.0.1:9000'; \
        echo 'listen.backlog = 511'; \
        echo 'pm = dynamic'; \
        echo 'pm.max_children = 100'; \
        echo 'pm.start_servers = 10'; \
        echo 'pm.min_spare_servers = 5'; \
        echo 'pm.max_spare_servers = 20'; \
        echo 'pm.max_requests = 500'; \
        echo 'pm.process_idle_timeout = 10s'; \
        echo 'clear_env = no'; \
        echo 'catch_workers_output = yes'; \
        echo 'php_admin_value[error_log] = /dev/stderr'; \
        echo 'php_admin_flag[log_errors] = on'; \
        echo 'request_terminate_timeout = 30s'; \
        echo 'rlimit_files = 4096'; \
        echo 'rlimit_core = 0'; \
    } > /etc/php82/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html
COPY . /var/www/html/

# Cron script'ini kopyala ve çalıştırılabilir yap
COPY cron-wp.sh /var/www/html/cron-wp.sh
RUN chmod +x /var/www/html/cron-wp.sh

# Plugin setup script'ini kopyala ve çalıştırılabilir yap
COPY setup-plugins.sh /var/www/html/setup-plugins.sh
RUN chmod +x /var/www/html/setup-plugins.sh

# NOT: Tüm eklentiler (Redis Cache, WP Super Cache, Autoptimize, Asset CleanUp, EWWW)
# wp-content/plugins volume mount nedeniyle Dockerfile'da yüklenemiyor
# Bunun yerine setup-plugins.sh scripti ile runtime'da yüklenecek

# WP-CLI Kurulumu (Sistem Genelinde)
RUN curl -fLsS --retry 3 --retry-delay 2 -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

# mu-plugins klasörünü oluştur ve optimizasyon plugin'lerini kopyala
RUN mkdir -p /var/www/html/wp-content/mu-plugins
COPY wp-content/mu-plugins/workpanel-optimizations.php /var/www/html/wp-content/mu-plugins/
COPY wp-content/mu-plugins/workpanel-auto-config.php /var/www/html/wp-content/mu-plugins/

# Yetkilendirme ve Klasör İzinleri
RUN mkdir -p /var/www/html/wp-content/uploads && \
    mkdir -p /var/www/html/wp-content/cache/autoptimize && \
    mkdir -p /var/www/html/wp-content/ewww && \
    mkdir -p /run/nginx && \
    chown -R nobody:nobody /var/www/html && \
    chown -R nobody:nobody /var/lib/nginx && \
    chmod -R 755 /var/www/html/wp-content/uploads && \
    chmod -R 755 /var/www/html/wp-content/cache && \
    chmod -R 755 /var/www/html/wp-content/ewww

# Nginx ve Başlatıcı Betiği kopyala
COPY nginx.conf /etc/nginx/nginx.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
