<?php

/**
 *Plugin Name: Osty Helper Plugin
 *Plugin URI: https://themeforest.net/user/madsparrow
 *Description: Special Plugin for Theme
 *Author: Mad Sparrow
 *Author URI: https://madsparrow.me
 *Version: 1.1.5
 *Text Domain: madsparrow
 * Domain Path: /languages
 *License: GPLv2+
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' ); // Exit if accessed directly.
}

/*
 * Register custom post type for special use
 */
if ( ! function_exists( 'portfolios_register' ) ) {

	function portfolios_register() {

		$labels = array(
			'name'                  => _x( 'Portfolio', 'Post Type General Name', 'madsparrow' ),
			'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'madsparrow' ),
			'menu_name'             => __( 'Portfolios', 'madsparrow' ),
			'name_admin_bar'        => __( 'Project', 'madsparrow' ),
			'archives'              => __( 'Project Archives', 'madsparrow' ),
			'attributes'            => __( 'Project Attributes', 'madsparrow' ),
			'parent_item_colon'     => __( 'Parent Item:', 'madsparrow' ),
			'all_items'             => __( 'All Projects', 'madsparrow' ),
			'add_new_item'          => __( 'Add New Project', 'madsparrow' ),
			'add_new'               => __( 'Add Project', 'madsparrow' ),
			'new_item'              => __( 'New Project', 'madsparrow' ),
			'edit_item'             => __( 'Edit Project', 'madsparrow' ),
			'update_item'           => __( 'Update Project', 'madsparrow' ),
			'view_item'             => __( 'View Project', 'madsparrow' ),
			'view_items'            => __( 'View Projects', 'madsparrow' ),
			'search_items'          => __( 'Search Project', 'madsparrow' ),
			'not_found'             => __( 'Not found', 'madsparrow' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'madsparrow' ),
			'featured_image'        => __( 'Featured Image', 'madsparrow' ),
			'set_featured_image'    => __( 'Set featured image', 'madsparrow' ),
			'remove_featured_image' => __( 'Remove featured image', 'madsparrow' ),
			'use_featured_image'    => __( 'Use as featured image', 'madsparrow' ),
			'insert_into_item'      => __( 'Insert into Project', 'madsparrow' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Project', 'madsparrow' ),
			'items_list'            => __( 'Projects list', 'madsparrow' ),
			'items_list_navigation' => __( 'Projects list navigation', 'madsparrow' ),
			'filter_items_list'     => __( 'Filter Projects list', 'madsparrow' ),
		);
		$args = array(
			'label'                 => __( 'Project', 'madsparrow' ),
			'description'           => __( 'Add Portfolios here', 'madsparrow' ),
			'labels'                => $labels,
			'show_in_rest' 			=> true,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'categories' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-portfolio',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( 'portfolios', $args );
	}
}
add_action( 'init', 'portfolios_register' );

// Portfolio category
if ( ! function_exists( 'portfolios_taxonomies' ) ) {

	function portfolios_taxonomies() {
	    $labels = array(
	        'name'              => _x( 'Categories', 'taxonomy general name', 'madsparrow' ),
	        'singular_name'     => _x( 'Category', 'taxonomy singular name', 'madsparrow' ),
	        'search_items'      => __( 'Search Categories', 'madsparrow' ),
	        'all_items'         => __( 'All Categories', 'madsparrow' ),
	        'parent_item'       => __( 'Parent Category', 'madsparrow' ),
	        'parent_item_colon' => __( 'Parent Category:', 'madsparrow' ),
	        'edit_item'         => __( 'Edit Category', 'madsparrow' ),
	        'update_item'       => __( 'Update Category', 'madsparrow' ),
	        'add_new_item'      => __( 'Add New Category', 'madsparrow' ),
	        'new_item_name'     => __( 'New Category Name', 'madsparrow' ),
	        'menu_name'         => __( 'Categories', 'madsparrow' ),
	    );

	    $args = array(
	        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_in_nav_menus' => true,
	        'show_admin_column' => true,
	        'show_in_rest'      => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'categories' ),
	    );

	    register_taxonomy( 'portfolios_categories', array( 'portfolios' ), $args );
	}
}
add_action( 'init', 'portfolios_taxonomies', 0 );

// Action Widgets Init
function osty_register_widgets() {
	$osty_widgets = array(
		'recent_posts' => 'osty_recent_widget_custom',
	);

	if ( class_exists( 'acf' ) ) {
		foreach ( $osty_widgets as $key => $value ) {
			require_once plugin_dir_path( __FILE__ ) . 'widgets/' . sanitize_key( $key ) . '.php';
			register_widget( $value );
		}
	}
}
add_action( 'widgets_init', 'osty_register_widgets' );

// Enable SVG support in WordPress
function osty_allow_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'osty_allow_svg_upload' );

if ( ! class_exists( 'MSHelperPlugin' ) ) {

	class MSHelperPlugin {

        private $theme_slug;
        private $theme_name;
        private $theme_version;
        private $theme_author;
        private $theme_is_child;

		private static $_instance = null;

		/**
		 * Main Instance
		 * Ensures only one instance of this class exists in memory at any one time.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
				self::$_instance->init_hooks();
				self::$_instance->theme_init();

			}
			return self::$_instance;
		}

		public $plugin_path;
		public $plugin_url;
		public $plugin_name;
		public $plugin_version;
		public $plugin_slug;

		public function __construct() {
			// We do nothing here!
		}

		/**
		 * Plugin init
		 */
		public function plugin_init() {
			$data = get_plugin_data( __FILE__ );
			$this->plugin_name = $data[ 'Name' ];
			$this->plugin_version = $data[ 'Version' ];
			$this->plugin_slug = 'ms_helper_plugin';
		}

		/**
		 * Theme init
		 */
		public function theme_init() {
			$theme_info = wp_get_theme();
			$theme_parent = $theme_info->parent();
			if ( !empty( $theme_parent ) ) {
				$theme_info = $theme_parent;
			}
            $this->theme_slug = $theme_info->get_stylesheet();
            $this->theme_name = $theme_info->get( 'Name' );
            $this->theme_version = $theme_info->get( 'Version' );
            $this->theme_author = $theme_info->get( 'Author' );
            $this->theme_is_child = !empty( $theme_parent );
		}

		/**
		 * Init options
		 */
		public function init_option() {
			$this->plugin_path = plugin_dir_path( __FILE__ );
			$this->plugin_url = plugin_dir_url( __FILE__ );

			load_plugin_textdomain( 'osty', false, $this->plugin_path . 'languages/' );
		}

		/**
		 * Init hooks
		 */
		public function init_hooks() {
			add_action( 'admin_init', array( $this, 'plugin_init' ) );

			// Process Elementor Blocks
			if ( defined( 'ELEMENTOR_PATH' ) ) {
				add_action( 'init', array( $this, 'init_elementor' ) );
			}

			// Elementor affiliate links
			add_action( 'admin_footer', array( $this, 'elementor_affiliate_script' ) );
			add_action( 'elementor/editor/footer', array( $this, 'elementor_affiliate_script' ) );
		}

		/**
		 * Init Elementor
		 */
		public function init_elementor() {
			require_once $this->plugin_path . 'elementor/helper.php';
			require_once $this->plugin_path . 'elementor/elementor.php';
			require_once $this->plugin_path . 'elementor/group-control-image-size.php';
		}

		/**
		 * Get all options
		 */
		private function get_options() {
			$options_slug = 'osty_helper_options';
			return unserialize( get_option( $options_slug, 'a:0:{}' ) );
		}

		/**
		 * Get option value
		 */
		public function get_option( $name, $default = null ) {
			$options = self::get_options();
			$name = sanitize_key( $name );
			return isset( $options[ $name ] ) ? $options[ $name ] : $default;
		}

		/**
		 * Update option
		 */
		public function update_option( $name, $value ) {
			$options_slug = 'osty_helper_options';
			$options = self::get_options();
			$options[ sanitize_key( $name ) ] = $value;
			update_option( $options_slug, serialize( $options ) );
		}

		/**
		 * Get all caches
		 */
		private function get_caches() {
			$caches_slug = 'cache';
			return $this->get_option( $caches_slug, array() );
		}

		/**
		 * Set cache
		 */
		public function set_cache( $name, $value, $time = 3600 ) {
			if ( ! $time || $time <= 0 ) {
				return;
			}
			$caches_slug = 'cache';
			$caches = self::get_caches();

			$caches[ sanitize_key( $name ) ] = array(
				'value' => $value,
				'expired' => time() + ( (int) $time ? $time : 0 ),
			);
			$this->update_option( $caches_slug, $caches );
		}

		/**
		 * Get cache
		 */
		public function get_cache( $name, $default = null ) {
			$caches = self::get_caches();
			$name = sanitize_key( $name );
			return isset( $caches[ $name ][ 'value' ] ) ? $caches[ $name ][ 'value' ] : $default;
		}

		/**
		 * Clear cache
		 */
		public function clear_cache( $name ) {
			$caches_slug = 'cache';
			$caches = self::get_caches();
			$name = sanitize_key( $name );
			if ( isset( $caches[ $name ] ) ) {
				$caches[ $name ] = null;
				$this->update_option( $caches_slug, $caches );
			}
		}

		/**
		 * Clear all expired caches
		 */
		public function clear_expired_caches() {
			$caches_slug = 'cache';
			$caches = self::get_caches();
			foreach ( $caches as $k => $cache ) {
				if ( isset( $cache ) && isset( $cache[ 'expired' ] ) && $cache[ 'expired' ] < time() ) {
					$caches[ $k ] = null;
				}
			}
			$this->update_option( $caches_slug, $caches );
		}

        /**
         * Elementor affiliate links script
         */
        public function elementor_affiliate_script() {
            ?>
            <script>
            (function() {
                var url = 'https://be.elementor.com/visit/?bta=226357&brand=elementor';
                function replaceLinks() {
                    document.querySelectorAll('a[href*="elementor.com/pro"], a[href*="go.elementor.com"]').forEach(function(link) {
                        link.href = url;
                    });
                }
                replaceLinks();
                new MutationObserver(replaceLinks).observe(document.body, {childList: true, subtree: true});
            })();
            </script>
            <?php
        }

	}

	function ms_helper_plugin() {
		return MSHelperPlugin::instance();
	}
	add_action( 'plugins_loaded', 'ms_helper_plugin' );

    // Share post block
    require_once plugin_dir_path( __FILE__ ) . 'widgets/share.php';

    // Plugin UPD
    add_filter('site_transient_update_plugins', 'osty_update_check');

    function osty_update_check($transient) {
        if (empty($transient->checked)) return $transient;

        $plugin_slug = 'osty_plugin/osty_hepler_plugin.php';
        $cache_key = 'osty_plugin_update_check';
        $cached_data = get_transient($cache_key);

        if ($cached_data !== false) {
            if (!empty($cached_data)) {
                $transient->response[$plugin_slug] = $cached_data;
            }
            return $transient;
        }

        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_slug);
        $current_version = $plugin_data['Version'];

        $remote_url = 'https://theme.madsparrow.me/plugins/osty-plugin-update.json';
        $response = wp_remote_get($remote_url, array(
            'timeout' => 5,
            'sslverify' => false
        ));

        if (is_wp_error($response)) {
            set_transient($cache_key, null, HOUR_IN_SECONDS);
            return $transient;
        }

        $data = json_decode(wp_remote_retrieve_body($response));

        $new_version = isset($data->new_version) ? (string)$data->new_version : null;

        if ($new_version && version_compare($current_version, $new_version, '<')) {
            $update_data = (object)[
                'slug'        => 'osty_plugin',
                'plugin'      => $plugin_slug,
                'new_version' => $new_version,
                'url'         => $data->url ?? '',
                'package'     => $data->package ?? ''
            ];

            set_transient($cache_key, $update_data, 12 * HOUR_IN_SECONDS);
            $transient->response[$plugin_slug] = $update_data;
        } else {
            set_transient($cache_key, null, 12 * HOUR_IN_SECONDS);
        }

        return $transient;
    }

    add_action('upgrader_process_complete', 'osty_clear_update_cache', 10, 2);
    function osty_clear_update_cache($upgrader_object, $options) {
        if ($options['type'] === 'plugin') {
            delete_transient('osty_plugin_update_check');
        }
    }

}

/**
 * Elementor default inst.
 */
register_activation_hook( __FILE__, 'osty_helper_plugin_activate' );
function osty_helper_plugin_activate() {
    portfolios_register();
    flush_rewrite_rules();
    $required_support = ['post', 'page', 'portfolios'];
    $existing_support = get_option('elementor_cpt_support', []);
    $merged = array_unique(array_merge($existing_support, $required_support));
    update_option('elementor_cpt_support', $merged);
    update_option('elementor_disable_color_schemes', 'yes');
    update_option('elementor_disable_typography_schemes', 'yes');
}