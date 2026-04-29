FROM mariadb:10.11

# Veritabanının Beynini RAM'e Taşımak (tmpfs /dev/shm) ve RAM Limiti (OOM Koruması)
RUN { \
        echo '[mysqld]'; \
        echo 'tmpdir=/dev/shm'; \
        echo 'innodb_buffer_pool_size=1G'; \
        echo 'innodb_log_file_size=256M'; \
        echo 'innodb_flush_log_at_trx_commit=2'; \
        echo 'innodb_flush_method=O_DIRECT'; \
        echo 'innodb_file_per_table=1'; \
        echo 'innodb_buffer_pool_instances=1'; \
        echo 'innodb_read_io_threads=4'; \
        echo 'innodb_write_io_threads=4'; \
        echo 'innodb_io_capacity=200'; \
        echo 'innodb_io_capacity_max=400'; \
        echo 'max_connections=100'; \
        echo 'thread_cache_size=16'; \
        echo 'table_open_cache=4096'; \
        echo 'table_definition_cache=2048'; \
        echo 'query_cache_type=0'; \
        echo 'query_cache_size=0'; \
        echo 'tmp_table_size=64M'; \
        echo 'max_heap_table_size=64M'; \
        echo 'join_buffer_size=2M'; \
        echo 'sort_buffer_size=2M'; \
        echo 'read_buffer_size=1M'; \
        echo 'read_rnd_buffer_size=2M'; \
        echo 'key_buffer_size=32M'; \
        echo 'skip-name-resolve'; \
        echo 'performance_schema=OFF'; \
    } > /etc/mysql/conf.d/workpanel-optimizations.cnf
