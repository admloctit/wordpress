<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Countdown
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Molla_Custom_Product_Countdown_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_countdown'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Countdown', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'countdown' );
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
			'section_product_countdown',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_countdown_type',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Type', 'molla-core' ),
					'default' => '',
					'options' => array(
						''       => esc_html__( 'Theme Option' ),
						'block'  => esc_html__( 'Block', 'molla-core' ),
						'inline' => esc_html__( 'Inline', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_countdown_label',
				array(
					'label'       => esc_html__( 'Label', 'molla-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'offer ends in', 'molla-core' ),
					'condition'   => array(
						'cl_countdown_type' => array( 'inline' ),
					),
				)
			);

			$this->add_responsive_control(
				'cl_countdown_align',
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
						'{{WRAPPER}} .inline-type' => 'max-width: none; padding: 5.5px 0; display: flex; flex-direction: column; align-items: {{VALUE}};',
						'{{WRAPPER}} .inline-type .countdown-title' => 'text-align: unset',
						'{{WRAPPER}} .block-type .countdown-row' => 'justify-content: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_countdown', $atts );
	}
}
