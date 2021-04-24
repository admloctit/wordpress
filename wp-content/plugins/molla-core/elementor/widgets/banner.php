<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Molla Banner Widget
 *
 * Molla Widget to display banner.
 *
 * @since 1.1
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Molla_Elementor_Banner_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_banner';
	}

	public function get_title() {
		return esc_html__( 'Molla Banner', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'banner' );
	}

	public function get_script_depends() {
		return array( 'molla-elementor-widgets-js' );
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'section_banner_items',
			array(
				'label' => esc_html__( 'Items', 'molla-core' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'banner_item_type',
			array(
				'label'   => esc_html__( 'Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => array(
					'text'   => esc_html__( 'Text', 'molla-core' ),
					'button' => esc_html__( 'Button', 'molla-core' ),
					'image'  => esc_html__( 'Image', 'molla-core' ),
				),
			)
		);

		$repeater->add_control(
			'banner_item_display',
			array(
				'label'   => esc_html__( 'Width', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => array(
					'block'  => esc_html__( 'Default', 'molla-core' ),
					'inline' => esc_html__( 'Inline', 'molla-core' ),
				),
			)
		);

		$repeater->add_control(
			'banner_item_aclass',
			array(
				'label' => esc_html__( 'Custom Class', 'molla-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$repeater->add_responsive_control(
			'banner_item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

			/* Text Item */
			$repeater->add_control(
				'banner_text_content',
				array(
					'label'     => esc_html__( 'Content', 'molla-core' ),
					'type'      => Controls_Manager::TEXTAREA,
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			$repeater->add_control(
				'banner_text_tag',
				array(
					'label'     => esc_html__( 'Tag', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'h2',
					'options'   => array(
						'h1'   => esc_html__( 'H1', 'molla-core' ),
						'h2'   => esc_html__( 'H2', 'molla-core' ),
						'h3'   => esc_html__( 'H3', 'molla-core' ),
						'h4'   => esc_html__( 'H4', 'molla-core' ),
						'h5'   => esc_html__( 'H5', 'molla-core' ),
						'h6'   => esc_html__( 'H6', 'molla-core' ),
						'p'    => esc_html__( 'p', 'molla-core' ),
						'div'  => esc_html__( 'div', 'molla-core' ),
						'span' => esc_html__( 'span', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_item_text_align',
				array(
					'label'     => esc_html__( 'Alignment', 'molla-core' ),
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
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
					),
				)
			);

			$repeater->add_control(
				'banner_text_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'banner_item_type' => 'text',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'banner_text_typo',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => array(
						'banner_item_type!' => 'image',
					),
					'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}',
				)
			);

			/* Button */
			$repeater->add_control(
				'banner_btn_text',
				array(
					'label'     => esc_html__( 'Text', 'molla-core' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_link',
				array(
					'label'     => esc_html__( 'Link Url', 'molla-core' ),
					'type'      => Controls_Manager::URL,
					'default'   => array(
						'url' => '',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_btn_padding',
				array(
					'label'      => esc_html__( 'Button Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array( 'px', 'em', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'banner_item_type' => 'button',
					),
				)
			);
			$repeater->add_control(
				'banner_btn_type',
				array(
					'label'     => esc_html__( 'Type', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''            => esc_html__( 'Default', 'molla-core' ),
						'btn-outline' => esc_html__( 'Outline', 'molla-core' ),
						'btn-link'    => esc_html__( 'Link', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_size',
				array(
					'label'     => esc_html__( 'Size', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'btn-md',
					'options'   => array(
						'btn-sm' => esc_html__( 'Small', 'molla-core' ),
						'btn-md' => esc_html__( 'Normal', 'molla-core' ),
						'btn-lg' => esc_html__( 'Large', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_skin',
				array(
					'label'     => esc_html__( 'Skin', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'btn-primary',
					'options'   => array(
						'btn-primary'   => esc_html__( 'Primary', 'molla-core' ),
						'btn-secondary' => esc_html__( 'Secondary', 'molla-core' ),
						'btn-alert'     => esc_html__( 'Alert', 'molla-core' ),
						'btn-dark'      => esc_html__( 'Dark', 'molla-core' ),
						'btn-light'     => esc_html__( 'Light', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_shadow',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Box Shadow', 'molla-core' ),
					'default'   => '',
					'options'   => array(
						''                 => esc_html__( 'None', 'molla-core' ),
						'btn-shadow-hover' => esc_html__( 'Shadow 1', 'molla-core' ),
						'btn-shadow'       => esc_html__( 'Shadow 2', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_border',
				array(
					'label'     => esc_html__( 'Border Style', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''            => esc_html__( 'Square', 'molla-core' ),
						'btn-rounded' => esc_html__( 'Rounded', 'molla-core' ),
						'btn-round'   => esc_html__( 'Ellipse', 'molla-core' ),
					),
					'condition' => array(
						'banner_btn_type!' => 'btn-link',
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_line_break',
				array(
					'label'     => esc_html__( 'Disable Line-break', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'nowrap',
					'options'   => array(
						'nowrap' => array(
							'title' => esc_html__( 'On', 'molla-core' ),
							'icon'  => 'eicon-h-align-right',
						),
						'normal' => array(
							'title' => esc_html__( 'Off', 'molla-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn' => 'white-space: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_icon',
				array(
					'label'     => esc_html__( 'Icon', 'molla-core' ),
					'type'      => Controls_Manager::ICONS,
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_icon_pos',
				array(
					'label'     => esc_html__( 'Icon Position', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'after',
					'options'   => array(
						'after'  => esc_html__( 'After', 'molla-core' ),
						'before' => esc_html__( 'Before', 'molla-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_icon_space',
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
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.icon-before i' => 'margin-right: {{SIZE}}px;',
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.icon-after i'  => 'margin-left: {{SIZE}}px;',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_icon_size',
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
						'.elementor-element-{{ID}} {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}px;',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_show_icon',
				array(
					'label'     => esc_html__( 'Show Icon on Hover', 'molla-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'no',
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->start_controls_tabs( 'tabs_btn_color' );

			$repeater->start_controls_tab(
				'tab_btn_normal',
				array(
					'label'     => esc_html__( 'Normal', 'molla-core' ),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_btn_hover',
				array(
					'label'     => esc_html__( 'Hover', 'molla-core' ),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_color_hover',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_back_color_hover',
				array(
					'label'     => esc_html__( 'Background Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_border_color_hover',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:hover' => 'border-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_btn_active',
				array(
					'label'     => esc_html__( 'Active', 'molla-core' ),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_color_active',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}:focus' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_back_color_active',
				array(
					'label'     => esc_html__( 'Background Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}:focus' => 'background-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'btn_border_color_active',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}:focus' => 'border-color: {{VALUE}};',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$repeater->add_responsive_control(
				'banner_btn_border_width',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_btn_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			/* Image */
			$repeater->add_control(
				'banner_image',
				array(
					'label'     => esc_html__( 'Choose Image', 'molla-core' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'banner_image',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$presets = array(
				array(
					'_id'                 => 'heading',
					'banner_item_type'    => 'text',
					'banner_item_display' => 'block',
					'banner_text_content' => 'This is a simple banner',
					'banner_text_tag'     => 'h3',
					'banner_text_color'   => '#fff',
				),
				array(
					'_id'                 => 'text',
					'banner_item_type'    => 'text',
					'banner_item_display' => 'block',
					'banner_text_content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <br/>euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
					'banner_text_tag'     => 'p',
					'banner_text_color'   => '#fff',
				),
				array(
					'_id'                 => 'button',
					'banner_item_type'    => 'button',
					'banner_item_display' => 'inline',
					'banner_btn_text'     => 'Click here',
					'banner_btn_type'     => 'btn-outline',
					'banner_btn_skin'     => 'btn-light',
				),
			);

			$repeater->add_responsive_control(
				'animation',
				array(
					'label'              => esc_html__( 'Entrance Animation', 'molla-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
					'separator'          => 'before',
				)
			);

		$repeater->add_control(
			'animation_duration',
			array(
				'label'        => esc_html__( 'Animation Duration', 'molla-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					'slow' => esc_html__( 'Slow', 'molla-core' ),
					''     => esc_html__( 'Normal', 'molla-core' ),
					'fast' => esc_html__( 'Fast', 'molla-core' ),
				),
				'prefix_class' => 'animated-',
				'condition'    => array(
					'animation!' => '',
				),
			)
		);

		$repeater->add_control(
			'animation_delay',
			array(
				'label'              => esc_html__( 'Animation Delay', 'molla-core' ) . ' (ms)',
				'type'               => Controls_Manager::NUMBER,
				'default'            => '',
				'min'                => 0,
				'step'               => 100,
				'condition'          => array(
					'animation!' => '',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'banner_item_list',
			array(
				'label'   => esc_html__( 'Banner Items', 'molla-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => $presets,
			)
		);

		$this->end_controls_section();

		/* Banner Style */
		$this->start_controls_section(
			'section_banner_style',
			array(
				'label' => esc_html__( 'Style', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_control(
				'img_back_style',
				array(
					'label'       => esc_html__( 'Use image as background style', 'molla-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Once you have enabled this option, your banner size is initially set as image size.', 'molla-core' ),
					'default'     => 'no',
				)
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'           => 'banner_background',
					'types'          => array( 'classic', 'gradient' ),
					'selector'       => '{{WRAPPER}} .banner',
					'fields_options' => array(
						'background' => array(
							'frontend_available' => true,
							'default'            => 'classic',
						),
						'color'      => array(
							'default' => '#c96',
							'dynamic' => array(),
						),
						'color_b'    => array(
							'dynamic' => array(),
						),
					),
				)
			);

			$this->add_control(
				'banner_height_heading',
				array(
					'label'     => esc_html__( 'Height', 'molla-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'banner_stretch',
				array(
					'label'       => esc_html__( 'Stretch Height', 'molla-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'You can make your banner height full of it\'s wrapper.' ),
					'default'     => 'no',
				)
			);

			$this->add_responsive_control(
				'banner_max_height',
				array(
					'label'      => esc_html__( 'Max Height', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner, .elementor-element-{{ID}} img' => 'max-height:{{SIZE}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$this->add_responsive_control(
				'banner_min_height',
				array(
					'label'      => esc_html__( 'Min Height', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'unit' => 'px',
						'size' => 450,
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner' => 'min-height:{{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .banner-img > img' => 'min-height:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'banner_effect_heading',
				array(
					'label'     => esc_html__( 'Hover Effects', 'molla-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'banner_hover_scale',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Scale', 'molla-core' ),
					'condition' => array(
						'img_back_style!' => 'yes',
					),
				)
			);

			$this->add_control(
				'banner_hover_effect',
				array(
					'label'       => esc_html__( 'Overlay', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'description' => esc_html__( 'You could choose one of overlays to show when you hover your banner.', 'molla-core' ),
					'options'     => array(
						''                     => esc_html__( 'No Overlay', 'molla-core' ),
						'banner-hover-default' => esc_html__( 'Default', 'molla-core' ),
						'banner-hover-1'       => esc_html__( 'Overlay 1', 'molla-core' ),
						'banner-hover-2'       => esc_html__( 'Overlay 2', 'molla-core' ),
						'banner-hover-3'       => esc_html__( 'Overlay 3', 'molla-core' ),
						'banner-hover-4'       => esc_html__( 'Overlay 4', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'banner_overlay_color',
				array(
					'label'     => esc_html__( 'Overlay Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .banner .banner-overlay:before, .elementor-element-{{ID}} .banner .banner-overlay:after' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'banner_hover_effect!' => '',
					),
				)
			);

			$this->add_control(
				'banner_more_heading',
				array(
					'label'     => esc_html__( 'More ...', 'molla-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'banner_img_pos',
				array(
					'label'     => esc_html__( 'Image Position (%)', 'molla-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'%' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .banner-img img' => 'object-position: {{SIZE}}%;',
					),
					'condition' => array(
						'img_back_style!' => 'yes',
					),
				)
			);

			$this->add_control(
				'parallax',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Enable Parallax', 'molla-core' ),
					'condition' => array(
						'img_back_style' => 'yes',
					),
				)
			);

			$this->add_control(
				'parallax_speed',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Parallax Speed', 'molla-core' ),
					'default'   => array(
						'size' => 1,
						'unit' => 'px',
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'condition' => array(
						'img_back_style' => 'yes',
						'parallax'       => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'banner_layer_layout',
			array(
				'label' => esc_html__( 'Banner Layer', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_control(
				'banner_wrap',
				array(
					'label'   => esc_html__( 'Wrap with', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''                => esc_html__( 'None', 'molla-core' ),
						'container'       => esc_html__( 'Container', 'molla-core' ),
						'container-fluid' => esc_html__( 'Container fluid', 'molla-core' ),
					),
				)
			);
			$this->add_responsive_control(
				'banner_content_padding',
				array(
					'label'      => esc_html__( 'Content Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_control(
				'banner_content_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .banner .banner-content-inner' => 'background: {{VALUE}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'banner_content_shadow',
					'selector' => '.elementor-element-{{ID}} .banner .banner-content-inner',
				)
			);
			$this->add_responsive_control(
				'banner_text_align',
				array(
					'label'     => esc_html__( 'Text Align', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
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
						'.elementor-element-{{ID}} .banner .banner-content-inner' => 'text-align: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				't_x_pos',
				array(
					'label'   => __( 'X Align', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'center',
					'options' => array(
						'left'   => __( 'Default', 'molla-core' ),
						'center' => __( 'Center', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				't_y_pos',
				array(
					'label'   => __( 'Y Align', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'center',
					'options' => array(
						'top'    => __( 'Default', 'molla-core' ),
						'center' => __( 'Center', 'molla-core' ),
					),
				)
			);

			$this->start_controls_tabs( 'banner_position_tabs' );

			$this->start_controls_tab(
				'banner_pos_left_tab',
				array(
					'label' => esc_html__( 'Left', 'molla-core' ),
				)
			);

			$this->add_responsive_control(
				'banner_left',
				array(
					'label'      => esc_html__( 'Left', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'left:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'banner_pos_top_tab',
				array(
					'label' => esc_html__( 'Top', 'molla-core' ),
				)
			);

			$this->add_responsive_control(
				'banner_top',
				array(
					'label'      => esc_html__( 'Top', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'top:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'banner_pos_right_tab',
				array(
					'label' => esc_html__( 'Right', 'molla-core' ),
				)
			);

			$this->add_responsive_control(
				'banner_right',
				array(
					'label'      => esc_html__( 'Right', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'right:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'banner_pos_bottom_tab',
				array(
					'label' => esc_html__( 'Bottom', 'molla-core' ),
				)
			);

			$this->add_responsive_control(
				'banner_bottom',
				array(
					'label'      => esc_html__( 'Bottom', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'banner_width',
				array(
					'label'      => esc_html__( 'Width', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'max-width:{{SIZE}}{{UNIT}}; width: 100%',
					),
				)
			);

			$this->add_responsive_control(
				'banner_height',
				array(
					'label'      => esc_html__( 'Height', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'height:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_animation',
				array(
					'label'              => esc_html__( 'Entrance Animation', 'molla-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
					'separator'          => 'before',
				)
			);

			$this->add_control(
				'content_animation_duration',
				array(
					'label'        => esc_html__( 'Animation Duration', 'molla-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						'slow' => esc_html__( 'Slow', 'molla-core' ),
						''     => esc_html__( 'Normal', 'molla-core' ),
						'fast' => esc_html__( 'Fast', 'molla-core' ),
					),
					'prefix_class' => 'animated-',
					'condition'    => array(
						'content_animation!' => '',
					),
				)
			);

			$this->add_control(
				'content_animation_delay',
				array(
					'label'              => esc_html__( 'Animation Delay', 'molla-core' ) . ' (ms)',
					'type'               => Controls_Manager::NUMBER,
					'default'            => '',
					'min'                => 0,
					'step'               => 100,
					'condition'          => array(
						'content_animation!' => '',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title' );

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_banner.php';
	}

	public function before_render() {
		// Lazyload background image
		$atts = $this->get_settings_for_display();
		if ( 'yes' == $atts['banner_stretch'] ) {
			$this->add_render_attribute( '_wrapper', 'class', 'stretch-banner' );
		}
		?>
		<div <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php
	}
}
