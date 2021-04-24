<?php

function molla_creative_grid_layout( $layout_id ) {
	$layout = array();
	if ( 1 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '3-4',
				'w-m'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-4',
				'w-l'  => '1-4',
				'w-m'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-4',
				'w-l'  => '1-4',
				'w-m'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-m'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-4',
				'w-l'  => '1-2',
				'w-m'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-4',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-4',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-4',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 2 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '1-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '2-3',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
		);
	} elseif ( 3 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '2-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 4 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-m'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);

	} elseif ( 5 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-3',
				'h'    => '1',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);

	} elseif ( 6 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 7 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medim',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medim',
			),
		);
	} elseif ( 8 == $layout_id ) {
		$layout = array(
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-6',
				'h'    => '1-3',
				'w-l'  => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-6',
				'h'    => '1-3',
				'w-l'  => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-6',
				'h'    => '2-3',
				'w-l'  => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-6',
				'h'    => '2-3',
				'w-l'  => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	}

	return apply_filters( 'molla_creative_grid_layout_type', $layout );
}

function molla_creative_grid_options() {
	if ( ! defined( 'MOLLA_VERSION' ) ) {
		return array();
	}
	$options = array(
		''  => array(
			'title' => esc_html__( 'Grid Masonry', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-masonry.jpg',
			'width' => '1',
		),
		'1' => array(
			'title' => esc_html__( 'Grid 1', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-1.jpg',
			'width' => '1',
		),
		'2' => array(
			'title' => esc_html__( 'Grid 2', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-2.jpg',
			'width' => '1',
		),
		'3' => array(
			'title' => esc_html__( 'Grid 3', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-3.jpg',
			'width' => '1',
		),
		'4' => array(
			'title' => esc_html__( 'Grid 4', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-4.jpg',
			'width' => '1',
		),
		'5' => array(
			'title' => esc_html__( 'Grid 5', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-5.jpg',
			'width' => '1',
		),
		'6' => array(
			'title' => esc_html__( 'Grid 6', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-6.jpg',
			'width' => '1',
		),
		'7' => array(
			'title' => esc_html__( 'Grid 7', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-7.jpg',
			'width' => '1',
		),
		'8' => array(
			'title' => esc_html__( 'Grid 8', 'molla-core' ),
			'image' => MOLLA_URI . '/assets/images/grid-layout/grid-8.jpg',
			'width' => '2',
		),
	);
	return apply_filters( 'molla_creative_grid_options', $options );
}

function molla_creative_grid_item_css( $id, $layout, $height, $height_ratio = 75, $sp = 20, $page_builder = 'elementor' ) {
	$deno        = array();
	$numer       = array();
	$gutter      = $sp / 2;
	$ws          = array(
		'w'   => array(),
		'w-l' => array(),
		'w-m' => array(),
		'w-s' => array(),
	);
	$hs          = array(
		'h'   => array(),
		'h-l' => array(),
		'h-m' => array(),
	);
	$breakpoints = Elementor\Core\Responsive\Responsive::get_breakpoints();

	if ( function_exists( 'molla_option' ) ) {
		$sp = molla_option( 'grid_gutter_width' );
	}
	$is_archive = class_exists( 'WooCommerce' ) && ( is_shop() || ( function_exists( 'molla_is_in_category' ) && molla_is_in_category() ) ) && ! wc_get_loop_prop( 'grid_type' );
	if ( 'elementor' == $page_builder ) {
		$prefix = '.elementor-element-' . $id;
	} elseif ( 'visual_composer' == $page_builder ) {
		$prefix = '#el-' . $id;
	}
	if ( $is_archive ) {
		$prefix = '';
	}
	if ( defined( 'MOLLA_VERSION' ) ) {
		$container_width = molla_option( 'container_width' );
	}
	$container_width = isset( $container_width ) && $container_width ? (int) $container_width : 1188;
	echo '<style scope="">';

	if ( $prefix ) {
		if ( 'elementor' == $page_builder ) {
			echo $prefix . '.elementor-section-boxed > .elementor-container{max-width:' . ( $container_width - $sp + $gutter * 2 ) . 'px; width: calc(100% + ' . ( $gutter * 2 ) . 'px); margin-left: -' . $gutter . 'px; margin-right: -' . $gutter . 'px;}';
			echo $prefix . '.elementor-section-full_width > .elementor-container{max-width:calc(100% + ' . $gutter * 2 . 'px); width:calc(100% + ' . $gutter * 2 . 'px); margin-left: -' . $gutter . 'px; margin-right: -' . $gutter . 'px;}';
			echo '@media (max-width:' . ( (int) $container_width + 19 ) . 'px) and (min-width: 480px) {.full-inner ' . $prefix . '.elementor-section.elementor-section-boxed > .elementor-container{ width: calc(100% - 40px + ' . (int) $gutter * 2 . 'px)}}';
			echo '@media (max-width: 479px) {.full-inner ' . $prefix . '.elementor-section.elementor-section-boxed > .elementor-container{ width: calc(100% - 20px + ' . (int) $gutter * 2 . 'px)}}';
		} elseif ( 'visual_composer' == $page_builder ) {

		}
	}

	echo $prefix . ' .grid' . '{display:block}';
	echo $prefix . ' .grid' . '>.grid-item{padding:' . $gutter . 'px}';

	foreach ( $layout as $grid_item ) {
		foreach ( $grid_item as $key => $value ) {
			if ( 'size' == $key ) {
				continue;
			}

			$num = explode( '-', $value );
			if ( isset( $num[1] ) && ! in_array( $num[1], $deno ) ) {
				$deno[] = $num[1];
			}
			if ( ! in_array( $num[0], $numer ) ) {
				$numer[] = $num[0];
			}

			if ( ( 'w' == $key || 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) && ! in_array( $value, $ws[ $key ] ) ) {
					$ws[ $key ][] = $value;
			}
			if ( ( 'h' == $key || 'h-l' == $key || 'h-m' == $key ) && ! in_array( $value, $hs[ $key ] ) ) {
				$hs[ $key ][] = $value;
			}
		}
	}
	foreach ( $ws as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		if ( 'w-l' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
		} elseif ( 'w-m' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
		} elseif ( 'w-s' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['sm'] - 1 ) . 'px) {';
		}

		foreach ( $value as $item ) {
			$opts  = explode( '-', $item );
			$width = ! isset( $opts[1] ) ? '100%' : 'calc(' . ( $opts[0] * 100 ) . '% / ' . $opts[1] . ')';
			echo $prefix . ' .grid-item.' . $key . '-' . $item . '{flex:0 0;flex-basis:' . $width . ';width:' . $width . '}';
		}

		if ( 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) {
			echo '}';
		}
	};
	foreach ( $hs as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		foreach ( $value as $item ) {
			$opts = explode( '-', $item );

			if ( isset( $opts[1] ) ) {
				$h = $height * $opts[0] / $opts[1];
			} else {
				$h = $height;
			}
			if ( 'h' == $key ) {
				echo $prefix . ' .h-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo $prefix . ' .h-' . $item . '{height:' . round( $h * $height_ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-l' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
				echo $prefix . ' .h-l-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo $prefix . ' .h-l-' . $item . '{height:' . round( $h * $height_ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-m' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo $prefix . ' .h-m-' . $item . '{height:' . round( $h * $height_ratio / 100, 2 ) . 'px}';
				echo '}';
			}
		}
	};
	$lcm = 1;
	foreach ( $deno as $value ) {
		$lcm = $lcm * $value / molla_get_gcd( $lcm, $value );
	}
	$gcd = $numer[0];
	foreach ( $numer as $value ) {
		$gcd = molla_get_gcd( $gcd, $value );
	}
	$sizer = round( ( 100 * $gcd / $lcm * 100 ) / 100, 2 );
	echo $prefix . ' .grid' . '>.grid-space{flex: 0 0;flex-basis:' . ( $sizer < 0.01 ? '100%' : 'calc(' . 100 * $gcd . '% / ' . $lcm . ')' ) . ';width:' . ( $sizer < 0.01 ? '100%' : 'calc(' . 100 * $gcd . '% / ' . $lcm . ')' ) . ';height:0;}';
	echo '</style>';
}
if ( ! function_exists( 'molla_get_gcd' ) ) :
	function molla_get_gcd( $a, $b ) {
		while ( $b ) {
			$r = $a % $b;
			$a = $b;
			$b = $r;
		}
		return $a;
	}
endif;

if ( ! function_exists( 'molla_is_elementor_preview' ) ) :
	function molla_is_elementor_preview() {
		return ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] );
	}
endif;

if ( ! function_exists( 'molla_shortcode_is_ajax' ) ) :
	function molla_shortcode_is_ajax() {
		if ( function_exists( 'mb_strtolower' ) ) {
			return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && mb_strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
		} else {
			return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
		}
	}
endif;

if ( ! function_exists( 'molla_get_image_sizes' ) ) :
	function molla_get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			__( 'Default', 'porto-functionality' ) => '',
			__( 'Full', 'porto-functionality' )    => 'full',
		);

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[  $_size . ' ( ' . get_option( "{$_size}_size_w" ) . 'x' . get_option( "{$_size}_size_h" ) . ( get_option( "{$_size}_crop" ) ? '' : ', false' ) . ' )' ] = $_size;
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size . ' ( ' . $_wp_additional_image_sizes[ $_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $_size ]['height'] . ( $_wp_additional_image_sizes[ $_size ]['crop'] ? '' : ', false' ) . ' )' ] = $_size;
			}
		}
		return $sizes;
	}
endif;

add_action( 'wp_ajax_molla_load_creative_layout', 'molla_load_creative_layout' );
add_action( 'wp_ajax_nopriv_molla_load_creative_layout', 'molla_load_creative_layout' );
function molla_load_creative_layout() {
	// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

	$mode = isset( $_POST['mode'] ) ? $_POST['mode'] : 0;

	if ( $mode ) {
		echo json_encode( molla_creative_grid_layout( $mode ) );
	} else {
		echo json_encode( array() );
	}

	exit();

	// phpcs:enable
}

// YITH attribute compatible
if ( ! function_exists( 'ywccl_get_term_meta' ) ) :
	function ywccl_get_term_meta( $id, $value ) {
		$tax = str_replace( '_yith_wccl_value', '', $value );
		global $wc_product_attributes;
		if ( 'colorpicker' == $wc_product_attributes[ $tax ]->attribute_type ) {
			return get_term_meta( $id, 'attr_color', true );
		}
		if ( 'label' == $wc_product_attributes[ $tax ]->attribute_type ) {
			return get_term_meta( $id, 'attr_label', true );
		}
	}
endif;

if ( ! function_exists( 'molla_get_post_id_by_name' ) ) {
	function molla_get_post_id_by_name( $post_type, $name ) {
		global $wpdb;
		if ( is_numeric( $name ) ) {
			$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND ID = %s", $post_type, $name ) );
			if ( $id ) {
				return $id;
			}
			return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'block' AND ID = %s", $name ) );
		}
		$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_name = %s", $post_type, $name ) );
		if ( $id ) {
			return $id;
		}
		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'block' AND post_name = %s", $name ) );
	}
}

if ( ! function_exists( 'molla_print_custom_post' ) ) {
	function molla_print_custom_post( $post_type, $name ) {
		if ( empty( $post_type ) ) {
			$post_type = 'block';
		}
		$atts         = array();
		$atts['name'] = $name;
		$atts['type'] = $post_type;
		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_block.php';
	}
}
