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

<section class="ms-page-content ms-404-page">
  <div class="ms-404--content">
    <h2><?php esc_html_e('Whoops, that page is gone.', 'osty') ?></h2>
    <p><?php esc_html_e('The page you are looking for does not exist. How you got here is a mystery. Go back to the', 'osty') ?>
    <a data-style="yes" class="ms-sl" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('homepage.', 'osty') ?></a>
  </p>
  </div>
  <div class="ms-404--bg">
    <h1><?php echo esc_html('404', 'osty')?></h1>
  </div>
</section>

<?php wp_footer(); ?>