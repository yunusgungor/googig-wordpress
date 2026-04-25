<?php
/**
 * Plugin Name: Transients API Example (Fragment Caching)
 * Description: Dinamik sayfalarda veritabanı yoran sorguları (en çok satan ürünler vb.) parçacık olarak RAM'de (Redis) tutar.
 * Version: 1.0.0
 * Author: Workpanel AI
 */

/**
 * Bu fonksiyon, sitenizde veya temanızda veritabanını çok yoran
 * spesifik bir listeyi (örneğin popüler gönderiler, karmaşık ürün filtreleri)
 * parçacık halinde önbelleğe almanızı sağlayan bir ÖRNEKTİR.
 * 
 * Temanızın functions.php veya ilgili yerlerinde doğrudan bu fonksiyonu çağırabilirsiniz.
 */
function workpanel_get_heavy_query_data() {
    // Sürüm kontrolü için eşsiz anahtar
    $cache_key = 'wp_heavy_custom_query_v1';
    
    // Redis (veya Memcached) Object Cache kurulu ise bu istek doğrudan RAM'den gelir
    $data = get_transient($cache_key);
    
    // Eğer önbellekte yoksa (veya süresi dolduysa)
    if (false === $data) {
        global $wpdb;
        
        // --- BURASI NORMALDE VERİTABANINI YORAN KISIMDIR ---
        // $data = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type = 'product' ORDER BY yorum_sayisi DESC LIMIT 10");
        
        // Simülasyon verisi:
        $data = "Bu ağır veri sadece 1 kez veritabanından hesaplandı ve RAM'e aktarıldı.";
        
        // Veriyi 1 saatliğine (3600 saniye) Redis'e yaz (Parçacık Önbellekleme)
        set_transient($cache_key, $data, 3600);
    }
    
    return $data;
}
