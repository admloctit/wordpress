<?php

add_shortcode( 'molla_heading', 'molla_shortcode_heading' );
function molla_shortcode_heading( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_heading.php';
	return ob_get_clean();
}
