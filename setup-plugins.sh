#!/bin/sh
# WordPress Eklenti Otomatik Yapılandırma Scripti
# Bu script container başladıktan sonra eklentileri aktifleştirir ve optimal ayarları yapar

echo "🚀 WordPress eklenti yapılandırması başlatılıyor..."

# WordPress kurulumunun tamamlanmasını bekle
MAX_WAIT=60
WAIT_COUNT=0
while [ $WAIT_COUNT -lt $MAX_WAIT ]; do
    if wp core is-installed --allow-root 2>/dev/null; then
        echo "✅ WordPress kurulumu tespit edildi"
        break
    fi
    echo "⏳ WordPress kurulumu bekleniyor... ($WAIT_COUNT/$MAX_WAIT)"
    sleep 2
    WAIT_COUNT=$((WAIT_COUNT + 2))
done

if [ $WAIT_COUNT -ge $MAX_WAIT ]; then
    echo "⚠️  WordPress kurulumu tespit edilemedi. Eklenti yapılandırması atlanıyor."
    exit 0
fi

# Eklentileri aktifleştir
echo "📦 Eklentiler aktifleştiriliyor..."

wp plugin activate redis-cache --allow-root 2>/dev/null && echo "✅ Redis Cache aktif"
wp plugin activate wp-super-cache --allow-root 2>/dev/null && echo "✅ WP Super Cache aktif"
wp plugin activate autoptimize --allow-root 2>/dev/null && echo "✅ Autoptimize aktif"
wp plugin activate wp-asset-clean-up --allow-root 2>/dev/null && echo "✅ Asset CleanUp aktif"
wp plugin activate ewww-image-optimizer --allow-root 2>/dev/null && echo "✅ EWWW Image Optimizer aktif"

# Redis Object Cache'i etkinleştir
echo "🔧 Redis Object Cache yapılandırılıyor..."
wp redis enable --allow-root 2>/dev/null && echo "✅ Redis Object Cache etkinleştirildi"

# Autoptimize Optimal Ayarları
echo "🔧 Autoptimize yapılandırılıyor..."
wp option update autoptimize_js_aggregate 'on' --allow-root
wp option update autoptimize_js_defer 'on' --allow-root
wp option update autoptimize_js_exclude 'wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.min.js' --allow-root
wp option update autoptimize_css_aggregate 'on' --allow-root
wp option update autoptimize_css_inline 'on' --allow-root
wp option update autoptimize_css_defer 'on' --allow-root
wp option update autoptimize_css_defer_inline 'on' --allow-root
wp option update autoptimize_html 'on' --allow-root
wp option update autoptimize_html_keepcomments 'off' --allow-root
wp option update autoptimize_optimize_logged 'off' --allow-root
wp option update autoptimize_optimize_checkout 'off' --allow-root
wp option update autoptimize_optimize_cart 'off' --allow-root
echo "✅ Autoptimize optimal ayarlar uygulandı"

# Asset CleanUp Optimal Ayarları
echo "🔧 Asset CleanUp yapılandırılıyor..."
wp option update wpacu_settings '{"test_mode":"0","dashboard_show":"1","hide_core_files":"1","input_style":"enhanced","fetch_cached_files_details":"1","disable_emojis":"1","disable_oembed":"1","disable_jquery_migrate":"1","disable_comment_reply":"1"}' --format=json --allow-root
echo "✅ Asset CleanUp optimal ayarlar uygulandı"

# EWWW Image Optimizer Optimal Ayarları
echo "🔧 EWWW Image Optimizer yapılandırılıyor..."

# EWWW temel ayarları
wp option update ewww_image_optimizer_auto 1 --allow-root
wp option update ewww_image_optimizer_jpg_level 30 --allow-root
wp option update ewww_image_optimizer_png_level 20 --allow-root
wp option update ewww_image_optimizer_metadata_remove 1 --allow-root
wp option update ewww_image_optimizer_jpg_quality 82 --allow-root
wp option update ewww_image_optimizer_lazy_load 1 --allow-root
wp option update ewww_image_optimizer_webp 1 --allow-root
wp option update ewww_image_optimizer_maxmediawidth 1920 --allow-root
wp option update ewww_image_optimizer_maxmediaheight 1920 --allow-root
wp option update ewww_image_optimizer_resize_detection 1 --allow-root

echo "✅ EWWW Image Optimizer optimal ayarlar uygulandı"

# WP Super Cache ayarları (zaten wp-cache-config.php ile yapılandırıldı)
echo "✅ WP Super Cache zaten yapılandırılmış"

# Cache temizliği
echo "🧹 Cache temizleniyor..."
wp cache flush --allow-root 2>/dev/null
wp transient delete --expired --allow-root 2>/dev/null

echo "✨ Eklenti yapılandırması tamamlandı!"
echo ""
echo "📊 Yapılandırılan Eklentiler:"
echo "  ✅ Redis Object Cache - Veritabanı sorgu cache"
echo "  ✅ WP Super Cache - Sayfa cache"
echo "  ✅ Autoptimize - CSS/JS optimize (aggregate, defer, inline)"
echo "  ✅ Asset CleanUp - Gereksiz script temizleme"
echo "  ✅ EWWW Image Optimizer - Görsel optimize (lossy, lazy load, WebP, max 1920px)"
echo ""
echo "🎯 Sonraki Adımlar:"
echo "  1. WordPress Admin'e giriş yapın"
echo "  2. Media → Bulk Optimize ile tüm görselleri optimize edin"
echo "  3. Asset CleanUp ile sayfa bazında gereksiz script'leri temizleyin"
echo "  4. Performans testi yapın (GTmetrix, PageSpeed Insights)"
