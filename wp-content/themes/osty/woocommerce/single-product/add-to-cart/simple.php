<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.2.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <div class="ms-variations--qty">
            <div class="ms-variations--label">
                <label for="<?php echo esc_attr( sanitize_title( 'Quantity' ) ); ?>"><?php echo esc_html__( 'Quantity', 'osty' ); ?></label>
            </div>

            <?php do_action( 'woocommerce_before_add_to_cart_quantity' );

            woocommerce_quantity_input(
                array(
                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                    'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                )
            );

            do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>
            
        </div>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt btn-wrap">
            <div class="f-btn-l">
                <svg height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 26 26" xml:space="preserve">
                    <g><path d="M25.856,10.641C21.673,19.5,20.312,19.5,19.5,19.5h-8c-2.802,0-4.949-1.648-5.47-4.2   c-0.016-0.078-1.6-7.853-2.005-10.025C3.826,4.21,3.32,3.5,1.5,3.5C0.671,3.5,0,2.829,0,2s0.671-1.5,1.5-1.5   c3.02,0,4.964,1.5,5.474,4.224c0.401,2.149,1.98,9.898,1.996,9.977c0.319,1.566,1.722,1.8,2.53,1.8h7.605   c0.817-0.878,2.679-4.261,4.038-7.141c0.354-0.749,1.249-1.068,1.997-0.716C25.89,8.997,26.21,9.891,25.856,10.641z M10.5,20.5   C9.119,20.5,8,21.619,8,23s1.119,2.5,2.5,2.5S13,24.381,13,23S11.881,20.5,10.5,20.5z M19.5,20.5c-1.381,0-2.5,1.119-2.5,2.5   s1.119,2.5,2.5,2.5S22,24.381,22,23S20.881,20.5,19.5,20.5z M14.663,12.344c0.1,0.081,0.223,0.12,0.346,0.12   s0.244-0.039,0.346-0.12c0.1-0.079,2.828-2.74,4.316-4.954c0.115-0.172,0.126-0.392,0.028-0.574   c-0.095-0.181-0.285-0.295-0.49-0.295h-2.226c0,0-0.217-4.291-0.359-4.49c-0.206-0.294-1.057-0.494-1.616-0.494   c-0.561,0-1.427,0.2-1.634,0.494c-0.141,0.198-0.328,4.49-0.328,4.49h-2.255c-0.206,0-0.395,0.114-0.492,0.295   c-0.097,0.182-0.086,0.403,0.028,0.574C11.816,9.605,14.564,12.265,14.663,12.344z"/></g>
                </svg>
            </div>

            <div class="f-btn-r">
                <span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span>
                <div class="btn-r_icon">
                <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                    <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                    <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                </svg>
                </div>
            </div>
        </button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
