# Eklenti İzin Sorunu ve Çözümü

**Tarih:** 29 Nisan 2026  
**Sorun:** Autoptimize ve EWWW Image Optimizer izin hataları  
**Durum:** ✅ Çözüldü

## 🚨 Hatalar

### 1. Autoptimize
```
Autoptimize cannot write to the cache directory 
(/var/www/html/wp-content/cache/autoptimize/), 
please fix to enable CSS/JS optimization!
```

### 2. EWWW Image Optimizer
```
EWWW Image Optimizer could not install tools in 
/var/www/html/wp-content/ewww/. 
Please adjust permissions on the folder.
```

## 🔍 Sebep

Eklentiler çalışmak için özel klasörlere ihtiyaç duyuyor:
- **Autoptimize:** `/var/www/html/wp-content/cache/autoptimize/` (CSS/JS cache)
- **EWWW:** `/var/www/html/wp-content/ewww/` (optimization tools)

Bu klasörler:
1. Otomatik oluşturulmuyordu
2. Veya yanlış izinlere sahipti (root:root yerine nobody:nobody olmalı)

## ✅ Çözüm

### 1. Dockerfile Güncelleme

```dockerfile
# Yetkilendirme ve Klasör İzinleri
RUN mkdir -p /var/www/html/wp-content/uploads && \
    mkdir -p /var/www/html/wp-content/cache/autoptimize && \
    mkdir -p /var/www/html/wp-content/ewww && \
    mkdir -p /run/nginx && \
    chown -R nobody:nobody /var/www/html && \
    chown -R nobody:nobody /var/lib/nginx && \
    chmod -R 755 /var/www/html/wp-content/uploads && \
    chmod -R 755 /var/www/html/wp-content/cache && \
    chmod -R 755 /var/www/html/wp-content/ewww
```

### 2. setup-plugins.sh Güncelleme

```bash
# Autoptimize cache klasörü
if [ ! -d "/var/www/html/wp-content/cache/autoptimize" ]; then
    mkdir -p /var/www/html/wp-content/cache/autoptimize
    chown -R nobody:nobody /var/www/html/wp-content/cache
    chmod -R 755 /var/www/html/wp-content/cache
    echo "✅ Autoptimize cache klasörü oluşturuldu"
else
    chown -R nobody:nobody /var/www/html/wp-content/cache/autoptimize
    chmod -R 755 /var/www/html/wp-content/cache/autoptimize
    echo "✅ Autoptimize cache izinleri düzeltildi"
fi

# EWWW Image Optimizer tools klasörü
if [ ! -d "/var/www/html/wp-content/ewww" ]; then
    mkdir -p /var/www/html/wp-content/ewww
    chown -R nobody:nobody /var/www/html/wp-content/ewww
    chmod -R 755 /var/www/html/wp-content/ewww
    echo "✅ EWWW tools klasörü oluşturuldu"
else
    chown -R nobody:nobody /var/www/html/wp-content/ewww
    chmod -R 755 /var/www/html/wp-content/ewww
    echo "✅ EWWW tools izinleri düzeltildi"
fi
```

### 3. Mevcut Container'da Manuel Düzeltme

```bash
# SSH ile sunucuya bağlan
ssh sunucum

# Container içinde klasörleri oluştur ve izinleri düzelt
docker exec <container_name> sh -c '
    mkdir -p /var/www/html/wp-content/cache/autoptimize && \
    mkdir -p /var/www/html/wp-content/ewww && \
    chown -R nobody:nobody /var/www/html/wp-content/cache && \
    chown -R nobody:nobody /var/www/html/wp-content/ewww && \
    chmod -R 755 /var/www/html/wp-content/cache && \
    chmod -R 755 /var/www/html/wp-content/ewww
'
```

## 🔍 Doğrulama

### 1. Klasör Varlığı
```bash
docker exec <container> ls -la /var/www/html/wp-content/ | grep -E "cache|ewww"
```

**Beklenen:**
```
drwxr-xr-x    3 nobody   nobody        4096 cache
drwxr-xr-x    3 nobody   nobody        4096 ewww
```

### 2. İzinler
```bash
docker exec <container> ls -la /var/www/html/wp-content/cache/
```

**Beklenen:**
```
drwxr-xr-x    3 nobody   nobody        4096 .
drwxr-xr-x    3 nobody   nobody        4096 autoptimize
```

### 3. WordPress Admin
```
WordPress Admin → Settings → Autoptimize
```
**Hata mesajı kaybolmalı** ✅

```
WordPress Admin → Media → Bulk Optimize
```
**Hata mesajı kaybolmalı** ✅

## 📊 İzin Yapısı

```
/var/www/html/wp-content/
├── cache/                    (755, nobody:nobody)
│   └── autoptimize/         (755, nobody:nobody)
│       ├── css/             (755, nobody:nobody)
│       └── js/              (755, nobody:nobody)
├── ewww/                    (755, nobody:nobody)
│   ├── lazy/                (755, nobody:nobody)
│   └── tools/               (755, nobody:nobody)
├── plugins/                 (755, nobody:nobody)
├── themes/                  (755, nobody:nobody)
└── uploads/                 (755, nobody:nobody)
```

## 🎯 Neden nobody:nobody?

WordPress PHP-FPM pool'u `nobody` kullanıcısı ile çalışıyor:

```ini
[www]
user = nobody
group = nobody
```

Bu nedenle tüm WordPress dosyaları `nobody:nobody` sahipliğinde olmalı.

## 🔄 Gelecek Deployment'lar

Yeni deployment'larda bu sorun olmayacak çünkü:
1. ✅ Dockerfile klasörleri oluşturuyor
2. ✅ setup-plugins.sh izinleri kontrol ediyor
3. ✅ İdempotent (tekrar çalıştırılabilir)

## 🚨 Troubleshooting

### Hata Hala Görünüyorsa

1. **Cache temizle:**
```bash
docker exec <container> wp cache flush --allow-root
```

2. **Eklentiyi deaktif/aktif et:**
```bash
docker exec <container> wp plugin deactivate autoptimize --allow-root
docker exec <container> wp plugin activate autoptimize --allow-root
```

3. **İzinleri tekrar kontrol et:**
```bash
docker exec <container> ls -la /var/www/html/wp-content/cache/autoptimize/
```

4. **WordPress admin'de test et:**
   - Settings → Autoptimize → "Test Autoptimize" butonuna tıkla

### EWWW Tools İndirme Hatası

EWWW Image Optimizer ilk kullanımda optimization tools'ları indirir. Bu işlem:
- ~30-60 saniye sürebilir
- Internet bağlantısı gerektirir
- `/var/www/html/wp-content/ewww/` klasörüne yazma izni gerektirir

**Manuel indirme:**
```bash
docker exec <container> wp ewww-image-optimizer install --allow-root
```

## 📚 İlgili Dosyalar

- `Dockerfile` - Klasör oluşturma ve izinler
- `setup-plugins.sh` - Runtime izin kontrolü
- `start.sh` - Script çalıştırma

---

**Sonuç:** İzin sorunu çözüldü, eklentiler artık cache ve tools klasörlerine yazabilir! ✅

**Tarih:** 29 Nisan 2026  
**Durum:** ✅ Çözüldü - Yeni Deployment Gerekli
