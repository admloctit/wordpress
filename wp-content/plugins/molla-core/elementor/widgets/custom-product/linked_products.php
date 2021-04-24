<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Linked_products
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Molla_Custom_Product_Linked_products_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_linked_products'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Linked Products', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-related';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'linked_products' );
	}

	public function get_script_depends() {
		$scripts = array();
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_linked_products',
			array(
				'label' => esc_html__( 'Products Selector', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_linked_selector_type',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Products Selector', 'molla-core' ),
					'default' => 'related',
					'options' => array(
						'upsells' => esc_html__( 'Upsells', 'molla-core' ),
						'related' => esc_html__( 'Related Products', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_title_align',
				array(
					'label'   => esc_html__( 'Title Align', 'molla-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'options' => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
				)
			);

			$this->add_control(
				'cl_linked_title_spacing',
				array(
					'type'    => Controls_Manager::SLIDER,
					'label'   => esc_html__( 'Title Spacing', 'molla-core' ),
					'default' => array(
						'size' => 20,
					),
					'range'   => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 50,
						),
					),
				)
			);

			$this->add_control(
				'cl_linked_count',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Products Count Per Page', 'molla-core' ),
					'default'   => array(
						'size' => 4,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'condition' => array(
						'cl_linked_selector_type' => array( 'related' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_orderby',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Order by', 'molla-core' ),
					'options' => array(
						'',
						'title'         => esc_html__( 'Title', 'molla-core' ),
						'ID'            => esc_html__( 'ID', 'molla-core' ),
						'date'          => esc_html__( 'Date', 'molla-core' ),
						'modified'      => esc_html__( 'Modified', 'molla-core' ),
						'rand'          => esc_html__( 'Random', 'molla-core' ),
						'comment_count' => esc_html__( 'Comment count', 'molla-core' ),
						'popularity'    => esc_html__( 'Popularity', 'molla-core' ),
						'rating'        => esc_html__( 'Rating', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_order',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Order way', 'molla-core' ),
					'options' => array(
						'',
						'DESC' => esc_html__( 'Descending', 'molla-core' ),
						'ASC'  => esc_html__( 'Ascending', 'molla-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_linked_product_layout',
			array(
				'label' => esc_html__( 'Products Layout', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_linked_layout',
				array(
					'label'   => esc_html__( 'Layout Mode', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''       => esc_html__( 'Theme Option', 'molla-core' ),
						'grid'   => esc_html__( 'Grid', 'molla-core' ),
						'slider' => esc_html__( 'Slider', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_spacing',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Spacing (px)', 'molla-core' ),
					'description' => esc_html__( 'Leave blank if you use theme default value.', 'molla-core' ),
					'default'     => array(
						'size' => 20,
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 40,
						),
					),
				)
			);

			$this->add_responsive_control(
				'cl_linked_columns',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Columns', 'molla-core' ),
					'default' => '4',
					'options' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
					),
				)
			);

			$this->add_control(
				'cl_linked_cols_under_mobile',
				array(
					'label'   => esc_html__( 'Columns Under Mobile', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''  => 'Default',
						'1' => 1,
						'2' => 2,
						'3' => 3,
					),
				)
			);

			$this->add_control(
				'cl_linked_nav_pos',
				array(
					'label'     => esc_html__( 'Nav & Dot Position', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						'owl-nav-inside' => esc_html__( 'Inner', 'molla-core' ),
						''               => esc_html__( 'Outer', 'molla-core' ),
						'owl-nav-top'    => esc_html__( 'Top', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_layout' => array( 'slider' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_nav_type',
				array(
					'label'     => esc_html__( 'Nav Type', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''                => esc_html__( 'Type 1', 'molla-core' ),
						'owl-full'        => esc_html__( 'Type 2', 'molla-core' ),
						'owl-nav-rounded' => esc_html__( 'Type 3', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_layout' => array( 'slider' ),
					),
				)
			);

			$this->add_responsive_control(
				'cl_linked_nav',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show navigation?', 'molla-core' ),
					'condition' => array(
						'cl_linked_layout' => array( 'slider' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_nav_show',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
					'default'   => 'yes',
					'condition' => array(
						'cl_linked_layout' => array( 'slider' ),
					),
				)
			);

			$this->add_responsive_control(
				'cl_linked_dot',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show slider dots?', 'molla-core' ),
					'condition' => array(
						'cl_linked_layout' => array( 'slider' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_linked_product_type',
			array(
				'label' => esc_html__( 'Products Type', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_linked_type',
				array(
					'label'   => esc_html__( 'Type', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''       => esc_html__( 'Theme Options', 'molla-core' ),
						'custom' => esc_html__( 'Custom', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_linked_product_style',
				array(
					'label'     => esc_html__( 'Product Type', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => array(
						'default'       => esc_html__( 'Default', 'molla-core' ),
						'classic'       => esc_html__( 'Classic', 'molla-core' ),
						'list'          => esc_html__( 'List', 'molla-core' ),
						'simple'        => esc_html__( 'Simple', 'molla-core' ),
						'popup'         => esc_html__( 'Popup 1', 'molla-core' ),
						'no-overlay'    => esc_html__( 'Popup 2', 'molla-core' ),
						'slide'         => esc_html__( 'Slide Over', 'molla-core' ),
						'light'         => esc_html__( 'Light', 'molla-core' ),
						'dark'          => esc_html__( 'Dark', 'molla-core' ),
						'full'          => esc_html__( 'Banner-Type', 'molla-core' ),
						'gallery-popup' => esc_html__( 'Gallery-Type', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_responsive_control(
				'cl_linked_product_align',
				array(
					'label'     => esc_html__( 'Product Align', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_t_x_pos',
				array(
					'label'     => esc_html__( 'Origin X Pos', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'center',
					'options'   => array(
						'left'   => esc_html__( 'Left', 'molla-core' ),
						'center' => esc_html__( 'Center', 'molla-core' ),
						'right'  => esc_html__( 'Right', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type'          => 'custom',
						'cl_linked_product_style' => 'full',
					),
				)
			);

			$this->add_control(
				'cl_linked_t_y_pos',
				array(
					'label'     => esc_html__( 'Origin Y Pos', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'center',
					'options'   => array(
						'top'    => esc_html__( 'Top', 'molla-core' ),
						'center' => esc_html__( 'Center', 'molla-core' ),
						'bottom' => esc_html__( 'Bottom', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type'          => 'custom',
						'cl_linked_product_style' => 'full',
					),
				)
			);

			$this->start_controls_tabs( 'cl_linked_tabs_position' );

				$this->start_controls_tab(
					'cl_linked_tab_pos_top',
					array(
						'label'     => esc_html__( 'Top', 'molla-core' ),
						'condition' => array(
							'cl_linked_type'          => 'custom',
							'cl_linked_product_style' => 'full',
						),
					)
				);

					$this->add_responsive_control(
						'cl_linked_body_pos_top',
						array(
							'label'      => esc_html__( 'Top', 'molla-core' ),
							'type'       => Controls_Manager::SLIDER,
							'separator'  => 'after',
							'default'    => array(
								'size' => 50,
								'unit' => '%',
							),
							'size_units' => array(
								'px',
								'%',
							),
							'range'      => array(
								'px' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 500,
								),
								'%'  => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'selectors'  => array(
								'{{WRAPPER}} .product-body' => 'top: {{SIZE}}{{UNIT}};',
							),
							'condition'  => array(
								'cl_linked_type'          => 'custom',
								'cl_linked_product_style' => 'full',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_linked_tab_pos_right',
					array(
						'label'     => esc_html__( 'Right', 'molla-core' ),
						'condition' => array(
							'cl_linked_type'          => 'custom',
							'cl_linked_product_style' => 'full',
						),
					)
				);

					$this->add_responsive_control(
						'cl_linked_body_pos_right',
						array(
							'label'      => esc_html__( 'Right', 'molla-core' ),
							'type'       => Controls_Manager::SLIDER,
							'separator'  => 'after',
							'size_units' => array(
								'px',
								'%',
							),
							'range'      => array(
								'px' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 500,
								),
								'%'  => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'selectors'  => array(
								'{{WRAPPER}} .product-body' => 'right: {{SIZE}}{{UNIT}};',
							),
							'condition'  => array(
								'cl_linked_type'          => 'custom',
								'cl_linked_product_style' => 'full',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_linked_tab_pos_bottom',
					array(
						'label'     => esc_html__( 'Bottom', 'molla-core' ),
						'condition' => array(
							'cl_linked_type'          => 'custom',
							'cl_linked_product_style' => 'full',
						),
					)
				);

					$this->add_responsive_control(
						'cl_linked_body_pos_bottom',
						array(
							'label'      => esc_html__( 'Bottom', 'molla-core' ),
							'type'       => Controls_Manager::SLIDER,
							'separator'  => 'after',
							'size_units' => array(
								'px',
								'%',
							),
							'range'      => array(
								'px' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 500,
								),
								'%'  => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'selectors'  => array(
								'{{WRAPPER}} .product-body' => 'bottom: {{SIZE}}{{UNIT}};',
							),
							'condition'  => array(
								'cl_linked_type'          => 'custom',
								'cl_linked_product_style' => 'full',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_linked_tab_pos_left',
					array(
						'label'     => esc_html__( 'Left', 'molla-core' ),
						'condition' => array(
							'cl_linked_type'          => 'custom',
							'cl_linked_product_style' => 'full',
						),
					)
				);

					$this->add_responsive_control(
						'cl_linked_body_pos_left',
						array(
							'label'      => esc_html__( 'Left', 'molla-core' ),
							'type'       => Controls_Manager::SLIDER,
							'separator'  => 'after',
							'default'    => array(
								'size' => 50,
								'unit' => '%',
							),
							'size_units' => array(
								'px',
								'%',
							),
							'range'      => array(
								'px' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 500,
								),
								'%'  => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'selectors'  => array(
								'{{WRAPPER}} .product-body' => 'left: {{SIZE}}{{UNIT}};',
							),
							'condition'  => array(
								'cl_linked_type'          => 'custom',
								'cl_linked_product_style' => 'full',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'cl_linked_product_hover',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show Product Hover Image', 'molla-core' ),
					'default'   => 'yes',
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_product_vertical_animate',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Vertical Action Animation', 'molla-core' ),
					'default'   => 'fade-left',
					'options'   => array(
						''          => esc_html__( 'FadeIn', 'molla-core' ),
						'fade-left' => esc_html__( 'FadeInLeft', 'molla-core' ),
						'fade-up'   => esc_html__( 'FadeInUp', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_visible_options',
				array(
					'label'       => esc_html__( 'Visible Items', 'molla-core' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'default'     => array(
						'cat',
						'price',
						'rating',
						'cart',
						'quickview',
						'wishlist',
						'deal',
					),
					'description' => esc_html__( 'Short description works only in full mode.', 'molla-core' ),
					'options'     => array(
						'cat'       => esc_html__( 'Category', 'molla-core' ),
						'price'     => esc_html__( 'Price', 'molla-core' ),
						'rating'    => esc_html__( 'Rating', 'molla-core' ),
						'cart'      => esc_html__( 'Add To Cart', 'molla-core' ),
						'quickview' => esc_html__( 'Quick View', 'molla-core' ),
						'wishlist'  => esc_html__( 'Wishlist', 'molla-core' ),
						'deal'      => esc_html__( 'Count Deal', 'molla-core' ),
						'desc'      => esc_html__( 'Short Description', 'molla-core' ),
					),
					'condition'   => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_product_label_type',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Label Type', 'molla-core' ),
					'default'   => '',
					'options'   => array(
						''       => esc_html__( 'Square', 'molla-core' ),
						'circle' => esc_html__( 'Circle', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_product_labels',
				array(
					'label'     => esc_html__( 'Labels', 'molla-core' ),
					'type'      => Controls_Manager::SELECT2,
					'multiple'  => true,
					'default'   => array(
						'featured',
						'new',
						'onsale',
						'outstock',
					),
					'options'   => array(
						'featured' => esc_html__( 'Featured', 'molla-core' ),
						'new'      => esc_html__( 'New', 'molla-core' ),
						'onsale'   => esc_html__( 'Sale', 'molla-core' ),
						'outstock' => esc_html__( 'Out Stock', 'molla-core' ),
						'hurry'    => esc_html__( 'Hurry Up', 'molla-core' ),
					),
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_quickview_pos',
				array(
					'label'       => esc_html__( 'Quick View Position', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'description' => esc_html__( 'Quick view button is placed by selected options in products.', 'molla-core' ),
					'options'     => array(
						''                  => esc_html__( 'Default', 'molla-core' ),
						'after-add-to-cart' => esc_html__( 'After Add To Cart', 'molla-core' ),
						'inner-thumbnail'   => esc_html__( 'Inner Thumbnail Vertical', 'molla-core' ),
					),
					'condition'   => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_wishlist_pos',
				array(
					'label'       => esc_html__( 'Wishlist Position', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'description' => esc_html__( 'Wishlist button is placed by selected options in products.', 'molla-core' ),
					'options'     => array(
						''                    => esc_html__( 'Default', 'molla-core' ),
						'after-add-to-cart'   => esc_html__( 'After Add To Cart', 'molla-core' ),
						'after-product-title' => esc_html__( 'After Product Name', 'molla-core' ),
						'inner-thumbnail'     => esc_html__( 'Inner Thumbnail Vertical', 'molla-core' ),
					),
					'condition'   => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_wishlist_style',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Wishlist Button Expandable', 'molla-core' ),
					'default'   => 'no',
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_out_stock_style',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show "Out-of-Stock" in body panel.', 'molla-core' ),
					'default'   => 'no',
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_product_icon_hide',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Hide Icon', 'molla-core' ),
					'default'   => 'no',
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_disable_product_out',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Disable Out Of Stock Products', 'molla-core' ),
					'default'   => 'no',
					'condition' => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_action_icon_top',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'settings'    => 'action_icon_top',
					'label'       => esc_html__( 'Icon Position Top', 'molla-core' ),
					'description' => esc_html__( 'In product action icon position is top of label.', 'molla-core' ),
					'condition'   => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

			$this->add_control(
				'cl_linked_divider_type',
				array(
					'label'       => esc_html__( 'Divider', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'dotted',
					'description' => esc_html__( 'For product buttons split.', 'molla-core' ),
					'options'     => array(
						''       => esc_html__( 'None', 'molla-core' ),
						'solid'  => esc_html__( 'Solid', 'molla-core' ),
						'dotted' => esc_html__( 'Dotted', 'molla-core' ),
					),
					'condition'   => array(
						'cl_linked_type' => 'custom',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_linked_products', $atts );
	}
}
