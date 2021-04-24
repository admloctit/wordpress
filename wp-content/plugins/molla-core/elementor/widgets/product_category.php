<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Product Categories Widget
 *
 * Molla Elementor widget to display product categories.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Molla_Controls_Manager;

class Molla_Elementor_Product_Category_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_product_category';
	}

	public function get_title() {
		return esc_html__( 'Molla Product Categories', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'product categories', 'shop', 'woocommerce' );
	}

	public function get_script_depends() {
		$scripts = array( 'owl-carousel', 'isotope-pkgd' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$style = array(
			'category_style' => array(
				'default',
				'action-slide',
				'back-clip',
				'inner-link',
				'fade-up',
				'fade-down',
			),
		);

		$link_style = array(
			'default',
			'float',
			'block',
			'action-slide',
			'back-clip',
			'fade-up',
			'fade-down',
		);

		$this->start_controls_section(
			'section_categories',
			array(
				'label' => esc_html__( 'Categories Selector', 'molla-core' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'Title', 'molla-core' ),
			)
		);

		$this->add_control(
			'desc',
			array(
				'label'       => esc_html__( 'Description', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Description', 'molla-core' ),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'     => esc_html__( 'Title Align', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
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
				'selectors' => array(
					'{{WRAPPER}} .title-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'Select categories', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'product_cat',
				'label_block' => true,
				'multiple'    => 'true',
			)
		);

		$this->add_control(
			'show_sub_cat',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show sub categories?', 'molla-core' ),
				'condition' => array(
					'ids!' => '',
					'ids!' => array(),
				),
			)
		);

		$this->add_control(
			'count',
			array(
				'type'  => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Categories Count', 'molla-core' ),
				'range' => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order by', 'molla-core' ),
				'default' => '',
				'options' => array(
					''            => '',
					'name'        => esc_html__( 'Name', 'molla-core' ),
					'id'          => esc_html__( 'ID', 'molla-core' ),
					'modified'    => esc_html__( 'Modified', 'molla-core' ),
					'count'       => esc_html__( 'Product Count', 'molla-core' ),
					'parent'      => esc_html__( 'Parent', 'molla-core' ),
					'description' => esc_html__( 'Description', 'molla-core' ),
					'term_group'  => esc_html__( 'Term Group', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order way', 'molla-core' ),
				'default' => '',
				'options' => array(
					''     => '',
					'DESC' => esc_html__( 'Descending', 'molla-core' ),
					'ASC'  => esc_html__( 'Ascending', 'molla-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'hide_empty',
			array(
				'type'    => Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Hide empty categories?', 'molla-core' ),
				'default' => 'yes',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_categories_layout',
			array(
				'label' => esc_html__( 'Categories Layout', 'molla-core' ),
			)
		);

		$this->add_control(
			'layout_mode',
			array(
				'label'   => esc_html__( 'Layout Mode', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'molla-core' ),
					'creative' => esc_html__( 'Grid - Creative', 'molla-core' ),
					'slider'   => esc_html__( 'Slider', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'grid_layout_mode',
			array(
				'label'     => esc_html__( 'Grid Layout Type', 'molla-core' ),
				'type'      => Molla_Controls_Manager::RADIOIMAGE,
				'default'   => '1',
				'options'   => molla_creative_grid_options(),
				'condition' => array(
					'layout_mode' => array( 'creative' ),
				),
			)
		);

		$this->add_control(
			'grid_layout_height',
			array(
				'label'       => esc_html__( 'Grid Height (px)', 'molla-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Input height of your grid-container.', 'molla-core' ),
				'range'       => array(
					'px' => array(
						'step' => 5,
						'min'  => 0,
						'max'  => 2000,
					),
				),
				'condition'   => array(
					'layout_mode'       => array( 'creative' ),
					'grid_layout_mode!' => array( '' ),
				),
			)
		);

		$this->add_control(
			'spacing',
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

		$this->add_control(
			'cols_upper_desktop',
			array(
				'label'     => esc_html__( 'Columns Upper Desktop ( >= 1200px )', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''  => esc_html__( 'Default', 'molla-core' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
				),
				'condition' => array(
					'layout_mode!' => array( 'creative' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
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
			'cols_under_mobile',
			array(
				'label'   => esc_html__( 'Columns Under Mobile ( <= 575px )', 'molla-core' ),
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
			'cat_slider_nav_pos',
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
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_control(
			'cat_slider_nav_type',
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
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show navigation?', 'molla-core' ),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_control(
			'slider_nav_show',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show slider dots?', 'molla-core' ),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);
		$this->add_control(
			'slider_loop',
			array(
				'label'     => esc_html__( 'Enable Loop', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_auto_play',
			array(
				'label'     => esc_html__( 'Enable Auto-Play', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_auto_play_time',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10000,
				'condition' => array(
					'layout_mode'      => 'slider',
					'slider_auto_play' => 'yes',
				),
			)
		);

		$this->add_control(
			'slider_center',
			array(
				'label'     => esc_html__( 'Enable Center Mode', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_categories_style',
			array(
				'label' => esc_html__( 'Categories Style', 'molla-core' ),
			)
		);

		$this->add_control(
			'category_style',
			array(
				'label'   => esc_html__( 'Category Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'      => esc_html__( 'Default', 'molla-core' ),
					'float'        => esc_html__( 'Float', 'molla-core' ),
					'block'        => esc_html__( 'Block', 'molla-core' ),
					'action-popup' => esc_html__( 'Action-popup', 'molla-core' ),
					'action-slide' => esc_html__( 'Action-slide', 'molla-core' ),
					'back-clip'    => esc_html__( 'Back-clip', 'molla-core' ),
					'fade-up'      => esc_html__( 'Fade-up', 'molla-core' ),
					'fade-down'    => esc_html__( 'Fade-down', 'molla-core' ),
					'expand'       => esc_html__( 'Expand', 'molla-core' ),
					'inner-link'   => esc_html__( 'Content-inner-link', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'content_align',
			[
				'label'   => esc_html__( 'Content Align', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
			]
		);

		$this->add_control(
			'overlay_type',
			array(
				'type'    => Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Enable Overlay', 'molla-core' ),
				'default' => 'yes',
			)
		);

		$this->add_control(
			't_x_pos',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'X Align', 'molla-core' ),
				'default'   => 'center',
				'separator' => 'before',
				'options'   => array(
					'left'   => esc_html__( 'Default', 'molla-core' ),
					'center' => esc_html__( 'Center', 'molla-core' ),
				),
				'condition' => $style,
			)
		);

		$this->add_control(
			't_y_pos',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Y Align', 'molla-core' ),
				'default'   => 'center',
				'options'   => array(
					'top'    => esc_html__( 'Default', 'molla-core' ),
					'center' => esc_html__( 'Center', 'molla-core' ),
				),
				'condition' => $style,
			)
		);
		$this->start_controls_tabs( 'tabs_position' );

		$this->start_controls_tab(
			'tab_pos_top',
			array(
				'label'     => esc_html__( 'Top', 'molla-core' ),
				'condition' => $style,
			)
		);

		$this->add_responsive_control(
			'cat_pos_top',
			array(
				'label'      => esc_html__( 'Top', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .cat-content' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => $style,
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pos_right',
			array(
				'label'     => esc_html__( 'Right', 'molla-core' ),
				'condition' => $style,
			)
		);

		$this->add_responsive_control(
			'cat_pos_right',
			array(
				'label'      => esc_html__( 'Right', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .cat-content' => 'right: {{SIZE}}{{UNIT}};',
				),
				'condition'  => $style,
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pos_bottom',
			array(
				'label'     => esc_html__( 'Bottom', 'molla-core' ),
				'condition' => $style,
			)
		);

		$this->add_responsive_control(
			'cat_pos_bottom',
			array(
				'label'      => esc_html__( 'Bottom', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .cat-content' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => $style,
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pos_left',
			array(
				'label'     => esc_html__( 'Left', 'molla-core' ),
				'condition' => $style,
			)
		);

		$this->add_responsive_control(
			'cat_pos_left',
			array(
				'label'      => esc_html__( 'Left', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .cat-content' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => $style,
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'with_subcat',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Show subcategories', 'molla-core' ),
			)
		);

		$this->add_control(
			'subcat_count',
			array(
				'label'     => esc_html__( 'Subcategories Count', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 3,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'condition' => array(
					'with_subcat' => 'yes',
				),
			)
		);

		$this->add_control(
			'subcat_icon',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'with_subcat' => 'yes',
				),
			)
		);

		$this->add_control(
			'subcat_icon_space',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .category-list i' => 'margin-right: {{SIZE}}px;',
				),
				'condition' => array(
					'with_subcat' => 'yes',
				),
			)
		);

		$this->add_control(
			'subcat_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .category-list i' => 'font-size: {{SIZE}}px;',
				),
				'condition' => array(
					'with_subcat' => 'yes',
				),
			)
		);

		$this->add_control(
			'hide_count',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Hide product counts', 'molla-core' ),
			)
		);

		$this->add_control(
			'hide_link',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Hide Link', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_btn_label',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Button Label', 'molla-core' ),
				'placeholder' => esc_html__( 'Shop Now', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_btn_type',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Button Type', 'molla-core' ),
				'default'   => '',
				'options'   => array(
					''    => esc_html__( 'Link', 'molla-core' ),
					'btn' => esc_html__( 'Button', 'molla-core' ),
				),
				'condition' => array(
					'category_style' => $link_style,
				),
			)
		);

		$this->add_control(
			'cat_btn_icon',
			array(
				'label' => esc_html__( 'Icon', 'molla-core' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'cat_btn_icon_pos',
			array(
				'label'   => esc_html__( 'Icon Position', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default' => 'right',
			)
		);

		$this->add_control(
			'cat_btn_icon_space',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cat-link.icon-after i'  => 'margin-left: {{SIZE}}px; margin-right: 0',
					'{{WRAPPER}} .cat-link.icon-before i' => 'margin-left: 0; margin-right: {{SIZE}}px',
				),
			)
		);

		$this->add_control(
			'cat_btn_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cat-link i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'default'   => 'woocommerce_thumbnail',
				'separator' => 'none',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_dim',
			array(
				'label' => esc_html__( 'Title Wrapper', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_heading',
			array(
				'label' => esc_html__( 'Title', 'molla-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .heading-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'desc_heading',
			array(
				'label'     => esc_html__( 'Description', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .heading-desc',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_content',
			array(
				'label' => esc_html__( 'Category Content', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cat_content_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_name_style',
			array(
				'label' => esc_html__( 'Category Name', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cat_title_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .cat-title a',
			)
		);

		$this->add_responsive_control(
			'name_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_cat_name_color' );

		$this->start_controls_tab(
			'tab_cat_name_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_title_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cat_name_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_count_style',
			array(
				'label' => esc_html__( 'Category Count', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cat_count_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .cat-title .count',
			)
		);

		$this->add_responsive_control(
			'count_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cat_count_color',
			array(
				'label'     => esc_html__( 'Category Count', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-title .count' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_subcat_style',
			array(
				'label'     => esc_html__( 'Subcategory', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'with_subcat' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cat_subcat_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .category-list li',
			)
		);

		$this->add_responsive_control(
			'subcat_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .category-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'subcat_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 40,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .category-list li + li' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_subcat_color' );

		$this->start_controls_tab(
			'tab_subcat_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_subcat_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .category-list a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_subcat_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_subcat_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .category-list a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_link_style',
			array(
				'label' => esc_html__( 'Shop Link', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cat_link_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .cat-link',
			)
		);

		$this->add_responsive_control(
			'shop_link_dimension',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'shop_link_padding',
			array(
				'label'      => esc_html__( 'Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'shop_link_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat-link' => 'border: 1px solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_cat_link' );

		$this->start_controls_tab(
			'tab_cat_link_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_link_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_link_bordercolor',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_link_backcolor',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'cat_btn_type'   => array(
						'btn',
					),
					'category_style' => $link_style,
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cat_link_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_link_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link:hover, {{WRAPPER}} .cat-link:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_link_hover_bordercolor',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link:hover, {{WRAPPER}} .cat-link:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_link_hover_backcolor',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat-link:hover, {{WRAPPER}} .cat-link:focus' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'cat_btn_type'   => array(
						'btn',
					),
					'category_style' => $link_style,
				),
			)
		);

		$this->add_control(
			'cat_link_hover_transition',
			array(
				'label'     => esc_html__( 'Transition Duration', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => array(
					'size' => 0.3,
				),
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cat-link' => 'transition: all {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_overlay',
			array(
				'label' => esc_html__( 'Overlay', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cat_thumb > a:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_dimension',
			[
				'label'      => esc_html__( 'Spacing', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cat_thumb > a:before' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .cat_thumb > a:before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'category_box_shadow',
			array(
				'label' => esc_html__( 'Shadow Effect', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_category_box_shadow' );

		$this->start_controls_tab(
			'tab_box_shadow_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'category_box_shadow',
				'selector' => '{{WRAPPER}} .product-category',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_box_shadow_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'category_box_shadow_hover',
				'selector' => '{{WRAPPER}} .product-category:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'cat_slider_style',
			array(
				'label' => esc_html__( 'Slider', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_nav',
			array(
				'label' => esc_html__( 'Nav Options', 'molla-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'slider_nav_font_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Font Size', 'molla-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'font-size: {{SIZE}}px',
				),
			)
		);

		$this->add_responsive_control(
			'cat_slider_nav_width',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Width', 'molla-core' ),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'cat_slider_nav_height',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'molla-core' ),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_dim',
			array(
				'label'      => esc_html__( 'Position', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button'    => 'top: {{TOP}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .owl-nav .owl-prev' => 'left: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .owl-nav .owl-next' => 'right: {{RIGHT}}{{UNIT}};',
				),
				'condition'  => array(
					'cat_slider_nav_pos!' => 'owl-nav-top',
				),
			)
		);

		$this->add_responsive_control(
			'slider_top_nav_dim',
			array(
				'label'              => esc_html__( 'Position', 'molla-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => array(
					'top',
					'right',
				),
				'size_units'         => array(
					'px',
					'%',
				),
				'selectors'          => array(
					'{{WRAPPER}} .owl-nav' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
				),
				'condition'          => array(
					'cat_slider_nav_pos' => 'owl-nav-top',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_nav_bg_color' );

		$this->start_controls_tab(
			'tab_nav_bg_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_slider_nav_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_slider_nav_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cat_slider_nav_border',
				'selector' => '{{WRAPPER}} .owl-nav button',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow',
				'selector' => '{{WRAPPER}} .owl-nav button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_bg_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'cat_slider_nav_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cat_slider_nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cat_slider_nav_hover_hover',
				'selector' => '{{WRAPPER}} .owl-nav button:not(.disabled):hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow_hover',
				'selector' => '{{WRAPPER}} .owl-nav button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_dot',
			array(
				'label'     => esc_html__( 'Dot Options', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'slider_dot_dim_vt',
			array(
				'label'      => esc_html__( 'Position Vertical', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 300,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-dots' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
				'condition'  => array(
					'cat_slider_nav_pos' => array( 'owl-nav-inside' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_dim_hz',
			array(
				'label'      => esc_html__( 'Position Horizontal', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 300,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-dots' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
				'condition'  => array(
					'cat_slider_nav_pos' => array( 'owl-nav-inside' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_dim',
			array(
				'label'              => esc_html__( 'Position', 'molla-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'vertical',
				'size_units'         => array(
					'px',
					'%',
				),
				'selectors'          => array(
					'{{WRAPPER}} .owl-dots' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition'          => array(
					'cat_slider_nav_pos' => array( '' ),
				),
			)
		);
		$this->start_controls_tabs( 'tabs_dot_color' );
		$this->start_controls_tab(
			'tab_dot_color',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'slider_dot_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'slider_dot_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_color_active',
			array(
				'label' => esc_html__( 'Active', 'molla-core' ),
			)
		);

		$this->add_control(
			'slider_dot_bg_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$atts       = $this->get_settings_for_display();
		$atts['id'] = $this->get_data( 'id' );

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product_category.php';
	}
}
