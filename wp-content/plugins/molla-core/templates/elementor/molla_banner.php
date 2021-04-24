<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Molla Banner Widget Render
 *
 * @since 1.1
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_item_list'           => array(),
			'img_back_style'             => 'no',
			'banner_hover_effect'        => '',
			'banner_hover_scale'         => '',
			'banner_wrap'                => '',
			'parallax'                   => '',
			'content_animation'          => '',
			'content_animation_duration' => '',
			'content_animation_delay'    => '',
			't_x_pos'                    => 'center',
			't_y_pos'                    => 'center',
		),
		$atts
	)
);

$banner_class  = array( 'banner' );
$wrapper_class = array( 'banner-content' );

if ( $banner_hover_effect ) {
	$banner_class[] = $banner_hover_effect;
}

if ( 'yes' == $banner_hover_scale ) {
	$banner_class[] = 'banner-scale';
}

if ( ! empty( $atts['banner_background_image']['url'] ) ) {

	$wrap_options = '';

	if ( $parallax ) {

		$banner_class[] = 'parallax-container';

		$wrap_options = 'data-plx-img="' . $atts['banner_background_image']['url'] . '"';
		if ( isset( $atts['banner_background_image']['background_repeat'] ) ) {
			$wrap_options .= ' data-plx-img-repeat="' . $atts['banner_background_image']['background_repeat'] . '"';
		}
		if ( isset( $atts['banner_background_image']['background_position'] ) ) {
			$wrap_options .= ' data-plx-img-pos="' . $atts['banner_background_image']['background_position'] . '"';
		}
		if ( isset( $atts['banner_background_image']['background_attachment'] ) ) {
			$wrap_options .= ' data-plx-img-att="' . $atts['banner_background_image']['background_attachment'] . '"';
		}
		if ( isset( $atts['banner_background_image']['background_size'] ) ) {
			$wrap_options .= ' data-plx-img-size="' . $atts['banner_background_image']['background_size'] . '"';
		}
		if ( isset( $atts['banner_background_image']['parallax_speed'] ) ) {
			$wrap_options .= ' data-plx-speed="' . $atts['banner_background_image']['parallax_speed']['size'] . '"';
		}
		if ( function_exists( 'molla_option' ) && molla_option( 'lazy_load_img' ) ) {
			if ( function_exists( 'molla_is_elementor_preview' ) && ! molla_is_elementor_preview() ) {
				$wrap_options .= ' data-lazyload="true"';
			}

			if ( isset( $atts['banner_background_image']['background_color'] ) ) {
				$wrap_options .= ' data-plx-color="' . $atts['banner_background_image']['background_color'] . '"';
			} else {
				$wrap_options .= ' data-plx-color="' . molla_option( 'lazy_load_img_back' ) . '"';
			}
		}
	}

	if ( function_exists( 'molla_option' ) && molla_option( 'lazy_load_img' ) ) {
		if ( 'yes' == $atts['img_back_style'] ) {
			$wrap_options .= ' data-lazy-back="' . esc_url( $atts['banner_background_image']['url'] ) . '"';
		} else {
			$banner_class[] = 'background-image-none';
		}
	}

	echo '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '"' . $wrap_options . '>';
} else {
	echo  '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '">';
}

/* Overlay */
if ( $banner_hover_effect ) {
	echo '<div class="banner-overlay"></div>';
}

/* Image */
if ( isset( $atts['banner_background_image']['id'] ) && $atts['banner_background_image']['id'] && 'yes' != $img_back_style ) {
	$banner_img_id = $atts['banner_background_image']['id'];
	?>
<figure class="banner-img">
	<?php
	echo apply_filters(
		'molla_lazy_load_images',
		wp_get_attachment_image(
			$banner_img_id,
			'full',
			false,
			$atts['banner_background_color'] ? array( 'style' => 'background-color:' . $atts['banner_background_color'] ) : ''
		)
	);
	?>
</figure>
	<?php
}

if ( $banner_wrap ) {
	echo '<div class="' . esc_attr( $banner_wrap ) . '"><div class="banner-wrap-inner">';
}

/* Content Animation */
$settings = array();

if ( $content_animation && ! molla_is_elementor_preview() ) {
	$wrapper_class[] = 'elementor-invisible';
	if ( $content_animation_duration ) {
		$wrapper_class[] = 'animated-' . $content_animation_duration;
	}
	$settings['_animation'] = $content_animation;
	if ( $content_animation_delay ) {
		$settings['_animation_delay'] = $content_animation_delay;
	}
}

/* Showing Items */
echo '<div class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '"' . ( $settings ? ( ' data-settings=' . json_encode( $settings ) ) : '' ) . '>';

$inner_classes  = 'banner-content-inner';
$inner_classes .= ' t-x-' . $t_x_pos . ' t-y-' . $t_y_pos;

echo '<div class="' . esc_attr( $inner_classes ) . '">';

foreach ( $banner_item_list as $key => $item ) {

	$class = array( 'banner-elem' );

	extract( // @codingStandardsIgnoreLine
		shortcode_atts(
			array(
				// Global Options
				'_id'                  => '',
				'banner_item_display'  => 'block',
				'banner_item_aclass'   => '',
				'animation'            => '',
				'animation_duration'   => '',
				'animation_delay'      => '',

				// Text Options
				'banner_item_type'     => '',
				'banner_text_tag'      => 'h2',
				'banner_text_content'  => '',

				// Image Options
				'banner_image'         => '',
				'banner_image_size'    => 'full',

				// Button Options
				'banner_btn_text'      => '',
				'banner_btn_link'      => '',
				'banner_btn_type'      => '',
				'banner_btn_size'      => '',
				'banner_btn_skin'      => 'btn-primary',
				'banner_btn_shadow'    => '',
				'banner_btn_border'    => 'btn-rounded',
				'banner_btn_link'      => '',
				'banner_btn_icon'      => '',
				'banner_btn_icon_pos'  => 'after',
				'banner_btn_show_icon' => 'no',
			),
			$item
		)
	);

	$class[] = 'elementor-repeater-item-' . $_id;

	// Custom Class
	if ( $banner_item_aclass ) {
		$class[] = $banner_item_aclass;
	}

	// Animation
	$setttings = '';
	if ( $animation && ! molla_is_elementor_preview() ) {
		$class[] = 'elementor-invisible';
		if ( $animation_duration ) {
			$class[] = 'animated-' . $animation_duration;
		}
		$setttings = array(
			'_animation'       => $animation,
			'_animation_delay' => $animation_delay ? $animation_delay : 0,
		);
		$setttings = "data-settings='" . json_encode( $setttings ) . "'";
	}

	// Item display type
	if ( 'block' == $banner_item_display ) {
		$class[] = 'item-block';
	} else {
		$class[] = 'item-inline';
	}

	if ( 'text' == $banner_item_type ) { // Text

		echo sprintf( '<%1$s class="' . esc_attr( implode( ' ', $class ) ) . ' text" ' . $setttings . '>%2$s</%1$s>', esc_attr( $banner_text_tag ), ( function_exists( 'molla_strip_script_tags' ) ? do_shortcode( molla_strip_script_tags( $banner_text_content ) ) : do_shortcode( wp_strip_all_tags( $banner_text_content ) ) ) );

	} elseif ( 'image' == $banner_item_type ) { // Image

		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . ' image" ' . $setttings . '>';
		echo wp_get_attachment_image(
			$banner_image['id'],
			$banner_image_size,
			false,
			''
		);
		echo '</div>';

	} elseif ( 'button' == $banner_item_type ) { // Button
		$html = '';
		if ( $banner_btn_text ) {
			$banner_btn_text = '<span ' . $this->get_render_attribute_string( 'text' ) . '>' . esc_html( $banner_btn_text ) . '</span>';
		}
		if ( is_array( $banner_btn_icon ) && $banner_btn_icon['value'] ) {
			$html = '<i class="' . $banner_btn_icon['value'] . '"></i>';
		}
		if ( 'before' == $banner_btn_icon_pos ) {
			$html .= $banner_btn_text;
		} else {
			$html = $banner_btn_text . $html;
		}

		$class[] = 'btn elementor-button';
		$class[] = esc_attr( $banner_btn_skin );
		$class[] = esc_attr( $banner_btn_size );
		if ( $banner_btn_type ) {
			$class[] = esc_attr( $banner_btn_type );
		}
		if ( $banner_btn_border ) {
			$class[] = esc_attr( $banner_btn_border );
		}
		if ( $banner_btn_shadow ) {
			$class[] = esc_attr( $banner_btn_shadow );
		}
		$class[] = 'icon-' . esc_attr( $banner_btn_icon_pos );
		if ( 'yes' == $banner_btn_show_icon ) {
			$class[] = 'icon-hidden';
		}

		$url = $banner_btn_link['url'] ? esc_url( $banner_btn_link['url'] ) : '#';

		echo '<a href="' . $url . '"' . ( $banner_btn_link['is_external'] ? 'target="nofollow"' : '' ) . ( $banner_btn_link['nofollow'] ? 'rel="_blank"' : '' ) . ' class="' . esc_attr( implode( ' ', $class ) ) . '"' . $setttings . '>' . $html . '</a>';
	}
}

echo '</div>';

echo '</div>';

if ( $banner_wrap ) {
	echo '</div></div>';
}

echo  '</div>';

do_action( 'molla_save_used_widget', 'banners' );
