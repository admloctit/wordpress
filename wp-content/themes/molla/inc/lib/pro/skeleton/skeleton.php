<?php

if ( ! class_exists( 'Molla_Skeleton' ) ) {
	class Molla_Skeleton {
		public $skeleton_sidebar        = false;
		public $skeleton_product        = false;
		public $skeleton_category       = false;
		public $skeleton_single_product = false;
		public $skeleton_post           = false;
		public $is_in_sidebar           = false;

		public function __construct() {

			if ( is_customize_preview() || 
			( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

			add_action( 'before_sidebar', array( $this, 'get_skeleton_sidebar' ), 20 );
			add_filter(
				'sidebar_content_classes',
				function( $classes ) {
					return $classes . ( $this->skeleton_sidebar ? ' skeleton-body' : '' );
				}
			);
			add_action( 'before_dynamic_sidebar', array( $this, 'before_dynamic_sidebar' ) );
			add_action( 'after_dynamic_sidebar', array( $this, 'after_dynamic_sidebar' ) );

			add_filter( 'molla_wc_shop_loop_classes', array( $this, 'shop_loop_classes' ) );
			add_action( 'molla_wc_before_shop_product', array( $this, 'before_shop_product' ), 20 );
			add_action( 'molla_wc_after_shop_product', array( $this, 'after_shop_product' ), 20 );

			add_filter( 'molla_wc_shop_cat_classes', array( $this, 'shop_cat_classes' ), 10, 2 );
			add_action( 'molla_wc_before_shop_cat', array( $this, 'before_shop_cat' ), 20 );
			add_action( 'molla_wc_after_shop_cat', array( $this, 'after_shop_cat' ), 20 );

			add_filter( 'molla_wc_single_product_classes', array( $this, 'single_product_classes' ) );
			add_action( 'molla_woo_before_single_product_content', array( $this, 'before_single_product_content' ), 20 );
			add_action( 'molla_woo_after_single_product_content', array( $this, 'after_single_product_content' ), 20 );

			add_filter( 'molla_loop_post_classes', array( $this, 'loop_post_classes' ) );
			add_action( 'molla_before_loop_post_item', array( $this, 'before_loop_post_item' ), 20 );
			add_action( 'molla_after_loop_post_item', array( $this, 'after_loop_post_item' ), 20 );

			// Menu lazyload skeleton
			add_filter( 'molla_menu_lazyload_content', array( $this, 'menu_skeleton' ), 10, 4 );

			add_action( 'init', array( $this, 'init' ) );
		}

		public function enqueue_scripts() {
			wp_enqueue_style( 'molla-skeleton-css', MOLLA_PRO_LIB_URI . '/skeleton/skeleton' . ( is_rtl() ? '-rtl' : '' ) . '.css' );
			wp_enqueue_script( 'molla-skeleton-js', MOLLA_PRO_LIB_URI . '/skeleton/skeleton.min.js', array( 'molla-main' ), MOLLA_VERSION, true );

			wp_localize_script(
				'molla-skeleton-js',
				'lib_skeleton',
				array(
					'lazyload' => molla_option( 'lazy_load_img' ),
				)
			);
		}

		public function init() {

		}

		public function get_skeleton_sidebar( $sidebar ) {
			$this->skeleton_sidebar = false;

			if ( ! molla_ajax() && ( 'shop-top-sidebar' == $sidebar || 'shop-sidebar' == $sidebar || 'product-sidebar' == $sidebar || is_archive() || is_search() || ( is_single() && ! is_page() ) ) ) {
				$this->skeleton_sidebar = molla_option( 'skeleton_screen' );
			}

			if ( has_filter( 'molla_is_product', '__return_true' ) ) { // if single product layout
				$this->skeleton_sidebar = false;
			}
		}

		public function before_dynamic_sidebar( $sidebar ) {
			if ( is_active_sidebar( $sidebar ) && $this->skeleton_sidebar ) {
				$this->is_in_sidebar = true;
				ob_start();
			}
		}

		public function after_dynamic_sidebar( $sidebar ) {
			if ( is_active_sidebar( $sidebar ) && $this->skeleton_sidebar ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="widget"></div><div class="widget"></div>';
				$this->is_in_sidebar = false;
			}
		}

		public function shop_loop_classes( $classes ) {
			if ( molla_is_shop() ||
				molla_is_in_category() ||
				( class_exists( 'WooCommerce' ) && molla_is_product() ) ||
				! wc_get_loop_prop( 'is_shortcode' ) ) {

				return $classes . ' skeleton-body';
			}

			return $classes;
		}

		public function before_shop_product() {
			$this->skeleton_product = false;

			if ( ! wc_get_loop_prop( 'widget' ) && class_exists( 'WooCommerce' ) ) {
				if ( molla_is_product() ) {
					$this->skeleton_product = molla_option( 'skeleton_screen' );
				} elseif ( ! molla_ajax() ) {
					$this->skeleton_product = molla_option( 'skeleton_screen' );
				}
			} elseif ( class_exists( 'WooCommerce' ) && molla_is_product() ) { // product layout builder
				$this->skeleton_product = molla_option( 'skeleton_screen' );
			}

			if ( has_filter( 'molla_is_product', '__return_true' ) ) { // if single product layout
				$this->skeleton_product = false;
			}

			// If render in sidebar
			if ( $this->is_in_sidebar ) {
				$this->skeleton_product = false;
			}

			if ( $this->skeleton_product ) {
				ob_start();
			}
		}

		public function after_shop_product( $style ) {
			if ( $this->skeleton_product ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="skel-pro' . ( 'list' == $style ? ' skel-pro-list' : '' ) . '"></div>';
			}
		}

		public function shop_cat_classes( $classes, $layout_mode ) {
			$this->skeleton_category = false;

			if ( ! $layout_mode && class_exists( 'WooCommerce' ) && molla_is_shop() || molla_is_in_category() ) {
				$this->skeleton_category = molla_option( 'skeleton_screen' );
			}

			if ( has_filter( 'molla_is_product', '__return_true' ) ) { // if single product layout
				$this->skeleton_category = false;
			}

			// If render in sidebar
			if ( $this->is_in_sidebar ) {
				$this->skeleton_category = false;
			}

			return $classes . ( $this->skeleton_category ? ' skeleton-body' : '' );
		}

		public function before_shop_cat() {
			if ( $this->skeleton_category ) {
				ob_start();
			}
		}

		public function after_shop_cat() {
			if ( $this->skeleton_category ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="skel-cat"></div>';
			}
		}

		public function single_product_classes( $classes ) {
			$this->skeleton_single_product = false;

			if ( ! isset( $_POST['quickview'] ) ) {
				$this->skeleton_single_product = molla_option( 'skeleton_screen' );
			}

			// If render in sidebar
			if ( $this->is_in_sidebar ) {
				$this->skeleton_category = false;
			}

			return $classes . ( $this->skeleton_single_product ? ' skeleton-body' : '' );
		}

		public function before_single_product_content() {
			if ( $this->skeleton_single_product ) {
				ob_start();
			}
		}

		public function after_single_product_content( $layout ) {
			if ( $this->skeleton_single_product ) :
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				?>
				<div class="skel-pro-single <?php echo esc_attr( $layout ); ?>">
					<div class="row">
						<div class="<?php echo esc_attr( 'gallery' == $layout ? 'col-12' : 'col-md-6' ); ?>">
							<div class="product-gallery">
							</div>
						</div>
						<div class="<?php echo esc_attr( 'gallery' == $layout ? 'col-12' : 'col-md-6' ); ?>">
							<div class="entry-summary row">
								<div class="<?php echo esc_attr( 'gallery' == $layout ? 'col-6' : 'col-md-12' ); ?>">
									<div class="entry-summary1"></div>
								</div>
								<div class="<?php echo esc_attr( 'gallery' == $layout ? 'col-6' : 'col-md-12' ); ?>">
									<div class="entry-summary2"></div>
								<?php
								if ( 'sticky' == $layout && class_exists( 'WooCommerce' ) ) {
									wc_get_template( 'single-product/tabs/tabs.php' );
								}
								?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			endif;
		}

		public function loop_post_classes( $classes ) {
			$this->skeleton_post = false;

			if ( is_archive() && ! molla_ajax() ) {
				$this->skeleton_post = molla_option( 'skeleton_screen' );
			}

			if ( has_filter( 'molla_is_product', '__return_true' ) ) { // if single product layout
				$this->skeleton_post = false;
			}
			
			// If render in sidebar
			if ( $this->is_in_sidebar ) {
				$this->skeleton_category = false;
			}

			return $classes . ( $this->skeleton_post ? ' skeleton-body' : '' );
		}

		public function before_loop_post_item() {
			if ( $this->skeleton_post ) {
				ob_start();
			}
		}

		public function after_loop_post_item( $type ) {
			if ( $this->skeleton_post ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="skel-post' . ( 'default' != $type ? ' skel-post-' . $type : '' ) . '"></div>';
			}
		}

		public function menu_skeleton( $content, $megamenu, $megamenu_width, $megamenu_pos ) {
			if ( $megamenu ) {
				$megamenu_classes = 'sub-menu megamenu';
				if ( ! $megamenu_width ) {
					$megamenu_classes .= ' megamenu-container';
				} else {
					$megamenu_classes .= ' pos-' . ( $megamenu_pos ? $megamenu_pos : 'left' );
				}
				$megamenu_classes .= ' skel-megamenu';
				return '<ul class="' . esc_attr( $megamenu_classes ) . '" style="width: ' . $megamenu_width . 'px;"></ul>';
			} else {
				return '<ul class="sub-menu skel-menu"></ul>';
			}
			return $content;
		}
	}
}

new Molla_Skeleton;
