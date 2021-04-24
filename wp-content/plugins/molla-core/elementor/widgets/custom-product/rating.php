<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Ratings
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Molla_Custom_Product_Rating_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_rating'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Rating', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-rating';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'rating' );
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
			'section_product_rating',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_rating_align',
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
						'{{WRAPPER}} .woocommerce-product-rating' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_rating', $atts );
	}
}
