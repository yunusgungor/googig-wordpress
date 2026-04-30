<?php
/**
 * Plugin Name: Workpanel WordPress Optimizations
 * Description: Otomatik performans optimizasyonları (Workpanel tarafından yönetilir)
 * Version: 1.0.0
 * Author: Workpanel
 */

// Güvenlik: Doğrudan erişimi engelle
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. wp_head Temizliği - Gereksiz Kodları Kaldır
 */
function workpanel_clean_wp_head() {
    // WordPress Generator Tag
    remove_action('wp_head', 'wp_generator');
    
    // RSD Link (Really Simple Discovery)
    remove_action('wp_head', 'rsd_link');
    
    // Windows Live Writer Manifest
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // REST API Link
    remove_action('wp_head', 'rest_output_link_wp_head');
    
    // oEmbed Discovery Links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Emoji Scripts ve Styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // RSS Feed Links (Gerekirse kaldırın)
    // remove_action('wp_head', 'feed_links', 2);
    // remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'workpanel_clean_wp_head');

/**
 * 2. Heartbeat API Kontrolü
 */
function workpanel_heartbeat_settings($settings) {
    // Admin panelinde 60 saniyeye çıkar
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'workpanel_heartbeat_settings');

// Frontend'de Heartbeat'i tamamen kapat
function workpanel_disable_heartbeat_frontend() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'workpanel_disable_heartbeat_frontend', 1);

/**
 * 3. Kullanılmayan CSS/JS Yüklenmesini Engelle
 */
function workpanel_disable_embeds() {
    // WordPress Embed Script'i kaldır
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'workpanel_disable_embeds');

/**
 * 4. WooCommerce Optimizasyonları (Eğer WooCommerce aktifse)
 */
if (class_exists('WooCommerce')) {
    
    // Cart Fragments'ı devre dışı bırak (Sepet ikonunu manuel güncelle)
    add_action('wp_enqueue_scripts', function() {
        wp_dequeue_script('wc-cart-fragments');
    }, 11);
    
    // WooCommerce Scripts'i sadece gerekli sayfalarda yükle
    add_action('wp_enqueue_scripts', function() {
        if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
            // WooCommerce CSS'lerini kaldır
            wp_dequeue_style('woocommerce-general');
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-smallscreen');
            
            // WooCommerce JS'lerini kaldır
            wp_dequeue_script('wc-add-to-cart');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('wc-cart-fragments');
        }
    }, 99);
    
    // WooCommerce Analytics'i kapat (Admin panelinde)
    add_filter('woocommerce_admin_disabled', '__return_true');
    add_filter('woocommerce_marketing_menu_items', '__return_empty_array');
}

/**
 * 5. Autoloaded Options Temizliği (Veritabanı Optimizasyonu)
 */
function workpanel_cleanup_autoload() {
    global $wpdb;
    
    // Transient'ları temizle (Süresi dolmuş geçici veriler)
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%' AND option_value < UNIX_TIMESTAMP()");
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%' AND option_value < UNIX_TIMESTAMP()");
}
// Günde bir kez çalıştır
if (!wp_next_scheduled('workpanel_cleanup_autoload')) {
    wp_schedule_event(time(), 'daily', 'workpanel_cleanup_autoload');
}
add_action('workpanel_cleanup_autoload', 'workpanel_cleanup_autoload');

/**
 * 6. Preconnect ve DNS Prefetch Ekle
 */
function workpanel_resource_hints($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $urls[] = '//fonts.googleapis.com';
        $urls[] = '//fonts.gstatic.com';
    }
    
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => '//fonts.googleapis.com',
            'crossorigin',
        );
    }
    
    return $urls;
}
add_filter('wp_resource_hints', 'workpanel_resource_hints', 10, 2);

/**
 * 7. Lazy Loading için Native Support
 */
function workpanel_add_lazy_loading($content) {
    // WordPress 5.5+ zaten native lazy loading destekliyor
    // Ek bir şey yapmaya gerek yok, sadece aktif olduğundan emin ol
    return $content;
}

/**
 * 8. Veritabanı Sorgu Optimizasyonu
 */
function workpanel_optimize_queries() {
    // Post meta sorgularını optimize et
    if (!is_admin()) {
        // Gereksiz meta sorguları engelle
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    }
}
add_action('init', 'workpanel_optimize_queries');

/**
 * 9. Redis Object Cache Durumunu Kontrol Et
 */
function workpanel_check_redis_status() {
    if (function_exists('wp_cache_get_last_changed')) {
        // Redis aktif
        return true;
    }
    return false;
}

/**
 * 10. Admin Bar Optimizasyonu (Frontend'de)
 */
if (!is_admin()) {
    add_filter('show_admin_bar', '__return_false');
}

/**
 * 11. Fragment Caching Örneği (Transients API)
 * Örnek: Popüler yazılar widget'ı için
 */
function workpanel_get_popular_posts_cached($limit = 5) {
    $cache_key = 'workpanel_popular_posts_' . $limit;
    $popular_posts = get_transient($cache_key);
    
    if (false === $popular_posts) {
        // Cache yoksa sorguyu çalıştır
        $popular_posts = new WP_Query(array(
            'posts_per_page' => $limit,
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'post_status' => 'publish'
        ));
        
        // 1 saat boyunca cache'le
        set_transient($cache_key, $popular_posts, HOUR_IN_SECONDS);
    }
    
    return $popular_posts;
}

/**
 * 12. Lazy Loading için Native Support
 * WordPress 5.5+ zaten native lazy loading destekliyor
 */
add_filter('wp_lazy_loading_enabled', '__return_true');

/**
 * 13. Preconnect ve DNS Prefetch için Ek Domainler
 * Eğer harici CDN veya font servisleri kullanıyorsanız
 */
function workpanel_add_preconnect_tags() {
    // Örnek: Google Fonts kullanıyorsanız
    // echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
    // echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com">';
}
add_action('wp_head', 'workpanel_add_preconnect_tags', 1);

/**
 * 14. Disable Pingbacks ve Trackbacks (Güvenlik + Performans)
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

/**
 * 15. Limit Post Revisions During Save (Ek Koruma)
 * wp-config.php'deki ayarı destekler
 */
add_filter('wp_revisions_to_keep', function($num, $post) {
    return 3;
}, 10, 2);

/**
 * 16. Disable Theme/Plugin Editor (Güvenlik)
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * 17. Limit Login Attempts (Güvenlik + Performans)
 * Brute-force saldırılarını yavaşlatır
 */
function workpanel_limit_login_attempts() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);
    
    if ($attempts && $attempts >= 5) {
        wp_die('Too many login attempts. Please try again in 15 minutes.', 'Login Blocked', array('response' => 429));
    }
}
add_action('wp_login_failed', function() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key) ?: 0;
    set_transient($transient_key, $attempts + 1, 15 * MINUTE_IN_SECONDS);
});
add_action('login_form', 'workpanel_limit_login_attempts');

/**
 * 18. Disable RSS Feeds (Eğer kullanmıyorsanız)
 * RSS feed'ler veritabanı sorgusu yapar
 */
// add_action('do_feed', function() { wp_die('No feed available.'); }, 1);
// add_action('do_feed_rdf', function() { wp_die('No feed available.'); }, 1);
// add_action('do_feed_rss', function() { wp_die('No feed available.'); }, 1);
// add_action('do_feed_rss2', function() { wp_die('No feed available.'); }, 1);
// add_action('do_feed_atom', function() { wp_die('No feed available.'); }, 1);

/**
 * 19. Optimize Database Tables on Schedule
 * Haftada bir veritabanı tablolarını optimize et
 */
function workpanel_optimize_database() {
    global $wpdb;
    $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);
    foreach ($tables as $table) {
        $wpdb->query("OPTIMIZE TABLE {$table[0]}");
    }
}
if (!wp_next_scheduled('workpanel_optimize_database')) {
    wp_schedule_event(time(), 'weekly', 'workpanel_optimize_database');
}
add_action('workpanel_optimize_database', 'workpanel_optimize_database');

/**
 * 20. Defer JavaScript Loading
 * JavaScript dosyalarını defer ile yükle
 */
function workpanel_defer_scripts($tag, $handle, $src) {
    // Admin panelinde defer kullanma
    if (is_admin()) {
        return $tag;
    }
    
    // Kritik scriptleri defer etme (bağımlılık sorunları için)
    $exclude_handles = [
        'jquery',
        'jquery-core',
        'jquery-migrate',
        'blocksy',
        'blocksy-companion',
        'stackable',
        'otter'
    ];
    
    if (in_array($handle, $exclude_handles)) {
        return $tag;
    }
    
    // Defer ekle
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'workpanel_defer_scripts', 10, 3);

/**
 * 21. Preload Critical Resources
 * Kritik kaynakları önceden yükle
 */
function workpanel_preload_resources() {
    // Tema CSS'ini preload et
    $theme_uri = get_stylesheet_directory_uri();
    echo '<link rel="preload" href="' . $theme_uri . '/style.css" as="style">';
    
    // Font dosyalarını preload et (eğer varsa)
    // echo '<link rel="preload" href="' . $theme_uri . '/fonts/font.woff2" as="font" type="font/woff2" crossorigin>';
}
add_action('wp_head', 'workpanel_preload_resources', 1);

/**
 * 22. Disable Dashicons on Frontend (Giriş yapmamış kullanıcılar için)
 */
function workpanel_disable_dashicons() {
    if (!is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'workpanel_disable_dashicons');

/**
 * 23. Limit Post Revisions During Autosave
 */
add_filter('wp_revisions_to_keep', function($num, $post) {
    // Autosave için sadece 1 revizyon tut
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return 1;
    }
    return 3;
}, 10, 2);

/**
 * Bilgi: Bu dosya mu-plugins klasöründe olduğu için otomatik yüklenir
 * ve devre dışı bırakılamaz. Workpanel tarafından yönetilir.
 */
