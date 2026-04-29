# WordPress Optimizasyonları - Deployment Rehberi

## 🎯 Yapılan Değişiklikler

### 1. Yeni Dosyalar
- ✅ `cron-wp.sh` - Sistem cron scripti (WP-Cron yerine)
- ✅ `wp-content/mu-plugins/workpanel-optimizations.php` - Otomatik optimizasyonlar
- ✅ `README-OPTIMIZATIONS.md` - Detaylı optimizasyon dokümantasyonu
- ✅ `DEPLOYMENT-GUIDE.md` - Bu dosya

### 2. Güncellenen Dosyalar
- ✅ `Dockerfile` - Cron script ve mu-plugin kopyalama eklendi
- ✅ `wp-config.php` - WP-Cron devre dışı, revisions limiti güncellendi
- ✅ `nginx.conf` - XML-RPC engelleme, gelişmiş gzip ayarları
- ✅ `start.sh` - Sistem cron başlatma eklendi
- ✅ `.dockerignore` - Gereksiz dosyalar eklendi

## 🚀 Deployment Adımları

### Workpanel Üzerinden Deploy

```bash
# 1. Değişiklikleri commit edin
cd googig-wordpress
git add .
git commit -m "feat: WordPress hızlandırma optimizasyonları eklendi"
git push origin main

# 2. Workpanel üzerinden deploy edin
# Web UI veya CLI kullanabilirsiniz
```

### Manuel Docker Compose ile Test (Opsiyonel)

```bash
# 1. Projeyi build edin
cd googig-wordpress
docker build -t googig-wordpress:optimized .

# 2. Test için çalıştırın
docker run -d \
  --name wp-test \
  -p 8080:80 \
  -e WORDPRESS_DB_HOST=host.docker.internal:3306 \
  -e WORDPRESS_DB_USER=wp_user \
  -e WORDPRESS_DB_PASSWORD=password \
  -e WORDPRESS_DB_NAME=wp_database \
  googig-wordpress:optimized

# 3. Logları kontrol edin
docker logs -f wp-test

# 4. Test sonrası temizlik
docker stop wp-test && docker rm wp-test
```

## ✅ Deploy Sonrası Kontroller

### 1. Container Sağlık Kontrolü
```bash
# Container'ın çalıştığını kontrol edin
docker ps | grep wordpress

# Health check endpoint'i test edin
curl http://blog.googig.cloud/health
# Beklenen: "ok"
```

### 2. Redis Bağlantısı
```bash
# WordPress admin paneline giriş yapın
# Eklentiler > Redis Object Cache > Enable Object Cache
# Yeşil "Connected" mesajını görmelisiniz
```

### 3. Cache Kontrolü
```bash
# Nginx microcache çalışıyor mu?
curl -I http://blog.googig.cloud/
# Header'da "X-Micro-Cache: HIT" veya "MISS" görmelisiniz

# Redis cache çalışıyor mu?
docker exec wordpress-redis redis-cli INFO stats
# keyspace_hits ve keyspace_misses değerlerini kontrol edin
```

### 4. Cron Kontrolü
```bash
# Container içinde cron çalışıyor mu?
docker exec wordpress-app ps aux | grep cron

# Cron loglarını kontrol edin
docker exec wordpress-app tail -f /var/log/messages | grep wp-cron
```

### 5. XML-RPC Engelleme
```bash
# XML-RPC engellenmiş mi?
curl -X POST http://blog.googig.cloud/xmlrpc.php
# Beklenen: Bağlantı reddedilmeli veya 444 hatası
```

### 6. Performans Testi
```bash
# Sayfa yükleme hızını test edin
curl -w "@curl-format.txt" -o /dev/null -s http://blog.googig.cloud/

# curl-format.txt içeriği:
# time_namelookup:  %{time_namelookup}\n
# time_connect:  %{time_connect}\n
# time_starttransfer:  %{time_starttransfer}\n
# time_total:  %{time_total}\n
```

## 🔧 Sorun Giderme

### Cron Çalışmıyor
```bash
# Container içine girin
docker exec -it wordpress-app sh

# Crontab'ı kontrol edin
crontab -l

# Manuel cron çalıştırın
/var/www/html/cron-wp.sh

# Logları kontrol edin
tail -f /var/log/messages
```

### Redis Bağlanamıyor
```bash
# Redis servisini kontrol edin
docker ps | grep redis
docker logs wordpress-redis

# WordPress container'dan Redis'e ping atın
docker exec wordpress-app ping wordpress-redis

# Redis bağlantısını test edin
docker exec wordpress-app php -r "var_dump(extension_loaded('redis'));"
```

### Nginx Cache Çalışmıyor
```bash
# Cache dizinini kontrol edin
docker exec wordpress-app ls -la /dev/shm/nginx-cache/

# Nginx yapılandırmasını test edin
docker exec wordpress-app nginx -t

# Nginx'i yeniden başlatın
docker exec wordpress-app nginx -s reload
```

### mu-plugin Yüklenmiyor
```bash
# mu-plugins dizinini kontrol edin
docker exec wordpress-app ls -la /var/www/html/wp-content/mu-plugins/

# Dosya izinlerini kontrol edin
docker exec wordpress-app cat /var/www/html/wp-content/mu-plugins/workpanel-optimizations.php

# WordPress admin panelinde kontrol edin
# Eklentiler > Must-Use bölümünde görünmeli
```

## 📊 Beklenen Sonuçlar

### Performans Metrikleri
- **İlk Byte Süresi (TTFB)**: < 200ms
- **Sayfa Yükleme**: < 500ms (cache hit)
- **Veritabanı Sorguları**: %85-90 azalma
- **RAM Kullanımı**: %25-35 azalma
- **CPU Kullanımı**: %40-50 azalma

### Cache Hit Oranları
- **Nginx Microcache**: %95+ (1 saniye sonra)
- **Redis Object Cache**: %90+ (veritabanı sorguları)
- **OPcache**: %100 (PHP dosyaları)

## 🎓 Ek Optimizasyonlar

### Cloudflare Entegrasyonu
1. Domain'i Cloudflare'e ekleyin
2. SSL/TLS: Full (strict)
3. Caching Level: Standard
4. Auto Minify: JS, CSS, HTML açık
5. Brotli: Açık
6. HTTP/3: Açık

### WooCommerce (Eğer kullanılıyorsa)
1. HPOS'u etkinleştirin
2. Cart Fragments'ı kontrol edin (otomatik devre dışı)
3. Analytics'i kapatın (otomatik kapalı)

### Host Sunucu Optimizasyonları
```bash
# TCP BBR algoritması
echo "net.core.default_qdisc=fq" | sudo tee -a /etc/sysctl.conf
echo "net.ipv4.tcp_congestion_control=bbr" | sudo tee -a /etc/sysctl.conf
sudo sysctl -p

# Swap alanı (2GB)
sudo fallocate -l 2G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab
```

## 📚 Dokümantasyon

- **Optimizasyon Detayları**: `README-OPTIMIZATIONS.md`
- **Kaynak Doküman**: `workpanel/docs/wordpress-hizlandirma.md`
- **Workpanel Config**: `workpanel.json`

## ✨ Sonuç

Tüm optimizasyonlar başarıyla uygulandı ve workpanel yapısına uyumlu hale getirildi. Deploy sonrası yukarıdaki kontrolleri yaparak sistemin düzgün çalıştığından emin olun.

**Not**: İlk deploy sonrası Redis Object Cache ve WP Super Cache eklentilerini WordPress admin panelinden manuel olarak etkinleştirmeyi unutmayın!
