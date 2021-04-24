<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Header Mobile Toggle Widget
 *
 *
 * @since 1.2
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Molla_Custom_Header_Responsive_Group_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_responsive_group';
	}

	public function get_title() {
		return esc_html__( 'Molla Responsive Items', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-integration';
	}

	public function get_categories() {
		return array( 'molla-header' );
	}

	public function get_keywords() {
		return array( 'menu', 'currency', 'language', 'login', 'responsive', 'links' );
	}

	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->slug ] = $item->name;
		}
		return $menu_items;
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'section_responsive_general',
			array(
				'label' => esc_html__( 'General', 'molla-core' ),
			)
		);

		$this->add_control(
			'mobile_label',
			array(
				'label'       => esc_html__( 'Mobile Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Links', 'molla-core' ),
			)
		);

		$this->add_control(
			'item_space',
			array(
				'label'     => esc_html__( 'Item Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .nav-dropdown > * + *' => 'margin-left: {{SIZE}}px;',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_color' );

		$this->start_controls_tab(
			'tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);
		$this->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .top-menu' => 'color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);
		$this->add_control(
			'color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .top-menu a:hover' => 'color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_responsive_items',
			array(
				'label' => esc_html__( 'Items', 'molla-core' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_type',
			[
				'label'   => esc_html__( 'Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'menu'              => esc_html__( 'Menu', 'molla-core' ),
					'login_form'        => esc_html__( 'Login Form', 'molla-core' ),
					'wishlist'          => esc_html__( 'Wishlist Link', 'molla-core' ),
					'currency_switcher' => esc_html__( 'Currency Switcher', 'molla-core' ),
					'lang_switcher'     => esc_html__( 'Language Switcher', 'molla-core' ),
					'html'              => esc_html__( 'Custom Html', 'molla-core' ),
				],
			]
		);

		$repeater->add_control(
			'menu',
			array(
				'label'     => esc_html__( 'Select Menu', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_menu_items(),
				'condition' => array(
					'item_type' => 'menu',
				),
			)
		);

		$repeater->add_control(
			'show_register_label',
			array(
				'label'     => esc_html__( 'Show Register Label', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'login_label',
			array(
				'label'       => esc_html__( 'Log In Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Log In', 'molla-core' ),
				'condition'   => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'delimiter',
			array(
				'label'       => esc_html__( 'Delimiter', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => ' / ',
				'condition'   => array(
					'item_type'           => 'login_form',
					'show_register_label' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'register_label',
			array(
				'label'       => esc_html__( 'Register Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Register', 'molla-core' ),
				'condition'   => array(
					'item_type'           => 'login_form',
					'show_register_label' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'logout_label',
			array(
				'label'       => esc_html__( 'Log Out Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Log Out', 'molla-core' ),
				'condition'   => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'account_icon',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'icon-user',
					'library' => 'molla-icons',
				),
				'condition' => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'account_icon_space',
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
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} i' => 'margin-right: {{SIZE}}px;',
				),
				'condition' => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'account_icon_size',
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
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}px;',
				),
				'condition' => array(
					'item_type' => 'login_form',
				),
			)
		);

		$repeater->add_control(
			'wishlist_label',
			array(
				'label'       => esc_html__( 'Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Wishlist', 'molla-core' ),
				'condition'   => array(
					'item_type' => 'wishlist',
				),
			)
		);

		$repeater->start_controls_tabs( 'tabs_wishlist_style' );

		$repeater->start_controls_tab(
			'tab_wishlist_normal',
			array(
				'label'     => esc_html__( 'Normal', 'molla-core' ),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);
		$repeater->add_control(
			'wishlist_color',
			array(
				'label'     => esc_html__( 'Count Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} span' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);
		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_wishlist_hover',
			array(
				'label'     => esc_html__( 'Hover', 'molla-core' ),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);
		$repeater->add_control(
			'wishlist_color_hover',
			array(
				'label'     => esc_html__( 'Count Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} a:hover span' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);
		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$repeater->add_control(
			'wishlist_icon',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'icon-heart-o',
					'library' => 'molla-icons',
				),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);

		$repeater->add_control(
			'wishlist_icon_space',
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
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} i' => 'margin-right: {{SIZE}}px;',
				),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);

		$repeater->add_control(
			'wishlist_icon_size',
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
					'.elementor-element-{{ID}} {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}px;',
				),
				'condition' => array(
					'item_type' => 'wishlist',
				),
			)
		);

		$repeater->add_control(
			'html',
			array(
				'label'     => esc_html__( 'Html', 'molla-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => '',
				'condition' => array(
					'item_type' => 'html',
				),
			)
		);

		$repeater->add_control(
			'item_aclass',
			[
				'label'     => esc_html__( 'Custom Class', 'molla-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'item_type' => array(
						'login_form',
						'wishlist',
						'currency_switcher',
						'lang_switcher',
					),
				),
			]
		);

		$repeater->add_responsive_control(
			'item_margin',
			[
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$presets = [
			[
				'_id'       => 'currency_switcher',
				'item_type' => 'currency_switcher',
			],
			[
				'_id'       => 'lang_switcher',
				'item_type' => 'lang_switcher',
			],
			[
				'_id'       => 'login_form',
				'item_type' => 'login_form',
			],
		];

		$this->add_control(
			'item_list',
			[
				'label'   => esc_html__( 'Items', 'molla-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => $presets,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'custom-header/molla_responsive_group.php';
	}
}
