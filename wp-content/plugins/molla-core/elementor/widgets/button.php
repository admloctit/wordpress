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
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Box_Shadow;

class Molla_Elementor_Button_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_button';
	}

	public function get_title() {
		return esc_html__( 'Molla Button', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'button' );
	}

	public function get_style_depends() {
		return array();
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button', 'molla-core' ),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Text', 'molla-core' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
				'default' => 'Click here',
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'   => esc_html__( 'Alignment', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'molla-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default' => 'left',
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link Url', 'molla-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'button_type',
			array(
				'label'   => esc_html__( 'Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''            => esc_html__( 'Default', 'molla-core' ),
					'btn-outline' => esc_html__( 'Outline', 'molla-core' ),
					'btn-link'    => esc_html__( 'Link', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'   => esc_html__( 'Size', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-md',
				'options' => array(
					'btn-sm' => esc_html__( 'Small', 'molla-core' ),
					'btn-md' => esc_html__( 'Normal', 'molla-core' ),
					'btn-lg' => esc_html__( 'Large', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'button_skin',
			array(
				'label'   => esc_html__( 'Skin', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-primary',
				'options' => array(
					'btn-primary'   => esc_html__( 'Primary', 'molla-core' ),
					'btn-secondary' => esc_html__( 'Secondary', 'molla-core' ),
					'btn-alert'     => esc_html__( 'Alert', 'molla-core' ),
					'btn-dark'      => esc_html__( 'Dark', 'molla-core' ),
					'btn-light'     => esc_html__( 'Light', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'shadow',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Box Shadow', 'molla-core' ),
				'default' => '',
				'options' => array(
					''                 => esc_html__( 'None', 'molla-core' ),
					'btn-shadow-hover' => esc_html__( 'Shadow 1', 'molla-core' ),
					'btn-shadow'       => esc_html__( 'Shadow 2', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'button_border',
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
					'button_type!' => 'btn-link',
				),
			)
		);

		$this->add_control(
			'line_break',
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
					'{{WRAPPER}} .btn' => 'white-space: {{VALUE}};',
				),

			)
		);

		$this->add_control(
			'btn_class',
			array(
				'label'   => esc_html__( 'Custom Class', 'molla-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
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
			'show_icon',
			array(
				'label'   => esc_html__( 'Show Icon on Hover', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'video_btn',
			array(
				'label'       => esc_html__( 'Use as Video Play Button', 'molla-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'molla-core' ),
				'label_on'    => esc_html__( 'On', 'molla-core' ),
				'description' => esc_html__( 'You can play video whenever you set video in parent section' ),
				'default'     => 'no',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button Style', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'btn_min_width',
			array(
				'label'      => esc_html__( 'Min Width', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typography',
				'label'    => esc_html__( 'Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .btn',
			)
		);

		$this->start_controls_tabs( 'tabs_btn_cat' );

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
					'{{WRAPPER}} .btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'btn_box_shadow',
				'selector' => '{{WRAPPER}} .btn',
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
					'{{WRAPPER}} .btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .btn:hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_active',
			array(
				'label' => esc_html__( 'Active', 'molla-core' ),
			)
		);

		$this->add_control(
			'btn_color_active',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn:not(:focus):active, {{WRAPPER}} .btn:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn:not(:focus):active, {{WRAPPER}} .btn:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn:not(:focus):active, {{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'btn_box_shadow_active',
				'selector' => '{{WRAPPER}} .btn:active, {{WRAPPER}} .btn:focus',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}


	protected function render() {
		$atts           = $this->get_settings_for_display();
		$btn_wrap_class = 'molla-button-wrapper elementor-align-' . $atts['button_align'];
		if ( $atts['button_align_tablet'] ) {
			$btn_wrap_class .= ' elementor-tablet-align-' . $atts['button_align_tablet'];
		}
		if ( $atts['button_align_mobile'] ) {
			$btn_wrap_class .= ' elementor-mobile-align-' . $atts['button_align_mobile'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $btn_wrap_class );
		$this->add_inline_editing_attributes( 'text' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php include MOLLA_ELEMENTOR_TEMPLATES . 'molla_button.php'; ?>
		</div>
		<?php

	}

	protected function content_template() {
		?>
		<# 
			let btn_class = 'molla-button-wrapper';
			if ( settings.button_align ) {
				btn_class += ' elementor-align-' + settings.button_align;
			}
			if ( settings.button_align_tablet ) {
				btn_class += ' elementor-tablet-align-' + settings.button_align_tablet;
			}
			if ( settings.button_align_mobile ) {
				btn_class += ' elementor-mobile-align-' + settings.button_align_mobile;
			}
		#>
		<div class="{{btn_class}}">
			<a href="{{ settings.link.url }}" class="btn {{settings.button_skin}} {{settings.button_size}} {{settings.button_type}} {{settings.button_border}} icon-{{settings.icon_pos}}{{'yes' == settings.show_icon ? ' icon-hidden' : ''}}" role="button">
				<# if ( settings.icon_pos == 'before' && settings.icon.value ) { #>
				<i class="{{ settings.icon.value }}"></i>
				<# } #>
				<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
				<# if ( settings.icon_pos == 'after' && settings.icon.value ) { #>
				<i class="{{ settings.icon.value }}"></i>
				<# } #>
			</a>
		</div>
		<?php
	}
}
