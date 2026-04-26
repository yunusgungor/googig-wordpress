<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Accordion extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms_accordion';
    }

    public function get_title() {
        return esc_html__( 'Accordion', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-accordion ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'accordion', 'controls', 'text', 'title', 'faq' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Accordion', 'madsparrow' ),
            ]
        );

        $repeater = new Repeater();
        
        $repeater->add_control(
            'accordion_title',
            [
                'label' => esc_html__( 'Title', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title', 'madsparrow' ),
            ]
        );

		$repeater->add_control(
			'accordion_text',
			[
				'label' => esc_html__( 'Text', 'madsparrow' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Type your text here', 'madsparrow' ),
                'separator' => 'before',
			]
		);

		$this->add_control(
			'accordion_content', 
            [
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'accordion_title' => esc_html__( 'Section #1', 'madsparrow' ),
						'accordion_text' => esc_html__( 'Type your text here', 'madsparrow' ),
					],
					[
						'accordion_title' => esc_html__( 'Section #2', 'madsparrow' ),
						'accordion_text' => esc_html__( 'Type your text here', 'madsparrow' ),
					],
					[
						'accordion_title' => esc_html__( 'Section #3', 'madsparrow' ),
						'accordion_text' => esc_html__( 'Type your text here', 'madsparrow' ),
					],
				],
			]
		);

        $this->end_controls_section();


        // TAB CONTENT
        $this->start_controls_section(
            'accordion_type', [
                'label' => __( 'View', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'accordion_collapse',
			[
				'label' => esc_html__( 'Collapse', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'madsparrow' ),
				'label_off' => esc_html__( 'Off', 'madsparrow' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_responsive_control(
            'accordion_gap', [
                'label' => __( 'Gap', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'pt' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'pt',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms_accordion' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'accordion_border_radius',
			[
				'label' => __( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_accordion' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				],
			]
		);

        $this->add_responsive_control(
			'accordion_border_radius_g',
			[
				'label' => __( 'Group Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac_panel' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				],
			]
		);

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'accordion_style_label', [
                'label' => __( 'Label', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'background',
                'label' => __( 'Background', 'madsparrow' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ms_ac--label',
            ]
        );

		$this->add_control(
			'accordion_label_padding',
			[
				'label' => esc_html__( 'Indent', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'line_effect',
			[
				'label' => esc_html__( 'Line Effect', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
				'label_on' => esc_html__( 'On', 'madsparrow' ),
				'label_off' => esc_html__( 'Off', 'madsparrow' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_responsive_control(
            'line_effect_size', [
                'label' => __( 'Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms_ac--label::before' => 'border-bottom: solid {{SIZE}}{{UNIT}} var(--color-contrast-higher);',
                    '{{WRAPPER}} .ms_ac--label::after' => 'border-bottom: solid {{SIZE}}{{UNIT}} var(--color-primary);',
                ],
                'condition' => [
					'line_effect' => 'yes',
				],
            ]
        );

		// TAB CONTENT
		$this->start_controls_tabs(
			'tabs_' . $first_level++,
		);
        
        $this->start_controls_tab(
          'data_style_before_tab_line',
          [
            'label' => __( 'Before', 'madsparrow' ),
            'condition' => [
                'line_effect' => 'yes',
            ],
          ]
        );

        $this->add_control(
            'line_effect_before',
            [
                'label'     => __( 'Line Color', 'madsparrow' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_ac--label::before' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
					'line_effect' => 'yes',
				],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
          'data_style_after_tab_line',
          [
            'label' => __( 'After', 'madsparrow' ),
            'condition' => [
                'line_effect' => 'yes',
            ],
          ]
        );

        $this->add_control(
            'line_effect_after',
            [
                'label'     => __( 'Line Color', 'madsparrow' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_ac--label::after' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
					'line_effect' => 'yes',
				],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .ms_ac--label',
				'separator' => 'before',
                'condition' => [
					'line_effect!' => 'yes',
				],
			]
		);

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'accordion_style_title', [
                'label' => __( 'Title', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .label-title',
			]
		);

        $this->add_control(
            'title_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_ac--label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'accordion_title_padding',
			[
				'label' => esc_html__( 'Indent', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--label .label-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'accordion_style_icon', [
                'label' => __( 'Icon', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'accordion_icon_size', [
                'label' => __( 'Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 4,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .accordion_icon--open' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .accordion_icon--close' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--icon' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				],
			]
		);
        
        $this->add_control(
            'icon_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_accordion .ms_ac--icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'icon_background',
                'label' => __( 'Background', 'madsparrow' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ms_ac--icon',
            ]
        );

        $this->add_responsive_control(
			'accordion_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'accordion_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'accordion_icon_position', [
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
					'accordion_icon_before[value]!' => '',
				],
			]
		);

		$this->add_control(
			'accordion_style_select',
			[
				'label' => esc_html__( 'Icon Style', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'rotation',
				'options' => [
					'rotation' => esc_html__( 'Rotation', 'madsparrow' ),
					'switching'  => esc_html__( 'Switching', 'madsparrow' ),
				],
			]
		);

		// TAB CONTENT
		$this->start_controls_tabs(
			'tabs_' . $first_level++
		);
        
        $this->start_controls_tab(
          'data_style_before_tab',
          [
            'label' => __( 'Before', 'madsparrow' ),
            'condition' => [
                'accordion_style_select' => 'switching',
            ],
          ]
        );

        $this->add_control(
            'accordion_icon_before',
            [
                'label' => __( 'Icon', 'madsparrow' ),
                'type' => Controls_Manager::ICONS,
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
          'data_style_after_tab',
          [
            'label' => __( 'After', 'madsparrow' ),
            'condition' => [
                'accordion_style_select' => 'switching',
            ],
          ]
        );

        $this->add_control(
            'accordion_icon_after',
            [
                'label' => __( 'Icon', 'madsparrow' ),
                'type' => Controls_Manager::ICONS,
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'accordion_style_content', [
                'label' => __( 'Content', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ms_ac--content .ms_ac--text',
			]
		);

        $this->add_control(
            'content_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_ac--content .ms_ac--text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'content_background',
                'label' => __( 'Background', 'madsparrow' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ms_ac--content',
            ]
        );

		$this->add_control(
			'accordion_content_padding',
			[
				'label' => esc_html__( 'Indent', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'pt', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms_ac--content .ms_ac--text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        
        if ( 'yes' === $settings['line_effect'] ) {
            $line_effect = ' l-ef';
        } else {
            $line_effect = '';
        }
        if ( 'yes' === $settings['accordion_collapse'] ) {
            $collapse = 'data-collapse="' . $settings['accordion_collapse'] . '"';
		} else {
            $collapse = '';
        }
        
        ?>

        <div class="ms_accordion i--<?php echo $settings['accordion_icon_position']; echo $line_effect?>" <?php echo $collapse; ?>>

            <?php foreach ( $settings[ 'accordion_content' ] as $index => $item ) : ?>
            
                <div class="ms_ac_panel">

                    <div class="ms_ac--label">

                        <div class="label-title">
                            <?php echo $item['accordion_title']; ?>
                        </div>
                        
                        <span class="ms_ac--icon <?php echo $settings['accordion_style_select']; ?>">

                            <?php if ( $settings['accordion_style_select'] == 'switching' ) : ?>

                                <div class="accordion_icon--open">
                                    <?php Icons_Manager::render_icon( $settings['accordion_icon_before'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>

                                <div class="accordion_icon--close">
                                    <?php Icons_Manager::render_icon( $settings['accordion_icon_after'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>

                            <?php else: ?>

                                <div class="accordion_icon--open">
                                    <?php Icons_Manager::render_icon( $settings['accordion_icon_before'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>

                            <?php endif; ?>

                        </span>
                    </div>

                    <div class="ms_ac--content">
                        <div class="ms_ac--text">
                            <?php echo $item['accordion_text']; ?>
                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php }

}