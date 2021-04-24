<?php

// load plugin text domain
function molla_load_plugin() {

	load_plugin_textdomain( 'molla-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	// molla elementor init
	require_once( MOLLA_CORE_DIR . '/elementor/' . 'init.php' );
	// molla gutenberg init
	require_once( MOLLA_CORE_DIR . '/gutenberg/' . 'init.php' );

	// add metaboxes
	require_once( MOLLA_CORE_DIR . '/meta_boxes/' . 'init.php' );
	require_once( MOLLA_CORE_DIR . '/post-type/' . 'molla-post-types.php' );

	// widgets
	$widgets = array(
		'price_filter',
		'block',
		'follow_us',
		'product_brands',
		'product_ordering',
		'wp_nav_menu',
		'post',
		'related_products',
	);
	foreach ( $widgets as $widget ) {
		require_once( MOLLA_CORE_DIR . '/widgets/' . $widget . '.php' );
	}

	// add shortcodes
	$shortcodes = array(
		'heading',
		'button',
		'count_down',
		'count_to',
		'blog',
		'product',
		'product_category',
		'block',
		'team_member',
		'testimonial',
		'image_carousel',
		'lightbox',
		'hotspot',
	);
	foreach ( $shortcodes as $shortcode ) {
		require_once( MOLLA_CORE_DIR . '/shortcodes/molla_' . $shortcode . '.php' );
	}

}
add_action( 'plugins_loaded', 'molla_load_plugin' );


function molla_load_widgets() {

	// widgets
	$widgets = array(
		'Molla_Block_Widget',
		'Molla_Posts_Widget',
		'Molla_Follow_Us_Widget',
		'Molla_Price_Filter_Widget',
		'Molla_Product_Ordering_Widget',
		'Molla_Nav_Menu_Widget',
		'Molla_Related_Products_Widget',
	);

	$woo_widgets = array(
		'Molla_Brands_Nav_Sidebar_Widget',
	);
	foreach ( $widgets as $widget ) {
		register_widget( $widget );
	}
	if ( class_exists( 'Woocommerce' ) ) {
		foreach ( $woo_widgets as $widget ) {
			register_widget( $widget );
		}
	}
}
add_action( 'widgets_init', 'molla_load_widgets' );


/**
 * Include Classes
 */
// Molla WooCommerce Custom Ordering
require_once MOLLA_CORE_DIR . '/classes/molla_wc_product_ordering.php';

