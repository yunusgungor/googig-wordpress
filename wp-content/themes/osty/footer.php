<?php
/**
 * @author: Mad Sparrow
 * @version: 1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

$footer_class = 'ms-footer ms-footer--template';

?>

<?php if (get_theme_mod( 'footer_template')) :?>
  <footer class="<?php echo osty_sanitize_class( $footer_class ); ?>">
    <section class="footer-container">
            <?php $footer_template = get_theme_mod( 'footer_template'); ?>
            <?php echo ms_render_elementor_template( $footer_template ); ?>
    </section>
  </footer>
<?php endif; ?>

<?php if ( get_theme_mod('custom_cursor') && get_theme_mod('custom_cursor') == '1' ) : ?>
    <?php $cursor_class = get_theme_mod('color_mode_select') === 'difference' ? ' difference' : ''; ?>
    <div class="ms-cursor-ring<?php echo esc_attr($cursor_class); ?>"></div>
    <div class="ms-cursor-dot<?php echo esc_attr($cursor_class); ?>"></div>
<?php endif; ?>

<?php if ( get_theme_mod('top_btn') && get_theme_mod('top_btn') == '1' ) : ?>
  <a class="back-to-top js-back-to-top" data-scroll-to href="#top">
    <div class="ms-btt--inner">
        <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"></path>
            <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"></path>
            <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"></path>
        </svg>
    </div>
  </a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>