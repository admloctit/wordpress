<?php

extract(
	shortcode_atts(
		array(
			'shortcode'                          => 'products',
			'cl_linked_title_align'              => 'center',
			'cl_linked_selector_type'            => 'related',
			'cl_linked_title_spacing'            => array( 'size' => 20 ),
			'cl_linked_count'                    => array( 'size' => 4 ),
			'cl_linked_orderby'                  => 'date',
			'cl_linked_order'                    => 'desc',
			'cl_linked_layout'                   => '',
			'cl_linked_spacing'                  => '',
			'cl_linked_columns'                  => 4,
			'cl_linked_columns_tablet'           => '',
			'cl_linked_columns_mobile'           => '',
			'cl_linked_cols_under_mobile'        => '',
			'cl_linked_nav_pos'                  => '',
			'cl_linked_nav_type'                 => '',
			'cl_linked_nav_show'                 => 'yes',
			'cl_linked_nav'                      => false,
			'cl_linked_nav_tablet'               => false,
			'cl_linked_nav_mobile'               => false,
			'cl_linked_dot'                      => false,
			'cl_linked_dot_tablet'               => false,
			'cl_linked_dot_mobile'               => false,
			'cl_linked_type'                     => '',
			'cl_linked_product_style'            => 'default',
			'cl_linked_product_align'            => 'center',
			'cl_linked_t_x_pos'                  => 'center',
			'cl_linked_t_y_pos'                  => 'center',
			'cl_linked_product_hover'            => 'yes',
			'cl_linked_product_vertical_animate' => 'fade-left',
			'cl_linked_visible_options'          => array(
				'cat',
				'price',
				'rating',
				'cart',
				'quickview',
				'wishlist',
				'deal',
			),
			'cl_linked_product_label_type'       => '',
			'cl_linked_product_labels'           => array(
				'featured',
				'new',
				'onsale',
				'outstock',
			),
			'cl_linked_quickview_pos'            => '',
			'cl_linked_wishlist_pos'             => '',
			'cl_linked_wishlist_style'           => 'no',
			'cl_linked_out_stock_style'          => 'no',
			'cl_linked_product_icon_hide'        => 'no',
			'cl_linked_disable_product_out'      => 'no',
			'cl_linked_action_icon_top'          => 'no',
			'cl_linked_divider_type'             => 'divider-dotted',
		),
		$atts
	)
);

$more_atts = array();

global $product;

if ( 'upsells' == $cl_linked_selector_type ) {
	$ids = $product->get_upsell_ids();
} else {
	$ids = wc_get_related_products( $product->get_id(), $cl_linked_count['size'], $product->get_upsell_ids() );
}

if ( empty( $ids ) ) {
	return;
}

$more_atts['ids']     = implode( ',', $ids );
$more_atts['columns'] = intval( $cl_linked_columns );

if ( $cl_linked_orderby ) {
	$more_atts['orderby'] = esc_attr( $cl_linked_orderby );
}
if ( $cl_linked_order ) {
	$more_atts['order'] = esc_attr( $cl_linked_order );
}

if ( $cl_linked_spacing ) {
	wc_set_loop_prop( 'spacing', esc_attr( $cl_linked_spacing['size'] ) );
}

if ( 'yes' == $cl_linked_out_stock_style ) {
	$cl_linked_out_stock_style = 'text';
} else {
	$cl_linked_out_stock_style = '';
}

if ( '' == $cl_linked_layout ) {
	$cl_linked_layout = function_exists( 'molla_opiton' ) ? molla_opiton( 'single_related_layout_type' ) : 'grid';
}
if ( '' == $cl_linked_product_style ) {
	$cl_linked_product_style = function_exists( 'molla_opiton' ) ? molla_option( 'post_product_type' ) : 'default';
}

wc_set_loop_prop( 'layout_mode', esc_attr( $cl_linked_layout ) );
wc_set_loop_prop( 'cols_tablet', esc_attr( $cl_linked_columns_tablet ) );
wc_set_loop_prop( 'cols_mobile', esc_attr( $cl_linked_columns_mobile ) );
wc_set_loop_prop( 'cols_under_mobile', esc_attr( $cl_linked_cols_under_mobile ) );
wc_set_loop_prop( 'product_slider_nav_pos', esc_attr( $cl_linked_nav_pos ) );
wc_set_loop_prop( 'product_slider_nav_type', esc_attr( $cl_linked_nav_type ) );
wc_set_loop_prop( 'widget', 'molla-product' );
wc_set_loop_prop( 'elem', 'product' );
wc_set_loop_prop( 'type', $cl_linked_type );
wc_set_loop_prop( 'product_style', $cl_linked_product_style );
wc_set_loop_prop( 'product_align', $cl_linked_product_align );
wc_set_loop_prop( 't_x_pos', $cl_linked_t_x_pos );
wc_set_loop_prop( 't_y_pos', $cl_linked_t_y_pos );
wc_set_loop_prop( 'product_hover', $cl_linked_product_hover );
wc_set_loop_prop( 'product_vertical_animate', $cl_linked_product_vertical_animate );
wc_set_loop_prop( 'product_show_op', $cl_linked_visible_options );
wc_set_loop_prop( 'product_label_type', $cl_linked_product_label_type );
wc_set_loop_prop( 'product_labels', $cl_linked_product_labels );
wc_set_loop_prop( 'quickview_pos', $cl_linked_quickview_pos );
wc_set_loop_prop( 'wishlist_pos', $cl_linked_wishlist_pos );
wc_set_loop_prop( 'wishlist_style', $cl_linked_wishlist_style );
wc_set_loop_prop( 'out_stock_style', $cl_linked_out_stock_style );
wc_set_loop_prop( 'product_icon_hide', $cl_linked_product_icon_hide );
wc_set_loop_prop( 'disable_product_out', $cl_linked_disable_product_out );
wc_set_loop_prop( 'action_icon_top', $cl_linked_action_icon_top );
wc_set_loop_prop( 'divider_type', $cl_linked_divider_type );
wc_set_loop_prop(
	'slider_nav',
	array(
		esc_attr( $cl_linked_nav ) == 'yes' ? true : false,
		esc_attr( $cl_linked_nav_tablet ) == 'yes' ? true : false,
		esc_attr( $cl_linked_nav_mobile ) == 'yes' ? true : false,
	)
);
wc_set_loop_prop( 'slider_nav_show', $cl_linked_nav_show );
wc_set_loop_prop(
	'slider_dot',
	array(
		esc_attr( $cl_linked_dot ) == 'yes' ? true : false,
		esc_attr( $cl_linked_dot_tablet ) == 'yes' ? true : false,
		esc_attr( $cl_linked_dot_mobile ) == 'yes' ? true : false,
	)
);

wc_set_loop_prop( 'extra_atts', $more_atts );

$extra_atts = ' ';
foreach ( $more_atts as $key => $value ) {
	$extra_atts .= $key . '=' . $value . ' ';
}

echo '<section class="' . ( 'upsells' == $cl_linked_selector_type ? 'up-sells upsells' : 'related' ) . '">';
if ( 'upsells' == $cl_linked_selector_type ) {
	$heading = apply_filters( 'woocommerce_product_upsells_products_heading', esc_html__( 'You may also like&hellip;', 'woocommerce' ) );
	if ( $heading ) {
		echo '<h2 class="title text-' . $cl_linked_title_align . '" style="margin-bottom: ' . $cl_linked_title_spacing['size'] . 'px;">' . esc_html( $heading ) . '</h2>';
	}
} else {
	$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'woocommerce' ) );
	if ( $heading ) {
		echo '<h2 class="title text-' . $cl_linked_title_align . '" style="margin-bottom: ' . $cl_linked_title_spacing['size'] . 'px;">' . esc_html( $heading ) . '</h2>';
	}
}
echo do_shortcode( '[products ' . $extra_atts . ']' );
echo '</section>';
