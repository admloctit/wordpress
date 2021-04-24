<?php

extract(
	shortcode_atts(
		array(
			'slider_col_cnt'  => 3,
			'slider_spacing'  => 20,
			'slider_nav_pos'  => '',
			'slider_nav_type' => '',
			'slider_nav'      => false,
			'slider_dot'      => true,
			'slider_loop'     => false,
			'align'           => '',
		),
		$atts
	)
);

do_action( 'molla_save_used_widget', 'slider' );

$output = '';

$class = 'owl-carousel owl-simple' . ( $slider_nav_pos ? ( ' ' . $slider_nav_pos ) : '' ) . ( $slider_nav_type ? ( ' ' . $slider_nav_type ) : '' );

$options           = array();
$options['margin'] = intval( $slider_spacing );
$options['loop']   = $slider_loop;
$options['dots']   = $slider_dot;
$options['nav']    = $slider_nav;

$args                  = array(
	0   => array(
		'items' => '',
	),
	576 => array(
		'items' => '',
	),
	768 => array(
		'items' => '',
	),
	992 => array(
		'items' => $slider_col_cnt,
	),
);
$options['responsive'] = molla_carousel_options( $args );
$class                .= molla_carousel_responsive_classes( $options['responsive'] );

?>

<div class="<?php echo esc_attr( $class ); ?>" data-toggle="owl" data-owl-options="<?php echo esc_attr( json_encode( $options ) ); ?>" >
<?php echo do_shortcode( $content ); ?>
</div>
