<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Cart Widget
 *
 *
 * @since 1.2
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Molla_Custom_Header_Cart_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cart';
	}

	public function get_title() {
		return esc_html__( 'Molla Cart', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-cart-medium';
	}

	public function get_categories() {
		return array( 'molla-header' );
	}

	public function get_keywords() {
		return array( 'cart', 'shopping' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

		$this->add_control(
			'canvas_type',
			array(
				'label'   => esc_html__( 'Enable Off-Canvas Type', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'canvas_action',
			array(
				'label'     => esc_html__( 'Open Mini-cart when', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''                    => esc_html__( 'Cart icon is clicked', 'molla-core' ),
					'after-product-added' => esc_html__( 'Product is added to cart', 'molla-core' ),
				),
				'condition' => array(
					'canvas_type' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'     => esc_html__( 'Show Label', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'cart_label',
			array(
				'label'       => esc_html__( 'Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Cart', 'molla-core' ),
				'condition'   => array(
					'show_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_count',
			array(
				'label'   => esc_html__( 'Show Count', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'count_pos',
			array(
				'label'   => esc_html__( 'Count Position', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'type-full',
				'options' => array(
					'count-linear' => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-h-align-right',
					),
					'type-full'    => array(
						'title' => esc_html__( 'Top', 'molla-core' ),
						'icon'  => 'eicon-v-align-top',
					),
				),
			)
		);

		$this->add_control(
			'count_space',
			array(
				'label'     => esc_html__( 'Count Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cart-count' => 'margin-left: {{SIZE}}px;',
				),
				'condition' => array(
					'count_pos' => 'count-linear',
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'molla-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-shopping-cart',
					'library' => 'molla-icons',
				),
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'     => esc_html__( 'Icon Position', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'top'  => array(
						'title' => esc_html__( 'Top', 'molla-core' ),
						'icon'  => 'eicon-v-align-top',
					),
				),
				'default'   => 'left',
				'condition' => array(
					'show_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_space',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .vdir .icon' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .hdir .icon' => 'margin-right: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'icon_size',
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
					'{{WRAPPER}} .shop-icon i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'show_price',
			array(
				'label'   => esc_html__( 'Show Price', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Icon, Label, Price', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typo',
				'label'    => esc_html__( 'Label', 'molla-core' ),
				'selector' => '{{WRAPPER}} .custom-label',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typo',
				'label'    => esc_html__( 'Price', 'molla-core' ),
				'selector' => '{{WRAPPER}} .cart-price .amount',
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
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .custom-label' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cart-price' => 'color: {{VALUE}}; transition: color .3s;',
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
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'label_color_hover',
			array(
				'label'     => esc_html__( 'Label Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .custom-label' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'price_color_hover',
			array(
				'label'     => esc_html__( 'Price Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .cart-price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_count',
			array(
				'label' => esc_html__( 'Count', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_typo',
				'label'    => esc_html__( 'Count', 'molla-core' ),
				'selector' => '{{WRAPPER}} .cart-count',
			)
		);

		$this->add_control(
			'count_size',
			array(
				'label'     => esc_html__( 'Count Size', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 16,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cart-count' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				),
			)
		);
		$this->add_control(
			'count_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cart-count' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'count_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .cart-count' => 'background-color: {{VALUE}};',
				),
			)
		);
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'custom-header/molla_cart.php';
	}
}
