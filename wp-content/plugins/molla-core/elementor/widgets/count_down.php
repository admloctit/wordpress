<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Countdown Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;

class Molla_Elementor_Count_Down_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_count_down';
	}

	public function get_title() {
		return esc_html__( 'Molla Count Down', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'count' );
	}

	public function get_script_depends() {
		$scripts = array( 'jquery-plugin', 'jquery-countdown' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_date',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'molla-core' ),
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
					'{{WRAPPER}} .deal-container' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'date',
			array(
				'label'   => esc_html__( 'Due Date', 'molla-core' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
			)
		);

		$this->add_control(
			'time_zone',
			array(
				'label'   => esc_html__( 'Time Zone', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''        => esc_html__( 'WordPress Defined Timezone', 'molla-core' ),
					'user_tz' => esc_html__( 'User System Timezone', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'CountDown Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => array(
					'block'  => esc_html__( 'Block', 'molla-core' ),
					'inline' => esc_html__( 'Inline', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'label',
			array(
				'label'     => esc_html__( 'Label', 'molla-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Offer Ends In:',
				'condition' => array(
					'type' => 'inline',
				),
			)
		);

		$this->add_control(
			'label_type',
			array(
				'label'   => esc_html__( 'Label Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''      => esc_html__( 'Full', 'molla-core' ),
					'short' => esc_html__( 'Short', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'label_pos',
			array(
				'label'   => esc_html__( 'Label Position', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''      => esc_html__( 'Inner', 'molla-core' ),
					'outer' => esc_html__( 'Outer', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'label_op',
			array(
				'label'    => esc_html__( 'Units', 'molla-core' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'default'  => array(
					'D',
					'H',
					'M',
					'S',
				),
				'options'  => array(
					'Y' => esc_html__( 'Year', 'molla-core' ),
					'O' => esc_html__( 'Month', 'molla-core' ),
					'W' => esc_html__( 'Week', 'molla-core' ),
					'D' => esc_html__( 'Day', 'molla-core' ),
					'H' => esc_html__( 'Hour', 'molla-core' ),
					'M' => esc_html__( 'Minute', 'molla-core' ),
					'S' => esc_html__( 'Second', 'molla-core' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_down_dimension',
			array(
				'label' => esc_html__( 'Dimension', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'countdown_padding',
			array(
				'label'      => esc_html__( 'Countdown Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .deal-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'amount_padding',
			array(
				'label'      => esc_html__( 'Amount Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'label_margin',
			array(
				'label'      => esc_html__( 'Label Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .countdown-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'type' => 'inline',
				),
			)
		);

		$this->add_responsive_control(
			'label_dimension',
			array(
				'label'      => esc_html__( 'Unit Position', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -50,
						'max'  => 50,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .countdown-period' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_down_typography',
			array(
				'label' => esc_html__( 'Typography', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_down_amount',
				'label'    => esc_html__( 'Amount', 'molla-core' ),
				'selector' => '{{WRAPPER}} .countdown-amount',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_down_label',
				'label'    => esc_html__( 'Unit, Label', 'molla-core' ),
				'selector' => '{{WRAPPER}} .countdown-period, {{WRAPPER}} .countdown-title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_down_color',
			array(
				'label' => esc_html__( 'Color', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'count_down_bg',
				'selector' => '{{WRAPPER}} .countdown-section',
			)
		);

		$this->add_control(
			'count_down_amount_color',
			array(
				'label'     => esc_html__( 'Amount', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .countdown-amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'count_down_label_color',
			array(
				'label'     => esc_html__( 'Unit, Label', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .countdown-period' => 'color: {{VALUE}};',
					'{{WRAPPER}} .countdown-title'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'count_down_separator_color',
			array(
				'label'     => esc_html__( 'Seperator', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_down_border',
			array(
				'label' => esc_html__( 'Border', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .countdown-section',
			)
		);

		$this->add_control(
			'border-radius',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Border-radius (%)', 'molla-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .countdown-section' => 'border-radius: {{SIZE}}%;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_count_down.php';
	}
}
