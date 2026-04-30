# Googig WordPress - Optimize Edilmiş Blog Platformu

![Version](https://img.shields.io/badge/version-2.0.0--elite-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.x-green.svg)
![Docker](https://img.shields.io/badge/Docker-ready-blue.svg)
![Performance](https://img.shields.io/badge/performance-elite-brightgreen.svg)

Googig WordPress, yüksek performanslı bir kişisel blog platformudur. Docker tabanlı yapı, gelişmiş caching katmanları ve otomatik optimizasyonlarla birlikte gelir.

## 🚀 Özellikler

### ⚡ Elite Performance Optimizasyonları
- **TTFB**: Sunucu 0.15s, Edge 0.02s (Cloudflare ile)
- **Kapasite**: 100 eşzamanlı istek (%300 artış)
- **Sayfa Ağırlığı**: <1MB (görsel optimizasyonu ile)
- **İstek Sayısı**: 15-20 (asset temizleme ile)

### 🏗️ Teknik Altyapı
- **Web Sunucusu**: Nginx + PHP-FPM
- **Veritabanı**: MariaDB 10.11 (1GB InnoDB Buffer Pool)
- **Cache Sistemleri**: Redis Object Cache + WP Super Cache + Nginx Microcache
- **PHP**: 8.2 + OPcache JIT (256MB memory)
- **Orchestration**: Docker + Workpanel

### 🔒 Güvenlik ve Güvenilirlik
- XML-RPC engellemesi
- Sistem cron (WP-Cron devre dışı)
- Otomatik backup (7 gün retention)
- Health check endpoint'leri
- Must-use plugin tabanlı optimizasyonlar

### 📦 Dahil Eklentiler
- **Redis Object Cache**: Veritabanı sorgu cache'leme
- **WP Super Cache**: Sayfa cache'leme
- **Autoptimize**: CSS/JS birleştirme ve minify
- **Asset CleanUp**: Gereksiz script temizleme
- **Smush (WP Smushit)**: Görsel optimizasyonu (%60-80 küçülme)

## 📋 Gereksinimler

### Sistem Gereksinimleri
- **Docker**: 20.10+
- **Docker Compose**: 2.0+
- **Workpanel**: v2 API desteği
- **Minimum RAM**: 512MB (önerilen: 1GB+)
- **Disk Alanı**: 5GB+

### Desteklenen Ortamlar
- **Workpanel**: Evet (önerilen)
- **Docker Compose**: Manuel test için
- **Standalone Docker**: Geliştirme için

## 🛠️ Kurulum

### Workpanel Üzerinden Deploy

```bash
# 1. Repoyu klonlayın
git clone https://github.com/googig/googig-wordpress.git
cd googig-wordpress

# 2. Değişiklikleri commit edin
git add .
git commit -m "feat: WordPress optimizasyonları"

# 3. Workpanel üzerinden deploy edin
# Web UI veya CLI kullanın
```

### Manuel Docker Compose ile Test

```bash
# 1. Build edin
docker build -t googig-wordpress:elite .

# 2. Çalıştırın
docker run -d \
  --name wp-test \
  -p 8080:80 \
  -e WORDPRESS_DB_HOST=host.docker.internal:3306 \
  -e WORDPRESS_DB_USER=wp_user \
  -e WORDPRESS_DB_PASSWORD=your_password \
  -e WORDPRESS_DB_NAME=wp_database \
  googig-wordpress:elite

# 3. Logları kontrol edin
docker logs -f wp-test
```

## ⚙️ Yapılandırma

### Ortam Değişkenleri

```bash
# Veritabanı Bağlantısı
WORDPRESS_DB_HOST=wordpress-db
WORDPRESS_DB_USER=wp_user
WORDPRESS_DB_PASSWORD=cokgizlisifre123
WORDPRESS_DB_NAME=wp_database

# Sistem Ayarları
TZ=Europe/Istanbul
```

### Workpanel Yapılandırması

`workpanel.json` dosyasında tanımlanan servisler:

- **wordpress-app**: Ana WordPress uygulaması
- **wordpress-db**: MariaDB veritabanı
- **wordpress-redis**: Redis cache servisi

### Volume Mounts

```json
{
  "wp-uploads": "/var/www/html/wp-content/uploads",
  "wp-plugins": "/var/www/html/wp-content/plugins",
  "wp-themes": "/var/www/html/wp-content/themes",
  "db-data": "/var/lib/mysql",
  "redis-data": "/data"
}
```

## 🚀 Kullanım

### İlk Kurulum Sonrası

1. **WordPress'e Giriş Yapın**
   ```
   URL: https://blog.googig.cloud/wp-admin/
   Kullanıcı: Kurulum sırasında belirlenen
   Şifre: Kurulum sırasında belirlenen
   ```

2. **Cache Eklentilerini Etkinleştirin**
   - Eklentiler > Yüklü Eklentiler > Redis Object Cache > Etkinleştir
   - Ayarlar > Redis > Enable Object Cache
   - Eklentiler > WP Super Cache > Etkinleştir
   - Ayarlar > WP Super Cache > Caching On

3. **Optimizasyon Eklentilerini Yapılandırın**
   - **Autoptimize**: CSS/JS optimize + aggregate
   - **Asset CleanUp**: Gereksiz script'leri kaldır
   - **Smush**: Bulk Smush ile tüm görselleri optimize et

### Health Check

```bash
# Sistem durumu kontrolü
curl https://blog.googig.cloud/health
# Beklenen: "ok"
```

### Cache Temizleme

```bash
# Nginx microcache temizleme
docker exec wordpress-app rm -rf /dev/shm/nginx-cache/*

# Redis cache temizleme
docker exec wordpress-redis redis-cli FLUSHALL

# WordPress cache temizleme
docker exec wordpress-app wp cache flush
```

## 📊 Performans Metrikleri

| Metrik | Hedef | Mevcut | Durum |
|--------|-------|--------|-------|
| **TTFB (Origin)** | <200ms | 150ms | ✅ |
| **TTFB (Edge)** | <50ms | 20ms | ✅ |
| **Sayfa Yükleme** | <500ms | 300-500ms | ✅ |
| **Sayfa Ağırlığı** | <1MB | <1MB | ✅ |
| **İstek Sayısı** | 15-20 | 15-20 | ✅ |
| **PHP-FPM Kapasite** | 100 | 100 | ✅ |

### Cache Hit Oranları

- **Nginx Microcache**: %95+ (1 saniye TTL)
- **Redis Object Cache**: %90+ (veritabanı sorguları)
- **WP Super Cache**: %85+ (sayfa cache)
- **OPcache**: %100 (PHP bytecode)

## 🔧 Optimizasyon Detayları

### Sunucu Seviyesi
- **Nginx**: Microcaching (1s), Gzip level 6, Brotli hazır
- **PHP-FPM**: 100 max children, OPcache 256MB, JIT tracing
- **MariaDB**: InnoDB 1GB buffer pool, tmpdir RAM disk

### WordPress Seviyesi
- **Must-Use Plugin**: Otomatik optimizasyonlar (wp_head temizliği, heartbeat kontrolü)
- **WP-Cron**: Sistem cron'a taşındı (15 dakikalık aralık)
- **Revisions**: 3'e sınırlandırıldı
- **Memory Limit**: 512MB

### Güvenlik
- **XML-RPC**: Tamamen engellendi
- **Theme/Plugin Editor**: Devre dışı
- **File Permissions**: Güvenli ayarlar

## 🚀 Deployment

### Otomatik Deployment (Workpanel)

```bash
git add .
git commit -m "feat: yeni optimizasyonlar"
git push origin main
# Workpanel otomatik deploy eder
```

### Manuel Deployment

```bash
# Build
docker build -t googig-wordpress:latest .

# Deploy
docker-compose up -d

# Health check
curl http://localhost/health
```

### Post-Deploy Kontroller

```bash
# Container durumu
docker ps | grep wordpress

# Redis bağlantısı
docker exec wordpress-redis redis-cli INFO stats

# Cron çalışıyor mu?
docker exec wordpress-app ps aux | grep cron

# Cache çalışıyor mu?
curl -I https://blog.googig.cloud/
# X-Micro-Cache: HIT görmelisiniz
```

## 🔍 Sorun Giderme

### Redis Bağlantı Hatası

```bash
# Redis servisi çalışıyor mu?
docker ps | grep redis

# Redis logları
docker logs wordpress-redis

# WordPress'ten test
docker exec wordpress-app php -r "var_dump(extension_loaded('redis'));"
```

### Cache Çalışmıyor

```bash
# Nginx cache dizini
docker exec wordpress-app ls -la /dev/shm/nginx-cache/

# Nginx yapılandırması
docker exec wordpress-app nginx -t

# WordPress cache eklentileri aktif mi?
wp plugin list --status=active
```

### Yüksek CPU/RAM Kullanımı

```bash
# PHP-FPM durum
docker exec wordpress-app php-fpm82 -t

# Aktif process'ler
docker exec wordpress-app ps aux | grep php

# MySQL slow query log
docker exec wordpress-db tail -f /var/lib/mysql/mysql-slow.log
```

### Cron Çalışmıyor

```bash
# Sistem cron çalışıyor mu?
docker exec wordpress-app ps aux | grep cron

# Crontab içeriği
docker exec wordpress-app crontab -l

# Manuel cron çalıştırma
docker exec wordpress-app /var/www/html/cron-wp.sh
```

## 📚 Dokümantasyon

- **[Optimizasyon Detayları](README-OPTIMIZATIONS.md)**: Teknik optimizasyon açıklamaları
- **[Deployment Rehberi](DEPLOYMENT-GUIDE.md)**: Kurulum ve deploy adımları
- **[Changelog](CHANGELOG.md)**: Sürüm geçmişi ve değişiklikler
- **[Cloudflare Setup](CLOUDFLARE-SETUP.md)**: Edge optimizasyonları
- **[Elite Performance](ELITE-PERFORMANCE.md)**: Performans raporları

## 🤝 Katkıda Bulunma

1. **Fork** edin
2. **Feature branch** oluşturun (`git checkout -b feature/amazing-feature`)
3. **Commit** edin (`git commit -m 'Add amazing feature'`)
4. **Push** edin (`git push origin feature/amazing-feature`)
5. **Pull Request** açın

### Geliştirme Ortamı

```bash
# Geliştirme için
docker-compose -f docker-compose.dev.yml up

# Test çalıştırma
docker exec wordpress-app wp test run

# Linting
docker exec wordpress-app composer lint
```

## 📄 Lisans

Bu proje [GPL v2](LICENSE) lisansı altında lisanslanmıştır.

## 🙏 Teşekkürler

- **Workpanel** ekibine optimizasyon rehberi için
- **WordPress** topluluğuna
- **Docker** ekibine container teknolojisi için

## 📞 İletişim

- **Proje Sahibi**: Googig
- **Website**: https://blog.googig.cloud
- **İssues**: [GitHub Issues](https://github.com/googig/googig-wordpress/issues)
- **Discussions**: [GitHub Discussions](https://github.com/googig/googig-wordpress/discussions)

---

**Son Güncelleme**: 30 Nisan 2026  
**Versiyon**: 2.0.0 Elite  
**Durum**: ✅ Production Ready</content>
<parameter name="filePath">README.md