<?php

add_shortcode( 'molla_testimonial', 'molla_shortcode_testimonial' );
function molla_shortcode_testimonial( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_testimonial.php';
	return ob_get_clean();
}
