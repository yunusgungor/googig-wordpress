<?php
namespace Elementor;

class Widget_MS_Contact_Form extends Widget_Base {
    
    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms-contact-form-7';
    }
    
    public function get_title() {
        return 'Contact Form 7';
    }
    
    public function get_icon() {
        return 'eicon-form-horizontal ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'contact', 'form', '7', 'mail' ];
    }

    protected function register_controls() {
        
        $first_level = 0;

        if ( ! class_exists( 'WPCF7_ContactForm' ) ) {

            // TAB CONTENT
            $this->start_controls_section(
                'section_' . $first_level++, [
                    'label' => esc_html__( 'Warning!', 'madsparrow' ),
                ]
            );

            // Contact Form 7 Not Installer/Activated
            $this->add_control(
                'notification_' . $first_level++, [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <strong>Contact Form 7</strong> first.',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'separator' => 'after',
                ]
            );

        } else {

            // TAB CONTENT
            $this->start_controls_section(
                'section_' . $first_level++, [
                    'label' => esc_html__( 'Contact Form 7', 'madsparrow' ),
                ]
            );

            $this->add_control(
                'contact_form', [
                    'label' => esc_html__( 'Button Align', 'madsparrow' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $this->ms_get_contact_form_7(),
                    'default' => 0,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'full_btn', [
                    'label' => __( 'Full Width Button', 'madsparrow' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'madsparrow' ),
                    'label_off' => __( 'Off', 'madsparrow' ),
                    'return_value' => 'on',
                    'default' => 'off',
                ]
            );

            $this->add_control(
                'contact_style', [
                    'label' => esc_html__( 'Style', 'your-text-domain' ),
                    'type' => Controls_Manager::SELECT2,
                    'default' => 'style_1',
                    'options' => [
                        'style_1' => 'Style 1',
                        'style_2' => 'Style 2',
                    ],
                ]
            );

            $this->add_control(
                'contact_align_btn', [
                    'label' => esc_html__( 'Button Align', 'your-text-domain' ),
                    'type' => Controls_Manager::SELECT2,
                    'default' => 'left',
                    'options' => [
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ],
                    'condition' => [
                        'full_btn!' => 'on',
                    ],
                ]
            );

            $this->add_responsive_control(
                'textarea_height_' . $first_level++, [
                    'label' => __( 'Container Height', 'madsparrow' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'vh', 'em', 'rem','custom' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1080,
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
                        'rem' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 90,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ms-contact-form-7 textarea.form-control' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

        }

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( [
            'contact-form-7' => [
                'class' => [ 'ms-contact-form-7', $settings['contact_align_btn'], $settings['full_btn'], $settings['contact_style'] ],
            ]
        ] );

        ?>

        <div <?php echo $this->get_render_attribute_string( 'contact-form-7' ); ?>>

            <?php
                if ( ! empty( $settings[ 'contact_form' ] ) ) {
                    echo do_shortcode( '[contact-form-7 id="' . $settings[ 'contact_form' ] . '" ]' );
                }
            ?>

        </div>

        <?php

    }

}

