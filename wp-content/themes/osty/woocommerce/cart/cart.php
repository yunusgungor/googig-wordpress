<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'osty_woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' ); ?>

<div class="breadcrumb-holder">
    <?php woocommerce_breadcrumb(); ?>
</div>

<?php do_action( 'woocommerce_before_cart' ); ?>

<div class="ms-woocommerce-cart-form-wrapper row">

	<form class="woocommerce-cart-form col-12 col-lg-8" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">

            <div class="cart-items">
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <div class="cart-item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                            <div class="cart-item-part product-thumbnail">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                if ( ! $product_permalink ) {
                                    echo wp_kses_post( $thumbnail );
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                }
                                ?>
                            </div>

                            <div class="ms-cart-item-parts">

                                <div class="cart-item-part product-name" data-title="<?php esc_attr_e( 'Product', 'osty' ); ?>">
                                    <?php
                                    if ( ! $product_permalink ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                    } else {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                    }
                                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                                    echo wc_get_formatted_cart_item_data( $cart_item );
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'osty' ) . '</p>', $product_id ) );
                                    }
                                    ?>
                                </div>

                                <div class="cart-item-part product-price" data-title="<?php esc_attr_e( 'Price', 'osty' ); ?>">
                                    <div class="cart-header-item product-price"><?php esc_html_e( 'Price:', 'osty' ); ?></div>
                                    <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                </div>

                                <div class="part-footer">
                                    <div class="cart-item-part product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'osty' ); ?>">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                                    'min_value'    => '0',
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );
                                        }
                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                        ?>
                                    </div>
                                    <div class="cart-item-part product-remove">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1.2em" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M2 6v10c0 1.1.9 2 2 2h10a2 2 0 0 0 2-2V6H2zm11-3V1c0-.6-.4-1-1-1H6c-.6 0-1 .4-1 1v2H0v2h18V3h-5zm-2 0H7V2h4v1z"></path></svg></a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_html__( 'Remove this item', 'osty' ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <div class="cart-item-part product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'osty' ); ?>">
                                <div class="cart-header-item product-subtotal"><?php esc_html_e( 'Subtotal:', 'osty' ); ?></div>
                                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
                <?php do_action( 'woocommerce_cart_contents' ); ?>
            </div>

            <div class="cart-actions">
            
                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon">
                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'osty' ); ?>" />
                        <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'osty' ); ?>">
                            <?php esc_html_e( 'Apply coupon', 'osty' ); ?>
                        </button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>

                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'osty' ); ?>"><?php esc_html_e( 'Update cart', 'osty' ); ?></button>
                <?php do_action( 'woocommerce_cart_actions' ); ?>
                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

            </div>

            <div class="cart-related-products">

                <?php $cart_items = WC()->cart->get_cart();

                $product_ids = array_map(function($item) {
                    return $item['product_id'];
                }, $cart_items);

                $related_ids = wc_get_related_products($product_ids, 4);

                if (empty($related_ids)) {
                    $related_ids = wc_get_products(array(
                        'limit' => 3,
                        'orderby' => 'rand',
                        'return' => 'ids',
                    ));
                }

                if (!empty($related_ids)) :
                    $related_products = wc_get_products(array('include' => $related_ids));
                    ?>
                    <div class="row ms-woo-feed">
                        <h2><?php esc_html_e('You may also like', 'osty'); ?></h2> 
                        <?php foreach ($related_products as $product) : ?>
                            <div class="col-md-4 col-sm-6">
                                <article class="ms-product product type-product post-<?php echo esc_attr($product->get_id()); ?> status-<?php echo esc_attr($product->get_status()); ?> <?php echo esc_attr($product->get_type()); ?>">
                                    <div class="ms-product-media">
                                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                            <?php if ($product->is_on_sale()) : ?>
                                                <span class="onsale"><?php esc_html_e('Sale!', 'osty'); ?></span>
                                            <?php endif; ?>
                                            <?php  echo wp_kses_post($product->get_image('woocommerce_thumbnail')); ?>
                                        </a>
                                    </div>
                                    <div class="ms-product-content">
                                        <div class="ms-product-info">
                                            <h5 class="ms-product-title">
                                                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                                    <?php echo esc_html($product->get_name()); ?>
                                                </a>
                                            </h5>
                                            <div class="ms-product-cat">
                                                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="product-cat">', '</span>' ); ?>
                                            </div>
                                            <div class="ms-product-footer">
                                                <div class="ms-product-price">
                                                    <span class="price">
                                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-product-link">
                                            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                                            data-quantity="1" 
                                            class="btn button product_type_<?php echo esc_attr($product->get_type()); ?> add_to_cart_button ajax_add_to_cart" 
                                            data-product_id="<?php echo esc_attr($product->get_id()); ?>" 
                                            aria-label="<?php esc_attr_e('Add to cart', 'osty'); ?>">
                                            <div class="f-btn-r">
                                                <span><?php esc_html_e('Add to cart', 'osty'); ?></span>
                                                <div class="btn-r_icon">
                                                    <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"></path>
                                                        <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"></path>
                                                        <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>

            </div>

        </div>

		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

    <div class="woocommerce-cart-sidebar col-12 col-lg-4">
        <div class="ms-cart-collaterals cart-collaterals">
            <?php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action( 'woocommerce_cart_collaterals' );
            ?>
        </div>
    </div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
