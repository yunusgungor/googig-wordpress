<?php

add_action( 'tgmpa_register', 'osty_register_required_plugins' );

function osty_register_required_plugins() {

	$source = 'https://theme.madsparrow.me/plugins/';

	$plugins = array(

		array(
			'name' => esc_html__( 'Elementor Page Builder', 'osty' ),
			'slug' => 'elementor',
			'required' => false,
		),

		array(
			'name' => esc_html__( 'Advanced Custom Fields PRO', 'osty' ),
			'slug' => 'acf_pro',
			'source' => esc_url( $source . 'advanced-custom-fields-pro.zip'),
			'required' => true,
		),

		array(
			'name' => esc_html__( 'Osty Helper Plugin', 'osty' ),
			'slug' => 'osty_plugin',
			'source' => esc_url( $source . 'osty_plugin.zip'),
			'required' => true,
		),

		array(
			'name' => esc_html__( 'Kirki', 'osty' ),
			'slug' => 'kirki',
			'required' => true,
		),

		array(
			'name' => esc_html__( 'Contact Form 7', 'osty' ),
			'slug' => 'contact-form-7',
			'required' => true,
		),

		array(
			'name' => esc_html__( 'WooCommerce', 'osty' ),
			'slug' => 'woocommerce',
			'required' => false,
		),

		array(
			'name' => esc_html__( 'MC4WP: Mailchimp for WordPress', 'osty' ),
			'slug' => 'mailchimp-for-wp',
			'required' => false,
		),

		array(
			'name' => esc_html__( 'One Click Demo Import', 'osty' ),
			'slug' => 'one-click-demo-import',
			'required' => true,
		),
	);

	$config = array(
		'id'           => 'osty',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}