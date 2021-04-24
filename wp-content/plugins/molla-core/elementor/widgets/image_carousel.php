<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Heading Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

class Molla_Elementor_Image_Carousel_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_image_carousel';
	}

	public function get_title() {
		return esc_html__( 'Molla Image Carousel', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'image', 'carousel' );
	}

	public function get_script_depends() {
		$scripts = array( 'owl-carousel' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		global $molla_animations;

		$this->start_controls_section(
			'section_image_carousel',
			array(
				'label' => esc_html__( 'Image Carousel', 'molla-core' ),
			)
		);

		$this->add_control(
			'images',
			array(
				'label'      => esc_html__( 'Add Images', 'molla-core' ),
				'type'       => Controls_Manager::GALLERY,
				'default'    => array(),
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'   => esc_html__( 'Slides to Show', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 4,
				'options' => array(
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
					7 => '7',
					8 => '8',
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'label'   => esc_html__( 'Spacing', 'molla-core' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 20,
				),
				'range'   => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 40,
					),
				),
			)
		);

		$this->add_control(
			'caption_type',
			array(
				'label'   => esc_html__( 'Caption', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''            => esc_html__( 'None', 'molla-core' ),
					'title'       => esc_html__( 'Title', 'molla-core' ),
					'caption'     => esc_html__( 'Caption', 'molla-core' ),
					'description' => esc_html__( 'Description', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'image_stretch',
			array(
				'label'   => esc_html__( 'Image Stretch', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => array(
					'no'  => esc_html__( 'No', 'molla-core' ),
					'yes' => esc_html__( 'Yes', 'molla-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'v_align',
			array(
				'label'     => esc_html__( 'Vertical Align', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'top',
				'options'   => array(
					'flex-start' => esc_html__( 'Top', 'molla-core' ),
					'center'     => esc_html__( 'Middle', 'molla-core' ),
					'flex-end'   => esc_html__( 'Bottom', 'molla-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .owl-item figure' => 'align-items:{{VALUE}}',
				),
				'condition' => array(
					'image_stretch' => 'no',
				),
			)
		);

		$this->add_responsive_control(
			'h_align',
			array(
				'label'     => esc_html__( 'Horizontal Align', 'molla-core' ),
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
					'{{WRAPPER}} .owl-item figure' => 'justify-content:{{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			array(
				'label' => esc_html__( 'Additional Options', 'molla-core' ),
			)
		);

		$this->add_control(
			'nav_pos',
			array(
				'label'   => esc_html__( 'Nav & Dot Position', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'owl-nav-inside' => esc_html__( 'Inner', 'molla-core' ),
					''               => esc_html__( 'Outer', 'molla-core' ),
					'owl-nav-top'    => esc_html__( 'Top', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'nav_type',
			array(
				'label'   => esc_html__( 'Nav Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''                => esc_html__( 'Type 1', 'molla-core' ),
					'owl-full'        => esc_html__( 'Type 2', 'molla-core' ),
					'owl-nav-rounded' => esc_html__( 'Type 3', 'molla-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'nav',
			array(
				'label'   => esc_html__( 'Enable Nav', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'nav_show',
			array(
				'type'    => Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
				'default' => 'yes',
			)
		);

		$this->add_responsive_control(
			'dot',
			array(
				'label'   => esc_html__( 'Enable Dots', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'   => esc_html__( 'Enable Loop', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'auto_play',
			array(
				'label'   => esc_html__( 'Enable Auto-Play', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'auto_play_time',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'auto_play' => 'yes',
				),
			)
		);

		$this->add_control(
			'auto_height',
			array(
				'label'   => esc_html__( 'Enable Auto-height', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'animation_in',
			array(
				'label'   => esc_html__( 'Animation In', 'molla-core' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => '',
				'options' => $molla_animations['animate_in'],
			)
		);

		$this->add_control(
			'animation_out',
			array(
				'label'   => esc_html__( 'Animation Out', 'molla-core' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => '',
				'options' => $molla_animations['animate_out'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_style',
			array(
				'label' => esc_html__( 'Slider', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_nav',
			array(
				'label' => esc_html__( 'Nav Options', 'molla-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'nav_width',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Width', 'molla-core' ),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'nav_height',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'molla-core' ),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'nav_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_dim',
			array(
				'label'      => esc_html__( 'Position', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-nav button'    => 'top: {{TOP}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .owl-nav .owl-prev' => 'left: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .owl-nav .owl-next' => 'right: {{RIGHT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_top_nav_dim',
			array(
				'label'              => esc_html__( 'Position', 'molla-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => array(
					'top',
					'right',
				),
				'size_units'         => array(
					'px',
					'%',
				),
				'selectors'          => array(
					'{{WRAPPER}} .owl-nav' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
				),
				'condition'          => array(
					'nav_pos' => 'owl-nav-top',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_nav_bg_color' );

		$this->start_controls_tab(
			'tab_nav_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);
		$this->add_control(
			'nav_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'nav_border',
				'selector' => '{{WRAPPER}} .owl-nav button',
			)
		);

		$this->add_control(
			'nav_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow',
				'selector' => '{{WRAPPER}} .owl-nav button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'nav_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'nav_border_hover',
				'selector' => '{{WRAPPER}} .owl-nav button:not(.disabled):hover',
			)
		);

		$this->add_control(
			'nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow_hover',
				'selector' => '{{WRAPPER}} .owl-nav button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_dot',
			array(
				'label'     => esc_html__( 'Dot Options', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'dot_dim_vt',
			array(
				'label'      => esc_html__( 'Position Vertical', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 300,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-dots' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
				'condition'  => array(
					'nav_pos' => array( 'owl-nav-inside' ),
				),
			)
		);

		$this->add_responsive_control(
			'dot_dim_hz',
			array(
				'label'      => esc_html__( 'Position Horizontal', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 300,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .owl-dots' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
				'condition'  => array(
					'nav_pos' => array( 'owl-nav-inside' ),
				),
			)
		);

		$this->add_responsive_control(
			'dot_dim',
			array(
				'label'              => esc_html__( 'Position', 'molla-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'vertical',
				'size_units'         => array(
					'px',
					'%',
				),
				'selectors'          => array(
					'{{WRAPPER}} .owl-dots' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition'          => array(
					'nav_pos' => array( '' ),
				),
			)
		);

		$this->start_controls_tabs( 'tabs_dot_color' );
		$this->start_controls_tab(
			'tab_dot_color',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'dot_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'dot_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_color_active',
			array(
				'label' => esc_html__( 'Active', 'molla-core' ),
			)
		);

		$this->add_control(
			'dot_bg_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_image_carousel.php';
	}

}
