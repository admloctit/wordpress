<?php

extract( /* @codingStandardsIgnoreLine */
	shortcode_atts(
		array(
			'name' => '',
			'type' => 'block',
		),
		$atts
	)
);

if ( ! post_type_exists( $type ) ) {
	return;
}

if ( $name ) {
	global $wpdb;

	$post_id = molla_get_post_id_by_name( $type, $name );

	if ( ! isset( $post_id ) ) {
		return;
	}

	if ( $post_id ) {
		// Polylang
		if ( function_exists( 'pll_get_post' ) && pll_get_post( $post_id ) ) {
			$lang_id = pll_get_post( $post_id );
			if ( $lang_id ) {
				$post_id = $lang_id;
			}
		}

		// WPML
		if ( function_exists( 'icl_object_id' ) ) {
			$lang_id = icl_object_id( $post_id, $type, false, ICL_LANGUAGE_CODE );
			if ( $lang_id ) {
				$post_id = $lang_id;
			}
		}
	}

	if ( $post_id ) {
		$the_post = get_post( $post_id, null, 'display' );

		if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
			$elements_data = get_post_meta( $post_id, '_elementor_data', true );

			if ( $elements_data ) {
				$elements_data = json_decode( $elements_data, true );
			}

			if ( ! empty( $elements_data ) ) {
				global $molla_settings;
				do_action( 'molla_before_elementor_block_content', $the_post, $type );

				if ( ! molla_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $post_id ) {

					if ( ! ( $molla_settings && isset( $molla_settings['page_blocks'][ $post_id ] ) && $molla_settings['page_blocks'][ $post_id ]['css'] ) ) {
						$css_file = new Elementor\Core\Files\CSS\Post( $post_id );
						$css_file->print_css();
					}

					if ( ! ( $molla_settings && isset( $molla_settings['page_blocks'][ $post_id ] ) && $molla_settings['page_blocks'][ $post_id ]['css'] ) ) {
						$block_css = get_post_meta( (int) $post_id, 'page_css', true );
						if ( $block_css ) {
							$style  = '';
							$style .= '<style id="block_' . (int) $post_id . '_css">';
							$style .= molla_minify_css( $block_css, molla_option( 'minify_css_js' ) );
							$style .= '</style>';

							echo apply_filters( 'molla_before_elementor_block_style', $style );
						}
					}

					$block_script = get_post_meta( (int) $post_id, 'page_script', true );
					if ( $block_script ) {
						$script  = '';
						$script .= '<script id="block_' . (int) $post_id . '_script">';
						$script .= trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $block_script ) );
						$script .= '</script>';

						echo apply_filters( 'molla_before_elementor_block_script', $script );
					}
				}

				$el_attr  = '';
				$el_class = '';

				if ( is_singular( 'block' ) && is_single( $post_id ) && molla_is_elementor_preview() ) {
					$el_attr = ' data-el-class="elementor-' . (int) $post_id . '"';
				} else {
					$el_class = ' elementor-' . (int) $post_id;
				}

				echo '<div class="molla-block elementor' . esc_attr( $el_class ) . '"' . $el_attr . '>';

				foreach ( $elements_data as $element_data ) {

					$element = Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );

					if ( ! $element ) {
						continue;
					}

					$element->print_element();
				}

				echo '</div>';

				do_action( 'molla_after_elementor_block_content', $the_post, $type );
				return;
			} else {
				global $post;
				$post = $the_post;
				setup_postdata( $the_post );
				the_content();
			}
		} else {
			// not elementor page
			do_action( 'molla_before_block_content', $the_post, $type );
			if ( ! isset( $the_post->post_content ) ) {
				return;
			}
			$post_content = $the_post->post_content;

			$block_css = get_post_meta( (int) $post_id, 'page_css', true );
			if ( $block_css ) {
				echo '<style id="block_' . (int) $post_id . '_css">';
				echo molla_minify_css( $block_css, molla_option( 'minify_css_js' ) );
				echo '</style>';
			}

			$block_script = get_post_meta( (int) $post_id, 'page_script', true );
			if ( $block_script ) {
				echo '<script id="block_' . (int) $post_id . '_script">';
				echo trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $block_script ) );
				echo '</script>';
			}

			if ( function_exists( 'has_blocks' ) && has_blocks( $the_post ) ) {
				echo do_shortcode( do_blocks( $post_content ) );
			} else {
				echo do_shortcode( $post_content );
			}
			do_action( 'molla_after_block_content', $the_post, $type );
		}
	}
}
