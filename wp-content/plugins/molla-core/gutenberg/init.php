<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gutenberg Class
 */
class Molla_Gutenberg {

	public $id;
	public $directions;

	public function __construct() {

		$this->id         = 0;
		$this->directions = array(
			'top',
			'right',
			'bottom',
			'left',
		);

		if ( is_admin() ) {
			add_action(
				'enqueue_block_editor_assets',
				function() {

					if ( defined( 'MOLLA_JS' ) ) {
						wp_enqueue_script( 'owl-carousel', MOLLA_JS . '/plugins/owl.carousel.min.js', false, true );
						wp_enqueue_script( 'isotope-pkgd', MOLLA_JS . '/plugins/isotope.pkgd.min.js', false, true );
						wp_enqueue_script( 'jquery-hoverIntent', MOLLA_JS . '/plugins/jquery.hoverIntent.min.js', false, true );
					}

					wp_enqueue_script( 'molla-gutenberg_blocks', MOLLA_CORE_JS . 'gutenberg-blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-editor' ), MOLLA_CORE_VERSION, true );

					if ( defined( 'MOLLA_CSS' ) ) {
						wp_enqueue_style( 'molla-plugins', MOLLA_PLUGINS_CSS . '/plugins.css' );
					}
				}
			);
			add_filter( 'block_categories', array( $this, 'molla_blocks_categories' ), 10, 2 );
		}

		include_once( MOLLA_CORE_DIR . '/gutenberg/includes/routes.php' );
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	public function molla_blocks_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'molla',
					'title' => esc_html__( 'Molla', 'molla-core' ),
					'icon'  => '',
				),
			)
		);
	}

	/**
	 * Gutenberg Blocks Register
	 */
	public function register_blocks() {

		$blocks = array(
			'carousel'    => 'carousel',
			'banner'      => 'banner',
			'product'     => 'product',
			'product-cat' => 'category',
			'blog'        => 'blog',
			'heading'     => 'heading',
			'icon-box'    => 'icon_box',
			'button'      => 'button',
			'section'     => 'section',
		);

		foreach ( $blocks as $block => $callback ) {
			register_block_type(
				'molla/molla-' . $block,
				array(
					'editor_script'   => 'molla-gutenberg_blocks',
					'render_callback' => array( $this, 'render_' . $callback ),
				)
			);
		}
	}

	/**
	 * Gutenberg Blocks Rendering
	 */
	public function render_carousel( $atts, $content = null ) {
		wp_enqueue_script( 'owl-carousel' );
		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		$this->id ++;

		$ret = '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? ' align' . $atts['align'] : '' ) . $addtional . '">';
		
		ob_start();

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_carousel.php';

		$ret .= ob_get_clean() . '</div>';
		return $ret;
	}
	public function render_banner( $atts, $content = null ) {

		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		$this->id ++;

		$ret = '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? ' align' . $atts['align'] : '' ) . $addtional . '"><style>';

		$x_pos = isset( $atts['x_pos'] ) ? $atts['x_pos'] : '50';
		$y_pos = isset( $atts['y_pos'] ) ? $atts['y_pos'] : '50';
		$width = isset( $atts['width'] ) ? $atts['width'] : '';

		$style  = '#gutenberg-block-' . $this->id . ' .x-' . $x_pos . ' { left: ' . $x_pos . '%; }';
		$style .= '#gutenberg-block-' . $this->id . ' .y-' . $y_pos . ' { top:' . $y_pos . '%; }';
		if ( $width ) {
			$style .= '#gutenberg-block-' . $this->id . ' .banner-content { width:' . $width . '%; }';
		}

		if ( isset( $atts['min_height'] ) ) {
			$style .= '#gutenberg-block-' . $this->id . ' .banner-img img { min-height:' . (int) $atts['min_height'] . 'px; object-fit: cover; }';
		}
		if ( isset( $atts['fixed_img'] ) && $atts['fixed_img'] ) {

			$style .= '#gutenberg-block-' . $this->id . ' .banner { padding:' . ( isset( $atts['pd_top'] ) ? (int) $atts['pd_top'] : 20 ) . 'px ' . ( isset( $atts['pd_right'] ) ? (int) $atts['pd_right'] : 20 ) . 'px ' . ( isset( $atts['pd_bottom'] ) ? (int) $atts['pd_bottom'] : 20 ) . 'px ' . ( isset( $atts['pd_left'] ) ? (int) $atts['pd_left'] : 20 ) . 'px;';

			if ( isset( $atts['banner_img_url'] ) && $atts['banner_img_url'] && ( ! isset( $atts['parallax'] ) || ! $atts['parallax'] ) ) {
				$style .= ' background-image: url("' . $atts['banner_img_url'] . '"); background-repeat: no-repeat; background-size: cover; background-position: center;';
			}
			$style .= '}';
			$style .= '#gutenberg-block-' . $this->id . ' .banner-content { position: relative }';
		}

		if ( function_exists( 'molla_minify_css' ) ) {
			$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
		}

		$ret .= $style . '</style>';

		ob_start();

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_banner.php';

		$ret .= ob_get_clean() . '</div>';
		return $ret;
	}
	public function render_product( $atts, $content = null ) {

		$ret            = $this->convert_op( $atts, 'product' );
		$atts           = $ret[0];
		$ret            = $ret[1];
		$atts['widget'] = true;
		$atts['type']   = 'custom';

		ob_start();
		echo molla_filter_output( $ret );
		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product.php';
		$ret = ob_get_clean();
		if ( isset( $atts['spacing'] ) && isset( $atts['layout_mode'] ) && 'slider' != $atts['layout_mode'] ) {
			$ret .= '</div>';
		}
		$ret .= '</div>';
		return $ret;
	}
	public function render_category( $atts, $content = null ) {

		if ( isset( $atts['categories_op'] ) && 'selected' == $atts['categories_op'] && $atts['categories'] ) {
			$atts['ids'] = $atts['categories'];
			if ( count( $atts['ids'] ) > 1 ) {
				$atts['show_sub_cat'] = false;
			}
		}

		if ( ! isset( $atts['x_pos'] ) ) {
			$atts['x_pos'] = 50;
		}
		if ( ! isset( $atts['y_pos'] ) ) {
			$atts['y_pos'] = 50;
		}
		if ( ! isset( $atts['count'] ) ) {
			$atts['count'] = 4;
		}

		$ret  = $this->convert_op( $atts, 'product-categories' );
		$atts = $ret[0];
		$ret  = $ret[1];

		ob_start();
		echo molla_filter_output( $ret );
		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product_category.php';
		$ret = ob_get_clean();
		if ( isset( $atts['spacing'] ) && isset( $atts['layout_mode'] ) && 'slider' != $atts['layout_mode'] ) {
			$ret .= '</div>';
		}
		$ret .= '</div>';
		return $ret;
	}
	public function render_blog( $atts, $content = null ) {

		$ret  = $this->convert_op( $atts, 'posts' );
		$atts = $ret[0];
		$ret  = $ret[1];

		ob_start();
		echo molla_filter_output( $ret );
		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_blog.php';
		return ob_get_clean() . '</div>';
	}
	public function render_heading( $atts, $content = null ) {
		$ret = '';
		$this->id ++;

		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		ob_start();

		$ret .= '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? ' align' . $atts['align'] : '' ) . $addtional . '"><style>';

		$style = '';

		$fonts = [ 'title', 'subtitle' ];
		foreach ( $fonts as $elem ) {
			$style .= '#gutenberg-block-' . $this->id . ' .heading-' . $elem . '{font-family: ' . ( isset( $atts[ $elem . '_font_family' ] ) ? $atts[ $elem . '_font_family' ] : 'Poppins' ) . ';font-size: ' . ( isset( $atts[ $elem . '_font_size' ] ) ? $atts[ $elem . '_font_size' ] : ( 'title' == $elem ? '2.4rem' : '1.8rem' ) ) . ';font-weight: ' . ( isset( $atts[ $elem . '_font_weight' ] ) ? $atts[ $elem . '_font_weight' ] : ( 'title' == $elem ? '600' : '400' ) ) . ';text-transform: ' . ( isset( $atts[ $elem . '_font_transform' ] ) ? $atts[ $elem . '_font_transform' ] : 'capitalize' ) . ';font-style: ' . ( isset( $atts[ $elem . '_font_style' ] ) ? $atts[ $elem . '_font_style' ] : 'normal' ) . ';text-decoration: ' . ( isset( $atts[ $elem . '_font_decoration' ] ) ? $atts[ $elem . '_font_decoration' ] : 'none' ) . ';line-height: ' . ( isset( $atts[ $elem . '_font_height' ] ) ? $atts[ $elem . '_font_height' ] : '1.4' ) . ';letter-spacing: ' . ( isset( $atts[ $elem . '_font_ltr_spacing' ] ) ? $atts[ $elem . '_font_ltr_spacing' ] : '0' ) . ';color: ' . ( isset( $atts[ $elem . '_color' ] ) ? $atts[ $elem . '_color' ] : ( 'title' == $elem ? '#333' : '#666' ) ) . ';}';
			$style .= '#gutenberg-block-' . $this->id . ' .heading:before {margin-right: ' . ( isset( $atts['decoration_spacing'] ) ? $atts['decoration_spacing'] . 'px' : '2.5rem' ) . '}';
			$style .= '#gutenberg-block-' . $this->id . ' .heading:after {margin-left: ' . ( isset( $atts['decoration_spacing'] ) ? $atts['decoration_spacing'] . 'px' : '2.5rem' ) . '}';
			$style .= isset( $atts['heading_align'] ) ? '#gutenberg-block-' . $this->id . ' .heading {justify-content: ' . $atts['heading_align'] . '}' : '';
		}

		if ( function_exists( 'molla_minify_css' ) ) {
			$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
		}
		$ret .= $style . '</style>';

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_heading.php';

		$ret .= ob_get_clean() . '</div>';
		return $ret;
	}
	public function render_icon_box( $atts, $content = null ) {
		$ret = '';

		$icon_wrap_style = '';
		$icon_style      = '';
		$icon_box_style  = '';
		$title_style     = '';
		$desc_style      = '';

		$atts['icon_align']    = isset( $atts['icon_align'] ) ? $atts['icon_align'] : 'center';
		$atts['content_align'] = isset( $atts['content_align'] ) ? $atts['content_align'] : 'center';

		$icon_margin = $this->get_dimensions( $atts, 'icon_margin_' );
		$icon_style .= 'margin: ' . $icon_margin['top'] . ' ' . $icon_margin['right'] . ' ' . $icon_margin['bottom'] . ' ' . $icon_margin['left'] . ';';

		if ( isset( $atts['icon_view'] ) ) {
			if ( isset( $atts['icon_padding'] ) ) {
				$icon_padding = $atts['icon_padding'];
				if ( $icon_padding && ! trim( preg_replace( '/(|-)[0-9.]/', '', $icon_padding ) ) ) {
					$icon_padding .= 'px';
				}
				if ( '' === $icon_padding ) {
					$icon_padding = '20px';
				}
			} else {
				$icon_padding = '20px';
			}
			$icon_style .= 'padding: ' . $icon_padding . ';';

			if ( 'stacked' == $atts['icon_view'] ) {
				if ( isset( $atts['icon_back_color'] ) && $atts['icon_back_color'] ) {
					$icon_style .= 'background-color: ' . $atts['icon_back_color'] . ';';
				}
			} elseif ( 'framed' == $atts['icon_view'] ) {
				if ( isset( $atts['icon_back_color'] ) && $atts['icon_back_color'] ) {
					$icon_style .= 'border-color: ' . $atts['icon_back_color'] . ';';
				}
			}
		}

		if ( isset( $atts['icon_position'] ) ) {
			$icon_wrap_style .= 'align-items: ' . $atts['icon_align'] . ';';
		}

		if ( ! isset( $atts['content_style'] ) ) {
			if ( ! isset( $atts['icon_position'] ) ) {
				$icon_box_style .= 'align-items: ' . $atts['icon_align'] . ';';
				$icon_box_style .= 'justify-content:' . $atts['content_align'] . ';';
			} else {
				$icon_box_style .= 'align-items:' . $atts['content_align'] . ';';
			}
		} else {
			$icon_box_style .= 'align-items: ' . $atts['content_align'] . ';';
			$icon_box_style .= 'justify-content:' . $atts['icon_align'] . ';';
			$icon_box_style .= 'text-align: ' . ( 'flex-start' == $atts['content_align'] ? 'left' : ( 'flex-end' == $atts['content_align'] ? 'right' : $atts['content_align'] ) ) . ';';
		}

		$icon_style .= 'font-size: ' . ( isset( $atts['icon_font_size'] ) && $atts['icon_font_size'] ? $atts['icon_font_size'] : '4rem' ) . ';';
		if ( isset( $atts['icon_color'] ) ) {
			$icon_style .= 'color: ' . $atts['icon_color'] . ';';
		}

		$title_style = 'font-family: ' . ( isset( $atts['title_font_family'] ) ? $atts['title_font_family'] : 'Poppins' ) .
						'; font-size: ' . ( isset( $atts['title_font_size'] ) ? $atts['title_font_size'] : '1.4rem' ) .
						'; font-weight: ' . ( isset( $atts['title_font_weight'] ) ? $atts['title_font_weight'] : '400' ) .
						'; text-transform: ' . ( isset( $atts['title_font_transform'] ) ? $atts['title_font_transform'] : 'capitalize' ) .
						'; font-style: ' . ( isset( $atts['title_font_style'] ) ? $atts['title_font_style'] : 'normal' ) .
						'; text-decoration: ' . ( isset( $atts['title_font_decoration'] ) ? $atts['title_font_decoration'] : 'none' ) .
						'; line-height: ' . ( isset( $atts['title_font_height'] ) ? $atts['title_font_height'] : '1.4' ) .
						'; letter-spacing: ' . ( isset( $atts['title_font_ltr_spacing'] ) ? $atts['title_font_ltr_spacing'] : '0' ) .
						'; color: ' . ( isset( $atts['title_color'] ) ? $atts['title_color'] : '#333' ) .
						'; margin-bottom: ' . ( isset( $atts['title_spacing'] ) ? $atts['title_spacing'] : '3' ) . 'px';

		$desc_style = 'font-family: ' . ( isset( $atts['desc_font_family'] ) ? $atts['desc_font_family'] : 'Poppins' ) .
					'; font-size: ' . ( isset( $atts['desc_font_size'] ) ? $atts['desc_font_size'] : '1.3rem' ) .
					'; font-weight: ' . ( isset( $atts['desc_font_weight'] ) ? $atts['desc_font_weight'] : '400' ) .
					'; text-transform: ' . ( isset( $atts['desc_font_transform'] ) ? $atts['desc_font_transform'] : 'none' ) .
					'; font-style: ' . ( isset( $atts['desc_font_style'] ) ? $atts['desc_font_style'] : 'normal' ) .
					'; text-decoration: ' . ( isset( $atts['desc_font_decoration'] ) ? $atts['desc_font_decoration'] : 'none' ) .
					'; line-height: ' . ( isset( $atts['desc_font_height'] ) ? $atts['desc_font_height'] : '1.4' ) .
					'; letter-spacing: ' . ( isset( $atts['desc_font_ltr_spacing'] ) ? $atts['desc_font_ltr_spacing'] : '0' ) .
					'; color: ' . ( isset( $atts['desc_color'] ) ? $atts['desc_color'] : '#777' );

		$this->id ++;

		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		ob_start();

		$ret .= '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? ' align' . $atts['align'] : '' ) . $addtional . '"><style>';

		$style  = '#gutenberg-block-' . $this->id . ' .icon-box-icon {' . $icon_wrap_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .icon-box {' . $icon_box_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .icon-box-icon i {' . $icon_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .icon-box-title {' . $title_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .icon-box-desc {' . $desc_style . '}';

		if ( function_exists( 'molla_minify_css' ) ) {
			$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
		}

		$ret .= $style . '</style>';

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_icon_box.php';

		$ret .= ob_get_clean() . '</div>';
		return $ret;
	}
	public function render_button( $atts, $content = null ) {
		$btn_style    = '';
		$wrap_style   = '';
		$icon_style   = '';
		$icon_spacing = '';

		$btn_padding = $this->get_dimensions( $atts, 'btn_pd_' );
		$btn_style  .= 'padding: ' . $btn_padding['top'] . ' ' . $btn_padding['right'] . ' ' . $btn_padding['bottom'] . ' ' . $btn_padding['left'] . ';';

		$btn_margin = $this->get_dimensions( $atts, 'btn_mg_' );
		$btn_style .= 'margin: ' . $btn_margin['top'] . ' ' . $btn_margin['right'] . ' ' . $btn_margin['bottom'] . ' ' . $btn_margin['left'] . ';';

		if ( isset( $atts['btn_border_radius'] ) && $atts['btn_border_radius'] ) {
			$btn_style .= 'border-radius: ' . $atts['btn_border_radius'] . ';';
		}
		if ( isset( $atts['icon_before'] ) ) {
			$btn_style .= 'flex-flow: row-reverse;';
		}

		foreach ( $this->directions as $direction ) {
			if ( isset( $atts[ 'icon_mg_' . $direction ] ) ) {
				$val = '';
				if ( 0 === $atts[ 'icon_mg_' . $direction ] ) {
					$val = 0;
				}
				if ( $val && ! trim( preg_replace( '/(|-)[0-9.]/', '', $val ) ) ) {
					$val .= 'px';
				}
				if ( '' !== $val ) {
					$icon_spacing .= 'margin-top: ' . $atts[ 'icon_mg' . $direction ] . ';';
				}
			}
		}

		if ( ! isset( $atts['icon_show_hover'] ) ) {
			$icon_style .= $icon_spacing;
		}
		if ( isset( $atts['icon_font_size'] ) && $atts['icon_font_size'] ) {
			$icon_style .= 'font-size: ' . $atts['icon_font_size'] . ';';
		}
		if ( isset( $atts['btn_align'] ) && $atts['btn_align'] ) {
			$wrap_style = 'justify-content: ' . $atts['btn_align'] . ';';
		}

		if ( isset( $atts['btn_color'] ) && $atts['btn_color'] ) {
			$btn_style .= 'color: ' . $atts['btn_color'] . ';';
		}
		if ( isset( $atts['btn_backcolor'] ) && $atts['btn_backcolor'] ) {
			$btn_style .= 'background-color: ' . $atts['btn_backcolor'] . ';';
		}
		if ( isset( $atts['btn_bordercolor'] ) && $atts['btn_bordercolor'] ) {
			$btn_style .= 'border-color: ' . $atts['btn_bordercolor'] . ';';
		}

		$btn_hover_style = '';

		if ( isset( $atts['btn_hover_color'] ) && $atts['btn_hover_color'] ) {
			$btn_hover_style .= 'color: ' . $atts['btn_hover_color'] . ';';
		}
		if ( isset( $atts['btn_hover_backcolor'] ) && $atts['btn_hover_backcolor'] ) {
			$btn_hover_style .= 'background-color: ' . $atts['btn_hover_backcolor'] . ';';
		}
		if ( isset( $atts['btn_hover_bordercolor'] ) && $atts['btn_hover_bordercolor'] ) {
			$btn_hover_style .= 'border-color: ' . $atts['btn_hover_bordercolor'] . ';';
		}

		$this->id ++;

		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		$ret = '';

		ob_start();

		$ret .= '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? ' align' . $atts['align'] : '' ) . $addtional . '"><style>';

		$style  = '#gutenberg-block-' . $this->id . ' .btn {' . $btn_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .btn-wrap {' . $wrap_style . '}';
		$style .= '#gutenberg-block-' . $this->id . ' .btn i {' . $icon_style . '}';

		if ( isset( $atts['icon_show_hover'] ) ) {
			$style .= '#gutenberg-block-' . $this->id . ' .btn:hover i,' . '#gutenberg-block-' . $this->id . ' .btn:focus i {' . $icon_spacing . '}';
		}

		$style .= '#gutenberg-block-' . $this->id . ' .btn:hover,' . '#gutenberg-block-' . $this->id . ' .btn:focus {' . $btn_hover_style . '}';

		if ( function_exists( 'molla_minify_css' ) ) {
			$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
		}

		$ret .= $style . '</style>';

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_button.php';

		$ret .= ob_get_clean() . '</div>';
		return $ret;
	}
	public function render_section( $atts, $content = null ) {
		$style = '';
		if ( isset( $atts['pd_top'] ) ) {
			$style .= 'padding-top: ' . $atts['pd_top'] . 'px;';
		} else {
			$style .= 'padding-top: 20px;';
		}
		if ( isset( $atts['pd_right'] ) ) {
			$style .= 'padding-right: ' . $atts['pd_right'] . 'px;';
		}
		if ( isset( $atts['pd_bottom'] ) ) {
			$style .= 'padding-bottom: ' . $atts['pd_bottom'] . 'px;';
		} else {
			$style .= 'padding-bottom: 20px;';
		}
		if ( isset( $atts['pd_left'] ) ) {
			$style .= 'padding-left: ' . $atts['pd_left'] . 'px;';
		}
		if ( isset( $atts['back_color'] ) && $atts['back_color'] ) {
			$style .= 'background-color: ' . $atts['back_color'] . ';';
		}
		if ( isset( $atts['back_img_url'] ) && $atts['back_img_url'] ) {
			$style .= ' background-image: url("' . $atts['back_img_url'] . '"); background-repeat: no-repeat; background-size: cover; background-position: center;';
		}
		$this->id ++;

		if ( function_exists( 'molla_minify_css' ) ) {
			$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
		}

		$ret  = '';
		$ret .= '<div id="gutenberg-block-' . $this->id . '"><style>';
		$ret .= '#gutenberg-block-' . $this->id . ' .section {' . $style . '}';
		$ret .= '</style>';

		ob_start();

		include MOLLA_GUTENBERG_TEMPLATES . 'molla_section.php';

		$ret .= ob_get_clean() . '</div>';

		return $ret;
	}

	public function convert_op( $atts, $type ) {

		if ( isset( $atts['layout_mode'] ) && 'slider' == $atts['layout_mode'] ) {
			wp_enqueue_script( 'owl-carousel' );
		} elseif ( isset( $atts['layout_mode'] ) && 'creative' == $atts['layout_mode'] ) {
			wp_enqueue_script( 'isotope-pkgd' );
		}

		if ( isset( $atts['slider_nav'] ) && $atts['slider_nav'] ) {
			$atts['slider_nav'] = 'yes';
		}
		if ( ! isset( $atts['slider_dot'] ) || ( isset( $atts['slider_dot'] ) && $atts['slider_dot'] ) ) {
			$atts['slider_dot'] = 'yes';
		}

		$addtional = '';
		if ( isset( $atts['className'] ) ) {
			$addtional = ' ' . $atts['className'];
		}

		$this->id ++;
		$ret = '<div id="gutenberg-block-' . $this->id . '" class="' . ( ( isset( $atts['align'] ) && $atts['align'] ) ? 'align' . $atts['align'] : '' ) . $addtional . '">';
		if ( isset( $atts['spacing'] ) ) {
			if ( ! isset( $atts['layout_mode'] ) || ( isset( $atts['layout_mode'] ) && 'slider' != $atts['layout_mode'] ) ) {
				$ret  .= '<style>';
				$style = '#gutenberg-block-' . $this->id . ' .' . $type . ' { margin-left: ' . - $atts['spacing'] / 2 . 'px; margin-right: ' . - $atts['spacing'] / 2 . 'px; } #gutenberg-block-' . $this->id . ' .' . $type . ' [class*="col-"] { padding-left: ' . $atts['spacing'] / 2 . 'px; padding-right: ' . $atts['spacing'] / 2 . 'px; }';

				if ( function_exists( 'molla_minify_css' ) ) {
					$style = molla_minify_css( $style, molla_option( 'minify_css_js' ) );
				}
				$ret .= $style . '</style>';
			}
		}
		return array( $atts, $ret );
	}

	public function get_dimensions( $atts, $key ) {
		$ret = array();
		foreach ( $this->directions as $direction ) {
			$val = ( ! isset( $atts[ $key . $direction ] ) || ! $atts[ $key . $direction ] ) ? 0 : $atts[ $key . $direction ];

			if ( $val && ! trim( preg_replace( '/(|-)[0-9.]/', '', $val ) ) ) {
				$val .= 'px';
			}
			$ret[ $direction ] = $val;
		}
		return $ret;
	}
}

new Molla_Gutenberg;
