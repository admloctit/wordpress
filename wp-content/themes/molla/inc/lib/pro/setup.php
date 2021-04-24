<?php

define( 'MOLLA_PRO_LIB', MOLLA_LIB . '/lib/pro' );
define( 'MOLLA_PRO_LIB_URI', MOLLA_URI . '/inc/lib/pro' );

// Skeleton Screen
if ( molla_option( 'skeleton_screen' ) ) {
	require_once( MOLLA_PRO_LIB . '/skeleton/skeleton.php' );
}

// Product Image Swatch
if ( class_exists( 'WooCommerce' ) && molla_option( 'image_swatch' ) ) {
	global $pagenow;
	if ( is_admin() && ( 'post-new.php' == $pagenow || 'post.php' == $pagenow || 'edit.php' == $pagenow || 'edit-tags.php' == $pagenow ) ) {
		require_once( MOLLA_PRO_LIB . '/image-swatch/admin-image-swatch-tab.php' );
	}

	require_once( MOLLA_PRO_LIB . '/image-swatch/image-swatch.php' );
}

// Molla Studio
if ( ( ( class_exists( 'Vc_Manager' ) && ( ( is_admin() && ( 'post.php' == $GLOBALS['pagenow'] || 'post-new.php' == $GLOBALS['pagenow'] || molla_ajax() ) ) || ( isset( $_REQUEST['vc_editable'] ) && $_REQUEST['vc_editable'] ) ) ) ||
	( defined( 'ELEMENTOR_VERSION' ) && ( molla_is_elementor_preview() || wp_doing_ajax() ) ) ) &&
	( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) ) {
	require_once MOLLA_PRO_LIB . '/studio/studio.php';
}

// Pre Order
if ( class_exists( 'WooCommerce' ) && molla_option( 'woo_pre_order' ) ) {
	require_once MOLLA_PRO_LIB . '/woo-pre-order/init.php';
}
