<?php 
/**
 * @author: MadSparrow
 * @version: 1.0
 */
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

$item_class = 'grid-item col-sm-auto col-lg-6 col-xl-' . $col_numb;
$thumb_size = 'osty-card-post-thumb';
?>

<div id="post-<?php the_ID(); ?>" <?php post_class($item_class); ?>>

    <div class="post-content">

        <?php if ( is_sticky() ) : ?>

            <div class="ms-sticky">
                <div class="ms-sticky--icon">
                    <svg x="0px" y="0px" width="42" height="42" viewBox="0 2 24 24">
                        <path d="M18.25,2H5.75C5.336,2,5,2.336,5,2.75v18.5c0,0.257,0.131,0.495,0.347,0.633c0.217,0.139,0.488,0.154,0.72,0.047L12,19.157	l5.933,2.772C18.034,21.977,18.142,22,18.25,22c0.141,0,0.28-0.039,0.403-0.117C18.869,21.745,19,21.507,19,21.25V2.75	C19,2.336,18.664,2,18.25,2z"></path>
                    </svg>
                </div>
            </div>

        <?php endif;?>   

        <div class="post-meta-cont">
            <span class="post-meta__date"><?php echo get_the_date(); ?></span>
            <div class="post-header">
                <a class="post-title" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
            <?php if ( isset( $show_excerpt_list)  ) {
                if ( $show_excerpt_list == 'on' ) {
                    echo osty_get_excerpt(get_the_ID(), $excerpt_length);
                }
            } else {
                echo osty_get_excerpt(get_the_ID(),'74');
            } ?>

        </div>

    </div>

    <?php if ( has_post_thumbnail() ) : ?>
        
            <figure class="ms-posts--card__media">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"></a>
                <img src="<?php the_post_thumbnail_url($size = $thumb_size); ?>" alt="<?php the_title_attribute (); ?>">
            </figure>
        
    <?php endif; ?>

</div>
