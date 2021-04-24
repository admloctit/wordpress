<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Molla_Metabox {

	public $locations = array();

	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

		$this->locations = array(
			'category',
			'post',
			'product',
			'product_attr',
		);
		foreach ( $this->locations as $location ) {
			include_once MOLLA_CORE_DIR . '/meta_boxes/locations/' . $location . '.php';
		}

		// Avoid sanitizing css field
		add_filter( 'rwmb_sanitize', array( $this, 'rwmb_sanitize' ), 15, 4 );
	}

	public function enqueue_scripts() {

		wp_localize_script(
			'wp-color-picker-alpha',
			'wpColorPickerL10n',
			array(
				'clear'            => esc_html__( 'Clear' ),
				'clearAriaLabel'   => esc_html__( 'Clear color' ),
				'defaultString'    => esc_html__( 'Default' ),
				'defaultAriaLabel' => esc_html__( 'Select default color' ),
				'pick'             => esc_html__( 'Select Color' ),
				'defaultLabel'     => esc_html__( 'Color value' ),
			)
		);
	}

	public function rwmb_sanitize( $value, $field, $old_value = null, $object_id = null ) {
		if ( current_user_can( 'administrator' ) && isset( $field['id'] ) ) {
			if ( 'page_css' == $field['id'] ) {
				return wp_strip_all_tags( htmlspecialchars_decode( $value ) );
			}
			if ( 'page_script' == $field['id'] ) {
				return htmlspecialchars_decode( $value );
			}
		}
		return $value;
	}

}

new Molla_Metabox;
