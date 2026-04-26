<?php

/**
 * @author: VLThemes
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Sidebar extends Widget_Base {

	use \MS_Elementor\Traits\Helper;

	public function get_name() {
		return 'ms-sidebar';
	}

	public function get_title() {
		return esc_html__( 'Sidebar', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-sidebar ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'sidebar', 'widget' ];
	}

	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {

		$first_level = 0;

		global $wp_registered_sidebars;

		$options = [];

		if ( ! $wp_registered_sidebars ) {
			$options[''] = esc_html__( 'No sidebars were found', 'elementor' );
		} else {
			$options[''] = esc_html__( 'Choose Sidebar', 'elementor' );

			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[ $sidebar_id ] = $sidebar['name'];
			}
		}

		$default_key = array_keys( $options );
		$default_key = array_shift( $default_key );

		// ANCHOR
		$this->start_controls_section(
			'section_sidebar', [
				'label' => esc_html__( 'Sidebar', 'madsparrow' ),
			]
		);

		$this->add_control(
			'sidebar', [
				'label' => esc_html__( 'Choose Sidebar', 'madsparrow' ),
				'type' => Controls_Manager::SELECT,
				'default' => $default_key,
				'options' => $options,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$sidebar = $this->get_settings_for_display( 'sidebar' );

		if ( empty( $sidebar ) ) {
			return;
		} ?>

		<div class="ms-sidebar"><?php dynamic_sidebar( $sidebar ); ?></div>
	 <?php }

}