# 1. Aşama: C Kodlarından PHP ve Swoole Derleme (Hazır imaj kullanılmıyor)
FROM ubuntu:22.04 AS builder

ENV DEBIAN_FRONTEND=noninteractive

# Gerekli C/C++ derleyicileri ve kütüphaneler
RUN apt-get update && apt-get install -y \
    build-essential cmake wget pkg-config autoconf bison re2c \
    libxml2-dev libsqlite3-dev libssl-dev \
    zlib1g-dev libcurl4-openssl-dev libpng-dev \
    libjpeg-dev libonig-dev libzip-dev libzstd-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src
# PHP Kaynak Kodunu İndirme
RUN wget https://www.php.net/distributions/php-8.2.15.tar.gz && \
    tar -xzf php-8.2.15.tar.gz

WORKDIR /usr/src/php-8.2.15

# 2. İşlemciye Özel Derleme (C Compiler Flags: march=native)
# PHP çekirdeği sunucunun işlemcisine özel donanım komutlarıyla derlenecek
ENV CFLAGS="-march=native -O3"
ENV CXXFLAGS="-march=native -O3"

# PHP'yi C kaynak kodundan konfigüre edip derliyoruz
RUN ./configure \
    --enable-fpm \
    --with-mysqli \
    --with-pdo-mysql \
    --with-openssl \
    --with-zlib \
    --with-curl \
    --enable-mbstring \
    --enable-gd \
    --with-jpeg \
    --enable-exif \
    --enable-opcache \
    --with-zip \
    && make -j$(nproc) && make install

# 1. Madde: PHP'yi Ölümsüz Yapmak (Swoole Kullanımı)
# Swoole C eklentisini de kaynak koddan makineye özel derliyoruz
WORKDIR /usr/src
RUN wget https://pecl.php.net/get/swoole-5.1.2.tgz && \
    tar -xzf swoole-5.1.2.tgz

WORKDIR /usr/src/swoole-5.1.2
RUN phpize && \
    ./configure --enable-openssl --enable-swoole-curl && \
    make -j$(nproc) && make install

# 6. Madde: Zstandard (zstd) Sıkıştırma Kurulumu
WORKDIR /usr/src
RUN wget https://pecl.php.net/get/zstd-0.13.3.tgz && \
    tar -xzf zstd-0.13.3.tgz

WORKDIR /usr/src/zstd-0.13.3
RUN phpize && \
    ./configure && \
    make -j$(nproc) && make install

# 2. Aşama: Çalışma Zamanı İmajı
FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y \
    libxml2 libsqlite3-0 libssl3 zlib1g \
    libcurl4 libpng16-16 libjpeg-turbo8 \
    libonig5 libzip4 curl unzip libzstd1 \
    && rm -rf /var/lib/apt/lists/*

# Derlenmiş PHP ve Swoole binary'lerini kopyala
COPY --from=builder /usr/local /usr/local

# Swoole, Opcache ve Zstd eklentilerini etkinleştir
RUN mkdir -p /usr/local/lib/php.conf.d && \
    echo "extension=swoole.so" > /usr/local/lib/php.ini && \
    echo "extension=zstd.so" >> /usr/local/lib/php.ini && \
    echo "zend_extension=opcache.so" >> /usr/local/lib/php.ini

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
    # Gelişmiş önbellek drop-in dosyasını içeri kopyala
    cp /var/www/html/wp-content/plugins/wp-super-cache/wp-cache-phase1.php /var/www/html/wp-content/advanced-cache.php

# PHP için yetkilendirme (Swoole/FPM fark etmeksizin web-server kullanıcısı)
RUN groupadd -g 1000 www-data && useradd -u 1000 -g www-data -s /bin/false www-data && \
    chown -R www-data:www-data /var/www/html

EXPOSE 80
# Not: WordPress'i tam anlamıyla Swoole üzerinden servis etmek için 
# wp-swoole tarzı bir sunucu sarmalayıcısı gerekir. Bu yapılandırma 
# Swoole'u sisteme kurup PHP'yi resident-memory için hazır hale getirir.
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
