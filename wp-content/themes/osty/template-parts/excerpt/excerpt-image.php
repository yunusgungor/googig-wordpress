<?php
/**
 * Show the appropriate content for the Image post format.
 *
 * @package WordPress
 * @since osty 1.0
 */

$thumb_size = 'osty-default-post-thumb'; ?>

<?php get_template_part( 'template-parts/excerpt/parts/media', 'badge' ); ?>

<?php if ( has_post_thumbnail() ) : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
		<figure class="media-wrapper">
			<img src="<?php the_post_thumbnail_url($size = $thumb_size); ?>" alt="<?php the_title_attribute (); ?>">
		</figure>	
	</a>

<?php endif; ?>