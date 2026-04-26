<?php
/**
 * Show the appropriate content for the Link post format.
 *
 * @package WordPress
 * @since osty 1.0.0
 */

?>

<?php if( class_exists('ACF') ) : ?>

	<?php get_template_part( 'template-parts/excerpt/parts/media', 'link' ); ?>

<?php else: ?>

	<?php get_template_part( 'template-parts/excerpt/excerpt', 'image' ); ?>

<?php endif; ?>