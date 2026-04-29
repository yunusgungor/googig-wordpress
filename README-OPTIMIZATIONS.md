# WordPress Hızlandırma Optimizasyonları

Bu WordPress kurulumu, `workpanel/docs/wordpress-hizlandirma.md` dökümanında belirtilen optimizasyonlarla yapılandırılmıştır.

## ✅ Uygulanan Optimizasyonlar

### 1. Sunucu Seviyesi Optimizasyonlar

#### Nginx + PHP-FPM Mimarisi
- ✅ Apache yerine hafif Nginx kullanımı
- ✅ PHP-FPM worker limitleri (max_children=30, OOM koruması)
- ✅ Microcaching (1 saniyelik cache, /dev/shm üzerinde)
- ✅ Gzip sıkıştırma (level 6)
- ✅ Brotli desteği hazır (nginx modülü gerekli)
- ✅ Statik dosyalar için cache (30 gün)
- ✅ Access log kapalı (Disk I/O tasarrufu)

#### PHP Optimizasyonları
- ✅ PHP 8.2 (JIT desteği ile)
- ✅ OPcache aktif (64MB, JIT tracing mode)
- ✅ Zend Garbage Collector kapalı (CPU tasarrufu)
- ✅ Redis extension yüklü

#### Veritabanı Optimizasyonları
- ✅ MariaDB 10.11 (MySQL yerine, daha az RAM tüketimi)
- ✅ InnoDB buffer pool: 1GB
- ✅ tmpdir: /dev/shm (RAM disk kullanımı)
- ✅ innodb_flush_log_at_trx_commit=2 (performans)

### 2. WordPress Seviyesi Optimizasyonlar

#### Otomatik Yüklenen Eklentiler
- ✅ **Redis Object Cache**: Veritabanı sorgularını cache'ler
- ✅ **WP Super Cache**: Sayfa cache'leme
- ✅ **Workpanel Optimizations** (mu-plugin): Otomatik optimizasyonlar

#### wp-config.php Ayarları
- ✅ WP_CACHE: true (kurulum sonrası)
- ✅ WP_POST_REVISIONS: 3 (veritabanı tasarrufu)
- ✅ DISABLE_WP_CRON: true (sistem cron kullanımı)
- ✅ WP_MEMORY_LIMIT: 512M
- ✅ Redis bağlantı ayarları

#### Güvenlik ve Performans
- ✅ XML-RPC engellendi (brute-force koruması)
- ✅ Heartbeat API sınırlandırıldı (60 saniye)
- ✅ wp_head temizliği (gereksiz kodlar kaldırıldı)
- ✅ Emoji scripts devre dışı
- ✅ Embed scripts devre dışı
- ✅ Pingback/Trackback devre dışı
- ✅ Theme/Plugin editor devre dışı (güvenlik)
- ✅ Lazy loading aktif (native)
- ✅ Fragment caching örneği (Transients API)

#### WooCommerce Optimizasyonları (Eğer kuruluysa)
- ✅ Cart Fragments devre dışı
- ✅ WooCommerce scripts sadece gerekli sayfalarda
- ✅ WooCommerce Analytics kapalı
- ⚠️ HPOS aktivasyonu (manuel, kurulum sonrası)

### 3. Sistem Entegrasyonları

#### Cron Yönetimi
- ✅ WordPress cron devre dışı
- ✅ Sistem cron her 15 dakikada çalışıyor
- ✅ `/var/www/html/cron-wp.sh` scripti

#### Cache Yönetimi
- ✅ Nginx microcache: /dev/shm/nginx-cache
- ✅ Redis: wordpress-redis servisi
- ✅ OPcache: PHP seviyesinde

## 📊 Beklenen Performans İyileştirmeleri

| Metrik | Öncesi | Sonrası | İyileşme |
|--------|--------|---------|----------|
| Sayfa Yükleme | ~2-3s | ~0.3-0.5s | %80-85 |
| RAM Kullanımı | %95+ | %60-70 | %25-35 |
| Veritabanı Sorguları | 50-100 | 5-15 | %85-90 |
| CPU Kullanımı | %80+ | %30-50 | %40-50 |

## 🔧 Kurulum Sonrası Yapılması Gerekenler

### 1. Redis Object Cache Aktivasyonu
WordPress admin paneline giriş yapın:
```
Eklentiler > Yüklü Eklentiler > Redis Object Cache > Etkinleştir
Ayarlar > Redis > Enable Object Cache
```

### 2. WP Super Cache Aktivasyonu
```
Eklentiler > Yüklü Eklentiler > WP Super Cache > Etkinleştir
Ayarlar > WP Super Cache > Caching On
```

### 3. Görsel Optimizasyonu (Önerilen)
Resim dosyalarınızı optimize etmek için aşağıdaki eklentilerden birini kurun:
```
- Smush (Ücretsiz, otomatik sıkıştırma)
- ShortPixel (Ücretsiz 100 resim/ay, WebP desteği)
- WebP Express (WebP formatına çevirme)
```

### 4. E-posta Offloading (Önerilen)
WordPress'in mail() fonksiyonu yerine harici SMTP kullanın:
```
Eklenti: WP Mail SMTP
Servisler: SendGrid (100 mail/gün ücretsiz), Mailgun, Gmail API
```

### 5. Çeviri Dosyaları Optimizasyonu (Türkçe siteler için)
Eğer siteniz Türkçe ise, .mo dosyalarını optimize edin:
```
Eklenti: Performant Translations veya Loco Translate
.mo dosyalarını .php array formatına çevirin
%30-50 performans artışı sağlar
```

### 6. Cloudflare Entegrasyonu (Önerilen)
- Domain'i Cloudflare'e ekleyin
- SSL/TLS: Full (strict)
- Caching Level: Standard
- Auto Minify: JS, CSS, HTML
- Brotli: Açık
- HTTP/3: Açık (Traefik seviyesinde de gerekli)
- Bot Fight Mode: Açık (Brute-force koruması)

### 7. WooCommerce HPOS (Eğer kullanılıyorsa)
```
WooCommerce > Ayarlar > Gelişmiş > Özellikler
High-Performance Order Storage (HPOS) > Etkinleştir
```

## 🚀 İleri Düzey Optimizasyonlar (Opsiyonel)

### Traefik HTTP/3 Desteği
Workpanel Traefik yapılandırmasına ekleyin:
```yaml
entryPoints:
  websecure:
    http3:
      advertisedPort: 443
```

### Brotli Nginx Modülü
Eğer nginx brotli modülü yüklüyse, `nginx.conf` içindeki yorum satırlarını kaldırın.

### Swap Alanı (Host Sunucuda)
```bash
# 2GB swap oluştur
sudo fallocate -l 2G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab
```

### TCP BBR (Host Sunucuda)
```bash
# BBR algoritmasını aktifleştir
echo "net.core.default_qdisc=fq" | sudo tee -a /etc/sysctl.conf
echo "net.ipv4.tcp_congestion_control=bbr" | sudo tee -a /etc/sysctl.conf
sudo sysctl -p
```

## 📝 Notlar

- **mu-plugins**: `wp-content/mu-plugins/workpanel-optimizations.php` otomatik yüklenir ve devre dışı bırakılamaz
- **Cron**: Sistem cron kullanıldığı için wp-cron.php web üzerinden çağrılmaz
- **Cache**: Microcache 1 saniye süreyle çalışır, admin/login sayfalarında bypass edilir
- **Redis**: wordpress-redis servisi ile otomatik bağlanır

## 🔍 Sorun Giderme

### Redis Bağlantı Hatası
```bash
# Redis servisini kontrol et
docker ps | grep redis
docker logs wordpress-redis
```

### Cache Temizleme
```bash
# Nginx cache temizle
rm -rf /dev/shm/nginx-cache/*

# Redis cache temizle
docker exec wordpress-redis redis-cli FLUSHALL
```

### Cron Çalışmıyor
```bash
# Container içinde cron loglarını kontrol et
docker exec wordpress-app grep wp-cron /var/log/messages
```

## 📚 Referanslar

- Kaynak Doküman: `workpanel/docs/wordpress-hizlandirma.md`
- Workpanel Yapılandırması: `workpanel.json`
- Nginx Yapılandırması: `nginx.conf`
- PHP-FPM Yapılandırması: Dockerfile içinde

## 🎯 Sonuç

Bu optimizasyonlar sayesinde 512 MB RAM ile bile yüksek performanslı bir WordPress sitesi çalıştırabilirsiniz. Tüm ayarlar workpanel yapısına uyumlu şekilde yapılandırılmıştır ve deploy sırasında otomatik olarak aktif olur.
