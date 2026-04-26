<?php
/**
 * @author: MadSparrow
 * @version: 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

get_header();

if ( class_exists( 'Kirki' ) ) {
    $disable_header = get_theme_mod( 'disable_header', true ); // если по умолчанию true
    if ( $disable_header ) {
        get_template_part( 'template-parts/header/header' );
    }
} else {
    get_template_part( 'template-parts/header/header' );
} ?>

<main class="ms-main">

    <div class="ms-page-content">

        <?php if( have_posts() ):

	       while( have_posts() ): the_post();

                get_template_part( 'template-parts/page/page', 'content' );

	       endwhile;
           
        endif; ?>

    </div>

</main>

<?php get_footer(); ?>