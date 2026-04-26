<?php

$priority = 0;

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'logo_dimensions',
		'label'       => esc_html__( 'Dimensions Control', 'osty' ),
		'description'       => esc_html__( 'Width and height must be specified in units of measurement (px, em, rem, pt). Example: 100px', 'osty' ),
		'section'     => 'logo_settings',
        'priority' => $priority++,
		'default'     => [
			'width'  => 'auto',
			'height' => '50px',
		],
        'output'    => [
            [
                'choice'      => 'width',
                'element'  => '.main-header__logo a, .main-header__logo svg, .main-header__logo img',
                'property' => 'width',
            ],
            [
                'choice'      => 'height',
                'element'  => '.main-header__logo a, .main-header__logo svg, .main-header__logo img',
                'property' => 'height',
            ],
        ],
        'transport' => 'auto',
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'logo_mobile_dimensions',
		'label'       => esc_html__( 'Mobile Logo Dimensions', 'osty' ),
		'description' => esc_html__( 'Width and height for mobile logo. Example: 100px', 'osty' ),
		'section'     => 'logo_settings',
		'priority'    => $priority++,
		'default'     => [
			'width'  => 'auto',
			'height' => '40px',
		],
		'output'      => [
			[
				'choice'   => 'width',
				'element'  => '.main-header__logo a, .main-header__logo svg, .main-header__logo img',
				'property' => 'width',
				'media_query' => '@media(max-width: 767px)',
			],
			[
				'choice'   => 'height',
				'element'  => '.main-header__logo a, .main-header__logo svg, .main-header__logo img',
				'property' => 'height',
				'media_query' => '@media(max-width: 767px)',
			],
		],
		'transport'   => 'auto',
	]
);


new \Kirki\Field\Image(
	[
		'settings'    => 'logo_light',
		'label'       => esc_html__( 'Image Logo Light', 'osty' ),
		'description' => esc_html__( 'For Dark Theme Mode', 'osty' ),
		'section'     => 'logo_settings',
		'default'     => '',
        'priority' => $priority++
	]
);

new \Kirki\Field\Image(
	[
		'settings'    => 'logo_dark',
		'label'       => esc_html__( 'Image Logo Dark', 'osty' ),
		'description' => esc_html__( 'For Light Theme Mode', 'osty' ),
		'section'     => 'logo_settings',
		'default'     => '',
        'priority' => $priority++
	]
);