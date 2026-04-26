<?php

/**
 * @author: madsparrow
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Gallery extends Widget_Base {

    use \MS_Elementor\Traits\Helper;

    public function get_name() {
        return 'ms_gallery';
    }

    public function get_title() {
        return esc_html__( 'Gallery', 'madsparrow' );
    }

    public function get_icon() {
        return 'eicon-gallery-justified ms-badge';
    }

    public function get_categories() {
        return [ 'ms-elements' ];
    }

    public function get_keywords() {
        return [ 'projects', 'gallery', 'grid', 'showcase', 'portfolio' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Gallery', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery', [
                'label' => __( 'Add Images', 'madsparrow' ),
                'type' => Controls_Manager::GALLERY,
            ]
        );

        $this->add_control(
            'gallery_layout', [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Layout', 'madsparrow' ),
                'default' => 'grid',
                'options' => [
                    'grid' => __( 'Grid', 'madsparrow' ),
                    'justified' => __( 'Justified', 'madsparrow' ),
                    'masonry' => __( 'Masonry', 'madsparrow' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'columns', [
                'label' => __( 'Columns', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'default' => '3',
                'desktop_default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '2',
                'options' => [
                    '1'  => __( '1', 'madsparrow' ),
                    '2' => __( '2', 'madsparrow' ),
                    '3' => __( '3', 'madsparrow' ),
                    '4' => __( '4', 'madsparrow' ),
                    '6' => __( '6', 'madsparrow' ),
                    '12' => __( '12', 'madsparrow' ),
                ],
                'condition' => [
                    'gallery_layout!' => 'justified',
                ],
            ]
        );

        $this->add_control(
            'link', [
                'label' => __( 'Link', 'madsparrow' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'media',
                'options' => [
                    'media'  => __( 'Media File', 'madsparrow' ),
                    'none' => __( 'None', 'madsparrow' ),
                ],
            ]
        );

        $this->add_control(
            'row_height', [
                'label' => esc_html__( 'Row Height', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 360
                ],
                'condition' => [
                    'gallery_layout' => 'justified',
                ],
            ]
        );

        $this->add_control(
            'margins', [
                'label' => esc_html__( 'Margins', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30
                ],
                'condition' => [
                    'gallery_layout' => 'justified',
                ],
            ]
        );

        $this->add_control(
            'grid_items_margin', [
                'label' => __( 'Spacing', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],
                'condition' => [
                    'gallery_layout!' => 'justified',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .grid' => 'margin: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'ratio', [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Aspect Ratio', 'madsparrow' ),
                'default' => '1:1',
                'options' => [
					'1/1' => esc_html__( '1:1', 'madsparrow' ),
					'4/3' => esc_html__( '4:3', 'madsparrow' ),
					'3/2' => esc_html__( '3:2', 'madsparrow' ),
					'3/4' => esc_html__( '3:4', 'madsparrow' ),
					'16/9' => esc_html__( '16:9', 'madsparrow' ),
					'16/10' => esc_html__( '16:10', 'madsparrow' ),
					'21/9' => esc_html__( '21:9', 'madsparrow' ),
                ],
                'condition' => [
                    'gallery_layout' => 'grid',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mfp-img' => 'aspect-ratio: {{TOP}}',
                ],
            ]
        );
        

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'gallery',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'hover_style', [
                'label' => __( 'Hover Style', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover', [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Effect', 'madsparrow' ),
                'default' => 'h_s1',
                'options' => [
                    'h_none' => __( 'None', 'madsparrow' ),
                    'h_s1' => __( 'Style 1', 'madsparrow' ),
                    'h_s2' => __( 'Style 2', 'madsparrow' ),
                    'h_s3' => __( 'Style 3', 'madsparrow' ),
                ],
            ]
        );

		$this->add_control(
			'icon_hs_3', [
				'label' => esc_html__( 'Icon', 'madsparrow' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-eye',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'eye',
						'search-plus',
                        'plus',
					],
					'fa-regular' => [
						'eye',
					],
				],
                'condition' => [
                    'hover' => 'h_s3',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'background_placeholder',
                'label' => __( 'Background', 'madsparrow' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .blockgallery.h_s3 .mfp-img::after',
                'condition' => [
                    'hover' => 'h_s3',
                ],
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => __( 'Icon Color', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mfp-icon' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'hover' => 'h_s3',
                ],
            ]
        );

        $this->add_control(
            'icon_size', [
                'label' => esc_html__( 'Icon Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 45
                ],
                'selectors' => [
                    '{{WRAPPER}} .mfp-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'hover' => 'h_s3',
                ],
            ]
        );

        $this->add_control(
            'bordert_options', [
                'label' => __( 'Image Border', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .blockgallery .mfp-img',
            ]
        );

        $this->add_control(
            'border_radius', [
                'label' => __( 'Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'pt' ],
                'selectors' => [
                    '{{WRAPPER}} .blockgallery .mfp-img, .blockgallery .mfp-none::after, .blockgallery .mfp-none, .blockgallery.h_s3' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        switch ( $settings[ 'gallery_layout' ] ) {

            case 'grid':
                $col_t = (isset($settings[ 'columns_tablet'])) ? $settings[ 'columns_tablet'] : '3';
                $col_m = (isset($settings[ 'columns_mobile'])) ? $settings[ 'columns_mobile'] : '2';
                $col = '12' / $settings[ 'columns'];
                $col_t = '12' / $col_t;
                $col_m = '12' / $col_m;

                $this->add_render_attribute( 'grid-wrap', [
                    'class' => 'ms-content--portfolio',
                    'id' => $this->get_id(),
                ] );  ?>

                <!-- Grid -->
                <div <?php echo $this->get_render_attribute_string( 'grid-wrap' ); ?>>
                    <div class="row grid grid-content blockgallery <?php echo $settings['hover']; ?>">
                        <div class="grid-sizer col-xs-12 col-lg-<?php echo $col?> col col-md-6"></div>
                        <?php foreach ( $settings['gallery'] as $image ) : ?>
                            <div class="grid-item col-<?php echo $col_m; ?> col col-lg-<?php echo $col; ?> col-md-<?php echo $col_t; ?>">
                            <?php $image_url = Group_Control_Image_Size_2::get_attachment_image_src( $image['id'], 'gallery', $settings ); ?>
                                <?php if ( $settings[ 'link' ] == 'media'): ?>
                                    <a class="mfp-img" href="<?php echo esc_attr( $image_url );?>" title="<?php echo wp_get_attachment_caption($image[ 'id' ]); ?>" data-elementor-open-lightbox="no">
                                        <figure class="ms-media-wrapper">
                                            <img src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                            <?php if ( $settings['hover'] === 'h_s3' ) : ?>
                                                <div class="mfp-icon">
                                                    <?php Icons_Manager::render_icon( $settings['icon_hs_3'], [ 'aria-hidden' => 'true' ] ); ?>
                                                </div>
                                            <?php endif; ?>
                                        </figure>
                                    </a>
                                <?php else: ?>
                                    <figure class="ms-media-wrapper mfp-none">
                                        <img src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                    </figure>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php break;

            case 'justified':

                $this->add_render_attribute( 'justified-wrap', [ 
                    'id' => $this->get_id(),
                ] );

                $this->add_render_attribute( 'justified-gallery', [
                    'class' => 'justified-gallery blockgallery ' . $settings['hover'],
                    'data-row-height' => $settings[ 'row_height' ]['size'],
                    'data-margins' => $settings[ 'margins' ]['size'],
                ] ); ?>
                
                <div <?php echo $this->get_render_attribute_string( 'justified-wrap' ); ?>>
                    <div <?php echo $this->get_render_attribute_string( 'justified-gallery' ); ?>>
                        <?php foreach ( $settings['gallery'] as $image ) : ?>
                            <?php $image_url = Group_Control_Image_Size_2::get_attachment_image_src( $image['id'], 'gallery', $settings ); ?>
                            <?php if ( $settings[ 'link' ] == 'media'): ?>
                            <a class="mfp-img" href="<?php echo esc_attr( $image_url );?>" title="<?php echo wp_get_attachment_caption($image[ 'id' ]); ?>" data-elementor-open-lightbox="no">
                                <img src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                <?php if ( $settings['hover'] === 'h_s3' ) : ?>
                                    <div class="mfp-icon">
                                        <?php Icons_Manager::render_icon( $settings['icon_hs_3'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <?php else: ?>
                                <div class="mfp-img default" >
                                    <img src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ( Plugin::$instance->editor->is_edit_mode() ) : ?>

                <script>
                    var $jus_grid = jQuery('#<?php echo $this->get_id(); ?>').find('.justified-gallery');
                    justified = $jus_grid;
                    var m = justified.data('margins'),
                        h = justified.data('row-height');
                    justified.justifiedGallery({
                        rowHeight : h,
                        margins : m,
                        captions : false,
                        border: 0,
                        lastRow : 'nojustify',
                    });
                </script>

                <?php endif;

            break;

            case 'masonry':

                $col = $settings[ 'columns'];
                $col = '12' / $col;      
                $grid_margin = isset($settings['grid_items_margin']['size']) ? $settings['grid_items_margin']['size'] : 15;
                $this->add_render_attribute( 'masonry-gallery', [ 
                    'id' => $this->get_id(),
                ] );

                ?>

               <div <?php echo $this->get_render_attribute_string( 'masonry-gallery' ); ?>>
                    <div class="ms-masonry-gallery row grid blockgallery <?php echo $settings['hover']; ?>" data-masonry='{ "percentPosition": true, "gutter": <?php echo $grid_margin; ?> }'>
                        <?php foreach ( $settings['gallery'] as $image ) : ?>
                            <?php $image_url = Group_Control_Image_Size_2::get_attachment_image_src( $image['id'], 'gallery', $settings ); ?>
                            <div class="grid-item col-lg-<?php echo $col; ?> col-md-4">
                                <?php if ( $settings[ 'link' ] == 'media'): ?>
                                    <a class="mfp-img" href="<?php echo esc_attr( $image_url );?>" title="<?php echo wp_get_attachment_caption($image[ 'id' ]); ?>" data-elementor-open-lightbox="no">
                                        <img src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                        <?php if ( $settings['hover'] === 'h_s3' ) : ?>
                                            <div class="mfp-icon">
                                                <?php Icons_Manager::render_icon( $settings['icon_hs_3'], [ 'aria-hidden' => 'true' ] ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                <?php else: ?>
                                    <img class="mfp-none" src="<?php echo esc_attr( $image_url ) ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ) ?>" loading="lazy"/>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div> 
                </div>

                <?php

                if ( Plugin::$instance->editor->is_edit_mode() ) : ?>
                    <script>
                    var el = jQuery('#<?php echo $this->get_id(); ?>').find('.ms-masonry-gallery'),
                        item = el.find('.grid-item').attr('class');
                        el.isotope();
                    el.imagesLoaded().progress( function() {
                        el.isotope('layout');
                    });
                    </script>
                <?php endif;

            break;

        }

    }

}