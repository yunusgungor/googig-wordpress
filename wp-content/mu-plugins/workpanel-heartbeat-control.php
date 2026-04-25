<?php
/**
 * Plugin Name: Heartbeat Control (AI Optimized)
 * Description: Sunucuyu gizlice yoran Heartbeat (Kalp Atışı) isteklerini ön yüzde tamamen kapatır, admin panelinde ise 60 saniyeye çekerek RAM tüketimini durdurur. Eklenti kurmanıza gerek kalmaz.
 * Version: 1.0.0
 * Author: Workpanel AI
 */

// Heartbeat hızını (sıklığını) admin panelinde en yavaş konuma (60 saniye) alıyoruz
add_filter('heartbeat_settings', function($settings) {
    // Standart 15 saniyeyi 60 saniyeye çıkartarak sunucuya giden AJAX yükünü %75 azaltıyoruz
    $settings['interval'] = 60;
    return $settings;
});

// Ön yüzde (Frontend) Heartbeat scriptini tamamen devre dışı bırakıyoruz
add_action('init', function() {
    // Eğer yönetici paneli sayfasında değilsek, Heartbeat'i tamamen iptal et
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}, 1);
