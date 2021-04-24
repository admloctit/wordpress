<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Meta
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;

class Molla_Custom_Product_meta_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_meta'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Meta', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-meta';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'meta' );
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
			'section_product_meta',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_meta_type',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Meta Direction', 'molla-core' ),
					'default'   => 'column',
					'options'   => array(
						'column' => esc_html__( 'Vertical', 'molla-core' ),
						'row'    => esc_html__( 'Horizontal', 'molla-core' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .product_meta' => 'flex-direction: {{VALUE}}',
						'{{WRAPPER}} .sku_wrapper'  => 'margin-right: 10px;',
					),
				)
			);

			$this->add_control(
				'cl_meta_align',
				array(
					'label'     => esc_html__( 'Align', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start'    => array(
							'title' => esc_html__( 'Left', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'        => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'      => array(
							'title' => esc_html__( 'Right', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'space-between' => array(
							'title' => esc_html__( 'Justified', 'molla-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .product_meta' => 'justify-content: {{VALUE}}; align-items: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cl_meta_typo',
					'label'    => esc_html__( 'Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .product_meta, {{WRAPPER}} .posted_in',
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_meta', $atts );
	}
}
