<?php

extract(
	shortcode_atts(
		array(
			'from'  => 0,
			'to'    => 99,
			'time'  => 3,
			'label' => '',
			'desc'  => '',
			'unit'  => '',
			'align' => 'center',
		),
		$atts
	)
);

$output = '<div class="molla-count-wrapper' . ( $align ? ( ' text-' . esc_attr( $align ) ) : '' ) . '">';

$output .= '<span class="count" data-from="' . (int) $from . '" data-to ="' . (int) $to . '" data-speed="' . (int) $time * 1000 . '"></span>' . esc_html( $unit );
$output .= '<h4 class="count-title">' . $label . '</h4>';
if ( $desc ) :
	$output .= '<p>' . $desc . '</p>';
endif;
$output .= '</div>';
echo $output;

do_action( 'molla_save_used_widget', 'counters' );
