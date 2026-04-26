<?php 
/**
 * @author: MadSparrow
 * @version: 1.0
 */

get_header();

$id = get_the_ID();

get_template_part( 'template-parts/header/header');

?>
<main class="ms-main" data-scroll-section>

    <div class="ms-content--portfolio">
        <?php while ( have_posts() ) : the_post();
            the_content();
        endwhile; ?>

        <?php if ( get_theme_mod( 'portfolio_navigation', true ) ) : ?>
            <div class="ms-spn--wrap">
                <div class="ms-spn_stck_h">
                    <?php osty_portfolio_nav_prev(); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    
</main>

<?php get_footer(); ?>
