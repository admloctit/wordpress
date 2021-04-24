<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Cart_form
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Molla_Custom_Product_Cart_form_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_cart_form'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Cart Form', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-add-to-cart';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'cart_form' );
	}

	public function get_script_depends() {
		$scripts = array( 'bootstrap-input-spinner', 'bootstrap-bundle' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_cart_form',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_cart_type',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Type', 'molla-core' ),
					'default'   => 'column',
					'options'   => array(
						'column' => esc_html__( 'Default', 'molla-core' ),
						'row'    => esc_html__( 'Inline QTY + Cart', 'molla-core' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .cart:not(.variations_form)' => 'flex-direction: {{VALUE}}',
						'{{WRAPPER}} .variations_button' => 'flex-direction: {{VALUE}}',
						'{{WRAPPER}} .single_variation_wrap' => 'flex-direction: column;',
						'{{WRAPPER}} .sticky-bar-action' => 'flex-direction: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'cl_cart_attribute_spacing',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Attribute Spacing', 'molla-core' ),
					'default'   => array(
						'size' => 20,
						'unit' => 'px',
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .single_variation_wrap' => 'margin-top: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .variations tr+tr' => 'margin-top: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} form.cart .variations' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} form.cart div.quantity' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} form.cart .quantity ~ button' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} form.cart .yith-wcwl-add-to-wishlist' => 'margin-bottom: {{SIZE}}{{UNIT}}; vertical-align: middle;',
					),
				)
			);

			$this->add_control(
				'cl_cart_qty_label',
				array(
					'label'     => esc_html__( 'QTY Label', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'block',
					'options'   => array(
						'block' => esc_html__( 'Show', 'molla-core' ),
						'none'  => esc_html__( 'Hide', 'molla-core' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .quantity label' => 'display: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'cl_cart_align',
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
						'{{WRAPPER}} .variations tr'     => 'justify-content: {{VALUE}}',
						'{{WRAPPER}} .cart:not(.variations_form)' => 'align-items: {{VALUE}}; justify-content: {{VALUE}}',
						'{{WRAPPER}} .variations_button' => 'align-items: {{VALUE}}; justify-content: {{VALUE}}',
						'{{WRAPPER}} .single_variation_wrap' => 'align-items: {{VALUE}}; justify-content: {{VALUE}}',

					),
				)
			);

			$this->add_control(
				'cl_cart_wishlist',
				array(
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'label'   => esc_html__( 'Add To Wishlist?', 'molla-core' ),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_cart_form', $atts );
	}
}
