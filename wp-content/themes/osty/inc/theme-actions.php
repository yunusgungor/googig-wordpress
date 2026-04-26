<?php

/**
 * Register Sidebar.
 */
function osty_register_sidebar() {

	// posts sidebar
	register_sidebar( 
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'osty' ),
			'id'            => 'blog_sidebar',
			'description' => esc_html__( 'Blog Widget Area', 'osty' ),
			'before_widget' => '<aside id="%1$s" class="%2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="text-divider"><h5>',
			'after_title'   => '</h5></div>'
		)
	);

	// shop sidebar
	if ( OSTY_WOOCOMMERCE ) {
		register_sidebar( array(
			'name' => esc_html__( 'Shop Sidebar', 'osty' ),
			'id' => 'shop_sidebar',
			'description' => esc_html__( 'Shop Widget Area', 'osty' ),
			'before_widget' => '<aside id="%1$s" class="%2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="text-divider"><h5>',
			'after_title' => '</h5></div>'
		) );
	}

}
add_action( 'widgets_init', 'osty_register_sidebar' );

if ( ! function_exists( 'wp_body_open' ) ) {
        function wp_body_open() {
                do_action( 'wp_body_open' );
        }
}

// Woo
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'customize_dropdown_option_label', 10, 1 );

function customize_dropdown_option_label( $args ) {
    
    $attribute_name = wc_attribute_label( $args['attribute'] );
    $args['show_option_none'] = sprintf( __( '%s', 'osty' ), $attribute_name );

    return $args;
}

add_filter( 'woocommerce_get_availability_text', 'remove_default_in_stock_message', 10, 2 );

function remove_default_in_stock_message( $availability, $product ) {
    return '';
}