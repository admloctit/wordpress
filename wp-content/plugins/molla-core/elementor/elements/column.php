<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

add_action( 'elementor/element/column/layout/after_section_end', 'molla_custom_column', 10, 2 );
add_action( 'elementor/frontend/column/before_render', 'molla_column_class', 10, 1 );
add_action( 'elementor/frontend/column/after_render', 'molla_column_class_after', 10, 1 );
add_filter( 'elementor/column/print_template', 'molla_column_print', 10, 2 );

function molla_custom_column( $self, $args ) {
	global $molla_animations;

	$self->start_controls_section(
		'column_additional',
		array(
			'label' => __( 'Molla Column Settings', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_LAYOUT,
		)
	);

	$self->add_control(
		'column_type',
		array(
			'label'   => __( 'Use as', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''          => '',
				'banner'    => __( 'Banner Layer', 'molla-core' ),
				'tab'       => __( 'Tab Content', 'molla-core' ),
				'accordion' => __( 'Accordion Content', 'molla-core' ),
				'slider'    => __( 'Slider', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		't_x_pos',
		array(
			'label'     => __( 'X Align', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'center',
			'options'   => array(
				'left'   => __( 'Default', 'molla-core' ),
				'center' => __( 'Center', 'molla-core' ),
			),
			'separator' => 'before',
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_control(
		't_y_pos',
		array(
			'label'     => __( 'Y Align', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'center',
			'options'   => array(
				'top'    => __( 'Default', 'molla-core' ),
				'center' => __( 'Center', 'molla-core' ),
			),
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);
	$self->start_controls_tabs( 'tabs_position' );

	$self->start_controls_tab(
		'tab_pos_top',
		array(
			'label'     => __( 'Top', 'molla-core' ),
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_responsive_control(
		'banner_pos_top',
		array(
			'label'      => __( 'Top', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'separator'  => 'after',
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
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_right',
		array(
			'label'     => __( 'Right', 'molla-core' ),
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_responsive_control(
		'banner_pos_right',
		array(
			'label'      => __( 'Right', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'separator'  => 'after',
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
				'{{WRAPPER}}' => 'right: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_bottom',
		array(
			'label'     => __( 'Bottom', 'molla-core' ),
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_responsive_control(
		'banner_pos_bottom',
		array(
			'label'      => __( 'Bottom', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'separator'  => 'after',
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
				'{{WRAPPER}}' => 'bottom: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_left',
		array(
			'label'     => __( 'Left', 'molla-core' ),
			'condition' => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_responsive_control(
		'banner_pos_left',
		array(
			'label'      => __( 'Left', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'separator'  => 'after',
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
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->add_responsive_control(
		'width',
		array(
			'label'      => __( 'Width', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
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
				'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_responsive_control(
		'height',
		array(
			'label'      => __( 'Height', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
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
				'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'column_type' => 'banner',
			),
		)
	);

	$self->add_control(
		'tab_title',
		array(
			'label'     => __( 'Title', 'molla-core' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'Tab',
			'condition' => array(
				'column_type' => 'tab',
			),
		)
	);

	$self->add_control(
		'accordion_title',
		array(
			'label'     => __( 'Title', 'molla-core' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'Panel Heading',
			'condition' => array(
				'column_type' => 'accordion',
			),
		)
	);

	$self->add_control(
		'accordion_header_icon',
		array(
			'label'            => __( 'Icon', 'molla-core' ),
			'type'             => Controls_Manager::ICONS,
			'separator'        => 'after',
			'fa4compatibility' => 'icon',
			'skin'             => 'inline',
			'label_block'      => false,
			'condition'        => array(
				'column_type' => 'accordion',
			),
		)
	);

	$self->add_responsive_control(
		'creative_width',
		array(
			'label'       => __( 'Grid Item Width (%)', 'molla-core' ),
			'type'        => Controls_Manager::NUMBER,
			'description' => 'This Option will be applied when only parent section is used for creative grid. Empty Value will be set from preset of parent creative grid.',
			'min'         => 1,
			'max'         => 100,
		)
	);

	$self->add_responsive_control(
		'creative_height',
		array(
			'label'       => __( 'Grid Item Height', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'preset',
			'options'     => array(
				'1'      => '1',
				'1-2'    => '1/2',
				'1-3'    => '1/3',
				'2-3'    => '2/3',
				'1-3'    => '1/3',
				'2-3'    => '2/3',
				'1-4'    => '1/4',
				'3-4'    => '3/4',
				'child'  => __( 'Depending on Children', 'molla-core' ),
				'preset' => __( 'Use From Preset', 'molla-core' ),
			),
			'description' => 'This Option will be applied when only parent section is used for creative grid.',
		)
	);

	$self->add_responsive_control(
		'creative_order',
		array(
			'label'       => __( 'Grid Item Order', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''   => __( 'Default', 'molla-core' ),
				'1'  => '1',
				'2'  => '2',
				'3'  => '3',
				'4'  => '4',
				'5'  => '5',
				'6'  => '6',
				'7'  => '7',
				'8'  => '8',
				'9'  => '9',
				'10' => '10',
			),
			'description' => 'This Option will be applied when only parent section is used for creative grid.',
		)
	);

	$self->add_control(
		'creative_category',
		array(
			'label' => __( 'Grid Item Category', 'molla-core' ),
			'type'  => Controls_Manager::TEXT,
		)
	);

	$self->add_control(
		'v_align',
		array(
			'label'     => __( 'Vertical Align', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'flex-start',
			'options'   => array(
				'flex-start' => __( 'Top', 'molla-core' ),
				'center'     => __( 'Middle', 'molla-core' ),
				'flex-end'   => __( 'Bottom', 'molla-core' ),
				'stretch'    => __( 'Stretch', 'molla-core' ),
			),
			'selectors' => array(
				'{{WRAPPER}} .owl-stage' => 'display: flex; align-items:{{VALUE}}',
			),
			'condition' => array(
				'column_type' => array( 'slider' ),
			),
		)
	);

	$self->add_control(
		'cols_upper_desktop',
		array(
			'label'     => __( 'Columns Upper Desktop ( >= 1200px )', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''  => __( 'Default', 'molla-core' ),
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
			),
			'condition' => array(
				'column_type' => array( 'slider' ),
			),
		)
	);

	$self->add_responsive_control(
		'cols',
		array(
			'label'     => __( 'Columns', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '3',
			'options'   => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
			),
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'cols_under_mobile',
		array(
			'label'     => __( 'Columns Under Mobile', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''  => 'Default',
				'1' => 1,
				'2' => 2,
				'3' => 3,
			),
			'condition' => array(
				'column_type' => array( 'slider' ),
			),
		)
	);

	$self->add_control(
		'spacing',
		array(
			'label'     => __( 'Spacing', 'molla-core' ),
			'type'      => Controls_Manager::SLIDER,
			'default'   => array(
				'size' => 20,
			),
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 40,
				),
			),
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_nav_pos',
		array(
			'label'     => __( 'Nav & Dot Position', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				'owl-nav-inside' => __( 'Inner', 'molla-core' ),
				''               => __( 'Outer', 'molla-core' ),
				'owl-nav-top'    => __( 'Top', 'molla-core' ),
			),
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_nav_type',
		array(
			'label'     => __( 'Nav Type', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''                => __( 'Type 1', 'molla-core' ),
				'owl-full'        => __( 'Type 2', 'molla-core' ),
				'owl-nav-rounded' => __( 'Type 3', 'molla-core' ),
			),
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_responsive_control(
		'slider_nav',
		array(
			'label'     => __( 'Enable Nav', 'molla-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'no',
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_nav_show',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => __( 'Enable Navigation Auto Hide', 'molla-core' ),
			'default'   => 'yes',
			'condition' => array(
				'column_type' => array( 'slider' ),
				'slider_nav'  => array( 'yes' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_dot',
		array(
			'label'     => __( 'Enable Dots', 'molla-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_loop',
		array(
			'label'     => __( 'Enable Loop', 'molla-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'no',
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_auto_play',
		array(
			'label'     => __( 'Enable Auto-Play', 'molla-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'no',
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_auto_play_time',
		array(
			'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 10000,
			'condition' => array(
				'column_type'      => 'slider',
				'slider_auto_play' => 'yes',
			),
		)
	);

	$self->add_control(
		'slider_auto_height',
		array(
			'label'     => __( 'Enable Auto-height', 'molla-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'no',
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_animation_in',
		array(
			'label'     => __( 'Animation In', 'molla-core' ),
			'type'      => Controls_Manager::SELECT2,
			'default'   => '',
			'options'   => $molla_animations['animate_in'],
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'slider_animation_out',
		array(
			'label'     => __( 'Animation Out', 'molla-core' ),
			'type'      => Controls_Manager::SELECT2,
			'default'   => '',
			'options'   => $molla_animations['animate_out'],
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->end_controls_section();

	$self->start_controls_section(
		'slider_style',
		array(
			'label'     => __( 'Slider', 'molla-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'column_type' => 'slider',
			),
		)
	);

	$self->add_control(
		'heading_nav',
		array(
			'label' => __( 'Nav Options', 'molla-core' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$self->add_responsive_control(
		'slider_nav_font_size',
		array(
			'type'      => Controls_Manager::SLIDER,
			'label'     => __( 'Font Size', 'molla-core' ),
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 20,
					'max'  => 100,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button' => 'font-size: {{SIZE}}px',
			),
		)
	);

	$self->add_responsive_control(
		'slider_nav_width',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => __( 'Width', 'molla-core' ),
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

	$self->add_responsive_control(
		'slider_nav_height',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => __( 'Height', 'molla-core' ),
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

	$self->add_responsive_control(
		'slider_nav_radius',
		array(
			'label'      => __( 'Border Radius', 'molla-core' ),
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

	$self->add_responsive_control(
		'slider_nav_dim',
		array(
			'label'      => __( 'Position', 'molla-core' ),
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
			'condition'  => array(
				'slider_nav_pos!' => 'owl-nav-top',
			),
		)
	);

	$self->add_responsive_control(
		'slider_top_nav_dim',
		array(
			'label'              => __( 'Position', 'molla-core' ),
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
				'slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->start_controls_tabs( 'tabs_nav_bg_color' );

	$self->start_controls_tab(
		'tab_nav_color_normal',
		array(
			'label' => __( 'Normal', 'molla-core' ),
		)
	);
	$self->add_control(
		'slider_nav_bg_color',
		array(
			'label'     => __( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_nav_color',
		array(
			'label'     => __( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'slider_nav_border',
			'selector' => '{{WRAPPER}} .owl-nav button',
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'slider_nav_box_shadow',
			'selector' => '{{WRAPPER}} .owl-nav button',
		)
	);
	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_nav_color_hover',
		array(
			'label' => __( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_nav_bg_color_hover',
		array(
			'label'     => __( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_nav_color_hover',
		array(
			'label'     => __( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'slider_nav_border_hover',
			'selector' => '{{WRAPPER}} .owl-nav button:not(.disabled):hover',
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'slider_nav_box_shadow_hover',
			'selector' => '{{WRAPPER}} .owl-nav button:hover',
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->add_control(
		'heading_dot',
		array(
			'label'     => __( 'Dot Options', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim_vt',
		array(
			'label'      => __( 'Position Vertical', 'molla-core' ),
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
				'slider_nav_pos!' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim_hz',
		array(
			'label'      => __( 'Position Horizontal', 'molla-core' ),
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
				'slider_nav_pos!' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim',
		array(
			'label'              => __( 'Position', 'molla-core' ),
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
				'slider_nav_pos' => array( '' ),
			),
		)
	);

	$self->start_controls_tabs( 'tabs_dot_color' );
	$self->start_controls_tab(
		'tab_dot_color',
		array(
			'label' => __( 'Normal', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color',
		array(
			'label'     => __( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color',
		array(
			'label'     => __( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_dot_color_hover',
		array(
			'label' => __( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color_hover',
		array(
			'label'     => __( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color_hover',
		array(
			'label'     => __( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_dot_color_active',
		array(
			'label' => __( 'Active', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color_active',
		array(
			'label'     => __( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color_active',
		array(
			'label'     => __( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->end_controls_section();
}


function molla_column_class( $self ) {

	$settings = $self->get_settings_for_display();

	$args        = array();
	$classes     = array();
	$column_args = array();
	$widget_args = array();

	global $molla_section;

	if ( isset( $molla_section['section'] ) && 'creative' == $molla_section['section'] && $molla_section['top'] == $self->get_data( 'isInner' ) ) {

		if ( $settings['creative_category'] ) {
			$cat_title = $settings['creative_category'];
			$cat_slug  = str_replace( ' ', '-', strtolower( $settings['creative_category'] ) );
			if ( false === array_search( $cat_title, $molla_section['categories'] ) ) {
				$molla_section['categories'][] = $cat_title;
			}
		}

		$idx       = $molla_section['index'];
		$classes[] = 'grid-item';

		if ( isset( $cat_slug ) ) {
			$classes[] = $cat_slug;
		}

		if ( $settings['creative_category'] ) {
			$grid = array();
		}
		if ( $settings['creative_width'] ) {
			$grid['w'] = $settings['creative_width'];

			if ( $settings['creative_width_tablet'] ) {
				$grid['w-l'] = $settings['creative_width_tablet'];
			}
			if ( $settings['creative_width_mobile'] ) {
				$grid['w-m'] = $settings['creative_width_mobile'];
			}
		} elseif ( $idx < count( $molla_section['preset'] ) ) {
			foreach ( $molla_section['preset'][ $idx ] as $key => $value ) {
				if ( 'h' == $key ) {
					continue;
				}

				$grid[ $key ] = $value;
			}
		} else {
			$grid['w']   = '1-4';
			$grid['w-l'] = '1-2';
		}

		if ( 'preset' == $settings['creative_height'] ) {
			$grid['h'] = $idx < count( $molla_section['preset'] ) ? $molla_section['preset'][ $idx ]['h'] : '1-3';
		} elseif ( 'child' != $settings['creative_height'] ) {
			$grid['h'] = $settings['creative_height'];
		}

		if ( $settings['creative_height_tablet'] && 'preset' != $settings['creative_height_tablet'] && 'child' != $settings['creative_height_tablet'] ) {
			$grid['h-l'] = $settings['creative_height_tablet'];
		}
		if ( $settings['creative_height_mobile'] && 'preset' != $settings['creative_height_mobile'] && 'child' != $settings['creative_height_mobile'] ) {
			$grid['h-m'] = $settings['creative_height_mobile'];
		}

		if ( $settings['creative_order'] ) {
			$args['data-creative-order'] = $settings['creative_order'];
		} else {
			$args['data-creative-order'] = $idx + 1;
		}
		if ( $settings['creative_order_tablet'] ) {
			$args['data-creative-order-lg'] = $settings['creative_order_tablet'];
		} else {
			$args['data-creative-order-lg'] = $idx + 1;
		}
		if ( $settings['creative_order_mobile'] ) {
			$args['data-creative-order-md'] = $settings['creative_order_mobile'];
		} else {
			$args['data-creative-order-md'] = $idx + 1;
		}

		foreach ( $grid as $key => $value ) {
			if ( $settings['creative_width'] && false !== strpos( $key, 'w' ) ) {
				if ( 0 == 100 % $value ) {
					$grid[ $key ] = '1-' . ( 100 / $value );
				} else {
					for ( $i = 1; $i <= 100; ++$i ) {
						$val       = $value * $i;
						$val_round = round( $val );
						if ( abs( round( $val - $val_round, 2, PHP_ROUND_HALF_UP ) ) <= 0.01 ) {
							$g            = molla_get_gcd( 100, $val_round );
							$grid[ $key ] = ( $val_round / $g ) . '-' . ( $i * 100 / $g );
							break;
						}
					}
				}
			}
		}

		$molla_section['layout'][ $idx ] = $grid;
		foreach ( $grid as $key => $value ) {
			if ( $value ) {
				$classes[] = $key . '-' . $value;
			}
		}
		$molla_section['index'] = ++$idx;
	}

	if ( 'banner' == $settings['column_type'] ) {
		$t_x = $settings['t_x_pos'];
		$t_y = $settings['t_y_pos'];

		$classes[]             = 'banner-content';
		$column_args['class']  = 'molla-elementor-column-wrap';
		$column_args['class'] .= ' t-x-' . $t_x;
		$column_args['class'] .= ' t-y-' . $t_y;
	} elseif ( 'tab' == $settings['column_type'] ) {
		global $molla_section;

		$classes[] = 'tab-pane';
		if ( isset( $molla_section['section'] ) ) {
			$molla_section['tab_data'][] = array(
				'title' => $settings['tab_title'],
				'id'    => $self->get_data( 'id' ),
			);

			if ( 'tab' == $molla_section['section'] && 0 == $molla_section['index'] ) {
				$classes[] = 'active';
			}
			$molla_section['index'] = ++$molla_section['index'];
		}
	} elseif ( 'accordion' == $settings['column_type'] ) {
		global $molla_section;

		if ( isset( $molla_section['section'] ) && 'accordion' == $molla_section['section'] ) {
			$a_class  = 'panel-body';
			$a_class .= ' collapse';
			if ( 0 == $molla_section['index'] ) {
				$a_class .= ' show';
			}

			?>
			<div class="accordion-panel">
				<div class="panel-header">
					<a href="#" role="button" data-toggle="collapse" data-target="#panel-<?php echo esc_attr( $self->get_data( 'id' ) ); ?>" class="<?php echo esc_attr( 0 == $molla_section['index'] ? '' : 'collapsed' ); ?>">
					<?php
					if ( $settings['accordion_header_icon']['value'] ) {
						echo '<i class="' . $settings['accordion_header_icon']['value'] . '"></i>';
					}

						echo '<span class="title">' . esc_html( $settings['accordion_title'] ) . '</span>';

					if ( $molla_section['active_icon']['value'] ) {
						echo '<span class="opened"><i class="' . $molla_section['active_icon']['value'] . '"></i></span>';
					}
					if ( $molla_section['icon']['value'] ) {
						echo '<span class="closed"><i class="' . $molla_section['icon']['value'] . '"></i></span>';
					}
					?>
					</a>
				</div>
				<div id="panel-<?php echo esc_attr( $self->get_data( 'id' ) ); ?>" data-parent="#accordion-<?php echo esc_attr( $molla_section['parent_id'] ); ?>" class="<?php echo esc_attr( $a_class ); ?> ">
			<?php

			$molla_section['index'] = ++$molla_section['index'];
		}
	} elseif ( 'slider' == $settings['column_type'] ) {
		wp_enqueue_script( 'owl-carousel' );
		do_action( 'molla_save_used_widget', 'slider' );

		$slider_active = true;
		$options       = array();
		$spacing       = '' !== $settings['spacing']['size'] ? intval( $settings['spacing']['size'] ) : 20;

		$options['margin']   = $spacing;
		$options['loop']     = 'yes' == $settings['slider_loop'] ? true : false;
		$options['autoplay'] = 'yes' == $settings['slider_auto_play'] ? true : false;
		if ( $options['autoplay'] ) {
			$options['autoplayTimeout'] = $settings['slider_auto_play_time'];
		}

		$options['autoHeight'] = 'yes' == $settings['slider_auto_height'] ? true : false;
		if ( 'default' != $settings['slider_animation_in'] || 'default' != $settings['slider_animation_out'] ) {

			wp_enqueue_style( 'animate' );

			if ( 'default' != $settings['slider_animation_in'] ) {
				$options['animateIn'] = $settings['slider_animation_in'];
			}
			if ( 'default' != $settings['slider_animation_out'] ) {
				$options['animateOut'] = $settings['slider_animation_out'];
			}
		}
		$owl_options           = array(
			0   => array(
				'items' => $settings['cols_under_mobile'],
				'dots'  => $settings['slider_dot_mobile'],
				'nav'   => $settings['slider_nav_mobile'],
			),
			576 => array(
				'items' => $settings['cols_mobile'],
				'dots'  => $settings['slider_dot_mobile'],
				'nav'   => $settings['slider_nav_mobile'],
			),
			768 => array(
				'items' => $settings['cols_tablet'],
				'dots'  => $settings['slider_dot_tablet'],
				'nav'   => $settings['slider_nav_tablet'],
			),
			992 => array(
				'items' => $settings['cols'],
				'dots'  => $settings['slider_dot'],
				'nav'   => $settings['slider_nav'],
			),
		);
		$options['responsive'] = $owl_options;
		$col_classes           = '';
		if ( defined( 'MOLLA_VERSION' ) ) {
			$options['responsive'] = molla_carousel_options( $owl_options );
			$col_classes           = molla_carousel_responsive_classes( $options['responsive'] );
		}

		$options = json_encode( $options );

		$widget_args['class']            = 'molla-elementor-column-wrap owl-carousel owl-simple' . esc_attr( ( $settings['slider_nav_pos'] ? ' ' . $settings['slider_nav_pos'] : '' ) ) . esc_attr( ( $settings['slider_nav_type'] ? ' ' . $settings['slider_nav_type'] : '' ) ) . esc_attr( $col_classes ) . esc_attr( 'yes' != $settings['slider_nav_show'] ? ' owl-nav-show' : '' ) . ' sp-' . $spacing;
		$widget_args['data-toggle']      = 'owl';
		$widget_args['data-owl-options'] = $options;
	}

	if ( defined( 'MOLLA_VERSION' ) ) {
		if ( ! is_admin() && ! is_customize_preview() && ! molla_ajax() && molla_option( 'lazy_load_img' ) &&
			isset( $settings['background_image']['url'] ) && $settings['background_image']['url'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'molla-lazyload-back' ) ) {

			$column_args['class']    = isset( $column_args['class'] ) ? ( $column_args['class'] . ' molla-lazyload-back' ) : ' molla-lazyload-back';
			$column_args['data-src'] = $settings['background_image']['url'];
			if ( $settings['background_color'] ) {
				$column_args['style'] = 'background-color: ' . $settings['background_color'];
			} else {
				$column_args['style'] = 'background-color: ' . molla_option( 'lazy_load_img_back' );
			}
		}
	}

	$args['class'] = $classes;

	$is_legacy_mode = ! method_exists( Elementor\Plugin::instance(), 'get_legacy_mode' ) || Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' );

	if ( $is_legacy_mode ) {
		$self->add_render_attribute(
			array(
				'_wrapper'        => $args,
				'_inner_wrapper'  => $column_args,
				'_widget_wrapper' => $widget_args,
			)
		);
	} else {
		if ( isset( $column_args['class'] ) && isset( $widget_args['class'] ) ) {
			$column_args['class'] .= $widget_args['class'];
		}
		$widget_args = array_merge( $widget_args, $column_args );
		$self->add_render_attribute(
			array(
				'_wrapper'        => $args,
				'_widget_wrapper' => $widget_args,
			)
		);
	}

}

function molla_column_class_after( $self ) {
	$settings = $self->get_settings_for_display();

	if ( 'accordion' == $settings['column_type'] ) {
		global $molla_section;

		if ( isset( $molla_section['section'] ) && 'accordion' == $molla_section['section'] ) {
			?>
				</div>
			</div>
			<?php
		}
	}
}

function molla_column_print( $template_content, $self ) {
	ob_start();
	?>

	<# if ( 'slider' == settings.column_type ) { #>

	<?php wp_enqueue_script( 'owl-carousel' ); ?>

		<# if ( 'default' != settings.slider_animation_in || 'default' != settings.slider_animation_out ) {

		<?php wp_enqueue_style( 'animate' ); ?>

		} #>
		
	<# }

		let wrap_class = ' molla-elementor-column-wrap';
		let wrap_op = '';

		options = {};
		if ( settings.creative_width ) {
			options['w'] = settings.creative_width;

			if ( settings.creative_width_tablet ) {
				options['w-l'] = settings.creative_width_tablet;
			}
			if ( settings.creative_width_mobile ) {
				options['w-m'] = settings.creative_width_mobile;
			}
		} else {
			options['w'] = 'preset';
		}

		if ( 'child' != settings.creative_height ) {
		options['h'] = settings.creative_height;
		}
		if ( settings.creative_height_tablet && 'preset' != settings.creative_height_tablet && 'child' != settings.creative_height_tablet ) {
			options['h-l'] = settings.creative_height_tablet;
		}
		if ( settings.creative_height_mobile && 'preset' != settings.creative_height_mobile && 'child' != settings.creative_height_mobile ) {
			options['h-m'] = settings.creative_height_mobile;
		}

		if ( settings.creative_order ) {
			wrap_op += ' data-creative-order="' + settings.creative_order + '"';
		}
		if ( settings.creative_order_tablet ) {
			wrap_op += ' data-creative-order-lg="' + settings.creative_order_tablet + '"';
		}
		if ( settings.creative_order_mobile ) {
			wrap_op += ' data-creative-order-md="' + settings.creative_order_mobile + '"';
		}

		if (settings.creative_category) {
			wrap_op += ' data-creative-cat-title="' + settings.creative_category + '"';
		}		

		wrap_op += 'data-creative-item=' + JSON.stringify(options);

		if ( 'banner' == settings.column_type ) {
			wrap_op += ' data-banner-class="' + 'banner-content t-x-' + settings.t_x_pos + ' t-y-' + settings.t_y_pos + '"';
		} else if ( 'tab' == settings.column_type ) {
			wrap_op += ' data-tab-title="' + settings.tab_title + '"';
			wrap_op += ' data-role="tab-content"';
		} else if ( 'accordion' == settings.column_type ) {
			wrap_op += ' data-accordion-title="' + settings.accordion_title + '"';
			wrap_op += ' data-accordion-icon="' + ( settings.accordion_header_icon ? settings.accordion_header_icon.value : '' ) + '"';
		} else if ( 'slider' == settings.column_type ) {
			let owl_option_ary = {},
				spacing = '' !== settings.spacing.size ? parseInt( settings.spacing.size ) : 20,
				owl_cols = {};

			if ( settings.cols > 4 ) {
				owl_cols = {
					'xl': settings.cols,
					'lg': 4,
					'md': 3,
					'sm': 2,
					'xs': 2,
				};
			} else if ( 4 == settings.cols ) {
				owl_cols = {
					'xl': 4,
					'lg': 4,
					'md': 3,
					'sm': 2,
					'xs': 2,
				};
			} else if ( 3 == settings.cols ) {
				owl_cols = {
					'xl': 3,
					'lg': 3,
					'md': 2,
					'sm': 2,
					'xs': 1,
				};
			} else if ( 2 == settings.cols ) {
				owl_cols = {
					'xl': 2,
					'lg': 2,
					'md': 1,
					'sm': 1,
					'xs': 1,
				};
			} else if ( 1 == settings.cols ) {
				owl_cols = {
					'xl': 1,
					'lg': 1,
					'md': 1,
					'sm': 1,
					'xs': 1,
				};
			}

			if ( settings.cols_upper_desktop ) {
				owl_cols['xl'] = settings.cols_upper_desktop;
			}
			if ( settings.cols_tablet ) {
				owl_cols['md'] = settings.cols_tablet;
			}
			if ( settings.cols_mobile ) {
				owl_cols['sm'] = settings.cols_mobile;
			}
			if ( settings.cols_under_mobile ) {
				owl_cols['xs'] = settings.cols_under_mobile;
			}

			wrap_class += ' owl-carousel owl-simple ' + settings.slider_nav_pos + ' ' + settings.slider_nav_type + ( 'yes' != settings.slider_nav_show ? ' owl-nav-show' : '' ) +
						' c-xl-' + owl_cols['xl'] +
						' c-lg-' + owl_cols['lg'] +
						' c-md-' + owl_cols['md'] +
						' c-sm-' + owl_cols['sm'] +
						' c-xs-' + owl_cols['xs'] +
						' sp-' + spacing;
			wrap_op += ' data-toggle="owl"';
			owl_option_ary = {
				margin: spacing,
				loop: 'yes' == settings.slider_loop ? true : false,
				autoplay: 'yes' == settings.slider_auto_play ? true : false,
				autoplayTimeout: settings.slider_auto_play_time,
				autoHeight: 'yes' == settings.slider_auto_height ? true : false,
				animateIn: 'default' != settings.slider_animation_in ? settings.slider_animation_in : '',
				animateOut: 'default' != settings.slider_animation_out ? settings.slider_animation_out : '',
				responsive: {
					0 : {
						items : parseInt(owl_cols['xs']),
						dots : 'yes' == settings.slider_dot_mobile ? true : false,
						nav : 'yes' == settings.slider_nav_mobile ? true : false,
					},
					576 : {
						items : parseInt(owl_cols['sm']),
						dots : 'yes' == settings.slider_dot_mobile ? true : false,
						nav : 'yes' == settings.slider_nav_mobile ? true : false,
					},
					768 : {
						items : parseInt(owl_cols['md']),
						dots : 'yes' == settings.slider_dot_tablet ? true : false,
						nav : 'yes' == settings.slider_nav_tablet ? true : false,
					},
					992 : {
						items : parseInt(owl_cols['lg']),
						dots : 'yes' == settings.slider_dot ? true : false,
						nav : 'yes' == settings.slider_nav ? true : false,
					},
					1200 : {
						items : parseInt(owl_cols['xl']),
						dots : 'yes' == settings.slider_dot ? true : false,
						nav : 'yes' == settings.slider_nav ? true : false,
					}
				}
			};
			owl_option_ary = JSON.stringify( owl_option_ary );
			wrap_op += ' data-owl-options=' + owl_option_ary;
		}
	#>
	<?php

	$is_legacy_mode = ! method_exists( Elementor\Plugin::instance(), 'get_legacy_mode' ) || Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' );

	?>
	<?php if ( $is_legacy_mode ) : ?>
	<div class="elementor-column-wrap">
	<?php else : ?>
	<div class="elementor-widget-wrap{{ wrap_class }}"{{{ wrap_op }}}>
	<?php endif; ?>
		<div class="elementor-background-overlay"></div>
		<?php if ( $is_legacy_mode ) : ?>
			<div class="elementor-widget-wrap{{ wrap_class }}"{{{ wrap_op }}}></div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
