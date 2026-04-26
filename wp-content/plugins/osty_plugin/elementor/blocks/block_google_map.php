<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Google_Map extends Widget_Base {

	public function get_script_depends() {
		return [ 'gmap-api-key' ];
	}

	public function get_name() {
		return 'ms_google_map';
	}

	public function get_title() {
		return esc_html__( 'Google Map', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-google-maps ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'map', 'google', 'locate' ];
	}

	protected function register_controls() {

		$first_level = 0;

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Google Map', 'madsparrow' ),
			]
		);

		$this->add_control(
			'lat', [
				'label' => esc_html__( 'Latitude', 'madsparrow' ),
				'description' => __( '<a href="https://www.latlong.net/" target="_blank">Here is a tool</a> where you can find Latitude &amp; Longitude of your location.' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '40.713669',
				'default' => '40.713669',
			]
		);

		$this->add_control(
			'lng', [
				'label' => esc_html__( 'Longitude', 'madsparrow' ),
				'description' => __( '<a href="https://www.latlong.net/" target="_blank">Here is a tool</a> where you can find Latitude &amp; Longitude of your location.' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '-74.007266',
				'default' => '-74.007266',
			]
		);

		$this->add_control(
			'zoom', [
				'label' => esc_html__( 'Zoom Level', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 25,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'map_height', [
				'label' => esc_html__( 'Height', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'vh' ],
				'default' => [
					'unit' => 'px',
					'size' => 450,
				],
				'range' => [
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1440,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
					'rem' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-gmap--wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'map_type', [
				'label' => esc_html__( 'Map Type', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'roadmap' => esc_html__( 'Road Map', 'madsparrow' ),
					'satellite' => esc_html__( 'Satellite', 'madsparrow' ),
					'hybrid' => esc_html__( 'Hybrid', 'madsparrow' ),
					'terrain' => esc_html__( 'Terrain', 'madsparrow' ),
				],
				'default' => 'roadmap',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'gesture_handling', [
				'label' => esc_html__( 'Gesture Handling', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'auto' => esc_html__( 'Auto', 'madsparrow' ),
					'cooperative' => esc_html__( 'Cooperative', 'madsparrow' ),
					'greedy' => esc_html__( 'Greedy', 'madsparrow' ),
					'none' => esc_html__( 'None', 'madsparrow' ),
				],
				'default' => 'auto',
				'description' => __( 'Understand more about Gesture Handling by reading it <a href="https://developers.google.com/maps/documentation/javascript/reference/3/#MapOptions" target="_blank">here.</a> Basically it control how it handles gestures on the map. Used to be draggable and scroll wheel function which is deprecated.' ),
			]
		);

		$this->add_control(
			'zoom_control', [
				'label' => esc_html__( 'Zoom Control', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'zoom_control_position', [
				'label' => esc_html__( 'Control Position', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'RIGHT_BOTTOM' => esc_html__( 'Bottom Right', 'madsparrow' ),
					'TOP_LEFT' => esc_html__( 'Top Left', 'madsparrow' ),
					'TOP_CENTER' => esc_html__( 'Top Center', 'madsparrow' ),
					'TOP_RIGHT' => esc_html__( 'Top Right', 'madsparrow' ),
					'LEFT_CENTER' => esc_html__( 'Left Center', 'madsparrow' ),
					'RIGHT_CENTER' => esc_html__( 'Right Center', 'madsparrow' ),
					'BOTTOM_LEFT' => esc_html__( 'Bottom Left', 'madsparrow' ),
					'BOTTOM_CENTER' => esc_html__( 'Bottom Center', 'madsparrow' ),
					'BOTTOM_RIGHT' => esc_html__( 'Bottom Right', 'madsparrow' ),
				],
				'default' => 'RIGHT_BOTTOM',
				'condition' => [
					'zoom_control' => 'yes',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'default_ui', [
				'label' => esc_html__( 'Default UI', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_type_control', [
				'label' => esc_html__( 'Map Type Control', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_type_control_style', [
				'label' => esc_html__( 'Control Style', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'DEFAULT' => esc_html__( 'Default', 'madsparrow' ),
					'HORIZONTAL_BAR' => esc_html__( 'Horizontal Bar', 'madsparrow' ),
					'DROPDOWN_MENU' => esc_html__( 'Dropdown Menu', 'madsparrow' ),
				],
				'default' => 'DEFAULT',
				'condition' => [
					'map_type_control' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_type_control_position', [
				'label' => esc_html__( 'Control Position', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'TOP_LEFT' => esc_html__( 'Top Left (Default)', 'madsparrow' ),
					'TOP_CENTER' => esc_html__( 'Top Center', 'madsparrow' ),
					'TOP_RIGHT' => esc_html__( 'Top Right', 'madsparrow' ),
					'LEFT_CENTER' => esc_html__( 'Left Center', 'madsparrow' ),
					'RIGHT_CENTER' => esc_html__( 'Right Center', 'madsparrow' ),
					'BOTTOM_LEFT' => esc_html__( 'Bottom Left', 'madsparrow' ),
					'BOTTOM_CENTER' => esc_html__( 'Bottom Center', 'madsparrow' ),
					'BOTTOM_RIGHT' => esc_html__( 'Bottom Right', 'madsparrow' ),
				],
				'default' => 'TOP_LEFT',
				'condition' => [
					'map_type_control' => 'yes',
				],
			]
		);

		$this->add_control(
			'streetview_control', [
				'label' => esc_html__( 'Streetview Control', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'streetview_control_position', [
				'label' => esc_html__( 'Streetview Position', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'RIGHT_BOTTOM' => esc_html__( 'Bottom Right (Default)', 'madsparrow' ),
					'TOP_LEFT' => esc_html__( 'Top Left', 'madsparrow' ),
					'TOP_CENTER' => esc_html__( 'Top Center', 'madsparrow' ),
					'TOP_RIGHT' => esc_html__( 'Top Right', 'madsparrow' ),
					'LEFT_CENTER' => esc_html__( 'Left Center', 'madsparrow' ),
					'RIGHT_CENTER' => esc_html__( 'Right Center', 'madsparrow' ),
					'BOTTOM_LEFT' => esc_html__( 'Bottom Left', 'madsparrow' ),
					'BOTTOM_CENTER' => esc_html__( 'Bottom Center', 'madsparrow' ),
					'BOTTOM_RIGHT' => esc_html__( 'Bottom Right', 'madsparrow' ),
				],
				'default' => 'RIGHT_BOTTOM',
				'condition' => [
					'streetview_control' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_style', [
				'label' => esc_html__( 'Map Style', 'madsparrow' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __( 'Add style from <a href="https://mapstyle.withgoogle.com/" target="_blank">Google Map Styling Wizard</a> or <a href="https://snazzymaps.com/explore" target="_blank">Snazzy Maps</a>. Copy and Paste the style in the textarea.' ),
				'condition' => [
					'map_type' => 'roadmap',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Marker Pins', 'madsparrow' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pin_lat', [
				'label' => esc_html__( 'Latitude', 'madsparrow' ),
				'description' => __( '<a href="https://www.latlong.net/" target="_blank">Here is a tool</a> where you can find Latitude &amp; Longitude of your location.' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'pin_lng', [
				'label' => esc_html__( 'Longitude', 'madsparrow' ),
				'description' => __( '<a href="https://www.latlong.net/" target="_blank">Here is a tool</a> where you can find Latitude &amp; Longitude of your location.' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'pin_icon', [
				'label' => esc_html__( 'Marker Icon', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'madsparrow' ),
					'custom' => esc_html__( 'Custom', 'madsparrow' ),
				],
			]
		);

		$repeater->add_control(
			'pin_icon_custom', [
				'label' => esc_html__( 'Choose Image', 'plugin-domain' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'pin_icon' => 'custom'
				]
			]
		);

		$repeater->add_control(
			'pin_title', [
				'label' => esc_html__( 'Title', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Pin Title',
			]
		);

		$repeater->add_control(
			'pin_text', [
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Pin content.'
			]
		);

		$this->add_control(
			'pins', [
				'label' => esc_html__( 'Pins', 'madsparrow' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => false,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'pin_lat' => '40.713669',
						'pin_lng' => '-74.007266',
						'pin_title' => 'Pin Title',
						'pin_text' => 'Pin content.'
					],
				],
				'title_field' => '{{{ pin_title }}}',
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Info Window', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'info_window_width', [
				'label' => esc_html__( 'Width', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250
				]
			]
		);

		$this->add_responsive_control(
			'delayainfo_window_content_align', [
				'label' => esc_html__( 'Alignment', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'madsparrow' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'madsparrow' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'madsparrow' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'madsparrow' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .ms-google-map__container' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Title', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'info_window_title_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-google-map__container h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'info_window_title_typography',
				'selector' => '{{WRAPPER}} .ms-google-map__container h6',
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'info_window_text_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-google-map__container div' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'info_window_text_typography',
				'selector' => '{{WRAPPER}} .ms-google-map__container div',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		// prepend map style
		$map_style = $settings[ 'map_style' ];
		$map_style = strip_tags( $map_style );
		$map_style = preg_replace( '/\s/', '', $map_style );

		// prepend map markers
		$mapmarkers = [];
		foreach ( $settings[ 'pins' ] as $item ) :
			$mapmarkers[] = array(
				'lat' => $item[ 'pin_lat' ],
				'lng' => $item[ 'pin_lng' ],
				'title' => htmlspecialchars( $item[ 'pin_title' ], ENT_QUOTES & ~ENT_COMPAT ),
				'text' => htmlspecialchars( $item[ 'pin_text' ], ENT_QUOTES & ~ENT_COMPAT ),
				'pin_icon' => $item[ 'pin_icon' ],
				'pin_icon_custom' => $item[ 'pin_icon_custom' ][ 'url' ]
			);
		endforeach;

		$this->add_render_attribute( 'google-map', [
			'id' => $this->get_id(),
			'class' => 'ms-gmap--wrapper',
			'data-map-lat' => $settings[ 'lat' ],
			'data-map-lng' => $settings[ 'lng' ],
			'data-map-zoom' => $settings[ 'zoom' ][ 'size' ],
			'data-map-gesture-handling' => $settings[ 'gesture_handling' ],
			'data-map-zoom-control' => $settings[ 'zoom_control' ],
			'data-map-zoom-control-position' => $settings[ 'zoom_control_position' ],
			'data-map-default-ui' => $settings[ 'default_ui' ],
			'data-map-type' => $settings[ 'map_type' ],
			'data-map-type-control' => $settings[ 'map_type_control' ],
			'data-map-type-control-style' => $settings[ 'map_type_control_style' ],
			'data-map-type-control-position' => $settings[ 'map_type_control_position' ],
			'data-map-streetview-control' => $settings[ 'streetview_control' ],
			'data-map-streetview-position' => $settings[ 'streetview_control_position' ],
			'data-map-info-window-width' => $settings[ 'info_window_width' ][ 'size' ],
			'data-map-locations' => json_encode( $mapmarkers ),
			'data-map-style' => $map_style
		] ); ?>

		<div <?php echo $this->get_render_attribute_string( 'google-map' ); ?>></div>
 		
 	<?php }

}