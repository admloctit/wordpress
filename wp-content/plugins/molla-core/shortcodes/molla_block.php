<?php

add_shortcode( 'molla_block', 'molla_shortcode_block' );
function molla_shortcode_block( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_block.php';
	return ob_get_clean();
}
