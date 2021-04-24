<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Prev-Next Navigation
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

class Molla_Custom_Product_Navigation_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_navigation'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Nav', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-post-navigation';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'navigation', 'prev', 'next' );
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
			'section_product_navigation',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

			$this->add_control(
				'cl_navigation_align',
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
						'{{WRAPPER}} .product-pager' => 'justify-content: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'cl_navigation_prev_icon',
				array(
					'label'            => esc_html__( 'Prev Icon', 'molla-core' ),
					'type'             => Controls_Manager::ICONS,
					'separator'        => 'before',
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'icon-angle-left',
						'library' => '',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'cl_navigation_next_icon',
				array(
					'label'            => esc_html__( 'Next Icon', 'molla-core' ),
					'type'             => Controls_Manager::ICONS,
					'separator'        => 'after',
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'icon-angle-right',
						'library' => '',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'cl_navigation_size',
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
						'{{WRAPPER}} .product-pager-link a' => 'font-size: {{SIZE}}px',
						'{{WRAPPER}} .product-pager-link a i' => 'font-size: calc({{SIZE}} * 1.4px)',
					),
				)
			);

			$this->start_controls_tabs( 'cl_navigation_tabs' );
				$this->start_controls_tab(
					'cl_navigation_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_navigation_a_color',
						array(
							'label'     => esc_html__( 'Link Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-pager-link a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_navigation_i_color',
						array(
							'label'     => esc_html__( 'Icon Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-pager-link i' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'cl_navigation_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

					$this->add_control(
						'cl_navigation_a_color_hover',
						array(
							'label'     => esc_html__( 'Link Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-pager-link:hover a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'cl_navigation_i_color_hover',
						array(
							'label'     => esc_html__( 'Icon Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-pager-link:hover i' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_navigation', $atts );
	}
}
