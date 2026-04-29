# Cloudflare Edge Caching Kurulumu

Bu dokümantasyon, `blog.googig.cloud` için Cloudflare üzerinde "Elite" seviye performans elde etmek için gerekli ayarları içerir.

## 🎯 Hedef Metrikler

| Metrik | Hedef |
|--------|-------|
| **TTFB (Edge)** | 0.01s - 0.03s |
| **Sayfa Ağırlığı** | <1MB |
| **İstek Sayısı** | ~15-20 |

## 1. Cloudflare Page Rules

### Cache Everything Rule

**URL Pattern:** `blog.googig.cloud/*`

**Ayarlar:**
- **Cache Level:** Cache Everything
- **Edge Cache TTL:** 2 hours (7200 seconds)
- **Browser Cache TTL:** 1 year
- **Origin Cache Control:** On

**Oluşturma Adımları:**
1. Cloudflare Dashboard → Rules → Page Rules
2. "Create Page Rule" butonuna tıklayın
3. URL pattern: `blog.googig.cloud/*`
4. Add Setting → Cache Level → Cache Everything
5. Add Setting → Edge Cache TTL → 2 hours
6. Add Setting → Browser Cache TTL → 1 year
7. Save and Deploy

### Admin Panel Bypass Rule

**URL Pattern:** `blog.googig.cloud/wp-admin/*`

**Ayarlar:**
- **Cache Level:** Bypass
- **Disable Performance**

**Oluşturma Adımları:**
1. Page Rules → Create Page Rule
2. URL pattern: `blog.googig.cloud/wp-admin/*`
3. Add Setting → Cache Level → Bypass
4. Add Setting → Disable Performance
5. Save and Deploy

### Login Bypass Rule

**URL Pattern:** `blog.googig.cloud/wp-login.php*`

**Ayarlar:**
- **Cache Level:** Bypass

## 2. Cloudflare Speed Optimizations

### Auto Minify
**Path:** Speed → Optimization → Content Optimization

- ✅ JavaScript
- ✅ CSS
- ✅ HTML

### Brotli Compression
**Path:** Speed → Optimization → Content Optimization

- ✅ Enable Brotli

### Early Hints
**Path:** Speed → Optimization → Protocol Optimization

- ✅ Enable Early Hints

### HTTP/3 (QUIC)
**Path:** Network → HTTP/3

- ✅ Enable HTTP/3 (with QUIC)

### 0-RTT Connection Resumption
**Path:** Network → 0-RTT Connection Resumption

- ✅ Enable

## 3. Cloudflare Caching Configuration

### Browser Cache TTL
**Path:** Caching → Configuration

- **Browser Cache TTL:** Respect Existing Headers

### Caching Level
**Path:** Caching → Configuration

- **Caching Level:** Standard

### Always Online
**Path:** Caching → Configuration

- ✅ Enable Always Online

## 4. Cloudflare Security (Performance Impact)

### Security Level
**Path:** Security → Settings

- **Security Level:** Medium (Balance between security and performance)

### Bot Fight Mode
**Path:** Security → Bots

- ✅ Enable Bot Fight Mode (Blocks bad bots without CAPTCHA)

## 5. Cache Purge Stratejisi

### Manuel Purge
Cloudflare Dashboard → Caching → Configuration → Purge Cache

**Ne Zaman Purge Yapılmalı:**
- Yeni içerik yayınlandığında
- Tema veya eklenti güncellemelerinde
- Tasarım değişikliklerinde

### Otomatik Purge (WP Plugin ile)
**Önerilen Plugin:** Cloudflare (Official)

```bash
# Container içinde WP-CLI ile kurulum
wp plugin install cloudflare --activate
```

**Plugin Ayarları:**
- API Token oluşturun (Cloudflare Dashboard → My Profile → API Tokens)
- Zone ID'yi girin
- "Automatic Cache Purge" seçeneğini aktifleştirin

## 6. DNS Ayarları

### Proxy Status
**Path:** DNS → Records

- **blog.googig.cloud:** ✅ Proxied (Orange Cloud)

### CNAME Flattening
**Path:** DNS → Settings

- ✅ Enable CNAME Flattening

## 7. Doğrulama

### Cache Status Kontrolü
```bash
curl -I https://blog.googig.cloud
```

**Beklenen Headers:**
```
cf-cache-status: HIT
x-micro-cache: HIT
cache-control: public, max-age=31536000
```

### TTFB Testi
```bash
curl -w "TTFB: %{time_starttransfer}s\n" -o /dev/null -s https://blog.googig.cloud
```

**Beklenen:** <0.05s (50ms)

### GTmetrix Test
- https://gtmetrix.com
- Test URL: https://blog.googig.cloud
- **Hedef Grade:** A (95+)

### PageSpeed Insights
- https://pagespeed.web.dev
- Test URL: https://blog.googig.cloud
- **Hedef Score:** 90+ (Mobile & Desktop)

## 8. Troubleshooting

### Cache HIT Alınamıyorsa

1. **Page Rules sırasını kontrol edin** (Admin bypass en üstte olmalı)
2. **Cookie kontrolü:** Giriş yapmış kullanıcılar için cache bypass olur
3. **Query string kontrolü:** `?` parametreli URL'ler farklı cache key'e sahiptir
4. **Development Mode:** Kapalı olduğundan emin olun

### TTFB Yüksekse

1. **Origin sunucu yanıt süresini kontrol edin:**
   ```bash
   curl -w "Origin TTFB: %{time_starttransfer}s\n" -o /dev/null -s -H "Host: blog.googig.cloud" http://ORIGIN_IP
   ```
2. **Argo Smart Routing** kullanmayı düşünün (Ücretli)
3. **Cloudflare Workers** ile edge computing kullanın

## 9. Maliyet Optimizasyonu

### Free Plan ile Maksimum Performans
- ✅ Cache Everything (Free)
- ✅ Auto Minify (Free)
- ✅ Brotli (Free)
- ✅ HTTP/3 (Free)
- ✅ Always Online (Free)

### Pro Plan Avantajları ($20/ay)
- ✅ Polish (Image Optimization)
- ✅ Mirage (Lazy Loading)
- ✅ Mobile Redirect
- ✅ 20 Page Rules (Free: 3)

### Business Plan Avantajları ($200/ay)
- ✅ Argo Smart Routing
- ✅ Custom Cache Keys
- ✅ Bypass Cache on Cookie
- ✅ 50 Page Rules

## 10. WordPress Entegrasyonu

### wp-config.php Ayarları
```php
// Cloudflare IP'lerini güvenilir proxy olarak tanımla
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

// Cloudflare SSL
if (isset($_SERVER['HTTP_CF_VISITOR'])) {
    $visitor = json_decode($_SERVER['HTTP_CF_VISITOR']);
    if ($visitor->scheme == 'https') {
        $_SERVER['HTTPS'] = 'on';
    }
}
```

### Cache Purge Webhook
```bash
# Yeni post yayınlandığında Cloudflare cache'i temizle
wp plugin install cloudflare --activate
wp cloudflare cache purge
```

## 📊 Beklenen Sonuçlar

### Başlangıç (Optimizasyon Öncesi)
- TTFB: ~1.45s
- Sayfa Ağırlığı: ~10MB+
- İstek Sayısı: 65+

### Final (Optimizasyon Sonrası)
- TTFB: **0.02s** (Edge)
- Sayfa Ağırlığı: **<1MB**
- İstek Sayısı: **~15-20**
- İyileşme: **%98**

---

**Not:** Bu ayarlar blog.googig.cloud için optimize edilmiştir. Farklı siteler için ayarlar değişebilir.

**Tarih:** 29 Nisan 2026  
**Durum:** Hazır - Cloudflare Dashboard'dan uygulanabilir
