<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Text_Ticker extends Widget_Base {

    public function get_name() {
        return 'ms_text_ticker';
    }

    public function get_title() {
        return esc_html__( 'Ticker', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-import-kit ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'text', 'animation', 'ticker', 'line' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Content', 'madsparrow' ),
            ]
        );

        $this->add_control(
            'ticker_style', [
                'label' => esc_html__( 'Style', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'madsparrow' ),
                    'list' => esc_html__( 'List', 'madsparrow' ),
                    'images' => esc_html__( 'Images', 'madsparrow' ),
                ],
            ]
        );

        $this->add_control(
            'text_ticker',[
                'label' => __( 'Text', 'madsparrow' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'placeholder' => __( 'Type your text here', 'madsparrow' ),
                'description' => __( 'You can use <strong>&#x3c;span&#x3e;</strong> tag to highlight specific words in text.', 'madsparrow' ),
                'default' => __( 'Type your text here', 'madsparrow' ),
                'condition' => [
                    'ticker_style' => 'default',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'ticker_text', [
                'label' => esc_html__( 'Text', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'ticker_list',
            [
                'label' => __('Word', 'madsparrow'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ ticker_text }}}',
                'condition' => [
                    'ticker_style' => 'list',
                ],
            ]
        );

        $this->add_control(
            'ticker_gallery',
            [
                'label' => __( 'Gallery', 'madsparrow' ),
                'type' => Controls_Manager::GALLERY,
                'dynamic' => ['active' => true],
                'condition' => [
                    'ticker_style' => 'images',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'ticker_gallery', // Будет ticker_gallery_size и ticker_gallery_custom_dimension
                'default' => 'full',
                'condition' => [
                    'ticker_style' => 'images',
                ],
            ]
        );

        $this->add_responsive_control(
            'indent_' . $first_level++, [
                'label' => __( 'Text Indent', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap .ms-tt' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ms-tt-wrap .ms-tt li:last-child' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

		$this->add_control(
			'image',
			[
                'label' => __( 'Divider Image', 'madsparrow' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'ticker_style!' => 'images',
                ],
			]
		);

        $this->add_responsive_control(
            'height_' . $first_level++, [
                'label' => __( 'Image Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 640,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text.img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ticker_style!' => 'images',
                ],
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

        $this->add_control(
            'ticker_height',
            [
                'label' => __( 'Height', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto'  => __( 'Auto', 'madsparrow' ),
                    'fixed' => __( 'Fixed', 'madsparrow' ),
                ],
                'condition' => [
                    'ticker_style' => 'images',
                ],
            ]
        );

        $this->add_control(
            'ticker_align',
            [
                'label' => __( 'Align Items', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'flex-start'  => __( 'Start', 'madsparrow' ),
                    'center' => __( 'Center', 'madsparrow' ),
                    'flex-end' => __( 'End', 'madsparrow' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap .ms-tt' => 'align-items: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'ticker_style' => 'images',
                    'ticker_height' => 'auto',
                ],
            ]
        );

        $this->add_responsive_control(
            'height_' . $first_level++, [
                'label' => __( 'Container Height', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1440,
                        'step' => 1,
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
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ticker_style' => 'images',
                    'ticker_height' => 'fixed',
                ],
            ]
        );

        $this->add_responsive_control(
            'space_' . $first_level++, [
                'label' => __( 'Space Between', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '0',
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap .ms-tt ' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ms-tt ' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ticker_style' => 'images',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .ms-tt__text',
                'separator' => 'before',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'text_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'bg_color', [
                'label' => esc_html__( 'Background Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-text-ticker',
            ]
        );

        $this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'madsparrow' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ms-tt-wrap .ms-tt__text.img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'ticker_style' => 'images',
                ],
			]
		);

        $this->add_control(
            'mask_enable',
            [
                'label' => __( 'Mask Active', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'madsparrow' ),
                'label_off' => __( 'No', 'madsparrow' ),
                'return_value' => 'on',
                'default' => '',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'text_stroke',
            [
                'label' => __( 'Stroke', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'madsparrow' ),
                'label_off' => __( 'No', 'madsparrow' ),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'stroke_color',
            [
                'label' => __( 'Stroke Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_stroke' => 'yes',
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'stroke_width', [
                'label' => __( 'Stroke Fill Width', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text' => ' -webkit-text-stroke-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'text_stroke' => 'yes',
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => __( 'Span Text', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography_span',
                'selector' => '{{WRAPPER}} .ms-tt__text span',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'text_color_span', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text span' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'bg_color_span', [
                'label' => esc_html__( 'Background Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt-wrap span' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border_span',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-tt-wrap span',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'text_stroke_span',
            [
                'label' => __( 'Stroke', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'madsparrow' ),
                'label_off' => __( 'No', 'madsparrow' ),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'stroke_color_span',
            [
                'label' => __( 'Stroke Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text span' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_stroke_span' => 'yes',
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->add_control(
            'stroke_width_span', [
                'label' => __( 'Stroke Fill Width', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'default' => '1',
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tt__text span' => ' -webkit-text-stroke-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'text_stroke_span' => 'yes',
                    'ticker_style!' => 'images',
                ],
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Options', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'scroll_dependency',
            [
                'label' => __( 'Scroll Dependency', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'madsparrow' ),
                'label_off' => __( 'No', 'madsparrow' ),
                'return_value' => 'on',
                'default' => 'on',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hover',
            [
                'label' => __( 'Hover Effect', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'  => __( 'None', 'madsparrow' ),
                    'stop' => __( 'Stop', 'madsparrow' ),
                    'slow_down' => __( 'Slow Down', 'madsparrow' ),
                ],
                'separator' => 'before',
                'condition' => [
                    'scroll_dependency' => '',
                ],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => __( 'Direction', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => __( 'Right to Left', 'madsparrow' ),
                    'right' => __( 'Left to Right', 'madsparrow' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'speed', [
                'label' => __( 'Speed', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'description' => __( 'Controls animation speed. Higher value = faster movement.', 'madsparrow' ),
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => .1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'condition' => [
                    'scroll_dependency' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll-speed', [
                'label' => __( 'Speed', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'description' => __( 'Controls scroll movement speed. Higher value = more movement on scroll.', 'madsparrow' ),
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'condition' => [
                    'scroll_dependency' => 'on',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( $settings['scroll_dependency'] ) {
            $s_d = 'on';
        } else {
            $s_d = 'off';
        }
        if ( $settings['scroll_dependency'] === 'on' ) {

            if ( $settings['direction'] === 'right' ) {
                $s_dir = '-';
            } else {
                $s_dir = '';
            }

            if ( isset($settings['scroll-speed']['size']) ) {
                $scroll_speed = $settings['scroll-speed']['size'];
            } else {
                $scroll_speed = '1';
            }

            $this->add_render_attribute( 'text-scope', [
                'id' => $this->get_id(),
                'class' => [ 'ms-tt-wrap s-d'],
                'data-scroll-css-progress' => '',
                'data-scroll' => '',
                'data-direction' => $settings['direction'] ?? '',
                'style' => '--speed-dependency:' . $scroll_speed . '',
            ]);

        } else {
            $this->add_render_attribute( 'text-scope', [
                'id' => $this->get_id(),
                'class' => [ 'ms-tt-wrap'],
                'data-speed' => $settings['speed']['size'] ?? '',
                'data-direction' => $settings['direction'] ?? '',
                'data-scroll' => $s_d,
                'data-hover' => $settings['hover'] ?? '',
            ]);
        }

        $this->add_render_attribute( 'text-wrap', [
            'class' => [ 'ms-tt'],
        ] );

        ?>
        <div class="ms-text-ticker" data-mask="<?php echo $settings['mask_enable'] ?? ''?>">
            <div <?php echo $this->get_render_attribute_string( 'text-scope' ); ?>>
                <div class="ms-tt-wrap"> 
                    <?php

                    ob_start();
                    ?>
                    <ul <?php echo $this->get_render_attribute_string('text-wrap'); ?>>

                        <?php if ($settings['ticker_style'] === 'list' && !empty($settings['ticker_list'])) : ?>

                            <?php foreach ($settings['ticker_list'] as $item) : ?>
                                <li class="ms-tt__text"><?php echo esc_html($item['ticker_text']); ?></li>
                                <?php if (!empty($settings['image']['url'])) : ?>
                                    <li class="ms-tt__text img"><img src="<?php echo esc_url($settings['image']['url']); ?>" alt="Ticker Image"/></li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>

                        <?php if ($settings['ticker_style'] === 'default' && !empty($settings['text_ticker'])) : ?>

                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                <li class="ms-tt__text"><?php echo esc_html($settings['text_ticker']); ?></li>
                                <?php if (!empty($settings['image']['url'])) : ?>
                                    <li class="ms-tt__text img"><img src="<?php echo esc_url($settings['image']['url']); ?>" alt="Ticker Image"/></li>
                                <?php endif; ?>
                            <?php endfor; ?>

                        <?php endif; ?>

                        <?php if ($settings['ticker_style'] === 'images') : ?>
                            <?php if (!empty($settings['ticker_gallery'])) : ?>
                                <?php foreach ($settings['ticker_gallery'] as $image) : ?>
                                    <?php
                                        $image_url = Group_Control_Image_Size::get_attachment_image_src(
                                            $image['id'],
                                            'ticker_gallery',
                                            $settings
                                        );
                                        $image_meta = wp_get_attachment_metadata($image['id']);
                                        $image_width = !empty($image_meta['width']) ? $image_meta['width'] : '';
                                        $image_height = !empty($image_meta['height']) ? $image_meta['height'] : '';
                                        $image_alt = get_post_meta($image['id'], '_wp_attachment_image_alt', true);
                                    ?>
                                    <?php if (!empty($image_url)) : ?>
                                        <li class="ms-tt__text img">
                                            <img
                                                src="<?php echo esc_url($image_url); ?>"
                                                alt="<?php echo esc_attr($image_alt); ?>"
                                                <?php if ($image_width) : ?>width="<?php echo esc_attr($image_width); ?>"<?php endif; ?>
                                                <?php if ($image_height) : ?>height="<?php echo esc_attr($image_height); ?>"<?php endif; ?>
                                                loading="lazy"
                                                decoding="async"
                                            />
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                    </ul>
                    <?php

                    $ticker_content = ob_get_clean();

                    echo $ticker_content;
                    echo $ticker_content;
                    ?>
                </div>
            </div>
        </div>
        <?php }

}