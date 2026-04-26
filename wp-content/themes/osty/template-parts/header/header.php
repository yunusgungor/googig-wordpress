<?php
/**
 * @package WordPress
 * @since osty 1.0.0
 */

 $has_cart    = OSTY_WOOCOMMERCE && ( is_woocommerce() || is_cart() );
 $has_search  = get_theme_mod( 'search_widget', false ) === true;
 $has_mode    = get_theme_mod( 'mode_switcher', false ) === true;

?>

<div class="<?php echo osty_header_class(); ?>" id="ms-header">

    <div class="main-header__layout">
		<div class="main-header__inner">
            
			<div class="main-header__logo">
				<div class="logo-dark">
					<?php if (get_theme_mod( 'logo_dark' )): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( get_theme_mod( 'logo_dark' ) ); ?>" alt="<?php echo esc_attr( bloginfo( 'name' ) ); ?>">
						</a>
					<?php else: ?>
						<div class="ms-logo__default">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<h3><?php bloginfo( 'name' ); ?></h3>
							</a>
						</div>
					<?php endif; ?>
				</div>
				<div class="logo-light">
					<?php if (get_theme_mod( 'logo_light' )): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( get_theme_mod( 'logo_light' ) ); ?>" alt="<?php echo esc_attr( bloginfo( 'name' ) ); ?>">
						</a>
					<?php else: ?>
					<div class="ms-logo__default">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<h3><?php bloginfo( 'name' ); ?></h3>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<?php get_template_part( 'template-parts/menu/default', get_post_format() ); ?>

            <div class="main-header--widgets">

                <?php if ( $has_cart || $has_search || $has_mode ) : ?>
                    <div class="ms-hw-inner">

                        <?php if ( $has_search ) :
                            get_template_part( 'template-parts/menu/widgets/search' );
                        endif; ?>

                        <?php if ( $has_mode ) :
                            get_template_part( 'template-parts/menu/widgets/switcher' );
                        endif; ?>

                        <?php if ( $has_cart ) :
                            get_template_part( 'template-parts/menu/widgets/cart' );
                        endif; ?>

                    </div>
                <?php endif; ?>

                <?php get_template_part( 'template-parts/menu/button', get_post_format() ); ?>

            </div>

            <div class="header__search-modal data-scroll-section">

                <button class="header__search--close-btn">
                    <svg class="icon icon--sm" viewBox="0 0 24 24">
                        <title>Close modal window</title>
                        <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="3" x2="21" y2="21"></line>
                            <line x1="21" y1="3" x2="3" y2="21"></line>
                        </g>
                    </svg>
                </button>

                <div class="header__search--inner">

                    <?php 

                        if ( OSTY_WOOCOMMERCE ) {
                            osty_search_woo();
                        } else {
                            get_search_form();
                        }
                        
                    ?>

                </div>
            </div>

		</div>
	</div>
	
</div>