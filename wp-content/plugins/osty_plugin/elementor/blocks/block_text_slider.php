<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Text_Slider extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms_text_slider';
    }

    public function get_title() {
        return esc_html__( 'Text Slider', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-slider-vertical ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'headline', 'animation', 'text', 'title', 'slider' ];
    }

    protected function register_controls() {

        $first_level = 0;        

        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Title', 'madsparrow' ),
            ]
        );

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text List', 'madsparrow' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text_title',
						'label' => esc_html__( 'Title', 'madsparrow' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Text Title' , 'madsparrow' ),
						'label_block' => true,
					],
                    [
                        'name' => 'text_color',
                        'label' => esc_html__( 'Color', 'madsparrow' ),
                        'type' => Controls_Manager::COLOR,
                    ]
				],
				'default' => [
					[
						'text_title' => esc_html__( 'Text #1', 'madsparrow' ),
					],
					[
						'text_title' => esc_html__( 'Text #2', 'madsparrow' ),
					],
				],
				'title_field' => '{{{ text_title }}}',
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

        $this->add_control(
            'title_color', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-text-slider .ms__text-slide-inner' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-text-slider .word',
            ]
        );

        $this->add_control(
			'text_speed', [
				'label' => __( 'Speed (sec.)', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
					'px' => [
                        'min' => .3,
                        'max' => 10,
                        'step' => .1,
					],
				],
				'default' => [
                    'unit' => 'px',
					'size' => 1,
				],
			]
		);

        $this->add_control(
			'text_delay', [
				'label' => __( 'Delay (sec.)', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
					'px' => [
						'min' => 1000,
						'max' => 10000,
						'step' => 1000,
					],
				],
				'default' => [
                    'unit' => 'px',
					'size' => 3000,
				],
			]
		);

        $this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['text'] ) : ?>
			<div class="ms-text-slider" data-speed="<?php echo $settings['text_speed']['size']?>" data-delay="<?php echo $settings['text_delay']['size']; ?>">
			    <div class="ms__text-slide-inner">
                    <?php foreach ( $settings['text'] as $index => $item ) : 
                        $item_key = 'ti-' . $index; ?>
                        <span class="word" style="color: <?php echo esc_attr( $item['text_color'] ); ?>"><?php echo $item['text_title']; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
		<?php endif;
	}

}