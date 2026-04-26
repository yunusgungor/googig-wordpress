<?php

/**
 * @author: Mad Sparrow
 * @version: 1.0
 */

namespace Elementor;

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Widget_MS_Button extends Widget_Base {

	public function get_name() {
		return 'ms-button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-button ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'button', 'link', 'action' ];
	}

	public static function get_button_sizes() {
		return [
			'sm' => esc_html__( 'Small', 'madsparrow' ),
			'ba' => esc_html__( 'Basic', 'madsparrow' ),
			'md' => esc_html__( 'Medium', 'madsparrow' ),
			'lg' => esc_html__( 'Large', 'madsparrow' ),
		];
	}

	public static function get_button_type() {
		return [
			'osty' => esc_html__( 'Osty Style', 'madsparrow' ),
			'default' => esc_html__( 'Default', 'madsparrow' ),
		];
	}

	public static function get_button_styles() {
		return [
			'primary' => esc_html__( 'Primary', 'madsparrow' ),
			'contrast' => esc_html__( 'Contrast', 'madsparrow' ),
			'subtle' => esc_html__( 'Subtle', 'madsparrow' ),
			'accent' => esc_html__( 'Accent', 'madsparrow' ),
		];
	}

	protected function register_controls() {

		$first_level = 0;

		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Button', 'madsparrow' ),
			]
		);

		$this->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Click Here',
				'label_block' => true
			]
		);

		$this->add_control(
			'link', [
				'label' => esc_html__( 'Link', 'madsparrow' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
                'description' => esc_html__( 'If you replace the link with an ID (e.g., #section1), clicking the button will trigger a smooth scroll to the corresponding section instead of opening a new page.', 'madsparrow' ),
				'default' => [
					'url'=> '#',
				]
			]
		);

		$this->add_control(
			'type', [
				'label' => esc_html__( 'Type', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => self::get_button_type(),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style', [
				'label' => esc_html__( 'Style', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => self::get_button_styles(),
				'separator' => 'before',
				'condition' => [
					'type' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'alignment', [
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
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'full_width', [
				'label' => esc_html__( 'Full Width', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'disabled', [
				'label' => esc_html__( 'Disable Button', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'size', [
				'label' => esc_html__( 'Size', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => self::get_button_sizes(),
				'default' => 'md'
			]
		);

		$this->add_control(
			'icon', [
				'label' => esc_html__( 'Icon', 'madsparrow' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
                'condition' => [
					'type' => 'default',
				],
			]
		);

		$this->add_control(
			'icon_position', [
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
					'icon[value]!' => '',
					'type' => 'default',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(

			'style_section',
				[
					'label' => __( 'Button', 'madsparrow' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'type' => 'default',
					],
				]
			);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'border',
				'label' => __( 'Border', 'madsparrow' ),
				'selector' => '{{WRAPPER}} .btn',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'pt' ],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				],
			]
		);

		// TAB CONTENT
		$this->start_controls_tabs(
			'tabs_' . $first_level++
		);

		// TAB CONTENT
		$this->start_controls_tab(
			'tab_' . $first_level++, [
				'label' => esc_html__( 'Normal', 'madsparrow' ),
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'text_color', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-default .ms-btn__text, .ms-btn__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_background',
			[
				'label' => esc_html__( 'Background', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'bg_color', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-default' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border',
			[
				'label' => esc_html__( 'Border Color', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_color_normal', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// TAB CONTENT
		$this->start_controls_tab(
			'tab_' . $first_level++, [
				'label' => esc_html__( 'Hover', 'madsparrow' ),
			]
		);

		$this->add_control(
			'btn_text_hover',
			[
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'text_color_hover', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-default:hover .ms-btn__text, .btn:hover .ms-btn__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_background_hover',
			[
				'label' => esc_html__( 'Background', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'bg_color_hover', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-default:hover, .btn-default:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_hover',
			[
				'label' => esc_html__( 'Border Color', 'madsparrow' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_color_hover', [
				'label' => esc_html__( 'Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'btn_opacity_hover',
			[
                'label' => esc_html__( 'Opacity', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => .1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1
                ],
                'selectors' => [
					'{{WRAPPER}} .btn-default:hover' => 'opacity: {{SIZE}};',
				],
            ]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		

		// TAB CONTENT
		$this->start_controls_section(

			'style_section_osty',
				[
					'label' => __( 'Button Color', 'madsparrow' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'type' => 'osty',
					],
				]
			);

			$this->add_control(
				'text_color_osty', [
					'label' => esc_html__( 'Color', 'madsparrow' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-osty .ms-btn--label' => 'color: {{VALUE}};',
						'{{WRAPPER}} .btn-wrap .btn .ms-btn--circle .circle-fill' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .btn-wrap .btn .ms-btn--circle .circle-outline' => 'stroke: {{VALUE}};',
					],
				]
			);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( $settings[ 'type' ] == 'default' ) {

			$this->add_render_attribute( [
				'button' => [
					'class' => [
						'btn',
						'btn-default',
						'btn--' . $settings[ 'size' ],
						'btn--' . $settings[ 'style' ]
					],
					'role' => 'button'
				]
			] );

		} else {

			$this->add_render_attribute( [
				'button' => [
					'class' => [
						'btn',
						'btn-osty',
						'btn--' . $settings[ 'size' ]
					],
					'role' => 'button'
				]
			] );

		}

		if ( $settings[ 'full_width' ] == 'yes' ) {
			$this->add_render_attribute( 'button', 'class', 'btn--full-width' );
		}

		if ( $settings[ 'disabled' ] == 'yes' ) {
			$this->add_render_attribute( 'button', 'class', 'btn--disabled' );
		}

		if ( ! empty( $settings[ 'link' ][ 'url' ] ) ) {

			$this->add_render_attribute( 'button', 'href', $settings[ 'link' ][ 'url' ] );

			if ( $settings[ 'link' ][ 'is_external' ] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}

			if ( $settings[ 'link' ][ 'nofollow' ] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}

		}

		if ( $settings[ 'type' ] == 'default' ) : ?>


		<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>

			<?php if ( ! empty( $settings[ 'icon' ][ 'value' ] ) && $settings[ 'icon_position' ] == 'left' ) : ?>

				<span class="ms-btn__icon ms-btn__icon--left">
					<?php Icons_Manager::render_icon( $settings[ 'icon' ], [ 'aria-hidden' => 'true' ] ); ?>
				</span>

			<?php endif; ?>

			<div class="ms-btn__text"><?php echo $settings[ 'text' ]; ?></div>


			<?php if ( ! empty( $settings[ 'icon' ][ 'value' ] ) && $settings[ 'icon_position' ] == 'right' ) : ?>

				<span class="ms-btn__icon ms-btn__icon--right">
					<?php Icons_Manager::render_icon( $settings[ 'icon' ], [ 'aria-hidden' => 'true' ] ); ?>
				</span>

			<?php endif; ?>

		</a>

		<?php else: ?>
			<div class="btn-wrap">
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>

                    <div class="f-btn-l">
                        <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                            <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                            <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                        </svg>
                    </div>

                    <div class="f-btn-r">
                        <span><?php echo $settings[ 'text' ]; ?></span>
                        <div class="btn-r_icon">
                        <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                            <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                            <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                        </svg>
                        </div>
                    </div>

				</a>
			</div>
		<?php endif;

	}

	}