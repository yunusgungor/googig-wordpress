<?php 
/**
 * @author: MadSparrow
 * @version: 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); } ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>
 data-theme="<?php echo esc_attr(osty_theme_mode()); ?>"
 data-menu="<?php echo esc_attr(osty_header_type()); ?>"
 data-smooth-scroll="<?php echo esc_attr(osty_smooth_scroll()); ?>">
    <?php wp_body_open(); ?>
    <?php echo osty_page_transition(); ?>
    <?php echo osty_bttb_target(); ?>