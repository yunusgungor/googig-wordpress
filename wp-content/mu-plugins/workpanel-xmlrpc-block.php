<?php
/**
 * Plugin Name: XML-RPC Blocker (AI Security)
 * Description: Kötü niyetli botların şifre denemesi (brute-force) yaparak CPU ve RAM'i sömürdüğü xmlrpc.php dosyasını tamamen kilitler.
 * Version: 1.0.0
 * Author: Workpanel AI
 */

// WordPress çekirdeğinde XML-RPC işlevselliğini kapat
add_filter('xmlrpc_enabled', '__return_false');

// HTTP isteği doğrudan xmlrpc.php dosyasına gelirse daha PHP yüklenmeden 403 HTTP kodu ile reddet
if (isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], 'xmlrpc.php') !== false) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    die('XML-RPC erişimi güvenlik ve performans sebebiyle Workpanel tarafından kapatılmıştır.');
}
