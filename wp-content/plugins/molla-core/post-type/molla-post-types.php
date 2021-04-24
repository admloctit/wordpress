<?php

class Molla_Builders {
	protected $template_types;
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		$this->template_types = array(
			'block'          => esc_html__( 'Blocks', 'molla-core' ),
			'header'         => esc_html__( 'Headers', 'molla-core' ),
			'footer'         => esc_html__( 'Footers', 'molla-core' ),
			'sidebar'        => esc_html__( 'Sidebars', 'molla-core' ),
			'popup'          => esc_html__( 'Popups', 'molla-core' ),
			'product_layout' => esc_html__( 'Single Product Layouts', 'molla-core' ),
		);

		add_action( 'admin_menu', array( $this, 'add_template_menu' ) );
		add_action( 'init', array( $this, 'register_post_types' ), 0 );
	}

	public function redirections() {
		if ( isset( $_REQUEST['page'] ) ) {
			$post_type = substr( $_REQUEST['page'], strpos( $_REQUEST['page'], '=' ) + 1 );
			wp_redirect( admin_url( 'edit.php?post_type=' . $post_type ) );
		}
	}


	public function add_template_menu() {
		add_menu_page(
			'Molla Builders',
			'Molla Builders',
			'administrator',
			'edit.php?post_type=block',
			function() {
				wp_redirect( admin_url( 'edit.php?post_type=block' ) );
			},
			'dashicons-molla-logo',
			3
		);

		foreach ( $this->template_types as $key => $title ) {
			if ( 'block' == $key ) {
				continue;
			}
			add_submenu_page(
				'edit.php?post_type=block',
				$title,
				$title,
				'administrator',
				'edit.php?post_type=' . $key,
				array( $this, 'redirections' )
			);
		}
	}

	public function register_post_types() {

		foreach ( $this->template_types as $key => $title ) {
			register_post_type(
				$key,
				array(
					'label'               => $title,
					'exclude_from_search' => true,
					'has_archive'         => false,
					'public'              => true,
					'rewrite'             => array( 'slug' => $key ),
					'supports'            => array( 'title', 'editor' ),
					'can_export'          => true,
					'show_in_rest'        => true,
					'show_in_menu'        => 'edit.php?post_type=' . $key,
				)
			);
		}

		register_post_type(
			'page_layout',
			array(
				'label'               => __( 'Page Layouts', 'molla-core' ),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'public'              => true,
				'rewrite'             => array( 'slug' => 'page_layout' ),
				'supports'            => array( 'title', 'editor' ),
				'can_export'          => true,
				'show_in_nav_menus'   => false,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-molla-logo',
				'menu_position'       => 5,
			)
		);
	}
}

Molla_Builders::get_instance();