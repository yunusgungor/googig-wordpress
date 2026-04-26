<?php
namespace Elementor;

class Widget_MS_Services extends Widget_Base {
    
    public function get_name() {
        return 'services';
    }
    
    public function get_title() {
        return 'Services';
    }
    
    public function get_icon() {
        return 'eicon-icon-box ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }
    
    public function get_keywords() {
        return [ 'service', 'box' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Service Box', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__( 'Image', 'madsparrow' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__( 'Title', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'text', [
                'label' => esc_html__( 'Text', 'madsparrow' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__( 'Link', 'madsparrow' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'separator' => 'before'
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Image', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'image_postition', [
                'label' => esc_html__( 'Position', 'madsparrow' ),
                'type' => Controls_Manager::CHOOSE,
                'devices' => [ 'desktop' ],
                'default' => 'img-top',
                'options' => [
                    'img-left' => [
                        'title' => esc_html__( 'Left', 'madsparrow' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'img-top' => [
                        'title' => esc_html__( 'Top', 'madsparrow' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'img-right' => [
                        'title' => esc_html__( 'Right', 'madsparrow' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
            ]
        );

        $this->add_control(
            'image_style', [
                'label' => esc_html__( 'Style', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'madsparrow' ),
                    'boxed' => esc_html__( 'Boxed', 'madsparrow' ),
                ]
            ]
        );

        $this->add_control(
            'box_bg',
            [
                'label' => __( 'Background', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-sb--img.boxed' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'image_style' => 'boxed',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-sb--img.boxed',
                'condition' => [
                    'image_style' => 'boxed',
                ],
            ]
        );

        $this->add_control(
            'border_radius', [
                'label' => __( 'Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-sb--img.boxed' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
                'condition' => [
                    'image_style' => 'boxed',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Title', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'html_tag', [
                'label' => esc_html__( 'HTML Tag', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
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
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .ms-sb--title',
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-sb--title span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Text', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .ms-sb--text',
            ]
        );

        $this->add_control(
            'text_color', [
                'label' => esc_html__( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-sb--text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }
    
    protected function render() {

        $settings = $this->get_settings_for_display();

        $sb_class = 'ms-sb ' . $settings['image_postition'];

        $this->add_render_attribute( 'service', 'class', $sb_class );

        $this->add_render_attribute( 'service-link', [
            'href' => $settings[ 'link' ][ 'url' ]
        ] );

        if ( $settings[ 'link' ][ 'is_external' ] ) {
            $this->add_render_attribute( 'service-link', 'target', '_blank' );
        }

        if ( $settings[ 'link' ][ 'nofollow' ] ) {
            $this->add_render_attribute( 'service-link', 'rel', 'nofollow' );
        }

        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'service' ); ?>>

            <?php if ( $settings[ 'image' ][ 'url' ] ) : ?>

                <div class="ms-sb--img <?php echo $settings['image_style']?>">
                    <?php if ( !empty( $settings[ 'link' ][ 'url' ] ) ) : ?>
                        <a <?php echo $this->get_render_attribute_string( 'service-link' ); ?>>
                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); ?>
                        </a>
                    <?php else: ?>
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); ?>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

            <div class="ms-sb--inner">
                <?php if ( $settings[ 'title' ] ) : ?>
                    <<?php echo esc_attr( $settings[ 'html_tag' ] ); ?> class="ms-sb--title">
                        <?php if ( !empty( $settings[ 'link' ][ 'url' ] ) ) : ?>
                            <a <?php echo $this->get_render_attribute_string( 'service-link' ); ?>><span><?php echo $settings[ 'title' ]; ?></span></a>
                        <?php else: ?>
                            <span><?php echo $settings[ 'title' ]; ?></span>
                        <?php endif; ?>
                    </<?php echo esc_attr( $settings[ 'html_tag' ] ); ?>>
                <?php endif; ?>
                <?php if ( $settings[ 'text' ] ) : ?>
                    <p class="ms-sb--text"><?php echo $settings[ 'text' ]; ?></p>
                <?php endif; ?>
            </div>

        </div>

        <?php

    }
    
}

