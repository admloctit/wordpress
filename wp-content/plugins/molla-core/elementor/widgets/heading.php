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
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;

class Molla_Elementor_Heading_Widget extends \Elementor\Widget_Heading {

	public function get_name() {
		return 'molla_heading';
	}

	public function get_title() {
		return esc_html__( 'Molla Heading', 'molla-core' );
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'heading', 'title', 'subtitle' );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->start_controls_section(
			'section_heading_extra',
			array(
				'label' => esc_html__( 'Subtitle & Link', 'molla-core' ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Subtitle text here..', 'molla-core' ),
			)
		);

		$this->add_control(
			'subtitle_tag',
			array(
				'label'   => esc_html__( 'Subtitle HTML Tag', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
			)
		);

		$this->add_control(
			'show_subtitle',
			array(
				'label'   => esc_html__( 'Show Subtitle', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'link_html',
			array(
				'label'     => esc_html__( 'Link', 'molla-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'   => esc_html__( 'Link Url', 'molla-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'molla-core' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'   => esc_html__( 'Icon Position', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'after'  => esc_html__( 'After', 'molla-core' ),
					'before' => esc_html__( 'Before', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'icon_space',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .icon-before i' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .icon-after i'  => 'margin-left: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
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
			'show_link',
			array(
				'label'   => esc_html__( 'Show Link', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'link_before',
			array(
				'label'     => esc_html__( 'Link before title', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'heading_align' => array(
						'flex-start',
						'center',
						'flex-end',
						'space-between',
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_type',
			array(
				'label' => esc_html__( 'Type', 'molla-core' ),
			)
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label'     => esc_html__( 'Heading Layout', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'      => [
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Justified', 'molla-core' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .heading' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'decoration_type',
			array(
				'label'     => esc_html__( 'Decoration Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''              => 'None',
					't-decor-both'  => esc_html__( 'Both', 'molla-core' ),
					't-decor-left'  => esc_html__( 'Left', 'molla-core' ),
					't-decor-right' => esc_html__( 'Right', 'molla-core' ),
				),
				'condition' => array(
					'heading_align' => array(
						'',
					),
				),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			[
				'label'              => esc_html__( 'Decoration Spacing', 'molla-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'horizontal',
				'size_units'         => array(
					'px',
					'em',
					'%',
				),
				'selectors'          => array(
					'{{WRAPPER}} .heading:before' => 'margin-right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .heading:after'  => 'margin-left: {{LEFT}}{{UNIT}};',
				),
				'condition'          => array(
					'heading_align' => array(
						'',
					),
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_subtitle',
			array(
				'label' => esc_html__( 'Subtitle', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Text Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .heading-subtitle',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .heading-subtitle',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_link',
			array(
				'label' => esc_html__( 'Link', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .title-link',
			)
		);

		$this->start_controls_tabs( 'tabs_heading_link' );

		$this->start_controls_tab(
			'tab_link_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);
		$this->add_control(
			'link_color_normal',
			array(
				'label'     => esc_html__( 'Text Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .title-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'link_shadow_normal',
				'selector' => '{{WRAPPER}} .title-link',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'link_box_shadow_normal',
				'selector' => '{{WRAPPER}} .title-link',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);
		$this->add_control(
			'link_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .title-link:hover, {{WRAPPER}} .title-link:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'link_shadow_hover',
				'selector' => '{{WRAPPER}} .title-link:hover, {{WRAPPER}} .title-link:focus',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'link_box_shadow_hover',
				'selector' => '{{WRAPPER}} .title-link:hover, {{WRAPPER}} .title-link:focus',
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_divider',
			array(
				'label' => esc_html__( 'Divider', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading:before, {{WRAPPER}} .heading:after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'divider_height',
			array(
				'label'     => esc_html__( 'Height', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 15,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .heading:before, {{WRAPPER}} .heading:after' => 'height: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'divider_box_shadow',
				'selector' => '{{WRAPPER}} .heading:before, {{WRAPPER}} .heading:after',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dimensions',
			array(
				'label' => esc_html__( 'Dimensions', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_wrap_margin',
			array(
				'label'      => esc_html__( 'Title Wrapper Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Title Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'condition'  => array(
					'show_subtitle' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-content .elementor-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Title & Subtitle Content Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'condition'  => array(
					'show_subtitle' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'subtitle_margin',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'condition'  => array(
					'show_subtitle' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'link_margin',
			array(
				'label'      => esc_html__( 'Link Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'condition'  => array(
					'show_link' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'link_padding',
			array(
				'label'      => esc_html__( 'Link Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'condition'  => array(
					'show_link' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_backs',
			array(
				'label' => esc_html__( 'Backgrounds', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_background',
			array(
				'label'     => esc_html__( 'Title Wrapper', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_background',
			array(
				'label'     => esc_html__( 'Title & Subtitle Content', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		echo '<div class="heading' . ( $settings['decoration_type'] ? ' ' . $settings['decoration_type'] : '' ) . '">';
		if ( $settings['title'] || ( $settings['subtitle'] && 'yes' == $settings['show_subtitle'] ) ) {
			echo '<div class="heading-content">';
		}
		parent::render();

		$atts = $this->get_settings_for_display();
		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_heading.php';
	}

	protected function _content_template() {
	}

}
