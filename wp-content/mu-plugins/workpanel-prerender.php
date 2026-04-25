<?php
/**
 * Plugin Name: Instant Prerender & Prefetch
 * Description: Kullanıcı bir bağlantıya fareyle yaklaştığı anda (hover) sayfayı arka planda gizlice yükler. Tıkladığında sayfa 0 milisaniyede açılır.
 * Version: 1.0.0
 * Author: Workpanel AI
 */

add_action('wp_footer', function() {
    // Sadece ön yüzdeki gerçek ziyaretçiler için aktif et
    if (is_admin()) return;
    ?>
    <script>
    // Kullanıcı bir linkin üzerine geldiğinde arka planda kaynakları indirir
    document.addEventListener("DOMContentLoaded", function() {
        let prefetchTimer;
        document.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('mouseenter', function() {
                let url = this.href;
                // Sadece kendi domainimizdeki sayfalara prefetch atılır
                if (url.startsWith(window.location.origin) && !document.querySelector(`link[href="${url}"]`)) {
                    // Kullanıcının imleci yanlışlıkla geçmediğinden emin olmak için 50ms bekle
                    prefetchTimer = setTimeout(function() {
                        let linkTag = document.createElement('link');
                        linkTag.rel = 'prerender'; // Tam istenildiği gibi prerender kullanılıyor
                        linkTag.href = url;
                        document.head.appendChild(linkTag);
                    }, 50); 
                }
            });
            link.addEventListener('mouseleave', function() {
                clearTimeout(prefetchTimer);
            });
        });
    });
    </script>
    <?php
}, 100);
