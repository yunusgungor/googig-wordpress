<?php 
/**
 * @author: MadSparrow
 * @version: 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

get_header();

get_template_part( 'template-parts/header/header');

?>

<main class="ms-main" data-scroll-section>

<section class="ms-page-header">
    <div class="ms-sp--header">
        <?php the_archive_title( '<h1 class="ms-sp--title">', '</h1>' ); ?>
    </div>
</section>

<div class="container">

	<div class="row">

		<div class="ms-posts--default col">
			<div class="grid-sizer"></div>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('grid-item col-12@sm'); ?>>

                    <div class="post-content">

                        <div class="post-header">

                            <?php if ( !has_post_thumbnail() ) : ?>

                                <div class="post-top">

                                    <?php if ( is_sticky() ) : ?>
                                        <div class="ms-sticky no-thumbnail">
                                            <span class="ms-sticky--icon"><?php esc_html_e('Feautured', 'osty'); ?></span>
                                        </div>
                                    <?php endif;?>

                                </div>

                            <?php endif; ?>
                                    
                        </div>

                        <a href="<?php the_permalink(); ?>">
                            <h2><?php the_title(); ?></h2>
                        </a>

                        <div class="post-meta-header">

                            <div class="post-meta__info">

                                <div class="card__header">
                                    <span class="post-meta__date"><?php echo get_the_date(); ?></span>
                                    <span class="ms-p--ttr"><?php echo osty_reading_time(get_the_ID()); ?></span>
                                </div>

                            </div>

                        </div>

                        <?php if ( isset( $show_excerpt_list)  ) {
                            if ( $show_excerpt_list == 'on' ) {
                                echo osty_get_excerpt(get_the_ID(), $excerpt_length);
                            }
                        } else {
                            echo osty_get_excerpt(get_the_ID(),'240');
                        } ?>

                        <div class="post-category__list"><span><?php esc_html_e('Category:', 'osty'); ?></span><?php the_category(','); ?></div>

                        <div class="post-footer">

                            <a href="<?php the_permalink(); ?>">
                                <span><?php esc_html_e('Read Article', 'osty'); ?></span>
                            </a>

                        </div>

                    </div>

                </article>
            <?php endwhile;
            wp_reset_postdata(); ?>

            <?php if (the_posts_pagination()) : ?>
                <div class="grid-item ms-pagination col">
                    <?php echo the_posts_pagination(); ?>
                </div>
            <?php endif; ?>
            
        </div>
        <?php if ( is_active_sidebar( 'blog_sidebar' ) ) : ?>
            <div class="pl-lg-5 col-lg-4 ms-sidebar">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>

</div>

</main>

<?php get_footer(); ?>