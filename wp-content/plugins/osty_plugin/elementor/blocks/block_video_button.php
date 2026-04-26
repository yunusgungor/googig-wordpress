<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Video_Button extends Widget_Base {

	public function get_name() {
		return 'ms_video_button';
	}

	public function get_title() {
		return esc_html__( 'Video Button', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-play ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'video', 'play', 'popup', 'button', 'fancybox' ];
	}

	protected function register_controls() {

		$first_level = 0;

		// ANCHOR
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Video Button', 'madsparrow' ),
			]
		);

		$this->add_control(
			'video_type', [
				'label' => esc_html__( 'Video Type', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'YouTube',
				'options' => [
					'youtube'=> esc_html__( 'YouTube', 'madsparrow' ),
					'vimeo'=> esc_html__( 'Vimeo', 'madsparrow' ),
				]
			]
		);

		$this->add_control(
			'caption', [
				'label' => esc_html__( 'Caption', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'url', [
				'label' => esc_html__( 'Video URL', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'input_type' => 'url',
				'label_block' => true,
				'default' => 'https://vimeo.com/367945766',
			]
		);

		$this->add_control(
			'start_time', [
				'label' => esc_html__( 'Start Time', 'madsparrow' ),
				'description' => esc_html__( 'Specify a start time (in seconds)', 'madsparrow' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'condition' => [
					'video_type' => 'youtube'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'end_time', [
				'label' => esc_html__( 'End Time', 'madsparrow' ),
				'description' => esc_html__( 'Specify an end time (in seconds)', 'madsparrow' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'video_type' => 'youtube'
				]
			]
		);

		$this->add_control(
			'auto_play', [
				'label' => esc_html__( 'Auto Play', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'madsparrow' ),
				'label_off' => esc_html__( 'No', 'madsparrow' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'mute', [
				'label' => esc_html__( 'Mute', 'madsparrow' ),
				'description' => esc_html__( 'This will play the video muted', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'madsparrow' ),
				'label_off' => esc_html__( 'No', 'madsparrow' ),
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_controls', [
				'label' => esc_html__( 'Show Controls', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'madsparrow' ),
				'label_off' => esc_html__( 'No', 'madsparrow' ),
				'default' => 'no',
			]
		);

		$this->add_control(
			'label', [
				'label' => esc_html__( 'Label', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Watch Video',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'label_position', [
				'label' => esc_html__( 'Label Position', 'madsparrow' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'madsparrow' ),
						'icon' => 'eicon-h-align-left',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'madsparrow' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'madsparrow' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'condition' => [
					'label!' => '',
				],
			]
		);

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'General', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
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

		$this->add_responsive_control(
			'button_size', [
				'label' => esc_html__( 'Button Size', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'button_icon_size', [
				'label' => esc_html__( 'Icon Size', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-vb__icon',
            ]
        );

		$this->add_control(
			'button_border_radius', [
				'label' => esc_html__( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_background_blur', [
				'label' =>esc_html__( 'Background Blur', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
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
			'button_color_n', [
				'label' =>esc_html__( 'Icon Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color_n', [
				'label' =>esc_html__( 'Background Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ms-vb__icon',
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
			'button_color_h', [
				'label' =>esc_html__( 'Icon Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color_h', [
				'label' =>esc_html__( 'Background Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-vb__icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'button_box_shadow_h',
				'selector' => '{{WRAPPER}} .ms-vb__icon:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Label', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'label!' => '',
				],
			]
		);

		$this->add_control(
			'label_color', [
				'label' => esc_html__( 'Text Color', 'madsparrow' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ms-vb__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .ms-vb__label',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings[ 'url' ] ) ) {
			return;
		}

		$this->add_render_attribute( 'video-button', [
			'class' => [
				'ms-vb',
				'ms-vb--label-' . $settings[ 'label_position' ]
			]
		] );

		switch ( $settings[ 'video_type' ] ) {

			case 'youtube':

				$this->add_render_attribute( 'video-button-link', [
					'data-video' => $settings[ 'video_type' ],
					'data-small-btn' => 'true',
					'data-caption' => $settings[ 'caption' ],
					'data-autoplay' => $settings[ 'auto_play' ] == 'yes' ? 1 : 0,
					'data-controls' => $settings[ 'show_controls' ] == 'yes' ? 1 : 0,
					'data-muted' => $settings[ 'mute' ] == 'yes' ? 1 : 0,
					'data-start' => $settings[ 'start_time' ],
					'data-end' => $settings[ 'end_time' ],
					'data-showinfo' => 0,
					'href' => $settings[ 'url' ]
				] );	

			break;

			case 'vimeo':

				$this->add_render_attribute( 'video-button-link', [
					'data-video' => $settings[ 'video_type' ],
					'data-small-btn' => 'true',
					'data-caption' => $settings[ 'caption' ],
					'data-autoplay' => $settings[ 'auto_play' ] == 'yes' ? 1 : 0,
					'data-controls' => $settings[ 'show_controls' ] == 'yes' ? 1 : 0,
					'data-muted' => $settings[ 'mute' ] == 'yes' ? 1 : 0,
					'href' => $settings[ 'url' ]
				] );

			break;
		}

		?>

		<div <?php echo $this->get_render_attribute_string( 'video-button' ); ?>>

			<a <?php echo $this->get_render_attribute_string( 'video-button-link' ); ?> class="ms-vb--src">
				<div class="ms-vb__icon">
					<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  					<path fill="none" d="M-1-1h582v402H-1z"/><g><path d="M5 3l14 9-14 9V3z"/></g>
				</svg>
				</div>

				<?php if ( $settings[ 'label' ] ) : ?>
				<span class="ms-vb__label"><?php echo $settings[ 'label' ]; ?></span>
			<?php endif; ?>
			</a>

		</div>

	<?php

	}

}