<?php

/**
 * @author: MadSparrow
 * @version: 1.0.0
 */

/**
 * Upload SVG for Elementor
 */
if ( ! function_exists( 'osty_unfiltered_files_upload' ) ) {
	function osty_unfiltered_files_upload() {

		// if exists, assign to $cpt_support var
		$cpt_support = get_option( 'elementor_unfiltered_files_upload' );

		// check if option DOESN'T exist in db
		if( ! $cpt_support ) {
			$cpt_support = '1'; //create string value default to enable upload svg
			update_option( 'elementor_unfiltered_files_upload', $cpt_support ); //write it to the database
		}
	}
}
add_action( 'elementor/init', 'osty_unfiltered_files_upload' );

/**
 * osty Widgets Priority
 */
if ( ! class_exists( 'ElementorPro\Plugin' ) ) {
	add_filter( 'elementor/editor/localize_settings', function( $settings ) {
		if ( ! empty( $settings[ 'promotionWidgets' ] ) ) {
			$settings[ 'promotionWidgets' ] = [];
		}
		return $settings;
	}, 20 );
}

/**
 * Add Parallax Effect To Container
 */
add_action( 'elementor/element/container/section_background/after_section_end', function( $section, $args ) {

	$section->start_controls_section(
		'section_navbar_position', [
			'label' => esc_html__( 'Position Sticky', 'osty' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

    $section->add_control(
		'position_sticky', [
			'label' => esc_html__( 'Section Sticky', 'osty' ),
			'type' => Elementor\Controls_Manager::SWITCHER,
            'description' => esc_html__( 'The preview does not work in the editor mode', 'osty' ),
            'return_value' => 'yes',
            'default' => 'no',
			'prefix_class' => ''
		]
	);

    $section->add_responsive_control(
        'position_sticky_top', [
            'label' => esc_html__( 'Top', 'osty' ),
            'type' => Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem', '%', 'vh', 'custom' ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
            'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
            ],
            'selectors' => [
                '{{WRAPPER}} .ms-sticky' => 'top: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'position_sticky' => ['yes'],
            ],
        ]
    );
    
    $section->end_controls_section();

    $section->start_controls_section(
		'section_navbar_offset', [
			'label' => esc_html__( 'Scroll Trigger', 'osty' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	$section->add_control(
		'parallax_container', [
			'label' => esc_html__( 'Scroll Trigger', 'osty' ),
			'type' => Elementor\Controls_Manager::SWITCHER,
            'description' => __( 'Works only when smooth scrolling is enabled', 'osty' ),
            'return_value' => 'yes',
            'default' => 'no',
			'prefix_class' => ''
		]
	);

    $section->add_control(
		'parallax_speed_container', [
            'label' => __( 'Speed', 'osty' ),
            'description' => __( 'Min -1, Max 1', 'osty' ),
            'type' => Elementor\Controls_Manager::NUMBER,
            'min' => -1,
            'max' => 1,
            'step' => 0.1,
            'default' => 0.4,
            'condition' => [
                'parallax_container' => ['yes'],
            ],
            'prefix_class' => ''
        ]
	);

    $section->add_control(
        'parallax_position', [
            'label' => esc_html__( 'Position', 'osty' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'description' => esc_html__( 'Accepted values are: "start", "middle", "end".', 'osty' ),
            'placeholder' => esc_html__( 'start,end', 'osty' ),
            'condition' => [
                'parallax_container' => ['yes'],
            ],
        ]
    );

    $section->add_control(
        'parallax_offset', [
            'label' => esc_html__( 'Offset', 'osty' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'description' => esc_html__( 'Example: "100,50%" represents an offset of 100 pixels for the enter position and 50% of the viewport height for.', 'osty' ),
            'placeholder' => esc_html__( '0,0', 'osty' ),
            'condition' => [
                'parallax_container' => ['yes'],
            ],
        ]
    );
    
	$section->end_controls_section();

}, 10, 2 );

if ( ! function_exists( 'osty_render_aos_animation' ) ) {
    function osty_scroll_parallax( $widget ) {
     $settings = $widget->get_settings_for_display();

     if ( $settings['position_sticky'] === 'yes' ) {

        $widget->add_render_attribute( '_wrapper', 'class', 'ms-sticky-w' );
        if ( isset( $settings['position_sticky_top'] ) && isset( $settings['position_sticky_top']['size'] ) && isset( $settings['position_sticky_top']['unit'] ) ) {
            $widget->add_render_attribute( '_wrapper', 'style', 'top:' . $settings['position_sticky_top']['size'] . $settings['position_sticky_top']['unit']);
        } else {
            $widget->add_render_attribute( '_wrapper', 'style', 'top:0px');
        }

     }
     
    if ( $settings['parallax_container'] === 'yes' ) {

        $widget->add_render_attribute( '_wrapper', 'data-scroll', '' );

        if ( $settings['parallax_position'] !== '' ) {
            $widget->add_render_attribute( '_wrapper', 'data-scroll-position', $settings['parallax_position'] );
        }
        
        if ( $settings['parallax_offset'] !== '' ) {
            $widget->add_render_attribute( '_wrapper', 'data-scroll-offset', $settings['parallax_offset'] );
        }
        
        $widget->add_render_attribute( '_wrapper', 'data-scroll-speed', $settings['parallax_speed_container'] );
    }
   
    }
}
   
add_action( 'elementor/frontend/container/before_render', 'osty_scroll_parallax', 10 );