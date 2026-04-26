<?php

/**
 * General
 */
$priority = 0;

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'page_transition',
		'label'       => esc_html__( 'Page transition', 'osty' ),
		'section'     => 'section_general_settings',
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
		'settings'    => 'top_btn',
		'label'       => esc_html__( 'Back To Top Button', 'osty' ),
		'section'     => 'section_general_settings',
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
		'settings'    => 'smooth_scroll',
		'label'       => esc_html__( 'Smooth Scroll', 'osty' ),
		'section'     => 'section_general_settings',
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
		'settings'    => 'share_post',
		'label'       => esc_html__( 'Share Post', 'osty' ),
		'section'     => 'section_general_settings',
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
		'settings'    => 'portfolio_navigation',
		'label'       => esc_html__( 'Show Portfolio Navigation', 'osty' ),
		'section'     => 'section_general_settings',
		'default'     => 'on',
		'priority' => $priority++,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'osty' ),
			'off' => esc_html__( 'Disable', 'osty' ),
		],
	]
);

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'custom_cursor',
		'label'       => esc_html__( 'Use Animated Cursor', 'osty' ),
		'section'     => 'section_general_settings',
		'default'     => 'on',
		'priority' => $priority++,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'osty' ),
			'off' => esc_html__( 'Disable', 'osty' ),
		],
	]
);

new \Kirki\Field\Select(
    [
        'settings'    => 'color_mode_select',
        'label'       => esc_html__( 'Color Mode', 'osty' ),
        'section'     => 'section_general_settings',
        'default'     => 'primary',
        'priority'    => $priority++,
        'choices'     => [
            'primary'    => esc_html__( 'Accent Color', 'osty' ),
            'difference' => esc_html__( 'Difference', 'osty' ),
            'custom'     => esc_html__( 'Custom', 'osty' ),
        ],
        'required'  => array( 
            array( 
                'setting'   => 'custom_cursor',
                'operator'  => '==',
                'value'     => '1'
            )
        ),
    ] 
);

new \Kirki\Field\Color(
	[
        'settings' => 'cursor_color_light',
        'section' => 'section_general_settings',
        'label' => esc_html__( 'Cursor Color Light Mode', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(38, 96%, 72%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--cursor-color',
            ],
        ],
        'transport' => 'auto',
        'required'  => array( 
            array( 
                'setting'   => 'color_mode_select',
                'operator'  => '==',
                'value'     => 'custom'
            )
        ),
    ]
);

new \Kirki\Field\Color(
	[
        'settings' => 'cursor_color_dark',
        'section' => 'section_general_settings',
        'label' => esc_html__( 'Cursor Color Dark Mode', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(38, 96%, 72%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--cursor-color',
            ],
        ],
        'transport' => 'auto',
        'required'  => array( 
            array( 
                'setting'   => 'color_mode_select',
                'operator'  => '==',
                'value'     => 'custom'
            )
        ),
    ]
);
