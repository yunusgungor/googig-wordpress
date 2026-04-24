FROM wordpress:latest

# Performans için gerekli sistem paketlerini ve Redis PHP eklentisini kuruyoruz
RUN apt-get update && \
    apt-get install -y --no-install-recommends unzip && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    rm -rf /var/lib/apt/lists/*

# OPcache ayarlarını agresif performans için optimize ediyoruz
RUN { \
		echo 'opcache.memory_consumption=256'; \
		echo 'opcache.interned_strings_buffer=16'; \
		echo 'opcache.max_accelerated_files=10000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Yerel dizindeki WordPress dosyalarını (indirdiğiniz kod tabanını) konteynere kopyalıyoruz
COPY . /var/www/html/

# Dosya izinlerini Apache'nin okuyabileceği/yazabileceği şekilde ayarlıyoruz
RUN chown -R www-data:www-data /var/www/html

# Redis Object Cache eklentisini indirip hazır konuma getiriyoruz ve anında aktifleştiriyoruz
RUN curl -fLsS -O https://downloads.wordpress.org/plugin/redis-cache.latest-stable.zip && \
    unzip redis-cache.latest-stable.zip -d /var/www/html/wp-content/plugins/ && \
    rm redis-cache.latest-stable.zip && \
    cp /var/www/html/wp-content/plugins/redis-cache/includes/object-cache.php /var/www/html/wp-content/object-cache.php && \
    chown -R www-data:www-data /var/www/html/wp-content
