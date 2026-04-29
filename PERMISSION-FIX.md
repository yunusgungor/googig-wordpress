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
3. **Kritik Sorun:** Autoptimize cache clear yapıldığında klasörler **root:root** olarak yeniden oluşturuluyordu

**Çözüm:** 
- İzinler 755 yerine **775** olmalı (group write gerekli)
- Her 5 dakikada bir cron job ile izinler otomatik düzeltilmeli

## ✅ Çözüm

### 1. Dockerfile Güncelleme

```dockerfile
# Yetkilendirme ve Klasör İzinleri
RUN mkdir -p /var/www/html/wp-content/uploads && \
    mkdir -p /var/www/html/wp-content/cache/autoptimize/css && \
    mkdir -p /var/www/html/wp-content/cache/autoptimize/js && \
    mkdir -p /var/www/html/wp-content/ewww && \
    mkdir -p /run/nginx && \
    chown -R nobody:nobody /var/www/html && \
    chown -R nobody:nobody /var/lib/nginx && \
    chmod -R 755 /var/www/html/wp-content/uploads && \
    chmod -R 775 /var/www/html/wp-content/cache && \
    chmod -R 755 /var/www/html/wp-content/ewww
```

**Not:** Cache klasörü için **775** izinleri (group write gerekli)

### 2. setup-plugins.sh Güncelleme

```bash
# Autoptimize cache klasörü (775 izinleri - group write gerekli)
if [ ! -d "/var/www/html/wp-content/cache/autoptimize" ]; then
    mkdir -p /var/www/html/wp-content/cache/autoptimize/css
    mkdir -p /var/www/html/wp-content/cache/autoptimize/js
    chown -R nobody:nobody /var/www/html/wp-content/cache
    chmod -R 775 /var/www/html/wp-content/cache
    echo "✅ Autoptimize cache klasörü oluşturuldu (775)"
else
    # Her zaman izinleri düzelt (Autoptimize cache clear sonrası root:root olabiliyor)
    chown -R nobody:nobody /var/www/html/wp-content/cache
    chmod -R 775 /var/www/html/wp-content/cache
    echo "✅ Autoptimize cache izinleri düzeltildi (775)"
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

**Not:** Script her çalıştığında izinleri düzeltir (idempotent)

### 3. start.sh Güncelleme (Cron Job)

```bash
# Her 5 dakikada bir Autoptimize cache izinlerini düzelt
# (Autoptimize cache clear sonrası root:root olma sorununu önler)
(crontab -l 2>/dev/null; echo "*/5 * * * * chown -R nobody:nobody /var/www/html/wp-content/cache && chmod -R 775 /var/www/html/wp-content/cache") | crontab -
```

**Not:** Bu cron job her 5 dakikada bir izinleri otomatik düzeltir

### 4. Mevcut Container'da Manuel Düzeltme

```bash
# SSH ile sunucuya bağlan
ssh sunucum

# Container içinde klasörleri oluştur ve izinleri düzelt
docker exec <container_name> sh -c '
    mkdir -p /var/www/html/wp-content/cache/autoptimize/css && \
    mkdir -p /var/www/html/wp-content/cache/autoptimize/js && \
    mkdir -p /var/www/html/wp-content/ewww && \
    chown -R nobody:nobody /var/www/html/wp-content/cache && \
    chown -R nobody:nobody /var/www/html/wp-content/ewww && \
    chmod -R 775 /var/www/html/wp-content/cache && \
    chmod -R 755 /var/www/html/wp-content/ewww
'
```

**Not:** Cache için **775**, EWWW için **755** izinleri

## 🔍 Doğrulama

### 1. Klasör Varlığı
```bash
docker exec <container> ls -la /var/www/html/wp-content/ | grep -E "cache|ewww"
```

**Beklenen:**
```
drwxrwxr-x    3 nobody   nobody        4096 cache
drwxr-xr-x    3 nobody   nobody        4096 ewww
```

**Not:** Cache klasörü **775** (rwxrwxr-x), EWWW klasörü **755** (rwxr-xr-x)

### 2. İzinler
```bash
docker exec <container> ls -la /var/www/html/wp-content/cache/
```

**Beklenen:**
```
drwxrwxr-x    3 nobody   nobody        4096 .
drwxrwxr-x    3 nobody   nobody        4096 autoptimize
```

**Not:** **775** izinleri (rwxrwxr-x) - group write gerekli

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
├── cache/                    (775, nobody:nobody) ← GROUP WRITE
│   └── autoptimize/         (775, nobody:nobody)
│       ├── css/             (775, nobody:nobody)
│       └── js/              (775, nobody:nobody)
├── ewww/                    (755, nobody:nobody)
│   ├── lazy/                (755, nobody:nobody)
│   └── tools/               (755, nobody:nobody)
├── plugins/                 (755, nobody:nobody)
├── themes/                  (755, nobody:nobody)
└── uploads/                 (755, nobody:nobody)
```

**Kritik:** Cache klasörü **775** olmalı (group write gerekli)

## 🎯 Neden nobody:nobody ve 775?

WordPress PHP-FPM pool'u `nobody` kullanıcısı ile çalışıyor:

```ini
[www]
user = nobody
group = nobody
```

Bu nedenle:
- Tüm WordPress dosyaları `nobody:nobody` sahipliğinde olmalı
- Cache klasörü **775** izinleri ile group write'a izin vermeli
- Autoptimize cache clear yapınca klasörler root:root olabiliyor, bu yüzden cron job ile sürekli düzeltilmeli

## 🔄 Gelecek Deployment'lar

Yeni deployment'larda bu sorun olmayacak çünkü:
1. ✅ Dockerfile klasörleri 775 izinleri ile oluşturuyor
2. ✅ setup-plugins.sh her çalıştığında izinleri kontrol ediyor
3. ✅ Cron job her 5 dakikada bir izinleri düzeltiyor
4. ✅ İdempotent (tekrar çalıştırılabilir)

**Autoptimize Cache Clear Sorunu:** Autoptimize cache clear yapıldığında klasörler root:root olarak yeniden oluşturulabiliyor. Bu yüzden cron job kritik!

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
# Beklenen: drwxrwxr-x (775) nobody:nobody
```

4. **Manuel izin düzeltme (gerekirse):**
```bash
docker exec <container> sh -c 'chown -R nobody:nobody /var/www/html/wp-content/cache && chmod -R 775 /var/www/html/wp-content/cache'
```

5. **WordPress admin'de test et:**
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
