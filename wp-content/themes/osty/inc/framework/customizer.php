<?php

/**
 * Update Kirki Config
 */

$first_level = 10;

// Theme options
new \Kirki\Panel(
	'theme_options',
	[
		'priority'    => $first_level++,
		'title'       => esc_html__( 'Osty Theme Options', 'osty' ),
	]
);

// General Options
new \Kirki\Section(
	'section_general_settings',
	[
        'title' => esc_html__('UI Enhancements', 'osty'),
		'panel'       => 'theme_options',
		'priority'    => $first_level++,  
	]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-general.php';

// Header
new \Kirki\Section(
	'header_settings',
	[
        'title' => esc_html__('Header', 'osty'),
        'panel' => 'theme_options',
        'priority' => $first_level++,
    ]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-header.php';

// Logo
new \Kirki\Section(
	'logo_settings',
	[
        'title' => esc_html__('Logo', 'osty'),
        'panel' => 'theme_options',
        'priority' => $first_level++,
    ]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-logo.php';

// Custom Footer
new \Kirki\Section(
	'footer_settings',
	[
        'title' => esc_html__('Footer', 'osty'),
        'panel' => 'theme_options',
        'priority' => $first_level++,
    ]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-footer.php';

// Fonts_setting
new \Kirki\Section(
	'fonts_setting',
	[
        'panel' => 'theme_options',
        'title' => esc_html__( 'Typography', 'osty' ),
        'priority' => $first_level++
    ]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-typography.php';

// Colors themes
new \Kirki\Section(
	'colors_schemes',
	[
        'panel' => 'theme_options',
        'title' => esc_html__( 'Colors', 'osty' ),
        'priority' => $first_level++
    ]
);

require_once OSTY_REQUIRE_DIRECTORY . 'inc/framework/setup/section-colors.php';