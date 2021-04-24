<?php

add_shortcode( 'molla_blog', 'molla_shortcode_blog' );
function molla_shortcode_blog( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_blog.php';
	return ob_get_clean();
}
