<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Block Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Molla_Elementor_Nav_Menu_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_nav_menu';
	}

	public function get_title() {
		return esc_html__( 'Molla Nav Menu', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'nav', 'menu', 'dropdown', 'toggle' );
	}

	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->slug ] = $item->name;
		}
		return $menu_items;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_products',
			array(
				'label' => esc_html__( 'Menu', 'molla-core' ),
			)
		);

		$this->add_control(
			'menu',
			array(
				'label'   => esc_html__( 'Select Menu', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_menu_items(),
			)
		);

		$this->add_control(
			'skin',
			array(
				'label'   => esc_html__( 'Select Skin', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''      => esc_html__( 'Default', 'molla-core' ),
					'skin1' => esc_html__( 'Skin 1', 'molla-core' ),
					'skin2' => esc_html__( 'Skin 2', 'molla-core' ),
					'skin3' => esc_html__( 'Skin 3', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'show_arrow',
			array(
				'label' => esc_html__( 'Show Arrow', 'molla-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'arrow_icon_size',
			array(
				'label'      => esc_html__( 'Arrow Size (px)', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .sf-arrows .menu-item-has-children>a:after' => 'font-size: {{SIZE}}px;',
				),
				'condition'  => array(
					'show_arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'hover_effect',
			array(
				'label'   => esc_html__( 'Hover Effect', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''                           => esc_html__( 'No Effect', 'molla-core' ),
					'scale-eff'                  => esc_html__( 'Top Scale', 'molla-core' ),
					'scale-eff bottom-scale-eff' => esc_html__( 'Bottom Scale', 'molla-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'effect_height',
			array(
				'label'      => esc_html__( 'Height', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'rem' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .menu > li > a:before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'hover_effect!' => '',
				),
			)
		);

		$this->add_control(
			'effect_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .menu > li > a:before' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'hover_effect!' => '',
				),
			)
		);

		$this->add_control(
			'toggle_menu',
			array(
				'label'     => esc_html__( 'Enable Toggle Menu', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'toggle_title',
			array(
				'label'     => esc_html__( 'Toggle Menu Title', 'molla-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Toggle Menu Title', 'molla-core' ),
				'condition' => array(
					'toggle_menu' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_title_link',
			array(
				'label'     => esc_html__( 'Link Url', 'molla-core' ),
				'type'      => Controls_Manager::URL,
				'default'   => array(
					'url' => '',
				),
				'condition' => array(
					'toggle_menu' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_active',
			array(
				'label'     => esc_html__( 'Toggle Menu Opens When', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hover',
				'options'   => array(
					'hover'   => esc_html__( 'Mouse Hover', 'molla-core' ),
					'toggle'  => esc_html__( 'Mouse Toggle', 'molla-core' ),
					'toggle2' => esc_html__( 'Mouse Toggle (active on homepage) ', 'molla-core' ),
				),
				'condition' => array(
					'toggle_menu' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_show_icon',
			array(
				'label'     => esc_html__( 'Show Icon', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'toggle_menu' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_icon',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'icon-bars',
					'library' => 'molla-icons',
				),
				'condition' => array(
					'toggle_menu'      => 'yes',
					'toggle_show_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_active_icon',
			array(
				'label'     => esc_html__( 'Active Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'icon-close',
					'library' => 'molla-icons',
				),
				'condition' => array(
					'toggle_menu'      => 'yes',
					'toggle_show_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_icon_pos',
			array(
				'label'     => esc_html__( 'Icon Position', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'left',
				'condition' => array(
					'toggle_menu'      => 'yes',
					'toggle_show_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'vertical_menu',
			array(
				'label'     => esc_html__( 'Show as Vertical', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => array(
					'toggle_menu!' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ancestor_style',
			array(
				'label' => esc_html__( 'Menu Ancestor', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'ancestor_typography',
					'selector' => '.elementor-element-{{ID}} .menu > li > a',
				)
			);

			$this->add_responsive_control(
				'ancestor_border',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);
			$this->add_control(
				'ancestor_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'ancestor_color_tab' );
				$this->start_controls_tab(
					'ancestor_normal',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

				$this->add_control(
					'ancestor_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'ancestor_hover',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

				$this->add_control(
					'ancestor_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'ancestor_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'ancestor_margin',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submenu_heading_style',
			array(
				'label' => esc_html__( 'Submenu Heading', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'submenu_heading_typography',
					'selector' => '.elementor-element-{{ID}} .megamenu .menu-subtitle > a',
				)
			);

			$this->add_responsive_control(
				'submenu_heading_border',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu-subtitle > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'submenu_heading_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu-subtitle > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'submenu_heading_color_tab' );
				$this->start_controls_tab(
					'submenu_heading_normal',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

				$this->add_control(
					'submenu_heading_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .megamenu .menu-subtitle > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_heading_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .megamenu .menu-subtitle > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_heading_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu-subtitle > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'submenu_heading_hover',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

				$this->add_control(
					'submenu_heading_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu li.menu-subtitle:hover > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_heading_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu li.menu-subtitle:hover > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_heading_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu li.menu-subtitle:hover > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'submenu_heading_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu-subtitle > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'submenu_heading_margin',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu-subtitle > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submenu_style',
			array(
				'label' => esc_html__( 'Submenu Item', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'submenu_typography',
					'selector' => '.elementor-element-{{ID}} li li > a',
				)
			);

			$this->add_responsive_control(
				'submenu_border',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'submenu_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'submenu_color_tab' );
				$this->start_controls_tab(
					'submenu_normal',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

				$this->add_control(
					'submenu_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'submenu_hover',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

				$this->add_control(
					'submenu_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu-item li:not(.menu-subtitle):hover > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu-item li:not(.menu-subtitle):hover > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu-item li:not(.menu-subtitle):hover > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'submenu_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'submenu_margin',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} li li:last-child' => 'margin: 0;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label'     => esc_html__( 'Menu Toggle', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'toggle_menu' => 'yes',
				),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'toggle_typography',
					'selector' => '.elementor-element-{{ID}} .dropdown-toggle',
				)
			);

			$this->add_responsive_control(
				'toggle_icon_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-toggle i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'toggle_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .icon-left .dropdown-toggle i' => 'margin-right: {{SIZE}}px;',
						'.elementor-element-{{ID}} .icon-right .dropdown-toggle i' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'toggle_border',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'toggle_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'toggle_color_tab' );
				$this->start_controls_tab(
					'toggle_normal',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

				$this->add_control(
					'toggle_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-toggle' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'toggle_hover',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-menu-wrapper:not(.open-toggle):hover .dropdown-toggle' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .dropdown-menu-wrapper.show .dropdown-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-menu-wrapper:not(.open-toggle):hover .dropdown-toggle' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .dropdown-menu-wrapper.show .dropdown-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'molla-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dropdown-menu-wrapper:not(.open-toggle):hover .dropdown-toggle' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .dropdown-menu-wrapper.show .dropdown-toggle' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'toggle_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => esc_html__( 'Menu Dropdown', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_padding',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-toggle + .menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .menu > li > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_bg',
				array(
					'label'     => esc_html__( 'Background', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .dropdown-toggle + .menu' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .menu li > ul' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .menu' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'dropdown_box_shadow',
					'selector' => '.elementor-element-{{ID}} .show .dropdown-box, .elementor-element-{{ID}} li ul',
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$args = (object) array(
			'html'              => $atts['menu'],
			'menu_type'         => ( 'yes' == $atts['toggle_menu'] ),
			'menu_title'        => $atts['toggle_title'],
			'menu_link'         => isset( $atts['toggle_title_link']['url'] ) ? $atts['toggle_title_link']['url'] : '',
			'menu_active_event' => $atts['toggle_active'],
			'menu_show_icon'    => ( 'yes' == $atts['toggle_show_icon'] ),
			'menu_icon'         => isset( $atts['toggle_icon']['value'] ) ? $atts['toggle_icon']['value'] : '',
			'menu_active_icon'  => isset( $atts['toggle_active_icon']['value'] ) ? $atts['toggle_active_icon']['value'] : '',
			'menu_icon_pos'     => $atts['toggle_icon_pos'],
			'menu_skin'         => $atts['skin'],
			'menu_show_arrow'   => $atts['show_arrow'],
			'menu_hover_effect' => $atts['hover_effect'],
			'menu_vertical'     => ( 'yes' != $atts['toggle_menu'] && 'yes' == $atts['vertical_menu'] ),
		);

		molla_get_template_part( 'template-parts/header/elements/custom_menu', null, $args );
	}
}
