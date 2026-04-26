<?php

/**
 * @author: Mad Sparrow
 * @version: 1.0
 */

namespace MS_Elementor\Traits;

if ( ! trait_exists( 'Helper' ) ) {

	trait Helper {

		public function ms_get_contact_form_7() {
			$options = [];

			if ( class_exists( 'WPCF7_ContactForm' ) ) {

				$wpcf7_form_list = get_posts( array(
					'post_type' => 'wpcf7_contact_form',
					'numberposts' => -1
				) );

				$options[0] = esc_html__( 'Select a Contact Form', 'madsparrow' );

				if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) {

					foreach ( $wpcf7_form_list as $post ) {
						$options[$post->ID] = $post->post_title;
					}

				} else {

					$options[0] = esc_html__( 'Create a Form First', 'madsparrow' );

				}
			}

			return $options;
		}

		public function ms_get_post_name( $post_type = 'post' ) {
			$options = [];

			$all_post = [
				'posts_per_page' => -1,
				'post_type'=> $post_type
			];

			$post_terms = get_posts( $all_post );

			if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
				foreach ( $post_terms as $term ) {
					$options[ $term->ID ] = $term->post_title;
				}
			}

			return $options;

		}

		function ms_get_post_types( $args = [] ) {

			$post_type_args = [
				'show_in_nav_menus' => true,
			];

			if ( ! empty( $args[ 'post_type' ] ) ) {
				$post_type_args[ 'name' ] = $args[ 'post_type' ];
			}

			$_post_types = get_post_types( $post_type_args , 'objects' );

			$post_types = [];
			foreach ( $_post_types as $post_type => $object ) {
				$post_types[ $post_type ] = $object->label;
			}

			return $post_types;
		}

		public function ms_get_all_sidebars() {
			global $wp_registered_sidebars;

			$options = [];

			if ( ! $wp_registered_sidebars ) {
				$options[''] = esc_html__( 'No sidebars were found', 'madsparrow' );
			} else {
				$options[''] = esc_html__( 'Choose Sidebar', 'madsparrow' );

				foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
					$options[ $sidebar_id ] = $sidebar['name'];
				}
			}

			return $options;
		}

		public function ms_get_all_types_post() {
			$options = [];

			$posts = get_posts([
				'post_type' => 'any',
				'post_style' => 'all_types',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
			]);

			if ( ! empty( $posts ) ) {
				return wp_list_pluck( $posts, 'post_title', 'ID' );
			}

			return [];

		}

		public function ms_get_post_type_categories( $type = 'term_id' ) {

			$options = [];

			$terms = get_terms( array(
				'taxonomy' => 'category',
				'hide_empty' => true,
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$options[ $term->{$type} ] = $term->name;
				}
			}

			return $options;

		}

		public function ms_get_taxonomies( $taxonomy = 'category' ) {

			$options = [];

			$terms = get_terms( array(
				'taxonomy' => $taxonomy,
				'hide_empty' => true,
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$options[ $term->slug ] = $term->name;
				}
			}

			return $options;

		}

		public function ms_get_p_taxonomies( $taxonomy = 'category' ) {

			$options = [];

			$terms = get_terms( array(
				'taxonomy' => $taxonomy,
				'hide_empty' => true,
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$options[ $term->slug ] = $term->name;
				}
			}

			return $options;

		}

		public function ms_get_available_menus() {
			$options = [];
			$menus = wp_get_nav_menus();
			foreach ( $menus as $menu ) {
				$options[ $menu->slug ] = $menu->name;
			}
			return $options;
		}

		public function ms_get_elementor_templates( $type = '' ) {

			$args = [
				'post_type' => 'elementor_library',
				'posts_per_page' => -1,
			];

			if ( $type ) {
 
				$args[ 'tax_query' ] = [
					[
						'taxonomy' => 'elementor_library_type',
						'field' => 'slug',
						'terms' => $type,
					],
				];

			}

			$page_templates = get_posts( $args );

			$options[0] = esc_html__( 'Select a Template', 'madsparrow' );

			if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
				foreach ( $page_templates as $post ) {
					$options[$post->ID] = $post->post_title;
				}
			} else {

				$options[0] = esc_html__( 'Create a Template First', 'madsparrow' );

			}

			return $options;

		}        
                
	}

}