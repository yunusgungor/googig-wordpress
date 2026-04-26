<?php

$priority = 0;

/**
 * Theme Mode
 */
new \Kirki\Field\Radio_Buttonset(
	[
        'settings'    => 'theme_mode',
        'label'       => esc_html__( 'Select Default Website Mode', 'osty' ),
        'section'     => 'colors_schemes',
        'default'     => 'light',
        'priority'    => $priority++,
        'choices'     => [
            'light'   => esc_html__( 'Light Mode', 'osty' ),
            'dark'    => esc_html__( 'Dark Mode', 'osty' ),
        ],
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<br>',
        'priority' => $priority++,
    ]
);

new \Kirki\Field\Custom(
	[
    'type' => 'custom',
    'settings' => 'sg_1',
    'section' => 'colors_schemes',
    'default' => '<div class="ms-mode-kirki-separator"><h2>' . esc_html__( 'Light Mode', 'osty' ) . '</h2></div>',
    'priority' => $priority++,
    ]
);

/**
 * Primary Color (Light Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'accent_color',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Accent Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(38, 96%, 72%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-primary',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Higher (Light Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'primary_color1',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Primary Text Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(0, 0%, 15%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-contrast-higher',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Medium (Light Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_color2',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Medium', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 35%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-contrast-medium',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Low (Light Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_low',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Low', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 70%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-contrast-low',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Lower (Light Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_lower',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Lower', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 92%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-contrast-lower',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Background Color Light
 */
new \Kirki\Field\Color(
	[
        'settings' => 'bg_color_light',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Background Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(0, 0%, 96%)',
            'output'    => [
            [
                'element'  => ':root, [data-theme="light"]',
                'property' => '--color-bg',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '',
        'priority' => $priority++,
    ]
);

/**
 * Primary Color (Dark Mode)
 */
new \Kirki\Field\Custom(
	[
    'type' => 'custom',
    'settings' => 'sg_2',
    'section' => 'colors_schemes',
    'default' => '<div class="ms-mode-kirki-separator"><h2>' . esc_html__( 'Dark Mode', 'osty' ) . '</h2></div>',
    'priority' => $priority++,
    ]
);

new \Kirki\Field\Color(
	[
        'settings' => 'accent_color_d',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Accent Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(37, 99%, 73%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-primary',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Higher (Dark Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'primary_color_dark_1',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Primary Text Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(0, 0%, 96%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-contrast-higher',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Medium (Dark Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_color_dark_2',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Medium', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 57%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-contrast-medium',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Low (Dark Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_low_2',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Low', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 22%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-contrast-low',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Contrast Lower (Dark Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'contrast_lower_2',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Color Contrast Lower', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => true 
        ),
        'default' => 'hsl(0, 0%, 19%)',
        'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-contrast-lower',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);

/**
 * Background Color (Dark Mode)
 */
new \Kirki\Field\Color(
	[
        'settings' => 'bg_color',
        'section' => 'colors_schemes',
        'label' => esc_html__( 'Background Color', 'osty' ),
        'priority' => $priority++,
        'choices' => array(
            'alpha' => false 
        ),
        'default' => 'hsl(0, 1%, 14%)',
            'output'    => [
            [
                'element'  => ':root, [data-theme="dark"]',
                'property' => '--color-bg',
            ],
        ],
        'transport' => 'auto',
    ]
);

// Separator
new \Kirki\Field\Custom(
	[
        'settings'    => 'separator' . $priority++,
        'section'     => 'colors_schemes',
        'default'     => '<hr>',
        'priority' => $priority++,
    ]
);