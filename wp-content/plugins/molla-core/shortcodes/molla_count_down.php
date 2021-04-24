<?php

add_shortcode( 'molla_count_down', 'molla_shortcode_count_down' );
function molla_shortcode_count_down( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_count_down.php';
	return ob_get_clean();
}
