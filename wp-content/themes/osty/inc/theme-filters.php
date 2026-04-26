<?php

function nice_excerpt_length( $length ) {
    $new_ecxerpt = '200';
    if( $new_ecxerpt != '' ) {
        return $length = intval( $new_ecxerpt );
    } else {
        return $length;
    }
}
add_filter( 'excerpt_length', 'nice_excerpt_length', 999 );

function osty_custom_fonts( $standard_fonts ){
    $my_custom_fonts = array();
    $my_custom_fonts['Plus Jakarta Sans'] = array(
    'label' => 'Plus Jakarta Sans',
    'variants' => array('regular'),
    'stack' => 'Plus Jakarta Sans, sans-serif',
    );
    $my_custom_fonts['font2'] = array(
    'label' => 'Plus Jakarta Sans',
    'variants' => array('200', '300', '300', '400', '500', '600', '700','700italic', '800'),
    'stack' => 'Plus Jakarta Sans, sans-serif',
    );
    return array_merge_recursive( $my_custom_fonts, $standard_fonts );
    }
add_filter( 'kirki/fonts/standard_fonts', 'osty_custom_fonts', 20 );

// Woocommerce

// Remove the category count for WooCommerce categories
add_filter( 'woocommerce_subcategory_count_html', '__return_null' );

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');

function wc_refresh_mini_cart_count( $fragments ) {
    ob_start();
    $cart_count = WC()->cart->get_cart_contents_count(); ?>
        <div id="mini-cart-count" class="header__cart-count">
            <span><?php echo wp_kses_post( $cart_count ); ?></span>
        </div>
    <?php $fragments['#mini-cart-count'] = ob_get_clean();
    return $fragments;
}

// Remove Slug from the Permalink
function osty_remove_cpt_slug( $post_link, $post ) {
 
    if ( 'portfolios' === $post->post_type && 'publish' === $post->post_status ) {
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }
 
    return $post_link;
}
add_filter( 'post_type_link', 'osty_remove_cpt_slug', 10, 2 );

// instruct wordpress on how to find posts from the new permalinks
function osty_parse_request_remove_cpt_slug( $query_vars ) {
 
    // return if admin dashboard 
    if ( is_admin() ) {
        return $query_vars;
    }
 
    // return if pretty permalink isn't enabled
    if ( ! get_option( 'permalink_structure' ) ) {
        return $query_vars;
    }
 
    $cpt = 'portfolios';
 
    // store post slug value to a variable
    if ( isset( $query_vars['pagename'] ) ) {
        $slug = $query_vars['pagename'];
    } elseif ( isset( $query_vars['name'] ) ) {
        $slug = $query_vars['name'];
    } else {
        global $wp;
        
        $path = $wp->request;
 
        // use url path as slug
        if ( $path && strpos( $path, '/' ) === false ) {
            $slug = $path;
        } else {
            $slug = false;
        }
    }
 
    if ( $slug ) {
        $post_match = get_page_by_path( $slug, 'OBJECT', $cpt );
 
        if ( ! is_admin() && $post_match ) {
 
            // remove any 404 not found error element from the query_vars array because a post match already exists in cpt
            if ( isset( $query_vars['error'] ) && $query_vars['error'] == 404 ) {
                unset( $query_vars['error'] );
            }
 
            // remove unnecessary elements from the original query_vars array
            unset( $query_vars['pagename'] );
    
            // add necessary elements in the the query_vars array
            $query_vars['post_type'] = $cpt;
            $query_vars['name'] = $slug;
            $query_vars[$cpt] = $slug; // this constructs the "cpt=>post_slug" element
        }
    }
 
    return $query_vars;
}
add_filter( 'request', "osty_parse_request_remove_cpt_slug" , 1, 1 );

function custom_related_products_args($args) {
    $args['posts_per_page'] = 3; // Количество товаров
    $args['columns'] = 3; // Количество колонок
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'custom_related_products_args');

// Remove <p> and <br/> from Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');