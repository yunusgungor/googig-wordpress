FROM mariadb:10.11

# Veritabanının Beynini RAM'e Taşımak (tmpfs /dev/shm) ve RAM Limiti (OOM Koruması)
RUN { \
        echo '[mysqld]'; \
        echo 'tmpdir=/dev/shm'; \
        echo 'innodb_buffer_pool_size=1G'; \
        echo 'innodb_log_file_size=256M'; \
        echo 'innodb_flush_log_at_trx_commit=2'; \
        echo 'innodb_flush_method=O_DIRECT'; \
    } > /etc/mysql/conf.d/workpanel-optimizations.cnf
