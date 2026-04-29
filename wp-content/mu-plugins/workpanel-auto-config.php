<?php
/**
 * Plugin Name: Workpanel Auto Configuration
 * Description: Otomatik olarak eklenti ayarlarını yapılandırır (sadece ilk kurulumda)
 * Version: 1.0.0
 * Author: Workpanel
 */

// Sadece admin panelinde çalış
if (!is_admin()) {
    return;
}

// Yapılandırmanın daha önce yapılıp yapılmadığını kontrol et
$config_done = get_option('workpanel_auto_config_done', false);

if ($config_done) {
    return; // Zaten yapılandırılmış
}

// WordPress tam yüklendiğinde çalış
add_action('admin_init', 'workpanel_auto_configure_plugins', 1);

function workpanel_auto_configure_plugins() {
    // Tekrar kontrol (race condition önleme)
    if (get_option('workpanel_auto_config_done', false)) {
        return;
    }

    // Yapılandırma başladı işareti
    update_option('workpanel_auto_config_in_progress', true);

    try {
        // Autoptimize Ayarları
        if (is_plugin_active('autoptimize/autoptimize.php')) {
            workpanel_configure_autoptimize();
        }

        // Asset CleanUp Ayarları
        if (is_plugin_active('wp-asset-clean-up/wpacu.php')) {
            workpanel_configure_asset_cleanup();
        }

        // Smush Ayarları
        if (is_plugin_active('wp-smushit/wp-smush.php')) {
            workpanel_configure_smush();
        }

        // Redis Cache Ayarları
        if (is_plugin_active('redis-cache/redis-cache.php')) {
            workpanel_configure_redis();
        }

        // Yapılandırma tamamlandı
        update_option('workpanel_auto_config_done', true);
        delete_option('workpanel_auto_config_in_progress');

        // Admin notice ekle
        add_action('admin_notices', 'workpanel_config_success_notice');

    } catch (Exception $e) {
        error_log('Workpanel Auto Config Error: ' . $e->getMessage());
        delete_option('workpanel_auto_config_in_progress');
    }
}

function workpanel_configure_autoptimize() {
    // JavaScript Ayarları
    update_option('autoptimize_js', 'on');
    update_option('autoptimize_js_aggregate', 'on');
    update_option('autoptimize_js_defer', 'on');
    update_option('autoptimize_js_exclude', 'wp-includes/js/dist/, wp-includes/js/tinymce/, js/jquery/jquery.min.js');
    
    // CSS Ayarları
    update_option('autoptimize_css', 'on');
    update_option('autoptimize_css_aggregate', 'on');
    update_option('autoptimize_css_inline', 'on');
    update_option('autoptimize_css_defer', 'on');
    update_option('autoptimize_css_defer_inline', 'on');
    
    // HTML Ayarları
    update_option('autoptimize_html', 'on');
    update_option('autoptimize_html_keepcomments', 'off');
    
    // Diğer Ayarlar
    update_option('autoptimize_optimize_logged', 'off'); // Giriş yapmış kullanıcılar için optimize etme
    update_option('autoptimize_optimize_checkout', 'off'); // Checkout sayfasında optimize etme
    update_option('autoptimize_optimize_cart', 'off'); // Sepet sayfasında optimize etme
    
    error_log('Workpanel: Autoptimize configured successfully');
}

function workpanel_configure_asset_cleanup() {
    $settings = array(
        'test_mode' => 0,
        'dashboard_show' => 1,
        'hide_core_files' => 1,
        'input_style' => 'enhanced',
        'fetch_cached_files_details' => 1,
        'disable_emojis' => 1,
        'disable_oembed' => 1,
        'disable_jquery_migrate' => 1,
        'disable_comment_reply' => 1,
        'disable_dashicons_for_guests' => 1,
    );
    
    update_option('wpacu_settings', $settings);
    
    error_log('Workpanel: Asset CleanUp configured successfully');
}

function workpanel_configure_smush() {
    // Temel Ayarlar
    $settings = array(
        'auto' => 1,              // Otomatik sıkıştırma
        'lossy' => 1,             // Lossy sıkıştırma (daha fazla küçülme)
        'strip_exif' => 1,        // EXIF verilerini kaldır
        'resize' => 1,            // Büyük görselleri yeniden boyutlandır
        'detection' => 1,         // Yanlış boyutlandırılmış görselleri tespit et
        'original' => 0,          // Orijinal dosyayı sakla (kapalı - disk tasarrufu)
        'backup' => 0,            // Yedekleme (kapalı - disk tasarrufu)
        'png_to_jpg' => 1,        // PNG'yi JPG'ye dönüştür (uygunsa)
        'lazy_load' => 1,         // Lazy loading
        'usage' => 0,             // Kullanım istatistikleri (kapalı)
    );
    update_option('wp-smush-settings', $settings);
    
    // Lazy Load Ayarları
    $lazy_load = array(
        'format' => array(
            'iframe' => 1,
            'img' => 1,
        ),
        'output' => array(
            'content' => 1,
            'widgets' => 1,
            'thumbnails' => 1,
            'gravatars' => 1,
        ),
        'exclude' => array(
            'classes' => '',
            'urls' => '',
        ),
        'fadein' => array(
            'duration' => 400,
            'delay' => 0,
        ),
        'spinner' => array(
            'selected' => 0,
        ),
        'placeholder' => 1,
    );
    update_option('wp-smush-lazy_load', $lazy_load);
    
    // Resize Ayarları (Max 1920px)
    $resize_sizes = array(
        'width' => 1920,
        'height' => 1920,
    );
    update_option('wp-smush-resize_sizes', $resize_sizes);
    
    // CDN Ayarları
    $cdn = array(
        'auto_resize' => 0,
        'webp' => 1,  // WebP desteği
    );
    update_option('wp-smush-cdn', $cdn);
    
    error_log('Workpanel: Smush configured successfully');
}

function workpanel_configure_redis() {
    // Redis Object Cache zaten wp-config.php'de yapılandırılmış
    // Sadece enable etmeyi dene
    if (function_exists('wp_redis_enable_cache')) {
        wp_redis_enable_cache();
        error_log('Workpanel: Redis Object Cache enabled successfully');
    }
}

function workpanel_config_success_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><strong>🚀 Workpanel Elite Performance</strong></p>
        <p>Tüm eklentiler otomatik olarak optimal ayarlarla yapılandırıldı:</p>
        <ul style="list-style: disc; margin-left: 20px;">
            <li>✅ <strong>Autoptimize:</strong> CSS/JS birleştirme ve minify aktif</li>
            <li>✅ <strong>Asset CleanUp:</strong> Gereksiz script temizleme aktif</li>
            <li>✅ <strong>Smush:</strong> Görsel optimizasyonu aktif (lossy, lazy load, WebP)</li>
            <li>✅ <strong>Redis Cache:</strong> Object cache aktif</li>
        </ul>
        <p><strong>Sonraki Adımlar:</strong></p>
        <ol style="margin-left: 20px;">
            <li>Smush → <strong>Bulk Smush</strong> ile tüm görselleri optimize edin</li>
            <li>Asset CleanUp ile sayfa bazında gereksiz script'leri temizleyin</li>
            <li>Performans testi yapın (GTmetrix, PageSpeed Insights)</li>
        </ol>
    </div>
    <?php
}

// Manuel reset için admin sayfası
add_action('admin_menu', 'workpanel_add_reset_menu');

function workpanel_add_reset_menu() {
    add_management_page(
        'Workpanel Config Reset',
        'Workpanel Config',
        'manage_options',
        'workpanel-config-reset',
        'workpanel_config_reset_page'
    );
}

function workpanel_config_reset_page() {
    if (isset($_POST['reset_config']) && check_admin_referer('workpanel_reset_config')) {
        delete_option('workpanel_auto_config_done');
        delete_option('workpanel_auto_config_in_progress');
        echo '<div class="notice notice-success"><p>Yapılandırma sıfırlandı. Sayfayı yenileyin.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Workpanel Yapılandırma</h1>
        <p>Otomatik yapılandırma durumu: <strong><?php echo get_option('workpanel_auto_config_done') ? 'Tamamlandı ✅' : 'Bekliyor ⏳'; ?></strong></p>
        
        <form method="post">
            <?php wp_nonce_field('workpanel_reset_config'); ?>
            <p>Eklenti ayarlarını sıfırlamak ve yeniden yapılandırmak için:</p>
            <button type="submit" name="reset_config" class="button button-secondary">Yapılandırmayı Sıfırla</button>
        </form>
    </div>
    <?php
}
