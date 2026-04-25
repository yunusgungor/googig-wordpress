<?php
/**
 * Plugin Name: Zstandard (zstd) Compression
 * Description: Tüm sayfa çıktılarını Gzip/Brotli yerine çok daha hızlı olan Zstandard (zstd) algoritması ile sıkıştırır.
 * Version: 1.0.0
 * Author: Workpanel AI
 */

// Sadece ön yüz için çalıştırılır, Admin paneli hariç tutulur
if (!is_admin() && extension_loaded('zstd')) {
    
    // İstemci tarayıcının zstd destekleyip desteklemediğini kontrol et
    $accept_encoding = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';
    
    if (strpos($accept_encoding, 'zstd') !== false) {
        // Çıktı tamponunu (Output Buffer) zstd sıkıştırma fonksiyonuna bağla
        ob_start('workpanel_zstd_compress_output');
    }
}

/**
 * Çıktıyı zstd ile sıkıştıran ve ilgili HTTP başlıklarını ekleyen fonksiyon
 */
function workpanel_zstd_compress_output($buffer) {
    // Çıktı boşsa işlem yapma
    if (empty($buffer)) {
        return $buffer;
    }
    
    // Zstd sıkıştırma işlemi (Seviye 3 genellikle optimum performans verir)
    $compressed = zstd_compress($buffer, 3);
    
    // Eğer sıkıştırma başarısız olursa orijinal çıktıyı dön
    if ($compressed === false) {
        return $buffer;
    }
    
    // İlgili HTTP Header'larını gönder
    header('Content-Encoding: zstd');
    header('Vary: Accept-Encoding');
    // Yeni boyutu bildir
    header('Content-Length: ' . strlen($compressed));
    
    return $compressed;
}
