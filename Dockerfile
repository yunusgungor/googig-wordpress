FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive

# Sistem bağımlılıklarını kur
RUN apt-get update && apt-get install -y \
    libxml2-dev libsqlite3-dev libssl-dev \
    zlib1g-dev libcurl4-openssl-dev libpng-dev \
    libjpeg-dev libonig-dev libzip-dev libzstd-dev \
    unzip curl nginx \
    && rm -rf /var/lib/apt/lists/*

# PHP'nin kendi temel eklentilerini kur (C'den derlemek yerine docker-php komutlarıyla saniyeler içinde kurar)
RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql opcache gd zip exif

# 1. Madde: PHP'yi Ölümsüz Yapmak (Swoole Kullanımı) ve Zstd
RUN pecl install swoole-5.1.2 zstd \
    && docker-php-ext-enable swoole zstd

# Opcache, Zstd ve JIT (Just-In-Time) Ayarları
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini && \
    echo "opcache.memory_consumption=64" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini && \
    echo "opcache.jit_buffer_size=64M" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini && \
    echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini && \
    echo "zend.enable_gc=Off" >> /usr/local/etc/php/conf.d/custom-gc.ini

# PHP-FPM Havuzu (OOM Koruması) Ayarları
RUN { \
        echo '[www]'; \
        echo 'user = www-data'; \
        echo 'group = www-data'; \
        echo 'listen = 127.0.0.1:9000'; \
        echo 'pm = dynamic'; \
        echo 'pm.max_children = 4'; \
        echo 'pm.start_servers = 1'; \
        echo 'pm.min_spare_servers = 1'; \
        echo 'pm.max_spare_servers = 2'; \
    } > /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html
COPY . /var/www/html/

# Redis Object Cache Eklentisini Hazırla
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/redis-cache.latest-stable.zip && \
    unzip redis-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm redis-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/redis-cache/includes/object-cache.php /var/www/html/wp-content/object-cache.php

# Güçlü Bir Sayfa Önbellekleme: WP Super Cache Eklentisini Hazırla
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/wp-super-cache.latest-stable.zip && \
    unzip wp-super-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm wp-super-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/wp-super-cache/wp-cache-phase1.php /var/www/html/wp-content/advanced-cache.php

# Yetkilendirme ve Uploads Klasörü İzni
RUN mkdir -p /var/www/html/wp-content/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/wp-content/uploads

# Nginx ve Başlatıcı Betiği kopyala
COPY nginx.conf /etc/nginx/nginx.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
