<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Title
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;

class Molla_Custom_Product_Title_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_title'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Title', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-title';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'name', 'title' );
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
			'section_product_title',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cl_title_typo',
					'label'    => esc_html__( 'Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .product_title',
				)
			);

			$this->add_control(
				'cl_title_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .product_title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'cl_title_align',
				array(
					'label'     => esc_html__( 'Align', 'molla-core' ),
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
						'{{WRAPPER}} .product_title' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_title', $atts );
	}
}
