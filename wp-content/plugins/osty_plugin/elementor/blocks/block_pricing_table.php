<?php

/**
 * @author: Mad Sparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Pricing_Table extends Widget_Base {

	use \MS_Elementor\Traits\Helper;

	public function get_name() {
		return 'ms-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-price-table ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'price', 'pricing', 'plan', 'table' ];
	}

	public static function get_button_sizes() {
		return [
			'sm' => esc_html__( 'Small', 'madsparrow' ),
			'ba' => esc_html__( 'Basic', 'madsparrow' ),
			'md' => esc_html__( 'Medium', 'madsparrow' ),
			'lg' => esc_html__( 'Large', 'madsparrow' ),
		];
	}

	public static function get_button_styles() {
		return [
			'primary' => esc_html__( 'Primary', 'madsparrow' ),
			'subtle' => esc_html__( 'Subtle', 'madsparrow' ),
			'accent' => esc_html__( 'Accent', 'madsparrow' ),
		];
	}

	protected function register_controls() {

		$first_level = 0;

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Pricing', 'madsparrow' ),
			]
		);

		$this->add_control(
			'currency_symbol', [
				'label' => esc_html__( 'Curency Symbol', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => '$'
			]
		);

		$this->add_control(
            'price', [
                'label' => __( 'Price', 'madsparrow' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
                'default' => 39,
            ]
        );

		$this->add_control(
			'popular', [
				'label' => esc_html__( 'Badge', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'madsparrow' ),
				'label_off' => esc_html__( 'Off', 'madsparrow' ),
				'return_value' => 'on',
			]
		);

		$this->add_control(
			'most_popular', [
				'label' => __( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'MOST POPULAR', 'madsparrow' ),
				'placeholder' => __( 'Type your text here', 'madsparrow' ),
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_control(
			'period', [
				'label' => esc_html__( 'Period', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => '/ Mo',
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Header', 'madsparrow' ),
			]
		);

		$this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Standard',
			]
		);

		$this->add_control(
			'description', [
				'label' => esc_html__( 'Description', 'madsparrow' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Enter your description', 'madsparrow' ),
			]
		);

		$this->add_control(
			'title_html_tag', [
				'label' => esc_html__( 'HTML Tag', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1' => esc_html__( 'Heading 1', 'madsparrow' ),
					'h2' => esc_html__( 'Heading 2', 'madsparrow' ),
					'h3' => esc_html__( 'Heading 3', 'madsparrow' ),
					'h4' => esc_html__( 'Heading 4', 'madsparrow' ),
					'h5' => esc_html__( 'Heading 5', 'madsparrow' ),
					'h6' => esc_html__( 'Heading 6', 'madsparrow' ),
					'div' => esc_html__( 'div', 'madsparrow' ),
					'span' => esc_html__( 'span', 'madsparrow' ),
					'p' => esc_html__( 'p', 'madsparrow' )
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Features', 'madsparrow' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'List Item', 'madsparrow' ),
			]
		);

		$repeater->add_control(
			'active', [
				'label' => esc_html__( 'Active', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'features_list', [
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'madsparrow' ),
						'active' => 'yes',
					],
					[
						'text' => esc_html__( 'List Item #2', 'madsparrow' ),
						'active' => 'yes',
					],
					[
						'text' => esc_html__( 'List Item #3', 'madsparrow' ),
						'active' => '',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Button', 'madsparrow' ),
			]
		);

		$this->add_control(
			'btn_show', [
				'label' => esc_html__( 'Show Button', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'btn_text', [
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Click Here',
				'label_block' => true,
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_link', [
				'label' => esc_html__( 'Link', 'madsparrow' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url'=> '#',
				],
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_style', [
				'label' => esc_html__( 'Style', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => self::get_button_styles(),
				'separator' => 'before',
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_full_width', [
				'label' => esc_html__( 'Full Width', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_disabled', [
				'label' => esc_html__( 'Disable Button', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_size', [
				'label' => esc_html__( 'Size', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => self::get_button_sizes(),
				'default' => 'md',
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_icon', [
				'label' => esc_html__( 'Icon', 'madsparrow' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
				'condition' => [
					'btn_show' => 'on',
				],
			]
		);

		$this->add_control(
			'btn_icon_position', [
				'label' => esc_html__( 'Position', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'madsparrow' ),
						'icon' => 'eicon-long-arrow-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'madsparrow' ),
						'icon' => 'eicon-long-arrow-right',
					],
				],
				'default' => 'right',
				'condition' => [
					'btn_icon[value]!' => '',
					'btn_show' => 'on',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Price Table', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'alignment', [
				'label' => esc_html__( 'Alignment', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
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
				],
				'selectors' => [
					'{{WRAPPER}} .ms-pt-block' => 'text-align: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),[
				'name' => 'background_price_table',
				'label' => __( 'Background', 'madsparrow' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .ms-pt-block',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .ms-pt-block',
			]
		);

		$this->add_responsive_control(
			'padding', [
				'label' => esc_html__( 'Padding', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ms-pt-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'price_border',
				'label' => __( 'Border', 'madsparrow' ),
				'selector' => '{{WRAPPER}} .ms-pt-block',
			]
		);

		$this->add_control(
			'border_radius', [
				'label' => __( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'pt' ],
				'selectors' => [
					'{{WRAPPER}} .ms-pt-block' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),[
				'name' => 'price_box_shadow',
				'label' => __( 'Box Shadow', 'madsparrow' ),
				'selector' => '{{WRAPPER}} .ms-pt-block',
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Badge', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			'badge_alignment', [
				'label' => esc_html__( 'Alignment', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
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
				],
				'selectors' => [
					'{{WRAPPER}} .most-popular' => 'text-align: {{VALUE}};'
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'price_badge_text',
				'selector' => '{{WRAPPER}} .ms-mp--badge', '{{WRAPPER}} .currency',
			]
		);

		$this->add_control(
			'badge_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-mp--badge' => 'color: {{VALUE}}',
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'border',
				'label' => __( 'Border', 'madsparrow' ),
				'selector' => '{{WRAPPER}} .ms-mp--badge',
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_control(
			'badge_radius', [
				'label' => __( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ms-mp--badge' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			'margin_badge', [
				'label' => esc_html__( 'Margin', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ms-mp--badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			'padding_badge', [
				'label' => esc_html__( 'Padding', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ms-mp--badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->add_control(
			'badge_bg', [
				'label' => esc_html__( 'Background Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-mp--badge' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'popular' => 'on',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Pricing', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Price', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'price_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price' => 'color: {{VALUE}}',  '{{WRAPPER}} .currency' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .price', '{{WRAPPER}} .currency',
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Currency', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'currency_typography',
				'selector' => '{{WRAPPER}} .currency',
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_position', [
				'label' => esc_html__( 'Position', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'before' => [
						'title' => esc_html__( 'Before', 'madsparrow' ),
						'icon' => 'eicon-h-align-left',
					],
					'after' => [
						'title' => esc_html__( 'After', 'madsparrow' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'before',
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Period', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'period_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .period' => 'color: {{VALUE}}',
				],
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'period_typography',
				'selector' => '{{WRAPPER}} .period',
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_control(
			'period_indent', [
				'label' => esc_html__( 'Period Indent', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .period' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Header', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_position', [
				'label' => esc_html__( 'Position', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top' => esc_html__( 'Top', 'madsparrow' ),
					'bottom' => esc_html__( 'Bottom', 'madsparrow' ),
				],
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Title', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt--title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ms-pt--title',
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Description', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'description_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt--subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .ms-pt--subtitle',
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Features', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'features_list_color', [
				'label' => esc_html__( 'Active Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt--content .active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'features_list_no_color', [
				'label' => esc_html__( 'No Active Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt--content .no-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'features_list_typography',
				'selector' => '{{WRAPPER}} .ms-pt--content',
			]
		);

		$this->add_control(
			'heading_' . $first_level++, [
				'label' => esc_html__( 'Icon', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color', [
				'label' => esc_html__( 'Active', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt-block li.active .icon-check svg' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_no_color', [
				'label' => esc_html__( 'No Active', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-pt-block li.no-active .icon-check svg' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Button', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'border_radius_btn', [
                'label' => __( 'Border Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'pt' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-pt--footer .btn' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

	}

	private function render_currency_symbol( $symbol, $location ) {

		$currency_position = $this->get_settings( 'currency_position' );
		$location_setting = ! empty( $currency_position ) ? $currency_position : 'before';

		if ( ! empty( $symbol ) && $location === $location_setting ) {
			echo '<span class="currency currency--' . $location . '">' . $symbol . '</span>';
		}

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'price-table', 'class', 'ms-pt-block' );

		?>

		<div <?php echo $this->get_render_attribute_string( 'price-table' ); ?>>

			<?php if ( $settings[ 'title' ] || $settings[ 'description' ] ) : ?>

				<div class="ms-pt--price">

					<?php if ( 'on' === $settings[ 'popular' ] ) : ?>

						<div class="most-popular">
							<div class="ms-mp--badge">
								<p><?php echo $settings[ 'most_popular' ]; ?></p>
							</div>
						</div>

					<?php endif; ?>

					<?php if ( $settings[ 'title_position' ] === 'bottom' ) : ?>

						<?php $this->render_currency_symbol( $settings[ 'currency_symbol' ], 'before' ); ?>

						<?php if ( ! empty( $settings[ 'price' ] ) || $settings[ 'price' ] === 0 ) : ?>
							<span class="price"><?php echo $settings[ 'price' ]; ?></span>
						<?php endif; ?>

						<?php $this->render_currency_symbol( $settings[ 'currency_symbol' ], 'after' ); ?>

						<?php if ( ! empty( $settings[ 'period' ] ) ) : ?>
							<span class="period"><?php echo $settings[ 'period' ]; ?></span>
						<?php endif; ?>

					<?php endif; ?>

				</div>

				<div class="ms-pt--header <?php echo $settings[ 'title_position' ]; ?>">

					<?php if ( ! empty( $settings[ 'title' ] ) ) : ?>

						<<?php echo $settings[ 'title_html_tag' ]; ?> class="ms-pt--title">
							<?php echo $settings[ 'title' ]; ?>
						</<?php echo $settings[ 'title_html_tag' ]; ?>>

					<?php endif; ?>

					<?php if ( $settings[ 'title_position' ] === 'top' ) : ?>

						<?php $this->render_currency_symbol( $settings[ 'currency_symbol' ], 'before' ); ?>

						<?php if ( ! empty( $settings[ 'price' ] ) || $settings[ 'price' ] === 0 ) : ?>
							<span class="price"><?php echo $settings[ 'price' ]; ?></span>
						<?php endif; ?>

						<?php $this->render_currency_symbol( $settings[ 'currency_symbol' ], 'after' ); ?>

						<?php if ( ! empty( $settings[ 'period' ] ) ) : ?>
							<span class="period"><?php echo $settings[ 'period' ]; ?></span>
						<?php endif; ?>

					<?php endif; ?>

					<?php if ( ! empty( $settings[ 'description' ] ) ) : ?>

						<p class="ms-pt--subtitle">
							<?php echo $settings[ 'description' ]; ?>
						</p>

					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php if ( ! empty( $settings[ 'features_list' ] ) ) : ?>

				<div class="ms-pt--content">

					<ul>

						<?php foreach ( $settings[ 'features_list' ] as $item ) : ?>

							<li class="<?php echo $item[ 'active' ] ? 'active' : 'no-active'; ?>">

								<?php if ( ! empty( $item[ 'text' ] ) ) : ?>
									<i class="icon-check">
										<?php if ( $item[ 'active' ] == 'yes') : ?>
											<svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17l-5-5"/></svg>
										<?php else: ?>
											<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;stroke-linecap:round;stroke-linejoin:round;}</style></defs><g><path class="cls-1" d="M7 7l18 18M7 25L25 7"/></g></svg>
										<?php endif; ?>
									</i>

									<span>
										<?php echo $item[ 'text' ]; ?>
									</span>

								<?php endif; ?>

							</li>

						<?php endforeach; ?>

					</ul>

				</div>

			<?php endif; ?>

			<?php if ( ! empty( $settings[ 'btn_text' ] ) ) : ?>

				<div class="ms-pt--footer">

					<?php

					$this->add_render_attribute( [
						'button' => [
							'class' => [
								'btn',
								'btn--' . $settings[ 'btn_size' ],
								'btn--' . $settings[ 'btn_style' ]
							],
							'role' => 'button'
						]
					] );

					if ( $settings[ 'btn_full_width' ] == 'yes' ) {
						$this->add_render_attribute( 'button', 'class', 'btn--full-width' );
					}

					if ( $settings[ 'btn_disabled' ] == 'yes' ) {
						$this->add_render_attribute( 'button', 'class', 'btn--disabled' );
					}

					if ( ! empty( $settings[ 'btn_link' ][ 'url' ] ) ) {

						$this->add_render_attribute( 'button', 'href', $settings[ 'btn_link' ][ 'url' ] );

						if ( $settings[ 'btn_link' ][ 'is_external' ] ) {
							$this->add_render_attribute( 'button', 'target', '_blank' );
						}

						if ( $settings[ 'btn_link' ][ 'nofollow' ] ) {
							$this->add_render_attribute( 'button', 'rel', 'nofollow' );
						}

					} ?>

					<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>

						<?php if ( ! empty( $settings[ 'btn_icon' ][ 'value' ] ) && $settings[ 'btn_icon_position' ] == 'left' ) : ?>

							<span class="ms-btn__icon ms-btn__icon--left">
								<?php Icons_Manager::render_icon( $settings[ 'btn_icon' ], [ 'aria-hidden' => 'true' ] ); ?>
							</span>

						<?php endif; ?>
						
						<div class="ms-btn__text">
							<span class="text--main"><?php echo $settings[ 'btn_text' ]; ?></span>
						</div>

						<span class="ms-btn--ripple"></span>

						<?php if ( ! empty( $settings[ 'btn_icon' ][ 'value' ] ) && $settings[ 'btn_icon_position' ] == 'right' ) : ?>

							<span class="ms-btn__icon ms-btn__icon--right">
								<?php Icons_Manager::render_icon( $settings[ 'btn_icon' ], [ 'aria-hidden' => 'true' ] ); ?>
							</span>

						<?php endif; ?>

					</a>

				</div>

			<?php endif; ?>

		</div>

		<?php

	}

}