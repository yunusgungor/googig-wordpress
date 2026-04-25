# 2. İşlemciye Özel Derleme: Hazır imaj kullanmak yerine MySQL kaynak kodundan derleniyor
FROM ubuntu:22.04 AS builder

ENV DEBIAN_FRONTEND=noninteractive

# Gerekli C/C++ derleyicileri ve bağımlılıkları
RUN apt-get update && apt-get install -y \
    build-essential cmake libncurses5-dev libssl-dev \
    bison pkg-config wget libtirpc-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src
# MySQL kaynak kodunu indir
RUN wget https://dev.mysql.com/get/Downloads/MySQL-8.0/mysql-8.0.36.tar.gz && \
    tar -xzf mysql-8.0.36.tar.gz

WORKDIR /usr/src/mysql-8.0.36

# 2. İşlemciye Özel Derleme (C Compiler Flags: march=native)
# Bu komut MySQL'i sadece bu sunucunun işlemcisine özel (AVX vb.) olarak optimize eder
ENV CFLAGS="-march=native -O3"
ENV CXXFLAGS="-march=native -O3"

# CMake ile yapılandırma ve derleme
RUN cmake . \
    -DDOWNLOAD_BOOST=1 \
    -DWITH_BOOST=/usr/src/boost \
    -DCMAKE_C_FLAGS="$CFLAGS" \
    -DCMAKE_CXX_FLAGS="$CXXFLAGS" \
    -DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
    -DWITH_SSL=system \
    -DWITH_ZLIB=system && \
    make -j$(nproc) && \
    make install

# Çalışma zamanı imajı
FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y libaio1 libnuma1 libssl-dev && rm -rf /var/lib/apt/lists/*

COPY --from=builder /usr/local/mysql /usr/local/mysql
ENV PATH="/usr/local/mysql/bin:${PATH}"

# MySQL kullanıcısı ve dizinleri
RUN groupadd mysql && useradd -r -g mysql -s /bin/false mysql && \
    mkdir -p /var/lib/mysql /var/run/mysqld /etc/mysql/conf.d && \
    chown -R mysql:mysql /var/lib/mysql /var/run/mysqld /usr/local/mysql

# 3. Veritabanının Beynini RAM'e Taşımak (tmpfs /dev/shm)
RUN { \
        echo '[mysqld]'; \
        echo 'user=mysql'; \
        echo 'datadir=/var/lib/mysql'; \
        echo 'socket=/var/run/mysqld/mysqld.sock'; \
        echo 'tmpdir=/dev/shm'; \
    } > /etc/mysql/my.cnf

USER mysql
EXPOSE 3306
CMD ["mysqld"]
