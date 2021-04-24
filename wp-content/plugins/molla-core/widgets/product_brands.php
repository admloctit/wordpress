<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

if ( class_exists( 'WC_Widget' ) ) :
	class Molla_Brands_Nav_Sidebar_Widget extends WC_Widget {

		public $brand_ancestors;

		public $current_brand;

		public function __construct() {
			$this->widget_cssclass    = 'widget_product_brands';
			$this->widget_description = esc_html__( 'A list or dropdown of product brands.', 'molla-core' );
			$this->widget_id          = 'molla_woo_product_brands';
			$this->widget_name        = esc_html__( 'Molla - Product Brands', 'molla-core' );
			$this->settings           = array(
				'title'        => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Product brands', 'molla-core' ),
					'label' => esc_html__( 'Title', 'molla-core' ),
				),
				'orderby'      => array(
					'type'    => 'select',
					'std'     => 'name',
					'label'   => esc_html__( 'Order by', 'molla-core' ),
					'options' => array(
						'order' => esc_html__( 'Brand order', 'molla-core' ),
						'name'  => esc_html__( 'Name', 'molla-core' ),
					),
				),
				'count'        => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show product counts', 'molla-core' ),
				),
				'hierarchical' => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Show hierarchy', 'molla-core' ),
				),
				'hide_empty'   => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide empty brands', 'molla-core' ),
				),
				'max_depth'    => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Maximum depth', 'molla-core' ),
				),
			);

			parent::__construct();
		}

		function widget( $args, $instance ) {

			global $wp_query, $post;

			$count         = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
			$hierarchical  = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
			$orderby       = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
			$hide_empty    = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
			$dropdown_args = array(
				'hide_empty' => $hide_empty,
			);
			$list_args     = array(
				'show_count'   => $count,
				'hierarchical' => $hierarchical,
				'taxonomy'     => 'product_brand',
				'hide_empty'   => $hide_empty,
			);
			$max_depth     = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

			$list_args['menu_order'] = false;
			$dropdown_args['depth']  = $max_depth;
			$list_args['depth']      = $max_depth;

			if ( 'order' === $orderby ) {
				$list_args['orderby']      = 'meta_value_num';
				$dropdown_args['orderby']  = 'meta_value_num';
				$list_args['meta_key']     = 'order';
				$dropdown_args['meta_key'] = 'order';
			}

			$this->current_brand   = false;
			$this->brand_ancestors = array();

			if ( is_tax( 'product_brand' ) ) {
				$this->current_brand   = $wp_query->queried_object;
				$this->brand_ancestors = get_ancestors( $this->current_brand->term_id, 'product_brand' );

			} elseif ( is_singular( 'product' ) ) {
				$terms = wc_get_product_terms(
					$post->ID,
					'product_brand',
					apply_filters(
						'molla_woo_product_brands_widget_product_terms_args',
						array(
							'orderby' => 'parent',
							'order'   => 'DESC',
						)
					)
				);

				if ( $terms ) {
					$main_term             = apply_filters( 'molla_woo_product_brands_widget_main_term', $terms[0], $terms );
					$this->current_brand   = $main_term;
					$this->brand_ancestors = get_ancestors( $main_term->term_id, 'product_brand' );
				}
			}

			$this->widget_start( $args, $instance );

			include_once MOLLA_LIB . '/lib/pro/brand/product-brand-walker.php';

			$list_args['walker']                     = new Molla_WC_Product_Brand_List_Walker();
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = esc_html__( 'No product brands exist.', 'molla-core' );
			$list_args['current_category']           = ( $this->current_brand ) ? $this->current_brand->term_id : '';
			$list_args['current_category_ancestors'] = $this->brand_ancestors;
			$list_args['max_depth']                  = $max_depth;

			echo '<ul class="product-brands">';

			wp_list_categories( apply_filters( 'molla_wc_product_brands_widget_args', $list_args ) );

			echo '</ul>';

			$this->widget_end( $args );
		}
	}
endif;
