<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Vertical Divider Widget
 *
 *
 * @since 1.2
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Molla_Custom_Header_Vertical_Divider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_vertical_divider';
	}

	public function get_title() {
		return esc_html__( 'Molla Vertical Divider', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-divider eicon-vertical-divider';
	}

	public function get_categories() {
		return array( 'molla-header' );
	}

	public function get_keywords() {
		return array( 'header', 'divider', 'spacing', 'vertical', 'line' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_divider_style',
			array(
				'label' => esc_html__( 'Vertical Divider', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'divider_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .divider' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'divider_height',
				array(
					'label'      => esc_html__( 'Height', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .divider' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'divider_width',
				array(
					'label'      => esc_html__( 'Width', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .divider' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( defined( 'MOLLA_VERSION' ) ) {
			molla_get_template_part( 'template-parts/header/elements/divider' );
		}
	}
}
