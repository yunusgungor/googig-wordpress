<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

get_template_part( 'template-parts/header/header');

$page_id = get_option('woocommerce_shop_page_id');

if ( function_exists( 'get_field' ) ) {
    $shop_slider = get_field( 'shop_slider', $page_id );
    $sidebar_position = get_field( 'sidebar_position', $page_id );
    $slider_width = get_field( 'content_width', $page_id );
    $slider_class = "swiper-container shop-slider " . $slider_width;
    $shop_sidebar_enabled = get_field( 'shop_sidebar', $page_id ) === 'enable';
} else {
    $shop_slider = false;
    $sidebar_position = 'right';
    $shop_sidebar_enabled = true;
}

$column_sidebar_class = 'col-lg-4 ms-sidebar ms-sb-wc ' . $sidebar_position;
$column_content_class = ( is_active_sidebar( 'shop_sidebar' ) && $shop_sidebar_enabled ) ? 'col-lg-8' : 'col-12';

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'osty_woocommerce_result_count', 'woocommerce_result_count' );
add_action( 'osty_woocommerce_catalog_ordering', 'woocommerce_catalog_ordering' );

?>

<main class="ms-main" data-scroll-section>

    <?php if ( !empty( $shop_slider ) && is_array( $shop_slider ) ) :

        $gallery = get_field( 'shop_slider', $page_id ); ?>

        <?php if ( is_array($gallery) ) : ?>
        <div class="<?php echo osty_sanitize_class( $slider_class ); ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $gallery as $image ) : ?>
                <div class="swiper-slide"><img src="<?php echo esc_url( $image['url'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ) ?>"></div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <!-- Навигация -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <?php endif; ?>

    <?php else: ?>

        <header class="ms-sp--header">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="ms-sp--title"><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>
        </header>

    <?php endif; ?>

    <div class="container">
        
        <?php woocommerce_breadcrumb(); ?>

        <div class="row">

            <?php if ( $sidebar_position === 'left' && is_active_sidebar( 'shop_sidebar' ) && $shop_sidebar_enabled ) : ?>
                <div class="<?php echo osty_sanitize_class( $column_sidebar_class ); ?>">
                    <?php do_action( 'woocommerce_sidebar' ); ?>
                </div>
            <?php endif; ?>

            <div class="<?php echo osty_sanitize_class( $column_content_class ); ?>">
                <?php
                if ( woocommerce_product_loop() ) {
                    do_action( 'woocommerce_before_shop_loop' );
                    wc_get_template_part( 'content-loop', 'header' );
                    woocommerce_product_loop_start();

                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();
                            do_action( 'woocommerce_shop_loop' );
                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();
                    do_action( 'woocommerce_after_shop_loop' );
                } else {
                    do_action( 'woocommerce_no_products_found' );
                }
                ?>
            </div>

            <?php if ( $sidebar_position === 'right' && is_active_sidebar( 'shop_sidebar' ) && $shop_sidebar_enabled ) : ?>

                <div class="<?php echo osty_sanitize_class( $column_sidebar_class ); ?>">
                    <?php do_action( 'woocommerce_sidebar' ); ?>
                </div>

            <?php endif; ?>

        </div>

    </div>

</main>




<?php get_footer( 'shop' );