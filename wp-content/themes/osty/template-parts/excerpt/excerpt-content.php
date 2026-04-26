<?php
/**
 * Show the appropriate content.
 *
 * @package WordPress
 * @since osty 1.0.0
 */

?>

<div class="post-content">

    <?php if ( !has_post_thumbnail() ) : ?>

        <div class="post-top">

            <?php if ( is_sticky() ) : ?>
                <div class="ms-sticky no-thumbnail">
                    <svg x="0px" y="0px" width="24" height="24" viewBox="5 0 24 24" class="b-icon-svg">
                        <path d="M18.25,2H5.75C5.336,2,5,2.336,5,2.75v18.5c0,0.257,0.131,0.495,0.347,0.633c0.217,0.139,0.488,0.154,0.72,0.047L12,19.157	l5.933,2.772C18.034,21.977,18.142,22,18.25,22c0.141,0,0.28-0.039,0.403-0.117C18.869,21.745,19,21.507,19,21.25V2.75	C19,2.336,18.664,2,18.25,2z"></path>
                    </svg>
                </div>
            <?php endif;?>
            <a href="<?php the_permalink(); ?>">
		        <h2><?php the_title(); ?></h2>
	        </a>
        </div>
    <?php else: ?>
        <a href="<?php the_permalink(); ?>">
            <h2><?php the_title(); ?></h2>
        </a>
    <?php endif; ?>
        		


    <div class="post-meta-header">

        <div class="post-meta__info">

            <div class="card__header">
                <span class="post-meta__date"><?php echo get_the_date(); ?></span>
                <span class="ms-p--ttr"><?php echo osty_reading_time(get_the_ID()); ?></span>
            </div>

            <div class="post-category__list"><span><?php esc_html_e('Category:', 'osty'); ?></span><?php the_category('&nbsp;/&nbsp;'); ?></div>
        
        </div>

    </div>

	<?php if ( isset( $show_excerpt_list)  ) {
		if ( $show_excerpt_list == 'on' ) {
			echo osty_get_excerpt(get_the_ID(), $excerpt_length);
		}
	} else {
		echo osty_get_excerpt(get_the_ID(),'240');
	} ?>

	<div class="post-footer">

        <a href="<?php the_permalink(); ?>">

            <div class="f-btn-l">
            <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
            </svg>
            </div>

            <div class="f-btn-r">
                <span><?php esc_html_e('Read Article', 'osty'); ?></span>
                <div class="btn-r_icon">
                <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                    <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                    <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                </svg>
                </div>
            </div>
            
        </a>

	</div>

</div>