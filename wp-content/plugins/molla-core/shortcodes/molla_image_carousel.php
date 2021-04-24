<?php

add_shortcode( 'molla_image_carousel', 'molla_shortcode_image_carousel' );
function molla_shortcode_image_carousel( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_image_carousel.php';
	return ob_get_clean();
}
