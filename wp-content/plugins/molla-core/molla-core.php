<?php
/*
Plugin Name: Molla Theme - Core
Plugin URI: http://themeforest.net/user/molla-themes
Description: Adds functionality such as Shortcodes, Post Types and Widgets to Molla Theme
Version: 1.2.9
Author: D-THEMES
Author URI: http://themeforest.net/user/molla-themes
License: GPL2
Text Domain: molla-core
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOLLA_CORE_VERSION', '1.2.8' );

class Molla_Core {
	/**
	 * Constructor
	 *
	 * @since 1.0
	 *
	*/
	public function __construct() {

		// define values
		define( 'MOLLA_CORE_URI', plugin_dir_url( __FILE__ ) );                                            // molla-core url
		define( 'MOLLA_CORE_DIR', plugin_dir_path( __FILE__ ) );                                           // molla-core path
		define( 'MOLLA_CORE_CSS', MOLLA_CORE_URI . 'assets/css/' );                                        // molla-core path
		define( 'MOLLA_CORE_JS', MOLLA_CORE_URI . 'assets/js/' );                                          // molla-core path
		define( 'MOLLA_CORE_CONTROLS', MOLLA_CORE_DIR . 'elementor/controls/' );                           // molla-core controls path
		define( 'MOLLA_CORE_WIDGETS', MOLLA_CORE_DIR . 'elementor/widgets/' );                             // molla-core widgets path
		define( 'MOLLA_ELEMENTOR_TEMPLATES', MOLLA_CORE_DIR . 'templates/elementor/' );                    // molla-core elementor-widget rendering path
		define( 'MOLLA_GUTENBERG_TEMPLATES', MOLLA_CORE_DIR . 'templates/gutenberg/' );                    // molla-core gudenberg-block rendering path

		// include libs
		require_once( MOLLA_CORE_DIR . '/functions/' . 'setup.php' );
		require_once( MOLLA_CORE_DIR . '/functions/' . 'helper.php' );
		require_once( MOLLA_CORE_DIR . '/functions/' . 'hooks.php' );

		register_activation_hook(
			__FILE__,
			function() {
				require_once( MOLLA_CORE_DIR . '/post-type/' . 'molla-post-types.php' );
				Molla_Builders::get_instance()->register_post_types();
				flush_rewrite_rules();
			}
		);
	}
}

new Molla_Core;
