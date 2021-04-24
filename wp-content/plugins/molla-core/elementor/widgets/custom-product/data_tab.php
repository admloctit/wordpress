<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Data_tab
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Molla_Custom_Product_Data_tab_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_data_tab'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Data Tab', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-product-tabs';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'data_tab' );
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
			'section_product_data_tab',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_tab_type',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Type', 'molla-core' ),
					'default' => 'theme',
					'options' => array(
						'theme'     => esc_html__( 'Theme Option', 'molla-core' ),
						''          => esc_html__( 'Tab', 'molla-core' ),
						'accordion' => esc_html__( 'Accordion', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'cl_tab_link_align',
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
						'{{WRAPPER}} .wc-tabs-wrapper .tabs' => 'text-align: {{VALUE}};',
					),
					'condition' => array(
						'cl_tab_type' => array( '', 'theme' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cl_tab_link_typo',
					'label'    => esc_html__( 'Link Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .tabs li .nav-link, {{WRAPPER}} .card-title .nav-link',
				)
			);

			$this->start_controls_tabs( 'cl_share_tabs' );
				$this->start_controls_tab(
					'cl_tab_link_tab',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_tab_link_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li .nav-link' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:before' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_tab_link_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li .nav-link' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'cl_tab_link_border',
							'selector' => '{{WRAPPER}} .tabs li .nav-link, {{WRAPPER}} .card-title .nav-link',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_tab_link_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_tab_link_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li .nav-link:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:hover:before' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_tab_link_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li .nav-link:hover' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'cl_tab_link_hover_border',
							'selector' => '{{WRAPPER}} .tabs li .nav-link:hover, {{WRAPPER}} .card-title .nav-link:hover',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'cl_tab_link_active_tab',
					array(
						'label' => esc_html__( 'Active', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_tab_link_active_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li.active .nav-link' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:not(.collapsed)' => 'color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:not(.collapsed):before' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_tab_link_active_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .tabs li.active .nav-link' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .card-title .nav-link:not(.collapsed)' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'cl_tab_link_active_border',
							'selector' => '{{WRAPPER}} .tabs li.active .nav-link, {{WRAPPER}} .card-title .nav-link:not(.collapsed)',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'cl_tab_link_dimen',
				array(
					'label'      => esc_html__( 'Link Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .tabs li .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .card-title .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'cl_tab_content_dimen',
				array(
					'label'      => esc_html__( 'Content Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'selectors'  => array(
						'{{WRAPPER}} .card-body'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_data_tab', $atts );
	}
}
