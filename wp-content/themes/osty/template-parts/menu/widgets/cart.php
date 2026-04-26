<div class="ms-h_w">
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="main-header__cart">
        <div class="header__cart-icon">
            <svg fill="none" viewBox="0 0 54 62"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.96" d="M14.142 18.175v-2.771c0-6.428 5.17-12.742 11.599-13.342 7.656-.743 14.113 5.285 14.113 12.799v3.942M3.602 43.573l.657 5.343c.629 5.6 2.686 10.2 14.17 10.2h17.142c11.484 0 13.541-4.6 14.141-10.2l2.143-17.141c.771-6.97-1.229-12.656-13.427-12.656H15.573c-12.2 0-14.2 5.685-13.428 12.656m34.835-1.228h.026m-20.024 0h.026"/></svg>
            <div id="mini-cart-count" class="header__cart-count"><?php echo osty_cart_count(); ?></div>
        </div>
    </a>
</div>