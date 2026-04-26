<?php

class Plugin {

    protected static $instance = null;

    public static function get_instance() {
        if ( ! isset( static::$instance ) ) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    private function include_widgets_files() {
        $plugin_path = ms_helper_plugin()->plugin_path;

        $widgets = [
            'block_image',
            'block_posts',
            'block_sidebar',
            'block_hero_style',
            'block_slider',
            'block_contact_form',
            'block_projects_showcase',
            'block_animated_headline',
            'block_text_slider',
            'block_button',
            'block_video_button',
            'block_gallery',
            'block_accordion',
            'block_services',
            'block_skill_bar',
            'block_team_member',
            'block_blockquote',
            'block_pricing_table',
            'block_social_icons',
            'block_text_ticker',
            'block_template',
            'block_simple_link',
            'block_magnetic_images',
        ];

        foreach ( $widgets as $widget ) {
            require_once $plugin_path . 'blocks/' . $widget . '.php';
        }
    }

    public function register_widgets() {
        $this->include_widgets_files();

        // Кэшируем widgets_manager
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

        // Register Widgets
        $widgets_manager->register( new \Elementor\Widget_MS_Animated_Headline() );
        $widgets_manager->register( new \Elementor\Widget_MS_Text_Slider() );
        $widgets_manager->register( new \Elementor\Widget_MS_Image() );
        $widgets_manager->register( new \Elementor\Widget_MS_Posts() );
        $widgets_manager->register( new \Elementor\Widget_MS_Sidebar() );
        $widgets_manager->register( new \Elementor\Widget_MS_Hero_Style() );
        $widgets_manager->register( new \Elementor\Widget_MS_Slider() );
        $widgets_manager->register( new \Elementor\Widget_MS_Contact_Form() );
        $widgets_manager->register( new \Elementor\Widget_MS_Projects() );
        $widgets_manager->register( new \Elementor\Widget_MS_Button() );
        $widgets_manager->register( new \Elementor\Widget_MS_Simple_Link() );
        $widgets_manager->register( new \Elementor\Widget_MS_Video_Button() );
        $widgets_manager->register( new \Elementor\Widget_MS_Gallery() );
        $widgets_manager->register( new \Elementor\Widget_MS_Accordion() );
        $widgets_manager->register( new \Elementor\Widget_MS_Services() );
        $widgets_manager->register( new \Elementor\Widget_MS_Skill() );
        $widgets_manager->register( new \Elementor\Widget_MS_Team() );
        $widgets_manager->register( new \Elementor\Widget_MS_Blockquote() );
        $widgets_manager->register( new \Elementor\Widget_MS_Pricing_Table() );
        $widgets_manager->register( new \Elementor\Widget_MS_Social_Icons() );
        $widgets_manager->register( new \Elementor\Widget_MS_Text_Ticker() );
        $widgets_manager->register( new \Elementor\Widget_MS_Magnetic() );
        $widgets_manager->register( new \Elementor\Widget_MS_Template() );
    }

    public function register_categories( $elements_manager ) {
        $categories = array(
            'ms-elements' => esc_html__( 'Mad Sparrow Elements', 'madsparrow' ),
            'ms-showcase' => esc_html__( 'Mad Sparrow Showcase', 'madsparrow' ),
            'ms-site'     => esc_html__( 'Mad Sparrow Site', 'madsparrow' ),
        );

        foreach ( $categories as $slug => $title ) {
            $elements_manager->add_category( $slug, array( 'title' => $title ) );
        }
    }

    public function register_elementor_locations( $elementor_theme_manager ) {
        $locations = array( 'header', 'footer', 'single', 'archive' );

        foreach ( $locations as $location ) {
            $elementor_theme_manager->register_location( $location );
        }
    }

    public function register_editor_styles() {
        wp_enqueue_style( 'ms-elementor-style', plugin_dir_url( __FILE__ ) . 'assets/css/elementor.css', array(), ms_helper_plugin()->plugin_version );
    }

    public function __construct() {
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_editor_styles' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
        add_action( 'elementor/theme/register_locations', [ $this, 'register_elementor_locations' ] );
    }

}

// Instantiate Plugin Class
Plugin::get_instance();
