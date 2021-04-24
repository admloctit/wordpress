<?php

if ( ! function_exists( 'wc_set_loop_prop' ) ) {
	return;
}

extract(
	shortcode_atts(
		array(
			'id'                    => '',
			'shortcode'             => 'product_categories',
			'title'                 => '',
			'desc'                  => '',
			'count'                 => '',
			'orderby'               => 'slug',
			'order'                 => '',
			'ids'                   => '',
			'show_sub_cat'          => 'no',
			'hide_empty'            => 'yes',

			'layout_mode'           => 'grid',
			'grid_layout_mode'      => '1',
			'grid_layout_height'    => '',
			'spacing'               => '',
			'cols_upper_desktop'    => '',
			'columns'               => 4,
			'columns_tablet'        => '',
			'columns_mobile'        => '',
			'cols_under_mobile'     => '',
			'cat_slider_nav_pos'    => '',
			'cat_slider_nav_type'   => '',
			'slider_nav'            => 'no',
			'slider_nav_show'       => 'yes',
			'slider_nav_tablet'     => 'no',
			'slider_nav_mobile'     => 'no',
			'slider_dot'            => 'no',
			'slider_dot_tablet'     => 'no',
			'slider_dot_mobile'     => 'no',
			'slider_loop'           => 'no',
			'slider_auto_play'      => 'no',
			'slider_auto_play_time' => 10000,
			'slider_center'         => 'no',

			'category_style'        => 'default',
			'overlay_type'          => 'yes',
			'content_align'         => 'left',
			't_x_pos'               => 'center',
			't_y_pos'               => 'center',
			'with_subcat'           => 'no',
			'subcat_count'          => 3,
			'subcat_icon'           => '',
			'hide_count'            => 'no',
			'hide_link'             => 'no',
			'cat_btn_label'         => esc_html__( 'Shop Now', 'molla-core' ),
			'cat_btn_type'          => '',
			'cat_btn_icon'          => '',
			'cat_btn_icon_pos'      => 'left',
			'thumbnail_size'        => 'woocommerce_thumbnail',
			'page_builder'          => 'elementor',
		),
		$atts
	)
);

// For running shortcode
if ( is_string( $cat_btn_icon ) ) {
	$cat_btn_icon = json_decode( $cat_btn_icon, true );
}

$output = '';

$heading_html = '';

if ( $title ) {
	$heading_html .= '<h2 class="heading-title">' . $title . '</h2>';
}
if ( $desc ) {
	$heading_html .= '<p class="heading-desc">' . $desc . '</p>';
}

if ( $heading_html ) {
	$output = '<div class="title-wrapper">' . $heading_html . '</div>';
}

$extra_atts = 'columns="' . intval( $columns ) . '"';

$ids_filtered = '';

if ( $ids ) {
	if ( ! is_array( $ids ) ) {
		$ids = explode( ',', $ids );
	}

	for ( $i = 0; $i < count( $ids );  $i ++ ) {
		if ( $ids[ $i ] !== '0' && ! intval( $ids[ $i ] ) ) {
			$ids[ $i ] = get_term_by( 'slug', $ids[ $i ], 'product_cat' );
			$ids[ $i ] = $ids[ $i ] ? $ids[ $i ]->term_id : -1;
		}
	}
	$ids_filtered = implode( ',', $ids );
}

if ( ( 'yes' == $show_sub_cat || true == $show_sub_cat ) && $ids ) {
	$parent_ids = explode( ',', $ids_filtered );
	$sub_ids    = '';
	foreach ( $parent_ids as $parent ) {
		$terms = get_terms(
			'product_cat',
			array(
				'parent'     => intval( $parent ),
				'hide_empty' => false,
			)
		);
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$sub_ids .= $term->term_id . ',';
			}
		}
	}
	$ids_filtered = $sub_ids ? $sub_ids : -1;
}

if ( $ids_filtered || 'yes' == $show_sub_cat ) {
	$extra_atts .= ' ids="' . esc_attr( $ids_filtered ) . '"';
	$orderby     = 'include';
	$order       = 'ASC';
}
$extra_atts .= ' orderby="' . esc_attr( $orderby ) . '"';
if ( $order ) {
	$extra_atts .= ' order="' . esc_attr( $order ) . '"';
}
if ( $count ) {
	if ( is_array( $count ) ) {
		$extra_atts .= ' limit="' . intval( $count['size'] ) . '"';
	} else {
		$extra_atts .= ' limit="' . intval( $count ) . '"';
	}
}

if ( 'yes' == $hide_empty || 'no' == $hide_empty ) {
	$hide_empty = 'yes' == $hide_empty ? true : false;
}
$extra_atts .= ' hide_empty="' . intval( $hide_empty ) . '"';

if ( $spacing ) {
	if ( is_array( $spacing ) ) {
		wc_set_loop_prop( 'spacing', esc_attr( $spacing['size'] ) );
	} else {
		wc_set_loop_prop( 'spacing', esc_attr( $spacing ) );
	}
}

wc_set_loop_prop( 'category_style', esc_attr( $category_style ) );
wc_set_loop_prop( 'layout_mode', esc_attr( $layout_mode ) );
wc_set_loop_prop( 'cols_upper_desktop', esc_attr( $cols_upper_desktop ) );
wc_set_loop_prop( 'cols_tablet', esc_attr( $columns_tablet ) );
wc_set_loop_prop( 'cols_mobile', esc_attr( $columns_mobile ) );
wc_set_loop_prop( 'cols_under_mobile', esc_attr( $cols_under_mobile ) );
wc_set_loop_prop( 'overlay_type', esc_attr( $overlay_type ) );
wc_set_loop_prop( 'content_align', esc_attr( $content_align ) );
wc_set_loop_prop( 'with_subcat', esc_attr( $with_subcat ) );
wc_set_loop_prop( 'subcat_count', esc_attr( isset( $subcat_count['size'] ) ? $subcat_count['size'] : '' ) );
wc_set_loop_prop( 'subcat_icon', esc_attr( isset( $subcat_icon['value'] ) ? $subcat_icon['value'] : '' ) );
wc_set_loop_prop( 'hide_count', esc_attr( $hide_count ) );
wc_set_loop_prop( 'hide_link', esc_attr( $hide_link ) );
wc_set_loop_prop( 'cat_btn_label', esc_attr( $cat_btn_label ) );
wc_set_loop_prop( 't_x_pos', esc_attr( $t_x_pos ) );
wc_set_loop_prop( 't_y_pos', esc_attr( $t_y_pos ) );
wc_set_loop_prop( 'cat_btn_type', esc_attr( $cat_btn_type ) );

if ( is_array( $cat_btn_icon ) && $cat_btn_icon['value'] ) {
	$cat_btn_icon = $cat_btn_icon['value'];
	wc_set_loop_prop( 'cat_btn_icon', esc_attr( $cat_btn_icon ) );
	wc_set_loop_prop( 'cat_btn_icon_pos', esc_attr( $cat_btn_icon_pos ) );
}

wc_set_loop_prop( 'image_size', $thumbnail_size );
wc_set_loop_prop( 'slider_nav_pos', esc_attr( $cat_slider_nav_pos ) );
wc_set_loop_prop( 'slider_nav_type', esc_attr( $cat_slider_nav_type ) );
wc_set_loop_prop( 'widget', 'molla-product-cat' );
wc_set_loop_prop( 'elem', 'product_cat' );
wc_set_loop_prop(
	'slider_nav',
	array(
		esc_attr( $slider_nav ) == 'yes' ? true : false,
		esc_attr( $slider_nav_tablet ) == 'yes' ? true : false,
		esc_attr( $slider_nav_mobile ) == 'yes' ? true : false,
	)
);
wc_set_loop_prop( 'slider_nav_show', $slider_nav_show );
wc_set_loop_prop(
	'slider_dot',
	array(
		esc_attr( $slider_dot ) == 'yes' ? true : false,
		esc_attr( $slider_dot_tablet ) == 'yes' ? true : false,
		esc_attr( $slider_dot_mobile ) == 'yes' ? true : false,
	)
);

wc_set_loop_prop( 'slider_loop', 'yes' == $slider_loop ? true : false );
wc_set_loop_prop( 'slider_auto_play', 'yes' == $slider_auto_play ? true : false );
wc_set_loop_prop( 'slider_auto_play_time', $slider_auto_play_time );
wc_set_loop_prop( 'slider_center', 'yes' == $slider_center ? true : false );

if ( 'creative' == $layout_mode ) {
	wc_set_loop_prop( 'grid_type', molla_creative_grid_layout( $grid_layout_mode ) );
	if ( $grid_layout_mode ) {
		wc_set_loop_prop( 'is_custom_creative', true );
		if ( is_array( $grid_layout_height ) ) {
			$grid_height = $grid_layout_height['size'];
		} else {
			$grid_height = $grid_layout_height;
		}
		$grid_height = ( '' === $grid_height ? 600 : intval( $grid_height ) );
		molla_creative_grid_item_css( $id, wc_get_loop_prop( 'grid_type' ), $grid_height, 75, 20, $page_builder );
	}
}

do_action( 'molla_save_used_widget', 'product-category' );
if ( 'slider' == $layout_mode ) {
	do_action( 'molla_save_used_widget', 'slider' );
}

$output .= do_shortcode( '[product_categories ' . $extra_atts . ']' );

echo $output;
