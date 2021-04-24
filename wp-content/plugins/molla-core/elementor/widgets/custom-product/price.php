<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Price
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;

class Molla_Custom_Product_Price_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_price'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Price', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-price';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'price' );
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
			'section_product_price',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cl_price_typo',
					'label'    => esc_html__( 'Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .woocommerce-Price-amount, {{WRAPPER}} p.price',
				)
			);

			$this->start_controls_tabs( 'cl_price_tabs' );
				$this->start_controls_tab(
					'cl_price_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

				$this->add_control(
					'cl_price_normal_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} .woocommerce-Price-amount' => 'color: {{VALUE}};',
							'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_price_saled_tab',
					array(
						'label' => esc_html__( 'Saled', 'molla-core' ),
					)
				);

				$this->add_control(
					'cl_price_saled_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} ins .woocommerce-Price-amount' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_price_old_tab',
					array(
						'label' => esc_html__( 'Old', 'molla-core' ),
					)
				);

				$this->add_control(
					'cl_price_old_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} del .woocommerce-Price-amount' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'cl_title_align',
				array(
					'label'     => esc_html__( 'Align', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} p.price' => 'justify-content: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_price', $atts );
	}
}
