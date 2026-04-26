<?php

/**
 * @author: VLThemes
 * @version: 1.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_MS_Template extends Widget_Base {

	use \MS_Elementor\Traits\Helper;

	public function get_name() {
		return 'ms-template';
	}

	public function get_title() {
		return esc_html__( 'Template', 'madsparrow' );
	}

	public function get_icon() {
		return 'eicon-document-file ms-badge';
	}

	public function get_categories() {
		return [ 'ms-elements' ];
	}

	public function get_keywords() {
		return [ 'template', 'library', 'block', 'page', 'section', 'element' ];
	}

	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {

		$first_level = 0;

		// ANCHOR
		$this->start_controls_section(
			'section_' . $first_level++, [
				'label' => esc_html__( 'Template', 'madsparrow' ),
			]
		);

		$this->add_control(
			'template', [
				'label' => esc_html__( 'Choose Template', 'madsparrow' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->ms_get_elementor_templates(),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$template_id = $this->get_settings( 'template' );

		if ( 'publish' !== get_post_status( $template_id ) ) {
			return;
		}

		?>

		<div class="ms-e-t"><?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, true ); ?></div>

		<?php

	}

}