<?php

extract(
	shortcode_atts(
		array(
			'date'       => '',
			'type'       => 'block',
			'label'      => 'Offer Ends IN:',
			'label_type' => '',
			'label_pos'  => '',
			'label_op'   => array( 'D', 'H', 'M', 'S' ),
			'time_zone'  => '',
		),
		$atts
	)
);

$output = '';

$format = '';
if ( is_array( $label_op ) ) {
	foreach ( $label_op as $e ) {
		$format .= $e;
	}
}

if ( $date ) {
	$date  = strtotime( $date );
	$now   = strtotime( 'now' );
	$date  = $date - $now;
	$class = 'deal-countdown';

	if ( $label_pos ) {
		$class .= ' outer-period';
	}
	if ( $time_zone ) {
		$class .= 'user_tz';
	}
	$output .= '<div class="deal-container ' . ( $type ) . '-type">';

	if ( 'inline' == $type ) {
		$output .= '<span class="countdown-title">' . sanitize_text_field( $label ) . '</span>';
	}

	$output .= '<div class="' . esc_attr( $class ) . '" data-until=' . esc_attr( $date ) . ' data-relative="true"' . ( $label_type ? ' data-labels-short="true"' : '' ) . ' data-format="' . esc_attr( $format ) . '" data-time-now="' . esc_attr( str_replace( '-', '/', current_time( 'mysql' ) ) ) . '"></div>';
	$output .= '</div>';
}
echo $output;

do_action( 'molla_save_used_widget', 'countdown' );
