<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Magnetic extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms_magnetic';
    }

    public function get_title() {
        return esc_html__( 'Magnetic Images', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-animation ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'iamges', 'effect', 'animations', 'gallery' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Magnetic', 'madsparrow' ),
            ]
        );

        $this->add_control(
            'm_gallery', [
                'label' => __( 'Add Images', 'madsparrow' ),
                'type' => Controls_Manager::GALLERY,
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Style', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'height', [
				'label' => esc_html__( 'Container Height', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'vh',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
                    'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .magnetic_hero .hero__images' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'width', [
				'label' => esc_html__( 'Images Width', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hero__images .hero__image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'image_ratio', [
				'label' => __( 'Image Ratio', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto' => esc_html__( 'auto', 'madsparrow' ),
					'1/1' => esc_html__( '1:1', 'madsparrow' ),
					'4/3' => esc_html__( '4:3', 'madsparrow' ),
					'3/2' => esc_html__( '3:2', 'madsparrow' ),
					'3/4' => esc_html__( '3:4', 'madsparrow' ),
					'9/16' => esc_html__( '9:16', 'madsparrow' ),
					'16/9' => esc_html__( '16:9', 'madsparrow' ),
					'16/10' => esc_html__( '16:10', 'madsparrow' ),
					'21/9' => esc_html__( '21:9', 'madsparrow' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .hero__images .hero__image'  => 'aspect-ratio: {{TOP}}',
                    // '{{WRAPPER}} .hero__images .hero__image img'  => 'aspect-ratio: {{TOP}}',
                ],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .hero__images .hero__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display(); ?>

            <div class="magnetic_hero">
                <div class="hero__images">
                    <?php foreach ( $settings['m_gallery'] as $image ) : ?>
                        <div class="hero__image">
                            <img src="<?php echo esc_attr( $image['url'] ) ?>" class="magnetic-image" alt="<?php echo esc_attr( get_the_title( $image['id']) ) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

    <?php }
   

}