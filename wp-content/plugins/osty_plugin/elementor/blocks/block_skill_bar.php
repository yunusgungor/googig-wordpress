<?php
namespace Elementor;

class Widget_MS_Skill extends Widget_Base {
    
    public function get_name() {
        return 'skill_bar';
    }
    
    public function get_title() {
        return 'Skill Bar';
    }
    
    public function get_icon() {
        return 'eicon-skill-bar ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'skill', 'slider' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section (
            'content_section', [
                'label' => __( 'Content', 'madsparrow' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sk_title', [
                'label' => __( 'Title', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Serivce title', 'madsparrow' ),
                'placeholder' => __( 'Type your title here', 'madsparrow' ),
                'separator' => 'before',
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

        $this->add_control(
            'counter', [
                'label' => __( 'Counter', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms_skill_bar .skill-bar span' => 'width: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .skill-title::after' => 'content: "{{SIZE}}{{UNIT}}"; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
            
        // TAB CONTENT
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Style Section', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Title', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .skill-title',
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .skill-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_' . $first_level++, [
                'label' => esc_html__( 'Bar', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'bar_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_skill_bar .skill-bar span' => 'background-color: {{VALUE}}', '{{WRAPPER}} .ms_skill_bar .skill-bar span b' => 'color: {{VALUE}}', '{{WRAPPER}} .skill-title::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_bar_color', [
                'label' => __( 'Bar Background', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms_skill_bar .skill-bar' => 'background-color: {{VALUE}}',
                ],
            ]

        );

        $this->add_control(
            'counter_height', [
                'label' => __( 'Height', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .skill-bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius_counter', [
                'label' => __( 'Border Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'pt' ],
                'default' => [
                    'unit' => 'pt',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .skill-bar' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};',                     '{{WRAPPER}} .ms_skill_bar .skill-bar span' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};',  
                ],
            ]
        ); 

        $this->end_controls_section();
    }
            
    protected function render() {

        $settings = $this->get_settings_for_display(); ?>

        <?php if ( $settings['sk_title'] ) : ?>

        <div class="ms_skill_bar">
            <<?php echo esc_attr( $settings[ 'html_tag' ] ); ?> class="skill-title"><?php echo $settings['sk_title']; ?></<?php echo esc_attr( $settings[ 'html_tag' ] ); ?>>
            <div class="skill-bar" data-bar="<?php echo $settings['counter']['size']; ?>">
                <span></span>
            </div>
        </div>

        <?php endif;

    }
            
    protected function content_template() { ?>

        <div class="ms_skill_bar">
            <{{ settings.html_tag }} class="skill-title">{{ settings.sk_title }}</{{ settings.html_tag }}>
            <div class="skill-bar" data-bar="{{ settings.counter.size }}">
                <span></span>
            </div>
        </div>

    <?php }

}

