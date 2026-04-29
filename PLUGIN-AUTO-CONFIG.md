# Otomatik Eklenti Yapılandırması

Bu dokümantasyon, googig-wordpress projesinde eklentilerin otomatik olarak nasıl yapılandırıldığını açıklar.

## 🎯 Amaç

WordPress kurulumu tamamlandığında, performans eklentilerinin (Autoptimize, Asset CleanUp, Smush) optimal ayarlarla otomatik olarak yapılandırılması.

## 🔧 Yapılandırma Mekanizması

### 1. Çift Katmanlı Yaklaşım

#### Katman 1: WP-CLI Script (setup-plugins.sh)
- Container başladıktan 30 saniye sonra çalışır
- WordPress kurulumunu bekler (max 60 saniye)
- Eklentileri aktifleştirir
- WP-CLI ile ayarları yapar
- Log: `/var/log/setup-plugins.log`

#### Katman 2: Must-Use Plugin (workpanel-auto-config.php)
- WordPress admin paneli ilk yüklendiğinde çalışır
- Daha güvenilir (WordPress API kullanır)
- Sadece bir kez çalışır (flag: `workpanel_auto_config_done`)
- Admin notice ile kullanıcıyı bilgilendirir

### 2. Yapılandırılan Eklentiler

#### ✅ Autoptimize

**JavaScript Ayarları:**
```php
autoptimize_js = on
autoptimize_js_aggregate = on        // Tüm JS dosyalarını birleştir
autoptimize_js_defer = on             // JS'yi defer et
autoptimize_js_exclude = wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.min.js
```

**CSS Ayarları:**
```php
autoptimize_css = on
autoptimize_css_aggregate = on        // Tüm CSS dosyalarını birleştir
autoptimize_css_inline = on           // Küçük CSS'leri inline yap
autoptimize_css_defer = on            // CSS'yi defer et
autoptimize_css_defer_inline = on     // Critical CSS inline
```

**HTML Ayarları:**
```php
autoptimize_html = on                 // HTML minify
autoptimize_html_keepcomments = off   // Yorumları kaldır
```

**Özel Ayarlar:**
```php
autoptimize_optimize_logged = off     // Giriş yapmış kullanıcılar için kapalı
autoptimize_optimize_checkout = off   // Checkout sayfasında kapalı
autoptimize_optimize_cart = off       // Sepet sayfasında kapalı
```

**Etki:**
- HTTP istek sayısı: %60-70 azalma
- JS/CSS boyutu: %30-40 küçülme
- Parse/Compile süresi: %40-50 azalma

---

#### ✅ Asset CleanUp

**Temel Ayarlar:**
```php
test_mode = 0                         // Test modu kapalı
dashboard_show = 1                    // Dashboard'da göster
hide_core_files = 1                   // Core dosyaları gizle
input_style = enhanced                // Gelişmiş arayüz
fetch_cached_files_details = 1        // Cache detayları
```

**Otomatik Temizlik:**
```php
disable_emojis = 1                    // Emoji script'lerini kaldır
disable_oembed = 1                    // oEmbed script'lerini kaldır
disable_jquery_migrate = 1            // jQuery Migrate'i kaldır
disable_comment_reply = 1             // Comment reply script'ini kaldır
disable_dashicons_for_guests = 1      // Misafirler için Dashicons kapalı
```

**Etki:**
- Gereksiz script'ler: %30-40 azalma
- DOM yükü: %20-30 azalma
- Sayfa ağırlığı: %15-25 azalma

---

#### ✅ Smush

**Temel Ayarlar:**
```php
auto = 1                              // Otomatik sıkıştırma
lossy = 1                             // Lossy sıkıştırma (%60-80 küçülme)
strip_exif = 1                        // EXIF verilerini kaldır
resize = 1                            // Büyük görselleri yeniden boyutlandır
detection = 1                         // Yanlış boyutlandırma tespiti
original = 0                          // Orijinal dosyayı sakla (kapalı)
backup = 0                            // Yedekleme (kapalı - disk tasarrufu)
png_to_jpg = 1                        // PNG → JPG dönüşümü (uygunsa)
lazy_load = 1                         // Lazy loading
usage = 0                             // Kullanım istatistikleri (kapalı)
```

**Lazy Load Ayarları:**
```php
format:
  iframe = 1                          // iframe'leri lazy load
  img = 1                             // Görselleri lazy load

output:
  content = 1                         // İçerikteki görseller
  widgets = 1                         // Widget'lardaki görseller
  thumbnails = 1                      // Thumbnail'ler
  gravatars = 1                       // Gravatar'lar

fadein:
  duration = 400                      // Fade-in süresi (ms)
  delay = 0                           // Gecikme yok

placeholder = 1                       // Placeholder göster
```

**Resize Ayarları:**
```php
width = 1920                          // Max genişlik
height = 1920                         // Max yükseklik
```

**CDN/WebP Ayarları:**
```php
auto_resize = 0                       // Otomatik resize (kapalı)
webp = 1                              // WebP desteği (aktif)
```

**Etki:**
- Görsel boyutu: %60-80 küçülme
- LCP (Largest Contentful Paint): %40-60 iyileşme
- Bandwidth: %70-80 tasarruf
- Lazy load ile initial load: %50-60 hızlanma

---

#### ✅ Redis Object Cache

**Ayarlar:**
```php
// wp-config.php'de zaten yapılandırılmış
WP_REDIS_HOST = wordpress-redis
WP_REDIS_PORT = 6379
WP_REDIS_DATABASE = 0
WP_REDIS_MAXTTL = 3600
```

**Etki:**
- Veritabanı sorguları: %80-90 azalma
- Sayfa oluşturma süresi: %60-70 azalma
- Sunucu yükü: %50-60 azalma

---

## 📋 Yapılandırma Akışı

```
Container Başlatma
    ↓
start.sh çalışır
    ↓
30 saniye bekle
    ↓
setup-plugins.sh (arka planda)
    ├─ WordPress kurulumu bekle (max 60s)
    ├─ Eklentileri aktifleştir
    ├─ WP-CLI ile ayarları yap
    └─ Log: /var/log/setup-plugins.log
    ↓
WordPress Admin İlk Yükleme
    ↓
workpanel-auto-config.php (mu-plugin)
    ├─ Yapılandırma flag kontrolü
    ├─ Eklenti ayarlarını yap (WordPress API)
    ├─ Flag set et (workpanel_auto_config_done)
    └─ Admin notice göster
    ↓
Kullanıcı Bilgilendirilir
    ↓
Manuel Adımlar:
    ├─ Smush → Bulk Smush
    ├─ Asset CleanUp → Sayfa bazında temizlik
    └─ Performans testi
```

## 🔍 Doğrulama

### 1. Setup Script Logları
```bash
# Container içinde
docker exec <container_name> cat /var/log/setup-plugins.log
```

**Beklenen Çıktı:**
```
🚀 WordPress eklenti yapılandırması başlatılıyor...
✅ WordPress kurulumu tespit edildi
📦 Eklentiler aktifleştiriliyor...
✅ Redis Cache aktif
✅ WP Super Cache aktif
✅ Autoptimize aktif
✅ Asset CleanUp aktif
✅ Smush aktif
🔧 Redis Object Cache yapılandırılıyor...
✅ Redis Object Cache etkinleştirildi
🔧 Autoptimize yapılandırılıyor...
✅ Autoptimize optimal ayarlar uygulandı
🔧 Asset CleanUp yapılandırılıyor...
✅ Asset CleanUp optimal ayarlar uygulandı
🔧 Smush yapılandırılıyor...
✅ Smush optimal ayarlar uygulandı
✨ Eklenti yapılandırması tamamlandı!
```

### 2. WordPress Admin Kontrolü
```
WordPress Admin → Araçlar → Workpanel Config
```

**Durum:** "Tamamlandı ✅"

### 3. Eklenti Ayarları Kontrolü

#### Autoptimize
```
WordPress Admin → Settings → Autoptimize
```
- ✅ Optimize JavaScript Code
- ✅ Aggregate JS-files
- ✅ Optimize CSS Code
- ✅ Aggregate CSS-files
- ✅ Optimize HTML Code

#### Asset CleanUp
```
WordPress Admin → Asset CleanUp → Settings
```
- ✅ Disable Emojis
- ✅ Disable oEmbed
- ✅ Disable jQuery Migrate
- ✅ Disable Dashicons for guests

#### Smush
```
WordPress Admin → Smush → Dashboard
```
- ✅ Automatic compression
- ✅ Lossy compression
- ✅ Strip my image metadata
- ✅ Resize my full size images
- ✅ Lazy load images

### 4. WP-CLI Kontrolü
```bash
# Container içinde
docker exec <container_name> sh

# Autoptimize ayarları
wp option get autoptimize_js_aggregate --allow-root
# Beklenen: on

# Smush ayarları
wp option get wp-smush-settings --allow-root --format=json
# Beklenen: {"auto":"1","lossy":"1",...}

# Asset CleanUp ayarları
wp option get wpacu_settings --allow-root --format=json
# Beklenen: {"disable_emojis":"1",...}
```

## 🔄 Manuel Sıfırlama

### Yöntem 1: WordPress Admin
```
WordPress Admin → Araçlar → Workpanel Config → Yapılandırmayı Sıfırla
```

### Yöntem 2: WP-CLI
```bash
docker exec <container_name> sh
wp option delete workpanel_auto_config_done --allow-root
wp option delete workpanel_auto_config_in_progress --allow-root
```

### Yöntem 3: Script Yeniden Çalıştırma
```bash
docker exec <container_name> /var/www/html/setup-plugins.sh
```

## 🚨 Troubleshooting

### Setup Script Çalışmadı
```bash
# Log kontrolü
docker exec <container_name> cat /var/log/setup-plugins.log

# Manuel çalıştırma
docker exec <container_name> /var/www/html/setup-plugins.sh
```

### Mu-Plugin Çalışmadı
```bash
# Mu-plugin kontrolü
docker exec <container_name> ls -la /var/www/html/wp-content/mu-plugins/

# Flag kontrolü
docker exec <container_name> wp option get workpanel_auto_config_done --allow-root
```

### Eklentiler Aktif Değil
```bash
# Eklenti listesi
docker exec <container_name> wp plugin list --allow-root

# Manuel aktivasyon
docker exec <container_name> wp plugin activate autoptimize --allow-root
```

### Ayarlar Uygulanmadı
```bash
# Option kontrolü
docker exec <container_name> wp option list --search="autoptimize*" --allow-root

# Manuel ayar
docker exec <container_name> wp option update autoptimize_js_aggregate 'on' --allow-root
```

## 📊 Performans Etkisi

| Metrik | Öncesi | Sonrası | İyileşme |
|--------|--------|---------|----------|
| **HTTP İstekleri** | 65+ | ~15-20 | %70 |
| **Sayfa Ağırlığı** | ~10MB | <1MB | %90 |
| **JS/CSS Boyutu** | ~2MB | ~600KB | %70 |
| **Görsel Boyutu** | ~8MB | ~1.5MB | %80 |
| **LCP** | ~4s | <1.5s | %60 |
| **TBT** | ~800ms | <200ms | %75 |

## 🎯 Manuel Adımlar (Deployment Sonrası)

### 1. Smush Bulk Optimization
```
WordPress Admin → Smush → Bulk Smush → Bulk Smush Now
```
**Süre:** Görsel sayısına göre 5-30 dakika

### 2. Asset CleanUp Sayfa Bazında Temizlik
```
1. Ana sayfayı ziyaret et
2. Asset CleanUp bar'ını aç
3. Gereksiz script'leri devre dışı bırak:
   - Contact Form 7 (eğer ana sayfada form yoksa)
   - WooCommerce (eğer e-ticaret yoksa)
   - Diğer kullanılmayan eklenti script'leri
```

### 3. Performans Testi
```bash
# GTmetrix
https://gtmetrix.com/?url=https://blog.googig.cloud

# PageSpeed Insights
https://pagespeed.web.dev/?url=https://blog.googig.cloud

# WebPageTest
https://www.webpagetest.org/?url=https://blog.googig.cloud
```

## 📚 Referanslar

- Autoptimize Docs: https://autoptimize.com/
- Asset CleanUp Docs: https://www.gabelivan.com/items/wp-asset-clean-up-pro/
- Smush Docs: https://wpmudev.com/docs/wpmu-dev-plugins/smush/
- WP-CLI Docs: https://wp-cli.org/

---

**Tarih:** 29 Nisan 2026  
**Versiyon:** 2.0.0  
**Durum:** ✅ Otomatik Yapılandırma Aktif
