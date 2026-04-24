FROM php:8.2-apache

# Sistem paketlerini kuruyoruz
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# PHP eklentilerini kuruyoruz (Ağır eklentileri ayırarak kaynak tüketimini dengeliyoruz)
# Hafif eklentileri paralel kurabiliriz
RUN docker-php-ext-install mysqli bcmath exif opcache

# GD eklentisi yapılandırma gerektirir
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

# intl ve zip eklentileri bellek yoğun olduğu için paralel derlemeyi kaldırıyoruz (veya kısıtlıyoruz)
RUN docker-php-ext-install intl zip

# Redis PHP eklentisini kuruyoruz
RUN pecl install redis && \
    docker-php-ext-enable redis

# Apache modüllerini aktif ediyoruz
# rewrite: Kalıcı bağlantılar (permalinks)
# expires & headers: Statik dosyaların tarayıcıda önbelleğe alınması (hız için kritik)
RUN a2enmod rewrite expires headers

# WP-CLI kuruyoruz (Performans ayarları ve yönetim için çok kullanışlı)
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

# OPcache ayarlarını agresif performans için optimize ediyoruz
RUN { \
		echo 'opcache.memory_consumption=256'; \
		echo 'opcache.interned_strings_buffer=16'; \
		echo 'opcache.max_accelerated_files=10000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# PHP Yükleme limitlerini artırıyoruz
RUN { \
		echo 'upload_max_filesize = 128M'; \
		echo 'post_max_size = 128M'; \
		echo 'memory_limit = 512M'; \
		echo 'max_execution_time = 300'; \
	} > /usr/local/etc/php/conf.d/wordpress-limits.ini

# Apache için statik dosya önbellekleme ayarları (Hız için)
RUN { \
        echo '<IfModule mod_expires.c>'; \
        echo '  ExpiresActive On'; \
        echo '  ExpiresDefault "access plus 1 month"'; \
        echo '  ExpiresByType image/x-icon "access plus 1 year"'; \
        echo '  ExpiresByType image/jpeg "access plus 1 year"'; \
        echo '  ExpiresByType image/png "access plus 1 year"'; \
        echo '  ExpiresByType image/gif "access plus 1 year"'; \
        echo '  ExpiresByType image/webp "access plus 1 year"'; \
        echo '  ExpiresByType text/css "access plus 1 month"'; \
        echo '  ExpiresByType text/javascript "access plus 1 month"'; \
        echo '  ExpiresByType application/javascript "access plus 1 month"'; \
        echo '  ExpiresByType application/x-shockwave-flash "access plus 1 month"'; \
        echo '</IfModule>'; \
    } > /etc/apache2/conf-available/performance.conf && a2enconf performance

# Çalışma dizini
WORKDIR /var/www/html

# Yerel dizindeki WordPress dosyalarını konteynere kopyalıyoruz
COPY . /var/www/html/

# Dosya izinlerini Apache'nin okuyabileceği/yazabileceği şekilde ayarlıyoruz
RUN chown -R www-data:www-data /var/www/html

# Redis Object Cache eklentisini indirip hazır konuma getiriyoruz ve anında aktifleştiriyoruz
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/redis-cache.latest-stable.zip && \
    unzip redis-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm redis-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/redis-cache/includes/object-cache.php /var/www/html/wp-content/object-cache.php && \
    chown -R www-data:www-data /var/www/html/wp-content
