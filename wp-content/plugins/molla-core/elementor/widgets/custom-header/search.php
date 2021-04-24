<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Header Search Widget
 *
 *
 * @since 1.2
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Molla_Custom_Header_Search_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_header_search';
	}

	public function get_title() {
		return esc_html__( 'Molla Search', 'molla-core' );
	}

	public function get_icon() {
		return 'icon-search';
	}

	public function get_categories() {
		return array( 'molla-header' );
	}

	public function get_keywords() {
		return array( 'header', 'search', 'find' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_search_content',
			array(
				'label' => esc_html__( 'Search', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Search Type', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'header-search-visible',
					'options' => array(
						'header-search-visible' => esc_html__( 'Static', 'molla-core' ),
						''                      => esc_html__( 'Toggle', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'search_type',
				array(
					'label'       => esc_html__( 'Search Content Types', 'molla-core' ),
					'description' => esc_html__( 'Select post type to search', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'all',
					'options'     => array(
						'all'     => esc_html__( 'All', 'molla-core' ),
						'product' => esc_html__( 'Product', 'molla-core' ),
						'post'    => esc_html__( 'Post', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'category',
				array(
					'label'   => esc_html__( 'Search by Category', 'molla-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'placeholder',
				array(
					'label'       => esc_html__( 'Placeholder', 'molla-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => 'Search...',
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Search Icon', 'molla-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'icon-search',
						'library' => 'molla-icons',
					),
				)
			);

			$this->add_control(
				'icon_first',
				array(
					'label'   => esc_html__( 'Icon First', 'molla-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
				)
			);

			$this->add_responsive_control(
				'search_width',
				array(
					'label'      => esc_html__( 'Search Width', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 200,
							'max'  => 600,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .header-search' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wrapper_style',
			array(
				'label' => esc_html__( 'Wrapper', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'wrapper_border',
					'selector' => '.elementor-element-{{ID}} .search-wrapper',
				)
			);

			$this->add_control(
				'wrapper_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			array(
				'label' => esc_html__( 'Input Field', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'input_typography',
					'selector' => '.elementor-element-{{ID}} .search-wrapper input.form-control, .elementor-element-{{ID}} select',
				)
			);

			$this->add_control(
				'search_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper select' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bg',
				array(
					'label'     => esc_html__( 'Background', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'background-color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid; margin-left: -{{LEFT}}{{UNIT}}',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'search_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box ~ .form-control' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'btn_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper button.btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'btn_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'btn_bd_width',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'btn_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn_color' );
				$this->start_controls_tab(
					'tab_btn_normal',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg',
						array(
							'label'     => esc_html__( 'Background', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_btn_hover',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

					$this->add_control(
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg',
						array(
							'label'     => esc_html__( 'Background', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'aria_label' => array(
				'search_content_type'  => $settings['search_type'],
				'search_by_categories' => ( 'yes' == $settings['category'] ),
				'search_placeholder'   => $settings['placeholder'] ? $settings['placeholder'] : esc_html__( 'Search...', 'molla-core' ),
			),
		);
		echo '<div class="header-search' . esc_attr( $settings['type'] ? ( ' ' . $settings['type'] ) : '' ) . ( 'yes' == $settings['icon_first'] ? ' icon-left' : '' ) . ' header-search-no-radius">';
			get_search_form( $args );
		echo '</div>';
	}
}
