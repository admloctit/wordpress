<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor CountTo Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Background;

class Molla_Elementor_Count_To_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_count_to';
	}

	public function get_title() {
		return esc_html__( 'Molla Counter', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'count' );
	}

	public function get_script_depends() {
		$scripts = array( 'jquery-countTo', 'jquery-waypoints' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

		$this->add_control(
			'from',
			array(
				'label'   => esc_html__( 'From', 'molla-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			)
		);

		$this->add_control(
			'to',
			array(
				'label'   => esc_html__( 'To', 'molla-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 99,
			)
		);

		$this->add_control(
			'unit',
			array(
				'label'       => esc_html__( 'Unit', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Unit',
			)
		);

		$this->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Label',
			)
		);

		$this->add_control(
			'desc',
			array(
				'label'       => esc_html__( 'Description', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'Description Here...',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Alignment', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
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
				'default' => 'center',
			)
		);

		$this->add_control(
			'time',
			array(
				'label'       => esc_html__( 'Counter rolling time', 'molla-core' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 3,
				'description' => esc_html__( 'Seconds of counter rolling', 'molla-core' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_to_typography',
			array(
				'label' => esc_html__( 'Typography', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_to_num',
				'label'    => esc_html__( 'Number', 'molla-core' ),
				'selector' => '{{WRAPPER}} .countdown-amount',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_to_label',
				'label'    => esc_html__( 'Label', 'molla-core' ),
				'selector' => '{{WRAPPER}} .countdown-period',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_to_desc',
				'label'    => esc_html__( 'Description', 'molla-core' ),
				'selector' => '{{WRAPPER}} .countdown-period',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'count_to_color',
			array(
				'label' => esc_html__( 'Color', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'count_to_num_color',
			array(
				'label'     => esc_html__( 'Number', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .molla-count-wrapper' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'count_to_label_color',
			array(
				'label'     => esc_html__( 'Label', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .count-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'count_to_desc_color',
			array(
				'label'     => esc_html__( 'Description', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .molla-count-wrapper p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_count_to.php';
	}
}
