<?php

add_shortcode( 'molla_product_category', 'molla_shortcode_product_category' );
function molla_shortcode_product_category( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product_category.php';
	return ob_get_clean();
}
