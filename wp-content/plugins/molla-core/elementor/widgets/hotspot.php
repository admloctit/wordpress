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
use Elementor\Molla_Controls_Manager;

class Molla_Elementor_Hotspot_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_hotspot';
	}

	public function get_title() {
		return esc_html__( 'Molla Hotspot', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'hotspot', 'dot' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'html',
				'options' => array(
					'html'    => esc_html__( 'Custom Html', 'molla-core' ),
					'block'   => esc_html__( 'Block', 'molla-core' ),
					'product' => esc_html__( 'Product', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'html',
			array(
				'label'     => esc_html__( 'Custom Html', 'molla-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => array( 'type' => 'html' ),
			)
		);

		$this->add_control(
			'block',
			array(
				'label'       => esc_html__( 'Select a Block', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'block',
				'label_block' => true,
				'condition'   => array( 'type' => 'block' ),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'     => esc_html__( 'Link Url', 'molla-core' ),
				'type'      => Controls_Manager::URL,
				'default'   => array(
					'url' => '',
				),
				'condition' => array( 'type!' => 'product' ),
			)
		);

		$this->add_control(
			'product',
			array(
				'label'       => esc_html__( 'Select a Product', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'product',
				'label_block' => true,
				'condition'   => array( 'type' => 'product' ),
			)
		);

		$this->add_responsive_control(
			'size',
			array(
				'label'      => esc_html__( 'Hotspot Size', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hotspot-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'molla-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-plus',
					'library' => '',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'popup_position',
			array(
				'label'   => esc_html__( 'Popup Position', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'molla-core' ),
					'right'  => esc_html__( 'Right', 'molla-core' ),
					'bottom' => esc_html__( 'Bottom', 'molla-core' ),
					'left'   => esc_html__( 'Left', 'molla-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'horizontal',
			array(
				'label'      => esc_html__( 'Horizontal', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'size_units' => array(
					'px',
					'%',
					'vw',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'vertical',
			array(
				'label'      => esc_html__( 'Vertical', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'size_units' => array(
					'px',
					'%',
					'vw',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'effect_delay',
			array(
				'label'     => esc_html__( 'Effect Delay ( ms )', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => array(
					'{{WRAPPER}} .hotspot-inner:after' => 'animation-delay: {{SIZE}}ms;',
				),
			)
		);

		$this->add_control(
			'el_class',
			array(
				'label' => esc_html__( 'Custom Class', 'molla-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .hotspot-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_hotspot' );

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
					'{{WRAPPER}} .hotspot-wrapper' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .hotspot-wrapper .hotspot-inner' => 'background-color: {{VALUE}};',
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
			'btn_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .hotspot-wrapper:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .hotspot-wrapper:hover .hotspot-inner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_hotspot.php';
	}
}
