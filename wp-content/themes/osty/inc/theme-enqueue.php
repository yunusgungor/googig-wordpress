<?php

/**
 * Include required assets (css, js etc.)
 */

class ostyEnqueueAssets {

    private $assets_dir;
    private $customizer_frontend_css;
    private $customizer_editor_css;
    private $theme_version;

    public function __construct() {
        $theme_info = wp_get_theme();
        $this->assets_dir = OSTY_THEME_DIRECTORY . 'assets/';
        $this->customizer_frontend_css = OSTY_THEME_DIRECTORY . 'inc/framework/customizer-frontend.css';
        $this->customizer_editor_css = OSTY_THEME_DIRECTORY . 'inc/framework/customizer-editor.css';
        $this->theme_version = $theme_info['Version'];
        $this->init_assets();
    }

    public function init_assets() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_gutenberg_editor_styles']);
    }

    public function enqueue_gutenberg_editor_styles() {
        wp_enqueue_style('osty-gutenberg', $this->assets_dir . 'css/osty-gutenberg-style.css', [], $this->theme_version);
    }

    public function fonts_url() {
        $fonts_url = '';
        $fonts = [];
        $display = 'swap';
        $fonts[] = 'Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';

        if ($fonts) {
            $fonts_url = add_query_arg([
                'family' => implode('&family=', $fonts),
                'display' => urlencode($display)
            ], 'https://fonts.googleapis.com/css2?family=');
        }

        return $fonts_url;
    }

    public function enqueue_styles() {
        if (!class_exists('Kirki')) {
            wp_enqueue_style('osty-customizer-editor', $this->customizer_frontend_css, [], $this->theme_version);
        }
        wp_enqueue_style('osty-google-fonts-frontend', $this->fonts_url(), [], null);
        wp_enqueue_style('bootstrap-grid', $this->assets_dir . 'css/vendor/bootstrap.min.css', [], $this->theme_version);
        wp_enqueue_style('locomotive-scroll', $this->assets_dir . 'css/vendor/locomotive-scroll.min.css', [], $this->theme_version);
        wp_enqueue_style('swiper', $this->assets_dir . 'css/vendor/swiper.min.css', [], $this->theme_version);
        wp_enqueue_style('swiper-material', $this->assets_dir . 'css/vendor/effect-material.min.css', [], $this->theme_version);
        wp_enqueue_style('splitting', $this->assets_dir . 'css/vendor/splitting.css', [], $this->theme_version);
        wp_enqueue_style('magnific-popup', $this->assets_dir . 'css/vendor/magnific-popup.css', [], $this->theme_version);
        wp_enqueue_style('plyr', $this->assets_dir . 'css/vendor/plyr.css', [], $this->theme_version);
        wp_enqueue_style('jarallax', $this->assets_dir . 'css/vendor/jarallax.min.css', [], $this->theme_version);
        wp_enqueue_style('fontawesome', $this->assets_dir . 'css/vendor/fontawesome.min.css', [], $this->theme_version);
        wp_enqueue_style('osty-main-style', $this->assets_dir . 'css/main.css', [], $this->theme_version);
    }

    public function enqueue_scripts() {
        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }

        wp_enqueue_script('imagesloaded');

        wp_enqueue_script('modernizr', $this->assets_dir . 'js/vendor/modernizr.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('splitting', $this->assets_dir . 'js/vendor/splitting.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('isotope', $this->assets_dir . 'js/vendor/isotope.pkgd.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('ms-swiper-bundle', $this->assets_dir . 'js/vendor/swiper-bundle.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('swiper-material', $this->assets_dir . 'js/vendor/effect-material.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('jarallax', $this->assets_dir . 'js/vendor/jarallax.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('jarallax-video', $this->assets_dir . 'js/vendor/jarallax-video.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('slider-video-background', $this->assets_dir . 'js/vendor/video-background.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('plyr', $this->assets_dir . 'js/vendor/plyr.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('justified-gallery', $this->assets_dir . 'js/vendor/jquery.justifiedGallery.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('magnific-popup', $this->assets_dir . 'js/vendor/magnific-popup.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('gsap', $this->assets_dir . 'js/vendor/gsap.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('scrolltrigger', $this->assets_dir . 'js/vendor/scrolltrigger.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('locomotive-scroll-2', $this->assets_dir . 'js/vendor/locomotive-scroll.min.js', ['jquery'], $this->theme_version, true);
        wp_enqueue_script('osty-main-script', $this->assets_dir . 'js/app.min.js', ['jquery'], $this->theme_version, true);
    }
}

new ostyEnqueueAssets();
