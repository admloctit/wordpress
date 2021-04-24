<?php

add_shortcode( 'molla_product', 'molla_shortcode_product' );
function molla_shortcode_product( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product.php';
	return ob_get_clean();
}
