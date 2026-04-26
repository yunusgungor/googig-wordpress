<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Image extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

	public function get_name() {
		return 'ms_image';
	}

	public function get_title() {
		return esc_html__( 'Image', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-image ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual' ];
	}

	protected function register_controls() {

        $first_level = 0;

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'madsparrow' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'madsparrow' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label' => esc_html__( 'Caption', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'madsparrow' ),
					'attachment' => esc_html__( 'Attachment Caption', 'madsparrow' ),
					'custom' => esc_html__( 'Custom Caption', 'madsparrow' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Custom Caption', 'madsparrow' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your image caption', 'madsparrow' ),
				'condition' => [
					'caption_source' => 'custom',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

        $this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'madsparrow' ),
					'file' => esc_html__( 'Media File', 'madsparrow' ),
					'custom' => esc_html__( 'Custom URL', 'madsparrow' ),
				],
			]
		);

        $this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'madsparrow' ),
				'type' => Controls_Manager::URL,
                'placeholder' => __( 'Enter URL', 'madsparrow' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'description' => sprintf(
					esc_html__( 'Manage your site’s lightbox settings in the %1$sLightbox panel%2$s.', 'madsparrow' ),
					'<a href="javascript: $e.run( \'panel/global/open\' ).then( () => $e.route( \'panel/global/settings-lightbox\' ) )">',
					'</a>'
				),
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'madsparrow' ),
					'no' => esc_html__( 'No', 'madsparrow' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->end_controls_section();

        // Style
        $this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'masparrow' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_control(
            'parallax_container', [
                'label' => esc_html__( 'Scroll Trigger', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => __( 'Works only when smooth scrolling is enabled', 'madsparrow' ),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => ''
            ]
        );
    
        $this->add_control(
            'parallax_speed_container', [
                'label' => __( 'Parallax Speed', 'madsparrow' ),
                'description' => __( 'Min -2, Max 2', 'madsparrow' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -2,
                'max' => 2,
                'step' => 0.1,
                'default' => 1,
                'condition' => [
                    'parallax_container' => ['yes'],
                ],
                'prefix_class' => ''
            ]
        );

        $this->add_control(
			'separator_panel_style' . $first_level++,
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
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
                    '{{WRAPPER}} .ms-image-widget .image_inner'  => 'aspect-ratio: {{TOP}}',
                    '{{WRAPPER}} .ms-image-widget .image_inner img'  => 'aspect-ratio: {{TOP}}',
                ],
			]
		);

        $this->add_control(
			'separator_panel_style' . $first_level++,
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => 100,
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
					'{{WRAPPER}} .ms-image-widget img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => 100,
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
					'{{WRAPPER}} .ms-image-widget img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'madsparrow' ),
					'fill' => esc_html__( 'Fill', 'madsparrow' ),
					'cover' => esc_html__( 'Cover', 'madsparrow' ),
					'contain' => esc_html__( 'Contain', 'madsparrow' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-position',
			[
				'label' => esc_html__( 'Object Position', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'center center' => esc_html__( 'Center Center', 'madsparrow' ),
					'center left' => esc_html__( 'Center Left', 'madsparrow' ),
					'center right' => esc_html__( 'Center Right', 'madsparrow' ),
					'top center' => esc_html__( 'Top Center', 'madsparrow' ),
					'top left' => esc_html__( 'Top Left', 'madsparrow' ),
					'top right' => esc_html__( 'Top Right', 'madsparrow' ),
					'bottom center' => esc_html__( 'Bottom Center', 'madsparrow' ),
					'bottom left' => esc_html__( 'Bottom Left', 'madsparrow' ),
					'bottom right' => esc_html__( 'Bottom Right', 'madsparrow' ),
				],
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'object-fit' => 'cover',
				],
			]
		);

        $this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

        $this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'madsparrow' ),
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
					'{{WRAPPER}} .ms-image-widget img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .ms-image-widget img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'madsparrow' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ms-image-widget:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'madsparrow' ) . ' (s)',
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'madsparrow' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .ms-image-widget .image_inner img' => 'mix-blend-mode: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .ms-image-widget img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms-image-widget img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .ms-image-widget img',
			]
		);

		$this->end_controls_section();

	}

	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = $this->has_caption( $settings );
        $link_to = $settings['link_to'];

        if ( $link_to == 'custom' ) { 
            $link = $settings['link']['url'];
            $open_lightbox = 'no';
        } else {
            $link = $settings['image']['url'];
            $open_lightbox = $settings['open_lightbox'];
        } ?>

        <?php 
            if ( $settings['parallax_container'] === 'yes' ) {
                $data_parallax = ' data-scroll data-scroll-speed="' . $settings['parallax_speed_container'] .'"';
            } else {
                $data_parallax = '';
            }
        ?>

        <div class="ms-image-widget">

            <?php if ( $has_caption ) : ?>
                <figure class="wp-caption">
            <?php endif; ?>
            <?php if ( $link && $link_to !== 'none' ) : ?>
                    <a href="<?php echo $link; ?>" data-elementor-open-lightbox="<?php echo $open_lightbox;?>">
            <?php endif; ?>
            <div class='image_inner'<?php echo $data_parallax; ?>>
                <?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
            </div>
            <?php if ( $link && $link_to !== 'none' ) : ?>
                    </a>
            <?php endif; ?>
            <?php if ( $has_caption ) : ?>
                    <figcaption class="widget-image-caption wp-caption-text"><?php
                        echo wp_kses_post( $this->get_caption( $settings ) );
                    ?></figcaption>
            <?php endif; ?>
            <?php if ( $has_caption ) : ?>
                </figure>
            <?php endif; ?>
        </div>

		<?php
	}

}
