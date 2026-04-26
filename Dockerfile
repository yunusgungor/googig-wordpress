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

# Opcache, Zstd ve JIT Ayarları
RUN echo "opcache.enable=1" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.memory_consumption=64" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.jit_buffer_size=64M" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "opcache.jit=tracing" >> /etc/php82/conf.d/00_opcache.ini && \
    echo "zend.enable_gc=Off" >> /etc/php82/conf.d/custom-gc.ini

# PHP-FPM Havuzu (OOM Koruması) Ayarları
RUN rm -f /etc/php82/php-fpm.d/www.conf && \
    { \
        echo '[www]'; \
        echo 'user = nobody'; \
        echo 'group = nobody'; \
        echo 'listen = 127.0.0.1:9000'; \
        echo 'pm = dynamic'; \
        echo 'pm.max_children = 30'; \
        echo 'pm.start_servers = 4'; \
        echo 'pm.min_spare_servers = 2'; \
        echo 'pm.max_spare_servers = 6'; \
        echo 'clear_env = no'; \
        echo 'catch_workers_output = yes'; \
        echo 'php_admin_value[error_log] = /dev/stderr'; \
        echo 'php_admin_flag[log_errors] = on'; \
    } > /etc/php82/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html
COPY . /var/www/html/

# Redis Object Cache Eklentisini Hazırla
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/redis-cache.latest-stable.zip && \
    unzip redis-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm redis-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/redis-cache/includes/object-cache.php /var/www/html/wp-content/object-cache.php

# WP Super Cache Eklentisini Hazırla
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/wp-super-cache.latest-stable.zip && \
    unzip wp-super-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm wp-super-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/wp-super-cache/wp-cache-config-sample.php /var/www/html/wp-content/wp-cache-config.php && \
    sed -i "s/\$cache_enabled = false;/\$cache_enabled = true;/g" /var/www/html/wp-content/wp-cache-config.php && \
    cp /var/www/html/wp-content/plugins/wp-super-cache/advanced-cache.php /var/www/html/wp-content/advanced-cache.php && \
    sed -i "s|// WP SUPER CACHE 1.2|// WP SUPER CACHE 1.2\ndefine('WPCACHEHOME', '/var/www/html/wp-content/plugins/wp-super-cache/');|" /var/www/html/wp-content/advanced-cache.php

# Yetkilendirme ve Uploads Klasörü İzni
RUN mkdir -p /var/www/html/wp-content/uploads && \
    mkdir -p /run/nginx && \
    chown -R nobody:nobody /var/www/html && \
    chown -R nobody:nobody /var/lib/nginx && \
    chmod -R 755 /var/www/html/wp-content/uploads

# Nginx ve Başlatıcı Betiği kopyala
COPY nginx.conf /etc/nginx/nginx.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
