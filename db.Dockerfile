FROM mariadb:10.11

# Veritabanının Beynini RAM'e Taşımak (tmpfs /dev/shm) ve RAM Limiti (OOM Koruması)
RUN { \
        echo '[mysqld]'; \
        echo 'tmpdir=/dev/shm'; \
        echo 'innodb_buffer_pool_size=128M'; \
    } > /etc/mysql/conf.d/workpanel-optimizations.cnf
