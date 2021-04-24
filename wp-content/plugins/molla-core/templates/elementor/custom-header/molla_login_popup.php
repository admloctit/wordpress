<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract( /* @codingStandardsIgnoreLine */
	shortcode_atts(
		array(
			'account_popup'       => 'no',
			'show_label'          => 'yes',
			'show_register_label' => 'yes',
			'login_label'         => esc_html__( 'Log In', 'molla-core' ),
			'register_label'      => esc_html__( 'Register', 'molla-core' ),
			'logout_label'        => esc_html__( 'Log Out', 'molla-core' ),
			'account_label'       => esc_html__( 'Account', 'molla-core' ),
			'delimiter'           => ' / ',
			'icon'                => '',
			'icon_pos'            => 'left',
		),
		$atts
	)
);

$html = '<' . ( isset( $tag ) && 'li' == $tag ? 'li' : 'div' ) . ' class="shop-icon' . ( 'left' == $icon_pos ? ' hdir' : ' vdir' ) . ' account-links">';
if ( is_array( $icon ) && $icon['value'] ) {
	$icon = '<i class="' . esc_attr( $icon['value'] ) . '"></i>';
} else {
	$icon = '';
}
if ( 'yes' == $account_popup ) {
	if ( is_user_logged_in() ) {
		$link  = wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) );
		$html .= '<a class="logout-link" href="' . esc_url( $link ) . '">' . $icon;
		if ( $show_label ) {
			$html .= ( $logout_label ? $logout_label : esc_html__( 'Log Out', 'molla-core' ) ) . '</a>';
		} else {
			$html .= '</a>';
		}
	} else {
		$link  = '';
		$link  = wc_get_page_permalink( 'myaccount' );
		$html .= '<a class="login-link" href="' . esc_url( $link ) . '">' . $icon;
		if ( $show_label ) {
			$html .= ( $login_label ? $login_label : esc_html__( 'Log In', 'molla-core' ) ) . ( 'yes' == $show_register_label ? ( ( $delimiter ? $delimiter : ' / ' ) . ( $register_label ? $register_label : esc_html__( 'Register', 'molla-core' ) ) ) : '' ) . '</a>';
		} else {
			$html .= '</a>';
		}
	}
} else {
	$link  = wc_get_page_permalink( 'myaccount' );
	$html .= '<a href="' . esc_url( $link ) . '">' . $icon;
	if ( $show_label ) {
		$html .= ( $account_label ? $account_label : esc_html__( 'Account', 'molla-core' ) ) . '</a>';
	} else {
		$html .= '</a>';
	}
}
$html .= '</' . ( isset( $tag ) && 'li' == $tag ? 'li' : 'div' ) . '>';
echo $html;
