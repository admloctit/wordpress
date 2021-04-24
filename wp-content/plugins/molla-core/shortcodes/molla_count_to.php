<?php

add_shortcode( 'molla_count_to', 'molla_shortcode_count_to' );
function molla_shortcode_count_to( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_count_to.php';
	return ob_get_clean();
}
