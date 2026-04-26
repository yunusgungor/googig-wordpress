<?php

$priority = 0;

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'setting_dimensions_1',
		'label'       => esc_html__( 'Dimensions Control', 'osty' ),
		'description'       => esc_html__( 'Any value must contain a unit of measurement (px, rem, em, %)', 'osty' ),
		'section'     => 'header_settings',
        'priority' => $priority++,
		'default'     => [
			'width'  => '1320px',
			'height' => '100px',
		],
        'output'    => [
            [
                'choice'      => 'width',
                'element'  => ':root',
                'property' => '--main-header-width-md',
            ],
            [
                'choice'      => 'height',
                'element'  => ':root',
                'property' => '--main-header-height',
            ],
        ],
        'transport' => 'auto',
	]
);

new \Kirki\Field\Radio_Buttonset(
    [
    'section'     => 'header_settings',
    'settings'    => 'type_header',
    'label' => esc_html__( 'Style', 'osty' ),
    'default'     => 'default',
    'choices'     => [
        'default'   => esc_html__( 'Default', 'osty' ),
        'fixed' => esc_html__( 'Fixed', 'osty' ),
    ],
    'priority' => $priority++,
] );

new \Kirki\Field\Radio_Buttonset(
    [
    'section'     => 'header_settings',
    'settings'    => 'menu_align',
    'label' => esc_html__( 'Menu Align 2', 'osty' ),
    'default'     => 'right',
    'choices'     => [
        'left'   => esc_html__( 'Left', 'osty' ),
        'center' => esc_html__( 'Center', 'osty' ),
        'right' => esc_html__( 'Right', 'osty' ),
    ],
    'priority' => $priority++,
] );

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'mode_switcher',
		'label'       => esc_html__( 'Theme Mode Switcher', 'osty' ),
		'section'     => 'header_settings',
		'default'     => 'off',
		'priority' => $priority++,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'osty' ),
			'off' => esc_html__( 'Disable', 'osty' ),
		],
	]
);

new \Kirki\Field\Checkbox_Switch(
    [
        'settings'    => 'search_widget',
        'label'       => esc_html__( 'Show Search', 'osty' ),
        'section'     => 'header_settings',
        'default'     => 'on',
        'priority' => $priority++,
        'choices'     => [
            'on'  => esc_html__( 'Enable', 'osty' ),
            'off' => esc_html__( 'Disable', 'osty' ),
        ],
    ]
);

if ( OSTY_WOOCOMMERCE ) {

    new \Kirki\Field\Checkbox_Switch(
        [
            'settings'    => 'cart_widget',
            'label'       => esc_html__( 'Show Cart', 'osty' ),
            'section'     => 'header_settings',
            'default'     => 'on',
            'priority' => $priority++,
            'choices'     => [
                'on'  => esc_html__( 'Enable', 'osty' ),
                'off' => esc_html__( 'Disable', 'osty' ),
            ],
        ]
    );

}

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'disable_header',
		'label'       => esc_html__( 'Show Header', 'osty' ),
		'description'       => esc_html__( 'Disable the default header site-wide to build your own using Elementor or another builder.', 'osty' ),
		'section'     => 'header_settings',
		'default'     => 'on',
		'priority' => $priority++,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'osty' ),
			'off' => esc_html__( 'Disable', 'osty' ),
		],
	]
);