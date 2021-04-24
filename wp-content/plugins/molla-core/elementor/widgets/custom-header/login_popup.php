<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Header Login Widget
 *
 *
 * @since 1.2
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Molla_Custom_Header_Login_Popup_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_login_popup';
	}

	public function get_title() {
		return esc_html__( 'Molla Account', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_categories() {
		return array( 'molla-header' );
	}

	public function get_keywords() {
		return array( 'login', 'register', 'account' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);

		$this->add_control(
			'account_popup',
			array(
				'label' => esc_html__( 'Enable Popup', 'molla-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'   => esc_html__( 'Show Label', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_register_label',
			array(
				'label'     => esc_html__( 'Show Register Label', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'show_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'login_label',
			array(
				'label'       => esc_html__( 'Log In Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Log In', 'molla-core' ),
				'condition'   => array(
					'account_popup' => 'yes',
					'show_label'    => 'yes',
				),
			)
		);

		$this->add_control(
			'delimiter',
			array(
				'label'       => esc_html__( 'Delimiter', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => ' / ',
				'condition'   => array(
					'account_popup'       => 'yes',
					'show_label'          => 'yes',
					'show_register_label' => 'yes',
				),
			)
		);
		$this->add_control(
			'register_label',
			array(
				'label'       => esc_html__( 'Register Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Register', 'molla-core' ),
				'condition'   => array(
					'account_popup'       => 'yes',
					'show_label'          => 'yes',
					'show_register_label' => 'yes',
				),
			)
		);
		$this->add_control(
			'logout_label',
			array(
				'label'       => esc_html__( 'Log Out Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Log Out', 'molla-core' ),
				'condition'   => array(
					'account_popup' => 'yes',
					'show_label'    => 'yes',
				),
			)
		);
		$this->add_control(
			'account_label',
			array(
				'label'       => esc_html__( 'Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Account', 'molla-core' ),
				'condition'   => array(
					'account_popup!' => 'yes',
					'show_label'     => 'yes',
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'molla-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-user',
					'library' => 'molla-icons',
				),
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'   => esc_html__( 'Icon Position', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'top'  => array(
						'title' => esc_html__( 'Top', 'molla-core' ),
						'icon'  => 'eicon-v-align-top',
					),
				),
				'default' => 'left',
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
					'{{WRAPPER}} .vdir i' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .hdir i' => 'margin-right: {{SIZE}}px;',
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
					'{{WRAPPER}} .shop-icon i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'label'    => esc_html__( 'Label', 'molla-core' ),
				'selector' => '{{WRAPPER}} a',
			)
		);

		$this->start_controls_tabs( 'tabs_color' );

		$this->start_controls_tab(
			'tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a i' => 'color: {{VALUE}}; transition: color .3s;',
				),
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a:hover i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'label_color_hover',
			array(
				'label'     => esc_html__( 'Label', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'custom-header/molla_login_popup.php';
	}
}
