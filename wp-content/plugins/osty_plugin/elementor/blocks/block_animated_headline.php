<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Animated_Headline extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms_animated_headline';
    }

    public function get_title() {
        return esc_html__( 'Animated Headline', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-animated-headline ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'headline', 'animation', 'text', 'title' ];
    }

    protected function register_controls() {

        $first_level = 0;        

        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Title', 'madsparrow' ),
            ]
        );

        $this->add_control(
			'animated_title',
			[
				'label' => esc_html__( 'Title', 'madsparrow' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'madsparrow' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'madsparrow' ),
			]
		);

        $this->add_responsive_control(
			'animated_header_align',
			[
				'label' => esc_html__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		// TAB CONTENT
		$this->start_controls_section(
			'section_', [
				'label' => esc_html__( 'Style', 'madsparrow' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-ah-wrapper .content__title',
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-ah-wrapper .content__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'normal'        => esc_html__( 'Normal', 'madsparrow' ),
                    'multiply'      => esc_html__( 'Multiply', 'madsparrow' ),
                    'screen'        => esc_html__( 'Screen', 'madsparrow' ),
                    'overlay'       => esc_html__( 'Overlay', 'madsparrow' ),
                    'darken'        => esc_html__( 'Darken', 'madsparrow' ),
                    'lighten'       => esc_html__( 'Lighten', 'madsparrow' ),
                    'color-dodge'   => esc_html__( 'Color Dodge', 'madsparrow' ),
                    'color-burn'    => esc_html__( 'Color Burn', 'madsparrow' ),
                    'hard-light'    => esc_html__( 'Hard Light', 'madsparrow' ),
                    'soft-light'    => esc_html__( 'Soft Light', 'madsparrow' ),
                    'difference'    => esc_html__( 'Difference', 'madsparrow' ),
                    'exclusion'     => esc_html__( 'Exclusion', 'madsparrow' ),
                    'hue'           => esc_html__( 'Hue', 'madsparrow' ),
                    'saturation'    => esc_html__( 'Saturation', 'madsparrow' ),
                    'color'         => esc_html__( 'Color', 'madsparrow' ),
                    'luminosity'    => esc_html__( 'Luminosity', 'madsparrow' ),
                    'plus-darker'   => esc_html__( 'Plus Darker', 'madsparrow' ),
                    'plus-lighter'  => esc_html__( 'Plus Lighter', 'madsparrow' ),
				],
				'default' => 'normal',
                'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .ms-ah-wrapper .content__title' => 'mix-blend-mode: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-ah-wrapper .content__title' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_control(
			'scrolltrigger', [
				'label' => __( 'Scrolltrigger', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __('Attach animation to scroll', 'madsparrow'),
				'label_on' => __( 'On', 'madsparrow' ),
				'label_off' => __( 'Off', 'madsparrow' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

        $this->add_control(
			'animated_header_effect',
			[
				'label' => esc_html__( 'Effect', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'disable' => 'Disable',
					'data-effect1' => 'Effect 1',
					'data-effect2' => 'Effect 2',
					'data-effect3' => 'Effect 3',
					'data-effect4' => 'Effect 4',
					'data-effect5' => 'Effect 5',
					'data-effect6' => 'Effect 6',
				],
				'default' => 'disable',
			]
		);

		$this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( '' === $settings['animated_title'] ) {
			return;
		}

        if ( '' === $settings['scrolltrigger'] ) {
			$scroll = 'off';
		} else {
			$scroll = $settings['scrolltrigger'];
		}
        // 

        $this->add_render_attribute( [
            'animated_headline' => [
                'class' => [ 'ms-ah-wrapper' ],
            ]
        ] );

        $title = $settings['animated_title']; ?>

        <div <?php echo $this->get_render_attribute_string( 'animated_headline' ); ?>>
            <h1 class="content__title" data-splitting <?php echo $settings['animated_header_effect']; ?> data-scroll="<?php echo $scroll; ?>">
            	<?php echo $title; ?>
            </h1>
        </div>
        
    <?php }

}