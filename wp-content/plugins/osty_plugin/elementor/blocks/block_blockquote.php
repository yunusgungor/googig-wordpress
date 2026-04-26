<?php
namespace Elementor;

class Widget_MS_Blockquote extends Widget_Base {
    
    public function get_name() {
        return 'blockquote';
    }
    
    public function get_title() {
        return 'Blockquote';
    }
    
    public function get_icon() {
        return 'eicon-blockquote ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }
    
    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Blockquote', 'madsparrow' ),
                        'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'blockquote_content', [
                'label' => __( 'Content', 'madsparrow' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Enter your quote', 'madsparrow' ),
                'rows' => 14,
            ]
        );

        $this->add_control(
            'cite', [
                'label' => __( 'Cite', 'madsparrow' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Cite', 'madsparrow' ),
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Blockquote', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style', [
                'label' => esc_html__( 'Style', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bqt-s1',
                'options' => [
                    'bqt-s1' => esc_html__( 'Style 1', 'madsparrow' ),
                    'bqt-s2' => esc_html__( 'Style 2', 'madsparrow' ),
                ]
            ]
        );

        $this->end_controls_section();

    }
            
    protected function render() {

        $settings = $this->get_settings_for_display(); ?>
        <?php if ($settings['style'] == 'bqt-s1'): ?>
            <?php if ( $settings['blockquote_content'] ) : ?>
                <blockquote>
                    <p><?php echo $settings['blockquote_content']; ?></p>
                    <?php if ( $settings['cite'] ) : ?>    
                        <p>— <cite><?php echo $settings['cite']; ?></cite></p>
                    <?php endif; ?>
                </blockquote>
            <?php endif; ?>
        <?php else: ?>
            <?php if ( $settings['blockquote_content'] ) : ?>
                <blockquote class="ms-bqt2">
                    <svg class="icon x-rm x-ucolor-a" viewBox="0 0 289 223" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M133.013 164.256C133.044 172.092 131.421 179.841 128.253 186.974C125.086 194.108 120.45 200.455 114.663 205.583C102.245 217.184 85.9251 223.417 69.1194 222.978C47.7849 222.978 30.9398 215.377 18.5844 200.173C6.24183 185.056 -0.352578 165.884 0.0145426 146.185C0.0145426 99.0222 12.6514 63.531 37.925 39.7116C63.1986 15.8922 91.1757 2.70508 121.856 0.150312V51.8843C106.395 53.57 91.7584 59.8667 79.7622 69.993C73.5885 74.7216 68.5027 80.7785 64.8631 87.7371C61.2235 94.6957 59.1186 102.387 58.6968 110.268C63.7922 107.727 69.3973 106.441 75.0647 106.511C93.3899 106.511 107.629 111.834 117.783 122.478C122.912 128.053 126.901 134.62 129.516 141.794C132.132 148.968 133.321 156.605 133.013 164.256ZM288.985 164.256C289.024 172.093 287.403 179.845 284.236 186.979C281.068 194.113 276.428 200.46 270.635 205.583C258.217 217.184 241.897 223.417 225.092 222.978C203.806 222.978 187.096 215.377 174.96 200.173C162.766 184.984 156.26 165.843 156.611 146.185C156.611 99.0222 169.113 63.531 194.117 39.7116C219.122 15.8922 247.062 2.65495 277.939 0V51.734C262.512 53.4849 247.926 59.8338 235.991 69.993C229.771 74.6936 224.64 80.7393 220.961 87.7003C217.282 94.6612 215.146 102.366 214.706 110.268C219.788 107.726 225.381 106.44 231.037 106.511C249.338 106.511 263.577 111.834 273.755 122.478C278.884 128.051 282.871 134.618 285.481 141.794C288.09 148.969 289.269 156.607 288.948 164.256H288.985Z" fill="#F3F5F7"></path>
                    </svg>    
                    <p><?php echo $settings['blockquote_content']; ?></p>
                    <?php if ( $settings['cite'] ) : ?>
                        <cite>— <?php echo $settings['cite']; ?></cite>
                    <?php endif; ?>
                </blockquote>
            <?php endif; ?>
        <?php endif;

    }

}