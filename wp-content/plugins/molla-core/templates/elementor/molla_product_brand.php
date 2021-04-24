<?php

use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;

extract(
	shortcode_atts(
		array(
			'brands'         => array(),
			'hide_empty'     => '',
			'orderby'        => 'name',
			'orderway'       => '',
			'count'          => 0,

			'columns'        => '4',
			'columns_tablet' => '',
			'columns_mobile' => '',
			'spacing'        => '',
			'thumbnail_size' => 'thumbnail',
			'image_stretch'  => '',
			'nav_pos'        => '',
			'nav_type'       => '',
			'nav'            => '',
			'nav_tablet'     => '',
			'nav_mobile'     => '',
			'nav_show'       => 'yes',
			'dot'            => 'yes',
			'loop'           => '',
			'auto_play'      => '',
			'auto_play_time' => 5000,
			'auto_height'    => '',
			'animation_in'   => '',
			'animation_out'  => '',
		),
		$atts
	)
);

$output = '';


if ( $brands ) {
	$brands = get_terms(
		'product_brand',
		array(
			'taxonomy'     => 'product_brand',
			'hierarchical' => false,
			'hide_empty'   => 'yes' == $hide_empty ? true : false,
			'include'      => implode( ',', $brands ),
			'orderby'      => 'include',
			'order'        => $orderway,
			'number'       => $count['size'],
		)
	);
} else {
	$brands = get_terms(
		'product_brand',
		array(
			'taxonomy'     => 'product_brand',
			'hierarchical' => false,
			'hide_empty'   => 'yes' == $hide_empty ? ture : false,
			'orderby'      => $orderby,
			'order'        => $orderway,
			'number'       => $count['size'],
		)
	);
}

$brand_logos = array();

if ( ! empty( $brands ) ) {
	foreach ( $brands as $brand ) {
		$brand_logos[ $brand->term_id ] = absint( get_term_meta( $brand->term_id, 'brand_thumbnail_id', true ) );
	}
}

$options             = array();
$options['margin']   = (int) $spacing['size'];
$options['loop']     = 'yes' == $loop ? true : false;
$options['autoplay'] = 'yes' == $auto_play ? true : false;
if ( $options['autoplay'] ) {
	$options['autoplayTimeout'] = $auto_play_time;
}
$options['autoHeight'] = 'yes' == $auto_height ? true : false;
$add_class             = 'owl-carousel owl-image-gallery owl-simple ' . ( 'yes' != $nav_show ? ' owl-nav-show' : '' );
if ( $nav_pos ) {
	$add_class .= ' ' . $nav_pos;
}
if ( $nav_type ) {
	$add_class .= ' ' . $nav_type;
}
if ( 'yes' != $image_stretch ) {
	$add_class .= ' owl-image-org';
}

$args = array(
	0   => array(
		'items' => '',
		'dots'  => isset( $dot_mobile ) ? $dot_mobile : '',
		'nav'   => isset( $nav_mobile ) ? $nav_mobile : '',
	),
	576 => array(
		'items' => $columns_mobile,
		'dots'  => isset( $dot_mobile ) ? $dot_mobile : '',
		'nav'   => isset( $nav_mobile ) ? $nav_mobile : '',
	),
	768 => array(
		'items' => $columns_tablet,
		'dots'  => isset( $dot_tablet ) ? $dot_tablet : '',
		'nav'   => isset( $nav_tablet ) ? $nav_tablet : '',
	),
	992 => array(
		'items' => $columns,
		'dots'  => isset( $dot ) ? $dot : '',
		'nav'   => isset( $nav ) ? $nav : '',
	),
);

if ( defined( 'MOLLA_VERSION' ) ) {
	$options['responsive'] = molla_carousel_options( $args );
	$add_class            .= molla_carousel_responsive_classes( $options['responsive'] );
	$add_class            .= ' sp-' . $spacing['size'];
}

$plugin_options_escaped = ' data-toggle="owl" data-owl-options="' . esc_attr( json_encode( $options ) ) . '"';

echo '<div class="' . esc_attr( $add_class ) . '" ' . $plugin_options_escaped . '>';
foreach ( $brand_logos as $id => $brand_logo ) {
	echo '<figure class="slide-image-wrap brand-logo">';
		echo '<a href="' . get_term_link( $id, 'product_brand' ) . '">';
			echo wp_get_attachment_image( $brand_logo, $thumbnail_size );
		echo '</a>';
	echo '</figure>';
}
echo '</div>';

do_action( 'molla_save_used_widget', 'slider' );
