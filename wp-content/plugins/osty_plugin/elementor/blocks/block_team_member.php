<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Team extends Widget_Base {

    use \MS_Elementor\Traits\Helper;
    
    public function get_name() {
        return 'team_member';
    }
    
    public function get_title() {
        return 'Team Member';
    }
    
    public function get_icon() {
        return 'eicon-person ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }
    
    public function get_keywords() {
        return [ 'team', 'member', 'card', 'author', 'avatar' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Team Member', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $this->add_control(
            'style', [
                'label' => esc_html__( 'Style', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'madsparrow' ),
                    'style-2' => esc_html__( 'Style 2', 'madsparrow' ),
                ],
            ]
        );

        $this->add_control(
            'image', [
                'label' => __( 'Choose Image', 'madsparrow' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
            ]
        );

        $this->add_control(
            'title', [
                'label' => __( 'Name', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'Name', 'madsparrow' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'function', [
                'label' => __( 'Position', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'Position', 'madsparrow' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description', [
                'label' => __( 'Description', 'madsparrow' ),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'placeholder' => esc_html__( 'Type your description here', 'madsparrow' ),
                'separator' => 'before',
            ]
        );

       $this->add_control(
            'show_socials', [
                'label' => esc_html__( 'Show Socials', 'madsparrow' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'view', [
                'label' => esc_html__( 'View', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => 'Icon',
                    'text' => 'Text',
                ],
                'default' => 'text',
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__( 'Icon', 'madsparrow' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'condition' => [
                    'view' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'text', [
                'label' => esc_html__( 'Text', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'view' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__( 'Link', 'madsparrow' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );

        $this->add_control(
            'socials', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'view' => 'icon',
                        'icon' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-brands'
                        ],
                        'link' => [ 'url' => '#' ]
                    ],
                    [
                        'view' => 'icon',
                        'icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands'
                        ],
                        'link' => [ 'url' => '#' ]
                    ],
                    [
                        'view' => 'icon',
                        'icon' => [
                            'value' => 'fab fa-linkedin-in',
                            'library' => 'fa-brands'
                        ],
                        'link' => [ 'url' => '#' ]
                    ]
                ],
                'condition' => [
                    'show_socials' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
        'style_section', [
                'label' => __( 'Team Member', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Card', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'content_align', [
                'label' => esc_html__( 'Aligment', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ],
                
                'condition' => [
                    'style' => 'style-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding', [
                'label' => esc_html__( 'Padding', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tm' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => ['style-2' , 'style-3'],
                ],
            ]
        );

        $this->add_control(
            'bg_color', [
                'label' => esc_html__( 'Background', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tm' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_overlay',
                'label' => __( 'Overlay', 'madsparrow' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ms-tm .ms-tm--img::after',
                'condition' => [
                    'style' => ['style-1'],
                ],
            ]
        );

        $this->add_control(
            'border_radius_bg', [
                'label' => __( 'Border Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'pt', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tm' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
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
                    '{{WRAPPER}} .ms-tm .ms-tm--img img'  => 'aspect-ratio: {{TOP}}',
                ],
			]
		);

        $this->add_control(
            'border_radius', [
                'label' => __( 'Border Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'pt', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-tm--img' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
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
                'selector' => '{{WRAPPER}} .ms-tm--title',
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tm--title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Position', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'html_tag_function', [
                'label' => esc_html__( 'HTML Tag', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'p',
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
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .ms-tm--function',
            ]
        );

        $this->add_control(
            'text_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tm--function' => 'color: {{VALUE}};',
                ],
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
            'desc_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-tm--desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Social', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'social_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-s-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_direction', [
                'label' => esc_html__( 'Direction', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'd_column',
                'options' => [
                    'd_row' => 'Row',
                    'd_column' => 'Column',
                ],
                'condition' => [
                    'style' => ['style-1'],
                ],
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render_socials( $instance ) {

        $this->add_render_attribute( 'socials', 'class', 'ms-tm--socials' );

        if ( $instance[ 'socials' ] ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'socials' ); ?>>
                <?php foreach ( $instance[ 'socials' ] as $item ) : ?>
                    <?php if ( ! empty( $item[ 'link' ][ 'url' ] ) ) : ?>
                        <?php $this->add_render_attribute( 'social-link-' . $item[ '_id' ], [
                                'class' => 'ms-s-icon',
                                'href' => $item[ 'link' ][ 'url' ]
                            ] );
                            if ( $item[ 'link' ][ 'is_external' ] ) {
                                $this->add_render_attribute( 'social-link-' . $item[ '_id' ], 'target', '_blank' );
                            }
                            if ( $item[ 'link' ][ 'nofollow' ] ) {
                                $this->add_render_attribute( 'social-link-' . $item[ '_id' ], 'rel', 'nofollow' );
                            }
                            switch( $item[ 'view' ] ) {
                                case 'icon':
                                    $this->add_render_attribute( 'social-link-' . $item[ '_id' ], [
                                        'class' => 'ms-s-icon--s2'
                                    ] );
                                    break;
                                case 'text':
                                    $this->add_render_attribute( 'social-link-' . $item[ '_id' ], [
                                        'class' => 'ms-s-icon--s1'
                                    ] );
                                    break;
                            }
                        ?>
                        <a <?php echo $this->get_render_attribute_string( 'social-link-' . $item[ '_id' ] ); ?>>
                            <?php
                                switch( $item[ 'view' ] ) {
                                    case 'icon':
                                        if ( $item[ 'icon' ][ 'value' ] ) :
                                            Icons_Manager::render_icon( $item[ 'icon' ], [ 'aria-hidden' => 'true' ] );
                                        endif;
                                    break;
                                    case 'text':
                                        if ( $item[ 'text' ] ) :
                                            echo $item[ 'text' ];
                                        endif;
                                    break;
                                }
                            ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ($settings['content_align']) {
            $c_align = $settings['content_align'];
        } else {
            $c_align = 'default';
        }

        $this->add_render_attribute( '', 'class', 'ms-tm' );

        $this->add_render_attribute( [
            'teem_member' => [
                'class' => [
                    'ms-tm',
                    $settings[ 'style' ],
                    $c_align,
                    $settings['social_direction'],
                ],
            ]
        ] ); ?>

        <div <?php echo $this->get_render_attribute_string( 'teem_member' ); ?>>
            <div class="ms-tm--box">

                <?php if ( $settings[ 'style' ] == 'style-1' || $settings[ 'style' ] == 'style-2') : ?>

                    <div class="ms-tm--img">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); ?>
                        <?php if ( $settings[ 'show_socials' ] == 'yes' ) { $this->render_socials( $settings ); } ?>
                    </div>

                    <div class="ms-tm--content">

                        <?php if ( $settings[ 'title' ] ) : ?>
                            <<?php echo esc_attr( $settings[ 'html_tag' ] ); ?> class="ms-tm--title"><?php echo $settings['title']; ?></<?php echo esc_attr( $settings[ 'html_tag' ] ); ?>>
                        <?php endif; ?>

                        <?php if ( $settings[ 'function' ] ) : ?>
                            <<?php echo esc_attr( $settings[ 'html_tag_function' ] ); ?> class="ms-tm--function"><?php echo $settings['function']; ?></<?php echo esc_attr( $settings[ 'html_tag_function' ] ); ?>>
                        <?php endif; ?>

                        <?php if ( $settings[ 'description' ] ) : ?>
                            <div class="ms-tm--desc">
                                <p><?php echo $settings['description'] ?></p>
                            </div>
                        <?php endif; ?>

                    </div>

                <?php else: ?>

                    <div class="ms-tm--img">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); ?>
                        
                    </div>

                    <div class="ms-tm--content">
                        <?php if ( $settings[ 'title' ] ) : ?>
                            <<?php echo esc_attr( $settings[ 'html_tag' ] ); ?> class="ms-tm--title"><?php echo $settings['title']; ?></<?php echo esc_attr( $settings[ 'html_tag' ] ); ?>>
                        <?php endif; ?>

                        <?php if ( $settings[ 'function' ] ) : ?>
                            <<?php echo esc_attr( $settings[ 'html_tag_function' ] ); ?> class="ms-tm--function"><?php echo $settings['function']; ?></<?php echo esc_attr( $settings[ 'html_tag_function' ] ); ?>>
                        <?php endif; ?>
                    </div>

                    <div class="ms-tm--desc">
                        <p><?php echo $settings['description'] ?></p>
                    </div>
                    
                    <div class="ms-tm_soc">
                        <?php if ( $settings[ 'show_socials' ] == 'yes' ) { $this->render_socials( $settings ); } ?>
                    </div>

                <?php endif; ?>

            </div>
        </div>
        
    <?php
    } 

}