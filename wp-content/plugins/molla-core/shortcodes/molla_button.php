<?php

add_shortcode( 'molla_button', 'molla_shortcode_button' );
function molla_shortcode_button( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_button.php';
	return ob_get_clean();
}
