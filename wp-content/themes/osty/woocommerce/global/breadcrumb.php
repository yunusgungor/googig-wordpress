<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

    if ( is_singular( 'product' ) || is_cart() || is_checkout() ) {

        $shop_page_id = wc_get_page_id( 'shop' );
        $shop_url    = get_permalink( $shop_page_id );
        $shop_name   = get_the_title( $shop_page_id );
    
        array_splice( $breadcrumb, 1, 0, array( array( $shop_name, $shop_url ) ) );
    
    }

	echo wp_kses_post( $wrap_before );

    foreach ( $breadcrumb as $key => $crumb ) {

        echo wp_kses_post( $before );
    
        if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '"><span>' . esc_html( $crumb[0] ) . '</span></a>';
        } else {
            echo esc_html( $crumb[0] );
        }
    
        echo wp_kses_post( $after );
    
        if ( sizeof( $breadcrumb ) !== $key + 1 ) {
            echo '<span class="sep"><svg class="default" width="5" height="9" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 14.5697L1.36504 16L9 8L1.36504 0L0 1.4303L6.26992 8L0 14.5697V14.5697Z"></path></svg></span>';
        }
    
    }

	echo wp_kses_post( $wrap_after );

}