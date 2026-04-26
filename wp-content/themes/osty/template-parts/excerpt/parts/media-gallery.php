<?php
/**
 * @author: MadSparrow
 * @version: osty 1.0
 */

$thumb_size = 'most-default-post-thumb';
$post_gallery_images = get_field( 'post_gallery_images' );

if ( has_post_thumbnail() ) {
	$images[] = get_post_thumbnail_id( get_the_ID() );
}

if ( $post_gallery_images ) {

	foreach( $post_gallery_images as $image ) {
		$images[] = $image[ 'ID' ];
	}

} ?>

<?php if ( $post_gallery_images ) : ?>

	<?php if ( has_post_thumbnail() || $post_gallery_images ) : ?>
        
		<?php if ( ! is_single() ) : ?>

			<?php if ( is_sticky() ) : ?>
				<div class="ms-sticky">
					<span class="ms-sticky--icon">
                        <svg version="1.0" width="32px" height="32px" viewBox="0 0 512 512">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                <path d="M2405 4924 c-265 -26 -428 -58 -628 -124 -690 -227 -1234 -772 -1466 -1466 -84 -252 -121 -493 -121 -782 0 -298 35 -525 121 -787 195 -594 617 -1077 1184 -1355 213 -104 412 -168 660 -211 161 -29 516 -36 697 -15 538 62 997 275 1372 636 397 382 627 843 702 1410 20 149 22 461 5 600 -104 828 -566 1495 -1282 1849 -226 112 -486 189 -763 227 -109 15 -403 26 -481 18z m474 -170 c165 -24 284 -52 431 -100 355 -118 674 -325 918 -597 286 -320 464 -699 539 -1152 25 -152 25 -562 0 -714 -94 -573 -376 -1065 -802 -1395 -173 -135 -325 -224 -512 -300 -474 -194 -1015 -226 -1508 -91 -774 212 -1352 808 -1541 1590 -56 233 -78 537 -55 775 32 331 141 675 297 936 256 430 658 764 1119 930 126 45 343 98 460 113 50 6 101 13 115 15 78 11 442 5 539 -10z"/>
                                <path d="M2523 4198 c-28 -13 -30 -20 -188 -503 -70 -214 -131 -393 -134 -397 -4 -4 -51 24 -106 62 -105 74 -136 84 -175 52 -32 -26 -30 -60 12 -189 l36 -113 -489 0 c-476 0 -490 -1 -509 -20 -30 -30 -26 -80 7 -112 16 -14 183 -137 373 -273 190 -136 351 -253 359 -260 11 -11 -4 -25 -85 -86 -91 -68 -99 -77 -102 -111 -2 -27 3 -43 17 -57 19 -19 33 -21 156 -21 91 0 135 -4 135 -11 0 -6 -65 -209 -145 -452 -80 -242 -145 -446 -145 -452 0 -7 9 -24 21 -39 44 -56 53 -51 470 245 210 149 385 267 389 262 4 -4 22 -52 40 -106 34 -105 58 -137 100 -137 42 0 66 32 100 137 18 54 36 101 39 106 4 4 178 -114 387 -263 306 -218 385 -270 412 -270 39 0 72 30 72 66 0 20 -251 806 -287 901 -4 10 24 13 135 13 140 0 141 0 161 26 43 55 29 80 -93 169 -53 38 -93 72 -89 76 5 4 176 127 380 273 205 147 377 276 383 286 15 29 12 55 -11 84 l-20 26 -490 0 c-269 0 -489 1 -489 3 0 2 16 50 35 107 40 119 44 161 15 190 -35 35 -69 25 -179 -51 -56 -39 -104 -69 -105 -68 -2 2 -67 200 -145 439 -113 344 -147 440 -167 458 -27 24 -47 26 -81 10z m182 -762 c80 -244 153 -450 162 -458 13 -10 116 -14 499 -18 l484 -5 -385 -275 c-260 -186 -388 -284 -395 -302 -10 -23 5 -78 133 -467 79 -243 142 -441 140 -441 -3 0 -174 120 -379 266 -390 277 -405 285 -456 252 -13 -9 -182 -129 -377 -267 -195 -138 -356 -250 -358 -248 -2 2 60 196 137 429 77 234 140 438 140 452 0 15 -10 37 -22 49 -13 12 -189 141 -392 287 l-370 265 481 3 481 2 24 28 c15 19 72 179 163 460 77 237 141 432 142 432 1 0 68 -200 148 -444z m-555 -306 c0 -5 -4 -12 -10 -15 -5 -3 -10 -4 -10 -1 0 2 -3 12 -6 20 -5 12 -2 15 10 10 9 -3 16 -10 16 -14z m844 -4 c-3 -9 -10 -16 -15 -16 -14 0 -11 28 4 33 16 6 19 3 11 -17z m-1119 -796 c3 -5 -3 -10 -15 -10 -12 0 -18 5 -15 10 3 6 10 10 15 10 5 0 12 -4 15 -10z m1405 -6 c0 -2 -9 -4 -21 -4 -11 0 -18 4 -14 10 5 8 35 3 35 -6z"/>
                            </g>
                        </svg>
					</span>
				</div>
			<?php endif;?>
			
			<div class="post-category__list top">
				<?php the_category(); ?>
			</div>
		
		<?php endif;?>

	<?php else: ?>
	
		<div class="post-top">
	
			<?php if ( is_sticky() ) : ?>
				<div class="ms-sticky no-thumbnail">
					<span class="ms-sticky--icon">
						<svg version="1.1" viewBox="0 0 460 460" style="enable-background:new 0 0 460 460;" xml:space="preserve">
							<path d="M421.5,2.9c-3.5-3.5-9-3.9-12.9-1l-303,220c-3.5,2.5-5,7.1-3.6,11.2c1.3,4.1,5.2,6.9,9.5,6.9h72.8L37.4,444.2 c-2.9,4-2.4,9.5,1.1,12.9c1.9,1.9,4.5,2.9,7.1,2.9c2,0,4.1-0.6,5.9-1.9l303-220c3.5-2.5,5-7.1,3.6-11.2c-1.3-4.1-5.2-6.9-9.5-6.9 h-72.8L422.6,15.8C425.4,11.9,425,6.4,421.5,2.9z"/>
						</svg>
					</span>
				</div>
			<?php endif;?>
	
			<div class="post-category__list">
				<?php the_category(); ?>
			</div>
	
		</div>
			
	<?php endif; ?>

	<div class="ms-post-media__gallery swiper-container">

		<div class="swiper-wrapper">

			<?php

				if ( $images ) :

					foreach( $images as $image ) :
						
						echo '<div class="swiper-slide">';
						if ( ! is_single() ) :
							echo '<a href="' . get_permalink() . '">';
						endif;
						echo wp_get_attachment_image( $image, $size = $thumb_size, false, array( 'loading' => 'lazy' ) );
						if ( ! is_single() ) :
							echo '</a>';
						endif;
						echo '</div>';

					endforeach;

				endif;

			?>

		</div>
		<div class="ms-sp-btn__prev">
			<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<polyline points="3.41 16.34 12.1 7.66 20.59 16.14"/>
			</svg>
		</div>
		<div class="ms-sp-btn__next">
			<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<polyline points="3.41 16.34 12.1 7.66 20.59 16.14"/>
			</svg>
		</div>

	</div>

<?php else:
	if ( ! is_single() ) :
		get_template_part( 'template-parts/excerpt/excerpt', 'image' );
	else:
		if ( has_post_thumbnail() ) : ?>
				<figure class="media-wrapper media-wrapper--21:9">
					<img src="<?php the_post_thumbnail_url($size = $thumb_size); ?>" alt="<?php the_title_attribute (); ?>">
				</figure>			
		<?php endif; ?>
	<?php endif;

endif; ?>