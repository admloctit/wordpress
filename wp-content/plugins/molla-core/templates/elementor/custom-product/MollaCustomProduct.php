<?php
namespace Molla_Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * MollaCustomProduct class
 *
 * manage rendering widgets using in custom-product category.
 *
 * @since 1.0
 */

class Molla_Custom_Product {
	public $widgets = array(
		'image',
		'navigation',
		'title',
		'meta',
		'rating',
		'price',
		'countdown',
		'excerpt',
		'cart_form',
		'share',
		'data_tab',
		'linked_products',
	);
	public $post;
	public $product_layout;
	public $product;
	protected $catalog_mode;
	protected $show_op;

	public function __construct() {
		if ( class_exists( 'WooCommerce' ) && ( ! isset( $_POST['action'] ) || 'molla_quickview-action' != $_POST['action'] ) ) {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'wp', array( $this, 'check_product_layout' ) );

			add_filter( 'molla_using_elementor_block', array( $this, 'use_product_layout' ) );
			add_filter( 'body_class', array( $this, 'add_body_class' ), 5 );

			add_action( 'molla-single-product_layout', array( $this, 'set_post_product' ) );
			add_action( 'woocommerce_before_single_product', array( $this, 'set_post_product' ) );

			foreach ( $this->widgets as $widget ) {
				add_action( 'molla_custom_layout_' . $widget, array( $this, 'render_' . $widget ) );
			}

			if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
				if ( defined( 'ELEMENTOR_VERSION' ) && ! wp_doing_ajax() ) {
					if ( ! has_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' ) ) {
						add_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );
					}
				}
			}
		}
	}

	public function init() {
		$posts = get_posts(
			array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'numberposts'         => 0,
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$this->post    = $post;
				$this->product = wc_get_product( $this->post );
				if ( 'variable' == $this->product->get_type() ) {
					break;
				}
			}
		}
	}

	public function check_product_layout() {
		global $post;

		if ( $post && ( 'product_layout' == $post->post_type || ( class_exists( 'WooCommerce' ) && is_product() && defined( 'MOLLA_VERSION' ) && 'custom' == molla_option( 'single_product_layout' ) ) ) ) {
			$this->product_layout = true;
		}
	}

	public function set_post_product() {
		if ( ! ( class_exists( 'WooCommerce' ) && is_product() ) && $this->product ) {
			global $post, $product;
			$post    = $this->post;
			$product = $this->product;
			setup_postdata( $this->post );
		}
	}

	public function use_product_layout( $res ) {
		if ( true == $this->product_layout ) {
			wp_enqueue_script( 'wc-single-product' );

			add_filter( 'molla_is_product', '__return_true' );
			wp_enqueue_style( 'molla-custom-product-css', MOLLA_CORE_URI . 'templates/elementor/custom-product/custom-product.css' );

			// navigation actions
			remove_filter( 'molla_after_breadcrumb', 'molla_single_product_next_prev_nav', 30 );

			// Catalog Mode
			$this->catalog_mode = false;
			$this->show_op      = array();

			if ( ! is_user_logged_in() && defined( 'MOLLA_VERSION' ) && molla_option( 'catalog_mode' ) ) {
				$this->catalog_mode = true;
				$this->show_op      = molla_option( 'public_product_show_op' );
			}

			return true;
		}
		return $res;
	}

	public function add_body_class( $cls ) {
		global $post;
		if ( $post && true == $this->product_layout ) {
			$cls[] = 'woocommerce';
		}

		return $cls;
	}

	public function render_image( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			add_filter( 'woocommerce_gallery_thumbnail_size', 'molla_single_product_thumbnail_size' );
			add_filter( 'woocommerce_gallery_image_size', 'molla_single_product_thumbnail_size' );

			include 'image.php';
		}

		wp_reset_postdata();
	}
	public function render_navigation( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			$this->prev_icon = $atts['cl_navigation_prev_icon']['value'];
			$this->next_icon = $atts['cl_navigation_next_icon']['value'];
			add_filter( 'molla_check_single_next_prev_nav', '__return_true' );
			add_filter(
				'molla_woocommerce_prev_icon',
				function( $icon ) {
					return $this->prev_icon;
				}
			);
			add_filter(
				'molla_woocommerce_next_icon',
				function( $icon ) {
					return $this->next_icon;
				}
			);
			echo molla_single_product_next_prev_nav();
		}

		wp_reset_postdata();
	}
	public function render_title( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			woocommerce_template_single_title();
		}

		wp_reset_postdata();
	}

	public function render_meta( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'cat', $this->show_op ) ) ) {
			remove_action( 'woocommerce_product_meta_start', 'molla_woocommerce_product_meta_wrap_start' );
			remove_action( 'woocommerce_product_meta_end', 'molla_woocommerce_product_meta_wrap_end' );

			woocommerce_template_single_meta();
		}

		wp_reset_postdata();
	}

	public function render_rating( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'cat', $this->show_op ) ) ) {
			woocommerce_template_single_rating();
		}

		wp_reset_postdata();
	}

	public function render_price( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'price', $this->show_op ) ) ) {
			woocommerce_template_single_price();
		}

		wp_reset_postdata();
	}

	public function render_countdown( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'deal', $this->show_op ) ) ) {
			$this->cl_countdown_type  = $atts['cl_countdown_type'];
			$this->cl_countdown_label = $atts['cl_countdown_label'];
			$set_countdown_type       = function( $type ) {
				if ( $this->cl_countdown_type ) {
					return $this->cl_countdown_type;
				}
				return $type;
			};
			$set_countdown_label      = function( $label ) {
				if ( $this->cl_countdown_label ) {
					return $this->cl_countdown_label;
				}
				return $label;
			};
			add_filter( 'molla_product_countdown_type', $set_countdown_type );
			add_filter( 'molla_product_countdown_label', $set_countdown_label );
			molla_woocommerce_single_product_deal();
			remove_filter( 'molla_product_countdown_type', $set_countdown_type );
			remove_filter( 'molla_product_countdown_label', $set_countdown_label );
		}

		wp_reset_postdata();
	}

	public function render_excerpt( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'desc', $this->show_op ) ) ) {
			woocommerce_template_single_excerpt();
		}

		wp_reset_postdata();
	}

	public function render_cart_form( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product && ( ! $this->catalog_mode || in_array( 'cart', $this->show_op ) ) ) {
			wp_enqueue_script( 'bootstrap-input-spinner' );

			// cart form actions
			add_filter( 'molla_sticky_add_to_cart_start', array( $this, 'check_sticky_cart' ) );
			add_filter( 'molla_sticky_add_to_cart_end', array( $this, 'check_sticky_cart' ) );

			woocommerce_template_single_add_to_cart();

			if ( $this->catalog_mode && ! in_array( 'price', $this->show_op ) ) {
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			}
		}

		wp_reset_postdata();
	}

	public function render_share( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			do_action( 'woocommerce_share', 'Share:' );
		}

		wp_reset_postdata();
	}

	public function render_data_tab( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			if ( 'theme' != $atts['cl_tab_type'] ) {
				set_theme_mod( 'single_product_data_style', esc_attr( $atts['cl_tab_type'] ) );
			}

			wp_enqueue_script( 'bootstrap-bundle' );
			wc_get_template_part( 'single-product/tabs/tabs' );

			wp_reset_postdata();
		}
	}

	public function render_linked_products( $atts ) {
		global $product;

		$this->set_post_product();

		if ( $product ) {
			include 'linked_product.php';
		}

		wp_reset_postdata();
	}

	public function check_sticky_cart( $res ) {
		if ( defined( 'MOLLA_VERSION' ) && molla_option( 'single_sticky_bar_show' ) ) {
			return false;
		}

		return $res;
	}
}

new Molla_Custom_Product;
