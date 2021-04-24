<?php

add_shortcode( 'molla_lightbox', 'molla_shortcode_lightbox' );
function molla_shortcode_lightbox( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_lightbox.php';
	return ob_get_clean();
}
