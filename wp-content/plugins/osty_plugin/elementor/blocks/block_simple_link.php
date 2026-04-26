<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Simple_Link extends Widget_Base {

    public function get_name() {
        return 'ms-simple-link';
    }

    public function get_title() {
        return esc_html__( 'Simple Link', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-link ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'simple', 'link', 'action' ];
    }

    protected function register_controls() {

        $first_level = 0;

        // TAB CONTENT
        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Link', 'madsparrow' ),
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
                'default' => [
                    'url'=> '#',
                ],
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Link Style', 'madsparrow' ),
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

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .ms-sl',
            ]
        );

		$this->add_control(
			'animation_transition', [
				'label' => esc_html__( 'Animation Transition', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'style_anim', [
				'label' => esc_html__( 'Osty Style Animation', 'madsparrow' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
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
            'text_color', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-sl' => 'color: {{VALUE}};',
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
            'text_color_hover', [
                'label' => esc_html__( 'Text Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-sl:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'icon', [
                'label' => esc_html__( 'Icon', 'madsparrow' ),
                'type' => Controls_Manager::ICONS,
                'separator' => 'before'
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
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( [
            'link' => [
                'class' => 'ms-sl',
                'role' => 'button',
                'data-transition' => $settings['animation_transition'],
                'data-style' => $settings['style_anim']
            ]
        ] );

        if ( $settings[ 'link' ][ 'url' ] ) {

            $this->add_render_attribute( 'link', 'href', $settings[ 'link' ][ 'url' ] );

            if ( $settings[ 'link' ][ 'is_external' ] ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( $settings[ 'link' ][ 'nofollow' ] ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }

        }

        ?>

        <a <?php echo $this->get_render_attribute_string( 'link' ); ?> target="hidden-iframe">

            <?php if ( ! empty( $settings[ 'icon' ][ 'value' ] ) && $settings[ 'icon_position' ] == 'left' ) : ?>

                <span class="ms-btn__icon link ms-btn__icon--left">
                    <?php Icons_Manager::render_icon( $settings[ 'icon' ], [ 'aria-hidden' => 'true' ] ); ?>
                </span>

            <?php endif; ?>

            <?php echo $settings[ 'text' ]; ?>

            <?php if ( ! empty( $settings[ 'icon' ][ 'value' ] ) && $settings[ 'icon_position' ] == 'right' ) : ?>

                <span class="ms-btn__icon link ms-btn__icon--right">
                    <?php Icons_Manager::render_icon( $settings[ 'icon' ], [ 'aria-hidden' => 'true' ] ); ?>
                </span>

            <?php endif; ?>

        </a>

        <?php

    }

}