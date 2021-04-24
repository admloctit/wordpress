<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Share
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Molla_Custom_Product_Share_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_share'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Share', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'share' );
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
			'section_product_share',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_share_size',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Size', 'molla-core' ),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 40,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .social-icons > .social-icon' => 'font-size: {{SIZE}}{{UNIT}}; width: 2.5em; height: 2.5em;',
					),
				)
			);

			$this->start_controls_tabs( 'cl_share_tabs' );
				$this->start_controls_tab(
					'cl_share_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_share_normal_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .social-icons > .social-icon' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_share_normal_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .social-icons > .social-icon' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'cl_share_normal_border',
							'selector' => '{{WRAPPER}} .social-icons > .social-icon',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_share_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_share_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .social-icons > .social-icon:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_share_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .social-icons > .social-icon:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'cl_share_hover_border',
							'selector' => '{{WRAPPER}} .social-icons > .social-icon:hover',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'cl_share_align',
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
					'separator' => 'before',
					'selectors' => array(
						'{{WRAPPER}} .social-icons' => 'justify-content: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_share', $atts );
	}
}
