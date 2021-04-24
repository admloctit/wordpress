<?php

add_shortcode( 'molla_hotspot', 'molla_shortcode_hotspot' );
function molla_shortcode_hotspot( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_hotspot.php';
	return ob_get_clean();
}
