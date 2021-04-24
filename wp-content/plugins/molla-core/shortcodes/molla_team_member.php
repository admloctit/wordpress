<?php

add_shortcode( 'molla_team_member', 'molla_shortcode_team_member' );
function molla_shortcode_team_member( $atts, $content = null ) {
	ob_start();
	include MOLLA_ELEMENTOR_TEMPLATES . 'molla_team_member.php';
	return ob_get_clean();
}
