<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use ELementor\Group_Control_Box_Shadow;
use ELementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Embed;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Molla_Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Molla_Element_Section extends \Elementor\Element_Section {

	public $is_legacy_mode     = true;
	public $is_video_available = false;
	public $post_type          = '';


	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data );

		add_action( 'elementor/frontend/section/before_render', array( $this, 'section_wrap_class' ), 10, 1 );

		if ( method_exists( Plugin::instance(), 'get_legacy_mode' ) && ! Plugin::instance()->get_legacy_mode( 'elementWrappers' ) ) {
			$this->is_legacy_mode = false;
		}

		$this->post_type = get_post_type();
	}

	/**
	 * Add classes to section wrap
	 */
	public function section_wrap_class( $self ) {

		$settings     = $self->get_settings_for_display();
		$classes      = array();
		$wrap_options = [];

		if ( 'banner' == $settings['section_layout_mode'] ) {
			if ( 'yes' == $settings['img_back_style'] ) {
				if ( 'yes' == $settings['banner_parallax'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'parallax-container' ) ) {
					$classes[] = 'parallax-container';

					if ( $settings['background_image']['url'] ) {
						$wrap_options['data-plx-img'] = $settings['background_image']['url'];
						if ( $settings['background_repeat'] ) {
							$wrap_options['data-plx-img-repeat'] = $settings['background_repeat'];
						}
						if ( $settings['background_position'] ) {
							$wrap_options['data-plx-img-pos'] = $settings['background_position'];
						}
						if ( $settings['background_attachment'] ) {
							$wrap_options['data-plx-img-att'] = $settings['background_attachment'];
						}
						if ( $settings['background_size'] ) {
							$wrap_options['data-plx-img-size'] = $settings['background_size'];
						}
						if ( $settings['parallax_speed'] ) {
							$wrap_options['data-plx-speed'] = (int) $settings['parallax_speed']['size'];
						}
						if ( function_exists( 'molla_option' ) && molla_option( 'lazy_load_img' ) ) {
							$wrap_options['data-lazyload'] = true;

							if ( $settings['background_color'] ) {
								$wrap_options['data-plx-color'] = $settings['background_color'];
							} else {
								$wrap_options['data-plx-color'] = molla_option( 'lazy_load_img_back' );
							}
						}
					}
				}
			} elseif ( false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'background-image-none' ) ) {
				$classes[] = 'background-image-none';
				if ( $settings['background_color'] ) {
					$classes[] = 'background-color-none';
				}
			}
		} elseif ( 'creative' == $settings['section_layout_mode'] ) {
			global $molla_section;
			if ( ! isset( $molla_section['section'] ) ) {
				$molla_section = array(
					'section'    => 'creative',
					'preset'     => molla_creative_grid_layout( $settings['creative_mode'] ),
					'layout'     => array(),
					'index'      => 0,
					'top'        => $self->get_data( 'isInner' ),
					'categories' => array(),
				);
			}
			if ( 'yes' == $settings['creative_categories'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'elementor-section-with-masonry' ) ) {
				$classes[] = 'elementor-section-with-masonry';
			}
		} elseif ( 'tab' == $settings['section_layout_mode'] ) {
			global $molla_section;
			if ( ! isset( $molla_section['section'] ) ) {
				$molla_section = array(
					'section'  => 'tab',
					'index'    => 0,
					'tab_data' => array(),
				);
			}
		} elseif ( 'accordion' == $settings['section_layout_mode'] ) {
			global $molla_section;
			if ( ! isset( $molla_section['section'] ) ) {
				$molla_section = array(
					'section'     => 'accordion',
					'parent_id'   => $self->get_data( 'id' ),
					'index'       => 0,
					'icon'        => $settings['accordion_icon'],
					'active_icon' => $settings['accordion_active_icon'],
				);
			}
		}

		if ( 'yes' == $settings['section_parallax'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'overflow-hidden' ) ) {
			$classes[]                      = 'section-parallax';
			$classes[]                      = 'overflow-hidden';
			$wrap_options['data-plx-speed'] = (int) $settings['section_parallax_speed']['size'];
		}

		if ( 'yes' == $settings['section_scrollable'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'section-scroll' ) ) {
			$classes[] = 'section-scroll';
			$tooltip   = $settings['section_scrollable_tooltip'];
			if ( $tooltip ) {
				$wrap_options['data-section-tooltip'] = $tooltip;
			}
		}

		if ( isset( $settings['section_sticky'] ) && 'yes' == $settings['section_sticky'] ) {
			$classes[] = 'sticky-header';
		}

		if ( 'yes' == $settings['video_banner_switch'] ) {
			global $molla_section;
			$molla_section['video'] = true;
			if ( 'yes' == $settings['lightbox'] ) {

				$video_url = $settings[ $settings['video_type'] . '_url' ];

				if ( 'hosted' === $settings['video_type'] ) {
					$video_url = $self->get_hosted_video_url();
				}
				if ( 'hosted' != $settings['video_type'] ) {
					$embed_params  = $self->get_embed_params();
					$embed_options = $self->get_embed_options();
				}
				if ( 'hosted' === $settings['video_type'] ) {
					$lightbox_url = $video_url;
				} else {
					$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
				}

				$lightbox_options = [
					'type'         => 'video',
					'videoType'    => $settings['video_type'],
					'url'          => $lightbox_url,
					'modalOptions' => [
						'id'                       => 'elementor-lightbox-' . $self->get_id(),
						'entranceAnimation'        => $settings['lightbox_content_animation'],
						'entranceAnimation_tablet' => $settings['lightbox_content_animation_tablet'],
						'entranceAnimation_mobile' => $settings['lightbox_content_animation_mobile'],
						'videoAspectRatio'         => $settings['aspect_ratio'],
					],
				];

				if ( 'hosted' === $settings['video_type'] ) {
					$lightbox_options['videoParams'] = $self->get_hosted_params();
				}
				$molla_section['lightbox'] = $lightbox_options;
			}
		}

		if ( defined( 'MOLLA_VERSION' ) ) {
			if ( ! is_admin() && ! is_customize_preview() && ! molla_ajax() && molla_option( 'lazy_load_img' ) &&
				isset( $settings['background_image']['url'] ) && $settings['background_image']['url'] && false === strpos( $self->get_render_attribute_string( '_wrapper' ), 'molla-lazyload-back' ) &&
				( 'banner' != $settings['section_layout_mode'] || 'yes' == $settings['img_back_style'] ) ) {

				$classes[]                = 'molla-lazyload-back';
				$wrap_options['data-src'] = $settings['background_image']['url'];
				if ( $settings['background_color'] ) {
					$wrap_options['style'] = 'background-color: ' . $settings['background_color'];
				} else {
					$wrap_options['style'] = 'background-color: ' . molla_option( 'lazy_load_img_back' );
				}
			}
		}

		$wrap_options['class'] = $classes;

		$self->add_render_attribute(
			array(
				'_wrapper' => $wrap_options,
			)
		);
	}

	/**
	 * Register section controls.
	 *
	 * Used to add new controls to the section element.
	 *
	 * @since 1.0
	 */
	protected function _register_controls() {

		parent::_register_controls();

		global $molla_animations;

		$this->start_controls_section(
			'section_layout_type',
			array(
				'label' => esc_html__( 'Molla Section Settings', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

		$this->add_control(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'molla-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'section_with_container',
			array(
				'label'     => esc_html__( 'Wrap with Container', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'layout'                        => 'boxed',
					'section_with_container_fluid!' => 'yes',
				),
			)
		);

		$this->add_control(
			'section_with_container_fluid',
			array(
				'label'     => esc_html__( 'Wrap with Container-Fluid', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'layout'                  => 'boxed',
					'section_with_container!' => 'yes',
				),
			)
		);

		$this->add_control(
			'section_scrollable',
			array(
				'label' => esc_html__( 'Enable Scrollable Section', 'molla-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'section_scrollable_tooltip',
			array(
				'label'       => esc_html__( 'Tooltip Text', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Please input tooltip text here...', 'molla-core' ),
				'default'     => '',
				'condition'   => array(
					'section_scrollable' => 'yes',
				),
			)
		);

		$this->add_control(
			'section_parallax',
			array(
				'label'       => esc_html__( 'Parallax Section', 'molla-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( "Section content's sticky in bottom of parent until it remains in viewport. You can set this option in top section generally.", 'molla-core' ),
			)
		);

		$this->add_control(
			'section_parallax_speed',
			array(
				'label'     => esc_html__( 'Speed', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 4,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 10,
					),
				),
				'condition' => array(
					'section_parallax' => 'yes',
				),
			)
		);

		if ( ! molla_is_elementor_preview() || 'header' == $this->post_type ) {
			$this->add_control(
				'section_sticky',
				array(
					'label' => esc_html__( 'Sticky Section', 'molla-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);
			$this->add_responsive_control(
				'section_sticky_padding',
				array(
					'label'      => esc_html__( 'Sticky Padding', 'donald-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'{{WRAPPER}}.fixed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'section_sticky' => 'yes',
					),
				)
			);
			$this->add_control(
				'section_sticky_bg',
				array(
					'label'     => esc_html__( 'Sticky Background', 'donald-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}.fixed' => 'background-color: {{VALUE}}',
					),
					'separator' => 'after',
					'condition' => array(
						'section_sticky' => 'yes',
					),
				)
			);
		}

		$this->add_control(
			'section_usuage',
			array(
				'label'     => esc_html__( 'Section Usage', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'section_layout_mode',
			array(
				'label'   => esc_html__( 'Use as', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''          => esc_html__( 'Default', 'molla-core' ),
					'creative'  => esc_html__( 'Creative', 'molla-core' ),
					'slider'    => esc_html__( 'Slider', 'molla-core' ),
					'banner'    => esc_html__( 'Banner', 'molla-core' ),
					'tab'       => esc_html__( 'Tab', 'molla-core' ),
					'accordion' => esc_html__( 'Accordion', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'v_align',
			array(
				'label'     => esc_html__( 'Vertical Align', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => array(
					'flex-start' => esc_html__( 'Top', 'molla-core' ),
					'center'     => esc_html__( 'Middle', 'molla-core' ),
					'flex-end'   => esc_html__( 'Bottom', 'molla-core' ),
					'stretch'    => esc_html__( 'Stretch', 'molla-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .owl-stage' => 'display: flex; align-items:{{VALUE}}',
				),
				'condition' => array(
					'section_layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_control(
			'cols_upper_desktop',
			array(
				'label'     => esc_html__( 'Columns Upper Desktop ( >= 1200px )', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''  => esc_html__( 'Default', 'molla-core' ),
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
					'section_layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'cols',
			array(
				'label'     => esc_html__( 'Columns', 'molla-core' ),
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
					'section_layout_mode' => array( 'slider', 'creative' ),
				),
			)
		);

		$this->add_control(
			'cols_under_mobile',
			array(
				'label'     => esc_html__( 'Columns Under Mobile ( <= 575px )', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''  => 'Default',
					'1' => 1,
					'2' => 2,
					'3' => 3,
				),
				'condition' => array(
					'section_layout_mode' => array( 'slider', 'creative' ),
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'molla-core' ),
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
					'section_layout_mode!' => array( '', 'banner', 'tab', 'accordion' ),
				),
			)
		);

		// Slider controls
		$this->add_control(
			'slider_nav_pos',
			array(
				'label'     => esc_html__( 'Nav & Dot Position', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					'owl-nav-inside' => esc_html__( 'Inner', 'molla-core' ),
					''               => esc_html__( 'Outer', 'molla-core' ),
					'owl-nav-top'    => esc_html__( 'Top', 'molla-core' ),
				),
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_nav_type',
			array(
				'label'     => esc_html__( 'Nav Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''                => esc_html__( 'Type 1', 'molla-core' ),
					'owl-full'        => esc_html__( 'Type 2', 'molla-core' ),
					'owl-nav-rounded' => esc_html__( 'Type 3', 'molla-core' ),
				),
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav',
			array(
				'label'     => esc_html__( 'Enable Nav', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_nav_show',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'section_layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot',
			array(
				'label'     => esc_html__( 'Enable Dots', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_loop',
			array(
				'label'     => esc_html__( 'Enable Loop', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_auto_play',
			array(
				'label'     => esc_html__( 'Enable Auto-Play', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_auto_play_time',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10000,
				'condition' => array(
					'section_layout_mode' => 'slider',
					'slider_auto_play'    => 'yes',
				),
			)
		);

		$this->add_control(
			'slider_auto_height',
			array(
				'label'     => esc_html__( 'Enable Auto-height', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_center',
			array(
				'label'     => esc_html__( 'Enable Center Mode', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_equal_height',
			array(
				'label'     => esc_html__( 'Set equal heights', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_animation_in',
			array(
				'label'     => esc_html__( 'Animation In', 'molla-core' ),
				'type'      => Controls_Manager::SELECT2,
				'default'   => '',
				'options'   => $molla_animations['animate_in'],
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'slider_animation_out',
			array(
				'label'     => esc_html__( 'Animation Out', 'molla-core' ),
				'type'      => Controls_Manager::SELECT2,
				'default'   => '',
				'options'   => $molla_animations['animate_out'],
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
			)
		);

		// Banner Controls
		$this->add_control(
			'banner_hover_effect',
			array(
				'label'     => esc_html__( 'Hover Effect', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''               => esc_html__( 'No Effect', 'molla-core' ),
					'banner-hover-1' => esc_html__( 'Effect 1', 'molla-core' ),
					'banner-hover-2' => esc_html__( 'Effect 2', 'molla-core' ),
				),
				'condition' => array(
					'section_layout_mode' => 'banner',
				),
			)
		);
		$this->add_control(
			'img_back_style',
			array(
				'label'     => esc_html__( 'Use image as background style', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'banner',
				),
			)
		);

		$this->add_responsive_control(
			'min_height',
			array(
				'label'      => esc_html__( 'Min Height', 'molla-core' ),
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
						'max'  => 100,
					),
				),
				'condition'  => array(
					'section_layout_mode' => 'banner',
				),
				'selectors'  => array(
					'{{WRAPPER}} .banner'           => 'min-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .banner-img > img' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'max_height',
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
						'max'  => 100,
					),
				),
				'condition'  => array(
					'section_layout_mode' => 'banner',
				),
				'selectors'  => array(
					'{{WRAPPER}} .banner'           => 'max-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .banner-img > img' => 'max-height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				),
			)
		);

		$this->add_responsive_control(
			'img_pos',
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
				'condition' => array(
					'section_layout_mode' => 'banner',
					'img_back_style!'     => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .banner-img > img' => 'object-position: {{SIZE}}%;',
				),
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'     => esc_html__( 'Link Url', 'molla-core' ),
				'type'      => Controls_Manager::URL,
				'condition' => array(
					'section_layout_mode'  => 'banner',
					'video_banner_switch!' => 'yes',
				),
			)
		);

		$this->add_control(
			'banner_parallax',
			array(
				'label'     => esc_html__( 'Background Parallax', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'banner',
					'img_back_style'      => 'yes',
				),
			)
		);

		$this->add_control(
			'parallax_speed',
			array(
				'label'     => esc_html__( 'Speed', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 4,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 10,
					),
				),
				'condition' => array(
					'banner_parallax' => 'yes',
				),
			)
		);

		$this->add_control(
			'section_video',
			array(
				'label'     => esc_html__( 'Video', 'molla-core' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'section_layout_mode' => 'banner',
				),
			)
		);

		$this->add_control(
			'video_banner_switch',
			array(
				'label'     => esc_html__( 'Enable Video', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'section_layout_mode' => 'banner',
				),
			)
		);

		// Tab Controls
		$this->add_control(
			'tab_nav_effect',
			array(
				'label'     => esc_html__( 'Nav Effect', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'custom',
				'options'   => array(
					'nav-pills'       => esc_html__( 'Effect 1', 'molla-core' ),
					'nav-border-anim' => esc_html__( 'Effect 2', 'molla-core' ),
					'custom'          => esc_html__( 'custom', 'molla-core' ),
				),
				'condition' => array(
					'section_layout_mode' => 'tab',
				),
			)
		);

		$this->add_control(
			'tab_type',
			array(
				'label'     => esc_html__( 'Tab Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'horizontal',
				'options'   => array(
					'horizontal' => esc_html__( 'Horizontal', 'molla-core' ),
					'vertical'   => esc_html__( 'Vertical', 'molla-core' ),
				),
				'condition' => array(
					'section_layout_mode' => 'tab',
					'tab_nav_effect'      => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'tab_nav_align',
			array(
				'label'     => esc_html__( 'Nav Align', 'molla-core' ),
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
				'condition' => array(
					'section_layout_mode' => 'tab',
				),
				'selectors' => array(
					'{{WRAPPER}} .nav' => 'justify-content: {{VALUE}};',
				),
			)
		);

		// Accordion Controls
		$this->add_control(
			'accordion_icon',
			array(
				'label'            => esc_html__( 'Icon', 'molla-core' ),
				'type'             => Controls_Manager::ICONS,
				'separator'        => 'before',
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'icon icon-plus',
					'library' => '',
				),
				'recommended'      => array(
					'fa-solid'   => array(
						'chevron-down',
						'angle-down',
						'angle-double-down',
						'caret-down',
						'caret-square-down',
					),
					'fa-regular' => array(
						'caret-square-down',
					),
				),
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'        => array(
					'section_layout_mode' => 'accordion',
				),
			)
		);

		$this->add_control(
			'accordion_active_icon',
			array(
				'label'            => esc_html__( 'Active Icon', 'molla-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon_active',
				'default'          => array(
					'value'   => 'icon icon-minus',
					'library' => '',
				),
				'recommended'      => array(
					'fa-solid'   => array(
						'chevron-up',
						'angle-up',
						'angle-double-up',
						'caret-up',
						'caret-square-up',
					),
					'fa-regular' => array(
						'caret-square-up',
					),
				),
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'        => array(
					'section_layout_mode'    => 'accordion',
					'accordion_icon[value]!' => '',
				),
			)
		);

		// Creative Grid Controls
		$this->add_control(
			'creative_mode',
			array(
				'label'     => esc_html__( 'Grid Layout Type', 'molla-core' ),
				'type'      => Molla_Controls_Manager::RADIOIMAGE,
				'default'   => '1',
				'options'   => molla_creative_grid_options(),
				'condition' => array(
					'section_layout_mode' => 'creative',
				),
			)
		);

		$this->add_control(
			'creative_height',
			array(
				'label'     => esc_html__( 'Grid Height (px)', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 5,
						'min'  => 0,
						'max'  => 2000,
					),
				),
				'condition' => array(
					'section_layout_mode' => array( 'creative' ),
				),
			)
		);

		$this->add_control(
			'creative_height_ratio',
			array(
				'label'     => esc_html__( 'Grid Mobile Height (%)', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 75,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 30,
						'max'  => 100,
					),
				),
				'condition' => array(
					'section_layout_mode' => array( 'creative' ),
				),
			)
		);

		$this->add_control(
			'creative_float_grid',
			array(
				'label'       => esc_html__( 'Use Float Grid', 'molla-core' ),
				'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for simple creative layouts.' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'section_layout_mode' => array( 'creative' ),
				),
			)
		);

		$this->add_control(
			'creative_categories',
			array(
				'label'     => esc_html__( 'Enable Filtering', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'section_layout_mode'  => 'creative',
					'creative_float_grid!' => 'yes',
				),
			)
		);
		$this->add_control(
			'creative_categories_transition',
			array(
				'label'     => esc_html__( 'Transition Duration', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.7,
				),
				'range'     => array(
					'px' => array(
						'step' => 0.1,
						'max'  => 3,
					),
				),
				'condition' => array(
					'section_layout_mode'  => 'creative',
					'creative_float_grid!' => 'yes',
					'creative_categories'  => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'creative_nav_align',
			array(
				'label'     => __( 'Nav Align', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'condition' => array(
					'section_layout_mode'  => 'creative',
					'creative_float_grid!' => 'yes',
					'creative_categories'  => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .nav' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Section Video Options
		$this->start_controls_section(
			'video_section',
			array(
				'label'     => esc_html__( 'Molla Video Options', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'   => esc_html__( 'Source', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => array(
					'youtube'     => esc_html__( 'YouTube', 'molla-core' ),
					'vimeo'       => esc_html__( 'Vimeo', 'molla-core' ),
					'dailymotion' => esc_html__( 'Dailymotion', 'molla-core' ),
					'hosted'      => esc_html__( 'Self Hosted', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'Link', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL', 'molla-core' ) . ' (YouTube)',
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'Link', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL', 'molla-core' ) . ' (Vimeo)',
				'default'     => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'dailymotion_url',
			array(
				'label'       => esc_html__( 'Link', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL', 'molla-core' ) . ' (Dailymotion)',
				'default'     => 'https://www.dailymotion.com/video/x6tqhqb',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'dailymotion',
				),
			)
		);

		$this->add_control(
			'insert_url',
			array(
				'label'     => esc_html__( 'External URL', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'hosted_url',
			array(
				'label'      => esc_html__( 'Choose File', 'molla-core' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => array(
					'active'     => true,
					'categories' => array(
						TagsModule::MEDIA_CATEGORY,
					),
				),
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'hosted',
					'insert_url' => '',
				),
			)
		);

		$this->add_control(
			'external_url',
			array(
				'label'        => esc_html__( 'URL', 'molla-core' ),
				'type'         => Controls_Manager::URL,
				'autocomplete' => false,
				'options'      => false,
				'label_block'  => true,
				'show_label'   => false,
				'dynamic'      => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'media_type'   => 'video',
				'placeholder'  => esc_html__( 'Enter your URL', 'molla-core' ),
				'condition'    => array(
					'video_type' => 'hosted',
					'insert_url' => 'yes',
				),
			)
		);

		$this->add_control(
			'start',
			array(
				'label'       => esc_html__( 'Start Time', 'molla-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify a start time (in seconds)', 'molla-core' ),
				'condition'   => array(
					'loop' => '',
				),
			)
		);

		$this->add_control(
			'end',
			array(
				'label'       => esc_html__( 'End Time', 'molla-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify an end time (in seconds)', 'molla-core' ),
				'condition'   => array(
					'loop'       => '',
					'video_type' => array( 'youtube', 'hosted' ),
				),
			)
		);

		$this->add_control(
			'video_back',
			array(
				'label'       => esc_html__( 'Use video as background style', 'molla-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( "Video size will be adjusted according to it's content size.", 'molla-core' ),
			)
		);

		$this->add_control(
			'video_min_height',
			array(
				'label'     => esc_html__( 'Min Height (px)', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'condition' => array(
					'video_back!' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-custom-embed-image-overlay img' => 'min-height: {{VALUE}}px; object-fit: cover;',
				),
			)
		);

		$this->add_control(
			'video_options',
			array(
				'label'     => esc_html__( 'Video Options', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'molla-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'play_on_mobile',
			array(
				'label'     => esc_html__( 'Play on Mobile', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'mute',
			array(
				'label' => esc_html__( 'Mute', 'molla-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'     => esc_html__( 'Loop', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type!' => 'dailymotion',
				),
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'     => esc_html__( 'Player Controls', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type!' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'showinfo',
			array(
				'label'     => esc_html__( 'Video Info', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => array( 'dailymotion' ),
				),
			)
		);

		$this->add_control(
			'modestbranding',
			array(
				'label'     => esc_html__( 'Modest Branding', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type' => array( 'youtube' ),
					'controls'   => 'yes',
				),
			)
		);

		$this->add_control(
			'logo',
			array(
				'label'     => esc_html__( 'Logo', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => array( 'dailymotion' ),
				),
			)
		);

		$this->add_control(
			'control_color',
			array(
				'label'     => esc_html__( 'Controls Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'video_type' => array( 'vimeo', 'dailymotion' ),
				),
			)
		);

		// YouTube.
		$this->add_control(
			'yt_privacy',
			array(
				'label'       => esc_html__( 'Privacy Mode', 'molla-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'molla-core' ),
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'rel',
			array(
				'label'     => esc_html__( 'Suggested Videos', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''    => esc_html__( 'Current Video Channel', 'molla-core' ),
					'yes' => esc_html__( 'Any Video', 'molla-core' ),
				),
				'condition' => array(
					'video_type' => 'youtube',
				),
			)
		);

		// Vimeo.
		$this->add_control(
			'vimeo_title',
			array(
				'label'     => esc_html__( 'Intro Title', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_portrait',
			array(
				'label'     => esc_html__( 'Intro Portrait', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_byline',
			array(
				'label'     => esc_html__( 'Intro Byline', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'download_button',
			array(
				'label'     => esc_html__( 'Download Button', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
				'condition' => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'poster',
			array(
				'label'     => esc_html__( 'Poster', 'molla-core' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'view',
			array(
				'label'   => esc_html__( 'View', 'molla-core' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'youtube',
			)
		);

		$this->add_control(
			'section_image_overlay',
			array(
				'label'     => esc_html__( 'Image Overlay', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'show_image_overlay',
			array(
				'label'     => esc_html__( 'Image Overlay', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'molla-core' ),
				'label_on'  => esc_html__( 'Show', 'molla-core' ),
			)
		);

		$this->add_control(
			'image_overlay',
			array(
				'label'     => esc_html__( 'Choose Image', 'molla-core' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_banner_parallax',
			array(
				'label'     => esc_html__( 'Background Parallax', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'show_image_overlay' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_parallax_speed',
			array(
				'label'     => esc_html__( 'Speed', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 4,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 10,
					),
				),
				'condition' => array(
					'show_image_overlay'    => 'yes',
					'video_banner_parallax' => 'yes',
				),
			)
		);

		$this->add_control(
			'lazy_load',
			array(
				'label'     => esc_html__( 'Lazy Load', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'show_image_overlay' => 'yes',
					'video_type!'        => 'hosted',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image_overlay', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_overlay_size` and `image_overlay_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
				'condition' => array(
					'show_image_overlay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_play_icon',
			array(
				'label'     => esc_html__( 'Play Icon', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'show_image_overlay'  => 'yes',
					'image_overlay[url]!' => '',
				),
			)
		);

		$this->add_control(
			'lightbox',
			array(
				'label'              => esc_html__( 'Lightbox', 'molla-core' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'label_off'          => esc_html__( 'Off', 'molla-core' ),
				'label_on'           => esc_html__( 'On', 'molla-core' ),
				'condition'          => array(
					'show_image_overlay'  => 'yes',
					'image_overlay[url]!' => '',
				),
				'separator'          => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_style',
			array(
				'label'     => esc_html__( 'Slider', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_layout_mode' => 'slider',
				),
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
			'slider_nav_font_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Font Size', 'molla-core' ),
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

		$this->add_responsive_control(
			'slider_nav_width',
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
			'slider_nav_height',
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
			'slider_nav_radius',
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
			'slider_nav_dim',
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
				'condition'  => array(
					'slider_nav_pos!' => 'owl-nav-top',
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
					'slider_nav_pos' => 'owl-nav-top',
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
			'slider_nav_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_nav_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border',
				'selector' => '{{WRAPPER}} .owl-nav button',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow',
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
			'slider_nav_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border_hover',
				'selector' => '{{WRAPPER}} .owl-nav button:not(.disabled):hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow_hover',
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
			'slider_dot_dim_vt',
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
					'slider_nav_pos!' => array( '' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_dim_hz',
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
					'slider_nav_pos!' => array( '' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_dim',
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
					'slider_nav_pos' => array( '' ),
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
			'slider_dot_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color',
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
			'slider_dot_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color_hover',
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
			'slider_dot_bg_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_border_color_active',
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

		$this->start_controls_section(
			'tab_style',
			array(
				'label'     => esc_html__( 'Tab', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_layout_mode' => 'tab',
				),
			)
		);

		$this->add_control(
			'tab_bd',
			array(
				'label'     => esc_html__( 'Tab Border Width (px)', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item a'        => 'border: {{VALUE}}px solid #ebebeb;',
					'{{WRAPPER}} .horizontal > .nav .nav-item a' => 'border-bottom-width: 0;',
					'{{WRAPPER}} .vertical > .nav .nav-item a' => 'border-right-width: 0;',
					'{{WRAPPER}} .nav .nav-item.active a' => 'border: {{VALUE}}px solid #d7d7d7;',
					'{{WRAPPER}} .horizontal > .nav .nav-item.active a' => 'border-bottom-width: 0;',
					'{{WRAPPER}} .vertical > .nav .nav-item.active a' => 'border-right-width: 0;',
					'{{WRAPPER}} .horizontal > .nav'      => 'border-bottom: {{VALUE}}px solid #d7d7d7;',
					'{{WRAPPER}} .vertical > .nav'        => 'border-right: {{VALUE}}px solid #d7d7d7;',
					'{{WRAPPER}} .tab-pane.active'        => 'border: {{VALUE}}px solid #d7d7d7;',
					'{{WRAPPER}} .horizontal > .tab-pane.active' => 'border-top-width: 0;',
					'{{WRAPPER}} .vertical > .tab-pane.active' => 'border-left-width: 0;',
					'{{WRAPPER}} .horizontal > .nav .active a:after' => 'bottom: -{{VALUE}}px; height: {{VALUE}}px;',
					'{{WRAPPER}} .vertical > .nav .active a:after' => 'right: -{{VALUE}}px; width: {{VALUE}}px;',
				),
				'condition' => array(
					'tab_nav_effect' => 'custom',
				),
			)
		);

		$this->add_control(
			'tab_br',
			array(
				'label'      => esc_html__( 'Tab Border Radius (px)', 'molla-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .horizontal > .tab-pane.active' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .horizontal > .nav .nav-item a' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .vertical > .tab-pane.active' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
					'{{WRAPPER}} .vertical > .nav .nav-item a' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'tab_nav_effect' => 'custom',
				),
			)
		);

		$this->add_control(
			'tab_bd_color',
			array(
				'label'     => esc_html__( 'Tab Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item.active a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tab-pane.active'        => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .horizontal > .nav'      => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .vertical > .nav'        => 'border-right-color: {{VALUE}};',
				),
				'condition' => array(
					'tab_nav_effect' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'tab_content_pad',
			array(
				'label'      => esc_html__( 'Tab Content Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'nav_style',
			array(
				'label'     => esc_html__( 'Nav', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_layout_mode' => array(
						'creative',
						'tab',
					),
				),
			)
		);

		$this->add_responsive_control(
			'nav_margin',
			array(
				'label'      => esc_html__( 'Nav Margin', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_dimension',
			array(
				'label'      => esc_html__( 'Nav Padding', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'top'    => 8,
					'right'  => 15,
					'bottom' => 8,
					'left'   => 15,
				),
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nav .nav-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_space',
			array(
				'label'     => esc_html__( 'Nav Spacing (px)', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item + .nav-item' => 'margin-left: {{VALUE}}px;',
					'{{WRAPPER}} .horizontal > .nav .nav-item + .nav-item' => 'margin-left: {{VALUE}}px;',
					'{{WRAPPER}} .vertical > .nav .nav-item + .nav-item' => 'margin-top: {{VALUE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_nav_typography',
				'label'    => esc_html__( 'Nav Typography', 'molla-core' ),
				'selector' => '{{WRAPPER}} .nav .nav-item a',
			)
		);

		$this->start_controls_tabs( 'tabs_bg_color' );

		$this->start_controls_tab(
			'tab_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'bg_color',
			array(
				'label'     => esc_html__( 'Nav Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Nav Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_bd_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav.nav-pills .nav-item a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-border-anim a:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'bg_color_hover',
			array(
				'label'     => esc_html__( 'Nav Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'color_hover',
			array(
				'label'     => esc_html__( 'Nav Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_bd_hover_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item a:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav.nav-pills .nav-item a:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-border-anim a:hover:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_active',
			array(
				'label' => esc_html__( 'Active', 'molla-core' ),
			)
		);

		$this->add_control(
			'bg_color_active',
			array(
				'label'     => esc_html__( 'Nav Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item.active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'color_active',
			array(
				'label'     => esc_html__( 'Nav Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item.active a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_bd_active_color',
			array(
				'label'     => esc_html__( 'Border Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nav .nav-item.active a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav.nav-pills .nav-item.active a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .nav-border-anim .active a:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'accordion_style',
			array(
				'label'     => esc_html__( 'Accordion', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_layout_mode' => 'accordion',
				),
			)
		);

			$this->add_responsive_control(
				'accordion_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'top'    => 1,
						'right'  => 1,
						'bottom' => 1,
						'left'   => 1,
					),
					'size_units' => array(
						'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .accordion' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'accordion_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						// Stronger selector to avoid section style from overwriting
						'{{WRAPPER}} .accordion'       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .accordion-panel' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'accordion_content_pad',
				array(
					'label'      => esc_html__( 'Panel Content Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'{{WRAPPER}} .panel-body > .elementor-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'accordion_header_pad',
				array(
					'label'      => esc_html__( 'Panel Header Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .panel-header a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'panel_header_typography',
					'label'    => esc_html__( 'Panel Header Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .panel-header a',
				)
			);

			$this->start_controls_tabs( 'accordion_color_tabs' );

				$this->start_controls_tab(
					'accordion_color_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'molla-core' ),
					)
				);

					$this->add_control(
						'accordion_bg_color',
						array(
							'label'     => esc_html__( 'Header Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_color',
						array(
							'label'     => esc_html__( 'Header Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'accordion_color_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'molla-core' ),
					)
				);

					$this->add_control(
						'accordion_bg_color_hover',
						array(
							'label'     => esc_html__( 'Header Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_color_hover',
						array(
							'label'     => esc_html__( 'Header Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'accordion_color_active_tab',
					array(
						'label' => esc_html__( 'Active', 'molla-core' ),
					)
				);

					$this->add_control(
						'accordion_bg_color_active',
						array(
							'label'     => esc_html__( 'Header Background Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a:not(.collapsed)' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_color_active',
						array(
							'label'     => esc_html__( 'Header Color', 'molla-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'{{WRAPPER}} .panel-header a:not(.collapsed)' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'accordion_icon_typography',
					'separator' => 'before',
					'label'     => esc_html__( 'Header Icon Typography', 'molla-core' ),
					'selector'  => '{{WRAPPER}} .panel-header a > i:first-child',
				)
			);

			$this->add_control(
				'accordion_color_icon_space',
				array(
					'label'     => esc_html__( 'Header Icon Space', 'molla-core' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						'{{WRAPPER}} .panel-header a > i:first-child' => 'margin-right: {{VALUE}}px;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_style',
			array(
				'label'     => esc_html__( 'Video', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'              => esc_html__( 'Aspect Ratio', 'molla-core' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'169' => '16:9',
					'219' => '21:9',
					'43'  => '4:3',
					'32'  => '3:2',
					'11'  => '1:1',
					'916' => '9:16',
				),
				'default'            => '169',
				'prefix_class'       => 'elementor-aspect-ratio-',
				'frontend_available' => true,
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'video_css_filters',
				'selector' => '{{WRAPPER}} .elementor-wrapper',
			)
		);

		$this->add_responsive_control(
			'video_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-fit-aspect-ratio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'play_icon_title',
			array(
				'label'     => esc_html__( 'Play Icon', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'play_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'play_icon_size',
			array(
				'label'     => esc_html__( 'Size', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 300,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'           => 'play_icon_text_shadow',
				'selector'       => '{{WRAPPER}} .elementor-custom-embed-play i',
				'fields_options' => array(
					'text_shadow_type' => array(
						'label' => _x( 'Shadow', 'Text Shadow Control', 'molla-core' ),
					),
				),
				'condition'      => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			array(
				'label'     => esc_html__( 'Lightbox', 'molla-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'video_banner_switch' => 'yes',
					'show_image_overlay'  => 'yes',
					'image_overlay[url]!' => '',
					'lightbox'            => 'yes',
				),
			)
		);

		$this->add_control(
			'lightbox_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}}' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color',
			array(
				'label'     => esc_html__( 'UI Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color_hover',
			array(
				'label'     => esc_html__( 'UI Hover Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover' => 'color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'lightbox_video_width',
			array(
				'label'     => esc_html__( 'Content Width', 'molla-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => '%',
				),
				'range'     => array(
					'%' => array(
						'min' => 30,
					),
				),
				'selectors' => array(
					'(desktop+)#elementor-lightbox-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lightbox_content_position',
			array(
				'label'                => esc_html__( 'Content Position', 'molla-core' ),
				'type'                 => Controls_Manager::SELECT,
				'frontend_available'   => true,
				'options'              => array(
					''    => esc_html__( 'Center', 'molla-core' ),
					'top' => esc_html__( 'Top', 'molla-core' ),
				),
				'selectors'            => array(
					'#elementor-lightbox-{{ID}} .elementor-video-container' => '{{VALUE}}; transform: translateX(-50%);',
				),
				'selectors_dictionary' => array(
					'top' => 'top: 60px',
				),
			)
		);

		$this->add_responsive_control(
			'lightbox_content_animation',
			array(
				'label'              => esc_html__( 'Entrance Animation', 'molla-core' ),
				'type'               => Controls_Manager::ANIMATION,
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render section output in the editor.
	 *
	 * Used to generate the live preview, using a Backbone JavaScript template.
	 *
	 * @since 1.0
	 */
	protected function _content_template() {
		?>

		<# if ( 'slider' == settings.section_layout_mode ) { #>

		<?php wp_enqueue_script( 'owl-carousel' ); ?>

			<# if ( 'default' != settings.slider_animation_in || 'default' != settings.slider_animation_out ) {

			<?php wp_enqueue_style( 'animate' ); ?>

			} #>

		<# } else if ( 'tab' == settings.section_layout_mode || 'accordion' == settings.section_layout_mode ) { #>

		<?php wp_enqueue_script( 'bootstrap-bundle' ); ?>

		<# } #>

		<#
			let content_width = '';

			let classes = '',
				options = '',
				tab_nav_class = '',
				beforeHtml = '';

			let img_url = '',
				fixed = '',
				link_url = '',
				url_is_external = '',
				url_nofollow = '';

			if (settings.layout == 'boxed') {
				if ( 'yes' == settings.section_with_container_fluid ) {
					content_width = ' container-fluid';
				} else if ( 'yes' == settings.section_with_container ) {
					content_width = ' container';
				}
			}

			if ( 'slider' == settings.section_layout_mode ) {
				let owl_option_ary = {},
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

				settings.gap = 'no';

				classes += ' owl-carousel owl-simple ' + settings.slider_nav_pos + ' ' + settings.slider_nav_type + ( 'yes' != settings.slider_nav_show ? ' owl-nav-show' : '' ) + ( 'yes' == settings.slider_equal_height ? ' carousel-equal-height' : '' ) +
							' c-xl-' + owl_cols['xl'] +
							' c-lg-' + owl_cols['lg'] +
							' c-md-' + owl_cols['md'] +
							' c-sm-' + owl_cols['sm'] +
							' c-xs-' + owl_cols['xs'];
				options += ' data-toggle="owl"';
				owl_option_ary = {
					margin: '' !== settings.spacing.size ? parseInt( settings.spacing.size ) : 20,
					loop: 'yes' == settings.slider_loop ? true : false,
					autoplay: 'yes' == settings.slider_auto_play ? true : false,
					autoplayTimeout: settings.slider_auto_play_time,
					autoHeight: 'yes' == settings.slider_auto_height ? true : false,
					center: 'yes' == settings.slider_center ? true : false,
					animateIn: 'default' != settings.slider_animation_in ? settings.slider_animation_in : '',
					animateOut: 'default' != settings.slider_animation_out ? settings.slider_animation_out : '',
					responsive: {
						0 : {
							items : parseInt(owl_cols['xs']),
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
				options += ' data-owl-options=' + owl_option_ary;

			} else if ( 'banner' == settings.section_layout_mode ) {
				img_url = settings.background_image.url;
				fixed = settings.img_back_style;
				link_url = settings.link_url.url;
				url_is_external = settings.link_url.is_external ? ' target="nofollow"' : '';
				url_nofollow = settings.link_url.nofollow ? ' rel="_blank"' : '';
				classes = ' banner';
				if (settings.banner_hover_effect) {
					classes += ' ' + settings.banner_hover_effect;
				}

				if ( 'yes' == settings.img_back_style ) {
					classes += ' img-not-fixed';

					if ( 'yes' == settings.banner_parallax ) {
						options += settings.background_image.url ? (' data-plx-img="' + settings.background_image.url + '"') : '',
						options += settings.background_repeat ? (' data-plx-img-repeat="' + settings.background_repeat + '"') : '',
						options += settings.background_position ? (' data-plx-img-pos="' + settings.background_position + '"') : '',
						options += settings.background_attachment ? (' data-plx-img-att="' + settings.background_attachment + '"') : '',
						options += settings.background_size ? (' data-plx-img-size="' + settings.background_size + '"') : '';
						options += settings.parallax_speed ? (' data-plx-speed="' + settings.parallax_speed.size + '"') : '';
					}
				}
			} else if ( 'tab' == settings.section_layout_mode ) {
				classes = ' tab-section ' + settings.tab_type;
				tab_nav_class = 'nav ';
				tab_nav_class += settings.tab_nav_effect;
			} else if ( 'accordion' == settings.section_layout_mode ) {
				classes = ' accordion ';
			} else if ( 'creative' == settings.section_layout_mode ) {
				settings.gap = 'no';
				let height = settings.creative_height.size;
				let spacing = settings.spacing.size;
				let mode = settings.creative_mode;
				let height_ratio = settings.creative_height_ratio.size;
				if ( '' == height ) {
					height = 600;
				}
				if ( '' === spacing ) {
					spacing = 20;
				}
				if ( '' == mode ) {
					mode = 0;
				}
				if ( ! (Number(height_ratio) <= 100 && Number(height_ratio) >= 30) ) {
					height_ratio = 75;
				}

				classes = ' grid';
				options += ' data-toggle="isotope"';

				if ( settings.creative_float_grid ) {
					classes += ' float-grid';
				} else {
					let isotope_option_ary = {
						'masonry': {
							'columnWidth' : '.grid-space',
						}
					};
					isotope_option_ary = JSON.stringify( isotope_option_ary );
					options += ' data-isotope-options=' + isotope_option_ary;
					<?php wp_enqueue_script( 'isotope-pkgd' ); ?>
				}

				options += ' data-creative-mode=' + mode;
				options += ' data-creative-height=' + height;
				options += ' data-creative-spacing=' + spacing
				options += ' data-creative-height-ratio=' + height_ratio;
			}

			if ( 'yes' == settings.section_parallax ) {

				classes += ' section-parallax-inner';

				if ( settings.section_parallax_speed ) {
					options += ' data-plx-speed=' + parseInt( settings.section_parallax_speed.size );
				}
			}
			
			if ( 'yes' == settings.section_sticky ) {
				options += ' data-sticky="true"';
			}

			if ( settings.background_video_link ) {
				let videoAttributes = 'autoplay muted playsinline';
				if ( ! settings.background_play_once ) {
					videoAttributes += ' loop';
				}
		#>
			<div class="elementor-background-video-container elementor-hidden-phone">
				<div class="elemento-rbackground-video-embed"></div>
				<video class="elementor-background-video-hosted elementor-html5-video" {{ videoAttributes }}></video>
			</div>
		<# } #>
		<div class="elementor-background-overlay"></div>
		<div class="elementor-shape elementor-shape-top"></div>
		<div class="elementor-shape elementor-shape-bottom"></div>

		<# if ( 'creative' == settings.section_layout_mode && 'yes' == settings.creative_categories ) { #>
			<ul class="nav nav-filter nav-pills w-100">
			</ul>
		<# } #>

		<?php if ( $this->is_legacy_mode ) : ?>
		<div class="elementor-container{{ content_width }} elementor-column-gap-{{ settings.gap }}">
			<div class="elementor-row{{ classes }}"{{{ options }}}>
		<?php else : ?>
		<div class="elementor-container{{ content_width }} {{ classes }} elementor-column-gap-{{ settings.gap }}"{{{ options }}}>
		<?php endif; ?>

				<# if ( 'yes' == settings.video_banner_switch ) {
					view.addRenderAttribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video molla-section-video' );
					view.addRenderAttribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
					view.addRenderAttribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
					view.addRenderAttribute( 'video_widget_wrapper', 'data-settings', JSON.stringify( settings ) );

					view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-wrapper' );
					if ( ! settings.show_image_overlay || ! settings.lightbox ) {
						view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-fit-aspect-ratio' );
					}
					if ( ! settings.video_back ) {
						view.addRenderAttribute( 'video_wrapper', 'class', 'video-fixed' );
					} else {
						view.addRenderAttribute( 'video_widget_wrapper', 'style', 'position: absolute; left: 0; right: 0; top: 0; bottom: 0;' );
						view.addRenderAttribute( 'video_wrapper', 'style', 'width: 100%; height: 100%;' );
					}
					view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-open-' + ( settings.show_image_overlay && settings.lightbox ? 'lightbox' : 'inline' ) );

					#>
					<div {{{ view.getRenderAttributeString( 'video_widget_wrapper' ) }}}>
						<div {{{ view.getRenderAttributeString( 'video_wrapper' ) }}}>
					<#

					let urls = {
						'youtube': settings.youtube_url,
						'vimeo': settings.vimeo_url,
						'dailymotion': settings.dailymotion_url,
						'hosted': settings.hosted_url,
						'external': settings.external_url
					};

					let video_url = urls[settings.video_type],
						video_html = '';

					if ( 'hosted' === settings.video_type ) {
						if ( settings.insert_url ) {
							video_url = urls['external']['url'];
						} else {
							video_url = urls['hosted']['url'];
						}

						if ( video_url ) {
							if ( settings.start || settings.end ) {
								video_url += '#t=';
							}

							if ( settings.start ) {
								video_url += settings.start;
							}

							if ( settings.end ) {
								video_url += ',' + settings.end;
							}
						}
					}
					if ( video_url ) {

						let video_params = {},
							options = [ 'autoplay', 'loop', 'controls' ];
						if ( 'hosted' === settings.video_type ) {

							for ( let i = 0; i < options.length; i ++ ) {
								if ( settings[ options[i] ] ) {
									video_params[ options[i] ] = '';
								}
							}

							if ( settings.autoplay ) {
								video_params['autoplay'] = '';
							}
							if ( settings.loop ) {
								video_params['loop'] = '';
							}
							if ( settings.controls ) {
								video_params['controls'] = '';
							}

							if ( settings.mute ) {
								video_params.muted = 'muted';
							}

							if ( settings.play_on_mobile ) {
								video_params.playsinline = '';
							}

							if ( ! settings.download_button ) {
								video_params.controlsList = 'nodownload';
							}

							if ( settings.poster.url ) {
								video_params.poster = settings.poster.url;
							}

							view.addRenderAttribute( 'video_tag', 'src', video_url );

							let param_keys = Object.keys( video_params );

							for ( let i = 0; i < param_keys.length; i ++ ) {
								view.addRenderAttribute( 'video_tag', param_keys[i], video_params[param_keys[i]] );
							}
							if ( ! settings.show_image_overlay || ! settings.lightbox ) {
								#>
								<video {{{ view.getRenderAttributeString( 'video_tag' ) }}}></video>
								<#
							}

						} else {
							view.addRenderAttribute( 'video_tag', 'src', video_url );
							if ( ! settings.show_image_overlay || ! settings.lightbox ) {
								#>
								<iframe {{{ view.getRenderAttributeString( 'video_tag' ) }}}></iframe>
								<#
							}
						}

						if ( settings.image_overlay.url && 'yes' === settings.show_image_overlay ) {
							view.addRenderAttribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

							if ( 'yes' == settings.video_banner_parallax ) {
								view.addRenderAttribute( 'image-overlay', 'class', 'parallax-container' );
								view.addRenderAttribute( 'image-overlay', 'data-plx-img', settings.image_overlay.url );
								view.addRenderAttribute( 'image-overlay', 'data-plx-img-size', 'cover' );
								view.addRenderAttribute( 'image-overlay', 'data-plx-img-pos', 'center' );
								view.addRenderAttribute( 'image-overlay', 'data-plx-speed', parseInt( settings.video_parallax_speed.size ) );
							}
							if ( settings.show_image_overlay && settings.lightbox ) {
								let lightbox_url = video_url,
									lightbox_options = {};

								lightbox_options = {
									'type'        : 'video',
									'videoType'   : settings.video_type,
									'url'         : lightbox_url,
									'modalOptions': {
										'entranceAnimation'       : settings.lightbox_content_animation,
										'entranceAnimation_tablet': settings.lightbox_content_animation_tablet,
										'entranceAnimation_mobile': settings.lightbox_content_animation_mobile,
										'videoAspectRatio'        : settings.aspect_ratio,
									},
								};

								if ( 'hosted' === settings.video_type ) {
									lightbox_options['videoParams'] = video_params;
								}

								view.addRenderAttribute( 'image-overlay', 'data-elementor-open-lightbox', 'yes' );
								view.addRenderAttribute( 'image-overlay', 'data-elementor-lightbox', JSON.stringify( lightbox_options ) );
								view.addRenderAttribute( 'image-overlay-lightbox', 'src', settings.image_overlay.url );

							} else {
								view.addRenderAttribute( 'image-overlay', 'style', 'background-image: url(' + settings.image_overlay.url + ');' );
							}

							#>
							<div {{{ view.getRenderAttributeString( 'image-overlay' ) }}}>
								<# if ( settings.show_image_overlay && settings.lightbox ) { #>
									<img {{{ view.getRenderAttributeString( 'image-overlay-lightbox' ) }}}>
								<# } #>
								<# if ( 'yes' === settings.show_play_icon ) { #>
									<div class="elementor-custom-embed-play" role="button">
										<i class="eicon-play" aria-hidden="true"></i>
										<span class="elementor-screen-only"></span>
									</div>
								<# } #>
							</div>
							<#
						}
					}
					#>
						</div>
					</div>
				<# } #>

				<# if ( 'accordion' == settings.section_layout_mode ) { #>
				<div class="panel-header">
					<a href="#" role="button" data-toggle="collapse" class="collapsed" data-target="">
						<i></i>

						<span class="title"></span>

						<# if ( settings.accordion_active_icon ) { #>
							<span class="opened"><i class="{{ settings.accordion_active_icon.value }}"></i></span>
						<# } #>
						<# if ( settings.accordion_icon ) { #>
							<span class="closed"><i class="{{ settings.accordion_icon.value }}"></i></span>
						<# } #>
					</a>
				</div>
				<# } #>
				<# if ( 'banner' == settings.section_layout_mode && settings.banner_hover_effect ) { #>
					<div class="banner-overlay"></div>
				<# } #>
				<# if ( link_url ) { #>
					<a class="fill" href="{{ link_url }}"{{{ url_is_external }}}{{{ url_nofollow }}}></a>
				<# } #>
				<# if ( img_url && 'yes' != fixed ) { #>
					<figure class="banner-img">
						<img src="{{ img_url }}">
					</figure>
				<# } #>

				<# if ( 'tab' == settings.section_layout_mode ) { #>
					<ul class="{{ tab_nav_class }}" role="tablist">
					</ul>
				<# } #>
		<?php if ( $this->is_legacy_mode ) : ?>
			</div>
		<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Before section rendering.
	 *
	 * Used to add stuff before the section element.
	 *
	 * @since 1.0
	 */
	public function before_render() {
		$settings     = $this->get_settings_for_display();
		$classes      = '';
		$wrap_options = '';
		?>
		<<?php echo esc_html( $this->get_html_tag() ); ?> <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
			<?php
			if ( 'video' === $settings['background_background'] ) :
				if ( $settings['background_video_link'] ) :
					$video_properties = Embed::get_video_properties( $settings['background_video_link'] );
					?>
					<div class="elementor-background-video-container elementor-hidden-phone">
						<?php if ( $video_properties ) : ?>
							<div class="elementor-background-video-embed"></div>
							<?php
						else :
							$video_tag_attributes = 'autoplay muted playsinline';
							if ( 'yes' !== $settings['background_play_once'] ) :
								$video_tag_attributes .= ' loop';
							endif;
							?>
							<video class="elementor-background-video-hosted elementor-html5-video" <?php echo $video_tag_attributes; ?>></video>
						<?php endif; ?>
					</div>
					<?php
				endif;
			endif;

			$has_background_overlay = in_array( $settings['background_overlay_background'], [ 'classic', 'gradient' ], true ) ||
									in_array( $settings['background_overlay_hover_background'], [ 'classic', 'gradient' ], true );

			if ( $has_background_overlay ) :
				?>
				<div class="elementor-background-overlay"></div>
				<?php
			endif;

			if ( $settings['shape_divider_top'] ) {
				$this->print_shape_divider( 'top' );
			}

			if ( $settings['shape_divider_bottom'] ) {
				$this->print_shape_divider( 'bottom' );
			}

			if ( 'yes' == $settings['section_scrollable'] ) {
				wp_enqueue_script( 'molla-interactive-section-scroll' );
			}

			$slider_active = false;
			if ( isset( $settings['section_layout_mode'] ) && 'slider' == $settings['section_layout_mode'] ) {
				$settings['gap'] = 'no';

				do_action( 'molla_save_used_widget', 'slider' );
				wp_enqueue_script( 'owl-carousel' );

				$slider_active = true;
				$options       = array();
				$spacing       = '' !== $settings['spacing']['size'] ? intval( $settings['spacing']['size'] ) : 20;

				$options['margin']   = $spacing;
				$options['loop']     = 'yes' == $settings['slider_loop'] ? true : false;
				$options['autoplay'] = 'yes' == $settings['slider_auto_play'] ? true : false;
				$options['center']   = 'yes' == $settings['slider_center'] ? true : false;
				if ( $options['autoplay'] ) {
					$options['autoplayTimeout'] = $settings['slider_auto_play_time'];
				}

				$options['autoHeight'] = 'yes' == $settings['slider_auto_height'] ? true : false;
				if ( 'default' != $settings['slider_animation_in'] || 'default' != $settings['slider_animation_out'] ) {
					if ( 'default' != $settings['slider_animation_in'] ) {
						$options['animateIn'] = $settings['slider_animation_in'];
					}
					if ( 'default' != $settings['slider_animation_out'] ) {
						$options['animateOut'] = $settings['slider_animation_out'];
					}
				}
				$owl_options = array(
					0    => array(
						'items' => $settings['cols_under_mobile'],
						'dots'  => $settings['slider_dot_mobile'],
						'nav'   => $settings['slider_nav_mobile'],
					),
					576  => array(
						'items' => $settings['cols_mobile'],
						'dots'  => $settings['slider_dot_mobile'],
						'nav'   => $settings['slider_nav_mobile'],
					),
					768  => array(
						'items' => $settings['cols_tablet'],
						'dots'  => $settings['slider_dot_tablet'],
						'nav'   => $settings['slider_nav_tablet'],
					),
					992  => array(
						'items' => $settings['cols'],
						'dots'  => $settings['slider_dot'],
						'nav'   => $settings['slider_nav'],
					),
					1200 => array(
						'items' => $settings['cols_upper_desktop'],
						'dots'  => $settings['slider_dot'],
						'nav'   => $settings['slider_nav'],
					),
				);

				if ( defined( 'MOLLA_VERSION' ) ) {
					$options['responsive'] = molla_carousel_options( $owl_options );
					$col_classes           = molla_carousel_responsive_classes( $options['responsive'] );
				}

				$options = json_encode( $options );

				$classes = ' owl-carousel owl-simple' . esc_attr( ( $settings['slider_nav_pos'] ? ' ' . $settings['slider_nav_pos'] : '' ) ) . esc_attr( ( $settings['slider_nav_type'] ? ' ' . $settings['slider_nav_type'] : '' ) ) . esc_attr( 'yes' != $settings['slider_nav_show'] ? ' owl-nav-show' : '' ) . ( 'yes' == $settings['slider_equal_height'] ? ' carousel-equal-height' : '' ) . esc_attr( $col_classes ) . ' sp-' . esc_attr( $spacing );

				$wrap_options = ' data-toggle=owl data-owl-options = ' . esc_attr( $options ) . '';

			} elseif ( 'banner' == $settings['section_layout_mode'] ) {
				$classes = ' banner';
				do_action( 'molla_save_used_widget', 'banners' );
				if ( 'yes' == $settings['img_back_style'] ) {
					$classes .= ' img-not-fixed';
				}
				if ( $settings['banner_hover_effect'] ) {
					$classes .= ' ' . $settings['banner_hover_effect'];
				}
			} elseif ( 'tab' == $settings['section_layout_mode'] ) {
				wp_enqueue_script( 'bootstrap-bundle' );
				do_action( 'molla_save_used_widget', 'tabs' );
				$classes = ' tab-section ' . $settings['tab_type'];
			} elseif ( 'accordion' == $settings['section_layout_mode'] ) {
				global $molla_section;
				wp_enqueue_script( 'bootstrap-bundle' );
				do_action( 'molla_save_used_widget', 'cards' );
				$classes      = ' accordion';
				$wrap_options = ' id=' . 'accordion-' . $molla_section['parent_id'];
			} elseif ( 'creative' == $settings['section_layout_mode'] ) {
				$settings['gap'] = 'no';
				$classes         = ' grid';

				if ( $settings['creative_float_grid'] ) {
					$classes .= ' float-grid';
				} else {
					$wrap_options  = ' data-toggle=isotope';
					$options       = array(
						'masonry' => array(
							'columnWidth' => '.grid-space',
						),
					);
					$wrap_options .= ' data-isotope-options=' . json_encode( $options );
					wp_enqueue_script( 'isotope-pkgd' );
				}

				$breakpoints   = Elementor\Core\Responsive\Responsive::get_breakpoints();
				$wrap_options .= ' data-creative-breaks=' . json_encode(
					array(
						'md' => $breakpoints['md'],
						'lg' => $breakpoints['lg'],
					)
				);
			}

			if ( 'yes' == $settings['section_parallax'] ) {
				$classes .= ' section-parallax-inner';
			}

			$content_width = '';
			if ( 'boxed' == $settings['layout'] ) {
				if ( 'yes' == $settings['section_with_container_fluid'] ) {
					$content_width = ' container-fluid';
				} elseif ( 'yes' == $settings['section_with_container'] ) {
					$content_width = ' container';
				}
			}

			if ( 'creative' == $settings['section_layout_mode'] && $settings['creative_categories'] ) {
				global $molla_section;
				?>
			<ul class="elementor-container nav nav-filter nav-pills" data-duration="<?php echo esc_attr( $settings['creative_categories_transition']['size'] ); ?>">
				<li class="nav-item active"><a href="#" class="nav-link" data-filter="*"><?php esc_html_e( 'All', 'molla-core' ); ?></a></li>
				<?php foreach ( $molla_section['categories'] as $title ) : ?>
					<?php $slug = str_replace( ' ', '-', strtolower( $title ) ); ?>
				<li class="nav-item"><a href="#" class="nav-link <?php echo esc_attr( $slug ); ?>" data-filter=".<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $title ); ?></a></li>
				<?php endforeach; ?>
			</ul>
				<?php
			}

			if ( $this->is_legacy_mode ) :
				?>
			<div class="elementor-container<?php echo esc_attr( $content_width ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ); ?>">
				<div class="elementor-row<?php echo esc_attr( $classes ); ?>"<?php echo esc_attr( $wrap_options ); ?>>
				<?php
			else :
				?>
			<div class="elementor-container<?php echo esc_attr( $content_width ) . esc_attr( $classes ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ); ?>"<?php echo esc_attr( $wrap_options ); ?>>
				<?php
			endif;
			if ( 'creative' == $settings['section_layout_mode'] ) {
				global $molla_section;
				molla_creative_grid_item_css(
					$this->get_data( 'id' ),
					$molla_section['layout'],
					$settings['creative_height']['size'] ? $settings['creative_height']['size'] : 600,
					30 <= intval( $settings['creative_height_ratio']['size'] ) && 100 >= intval( $settings['creative_height_ratio']['size'] ) ? intval( $settings['creative_height_ratio']['size'] ) : 125,
					'' !== $settings['spacing']['size'] ? $settings['spacing']['size'] : 20
				);
			}
			?>
				<?php if ( 'banner' == $settings['section_layout_mode'] ) : ?>
					<?php if ( $settings['banner_hover_effect'] ) : ?>
						<div class="banner-overlay"></div>
					<?php endif; ?>
					<?php if ( isset( $settings['link_url']['url'] ) && $settings['link_url']['url'] ) : ?>
						<a class="fill" href="<?php echo esc_url( $settings['link_url']['url'] ); ?>"<?php echo esc_attr( $settings['link_url']['is_external'] ? 'target=nofollow' : '' ) . esc_attr( $settings['link_url']['nofollow'] ? ' rel=_blank' : '' ); ?>></a>
					<?php endif; ?>
					<?php if ( ! empty( $settings['background_image']['url'] ) && 'yes' != $settings['img_back_style'] && 'yes' != $settings['video_banner_switch'] ) : ?>
						<figure class="banner-img">
							<?php
							if ( function_exists( 'molla_option' ) && molla_option( 'lazy_load_img' ) ) {
								$settings['image_size'] = 'full';
							}
							echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'background_image' );
							?>
						</figure>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				if ( 'tab' == $settings['section_layout_mode'] ) :
					global $molla_section;
					?>
					<ul class="nav<?php echo ' ' . esc_attr( $settings['tab_nav_effect'] ); ?>" role="tablist">
					<?php foreach ( $molla_section['tab_data'] as $idx => $data ) : ?>
						<li class="nav-item<?php echo esc_attr( 0 == $idx ? ' active' : '' ); ?>"><a href="#" class="nav-link" data-toggle="tab" data-target="<?php echo esc_attr( $data['id'] ); ?>" role="tab"><?php echo esc_html( $data['title'] ); ?></a></li>
					<?php endforeach; ?>
					</ul>
					<?php
				endif;
				?>

				<?php
				if ( 'yes' == $settings['video_banner_switch'] ) :

					$video_url = $settings[ $settings['video_type'] . '_url' ];

					if ( 'hosted' === $settings['video_type'] ) {
						$video_url = $this->get_hosted_video_url();
					}

					if ( empty( $video_url ) ) {
						return;
					}

					if ( 'hosted' === $settings['video_type'] ) {
						ob_start();

						$this->render_hosted_video();

						$video_html = ob_get_clean();
					} else {
						$embed_params = $this->get_embed_params();

						$embed_options = $this->get_embed_options();

						$video_html = Embed::get_embed_html( $video_url, $embed_params, $embed_options );
					}

					if ( empty( $video_html ) ) {
						echo esc_url( $video_url );

						return;
					}

					$this->is_video_available = true;

					$this->add_render_attribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video molla-section-video' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-settings', wp_json_encode( $this->get_frontend_settings() ) );

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-wrapper' );

					if ( ! $settings['lightbox'] ) {
						$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-fit-aspect-ratio' );
					}
					if ( ! $settings['video_back'] ) {
						$this->add_render_attribute( 'video_wrapper', 'class', 'video-fixed' );
					}

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-open-' . ( $settings['lightbox'] ? 'lightbox' : 'inline' ) );
					?>


					<div <?php echo $this->get_render_attribute_string( 'video_widget_wrapper' ); ?>>
						<div <?php echo $this->get_render_attribute_string( 'video_wrapper' ); ?>>
							<?php
							if ( ! $settings['lightbox'] ) {
								echo $video_html; // XSS ok.
							}

							if ( $this->has_image_overlay() ) {
								$this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

								if ( 'yes' == $settings['video_banner_parallax'] ) {
									$this->add_render_attribute( 'image-overlay', 'class', 'parallax-container' );
									$this->add_render_attribute( 'image-overlay', 'data-plx-img', $settings['image_overlay']['url'] );
									$this->add_render_attribute( 'image-overlay', 'data-plx-img-size', 'cover' );
									$this->add_render_attribute( 'image-overlay', 'data-plx-img-pos', 'center' );
									$this->add_render_attribute( 'image-overlay', 'data-plx-speed', (int) $settings['video_parallax_speed']['size'] );
								}

								if ( $settings['lightbox'] ) {
									if ( 'hosted' === $settings['video_type'] ) {
										$lightbox_url = $video_url;
									} else {
										$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
									}

									global $molla_section;

									$lightbox_options = $molla_section['lightbox'];

									$this->add_render_attribute(
										'image-overlay',
										[
											'data-elementor-open-lightbox' => 'yes',
											'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
										]
									);

									if ( Plugin::$instance->editor->is_edit_mode() ) {
										$this->add_render_attribute(
											'image-overlay',
											[
												'class' => 'elementor-clickable',
											]
										);
									}
								} else {
									$this->add_render_attribute( 'image-overlay', 'style', 'background-image: url(' . Group_Control_Image_Size::get_attachment_image_src( $settings['image_overlay']['id'], 'image_overlay', $settings ) . ');' );
								}
								?>
								<div <?php echo $this->get_render_attribute_string( 'image-overlay' ); ?>>
									<?php if ( $settings['lightbox'] ) : ?>
										<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_overlay' ); ?>
									<?php endif; ?>
									<?php if ( 'yes' === $settings['show_play_icon'] ) : ?>
										<div class="elementor-custom-embed-play" role="button">
											<i class="eicon-play" aria-hidden="true"></i>
											<span class="elementor-screen-only"><?php echo esc_html__( 'Play Video', 'molla-core' ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							<?php } ?>
				<?php endif; ?>
		<?php
	}

	/**
	 * After section rendering.
	 *
	 * Used to add stuff after the section element.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function after_render() {
		$settings = $this->get_settings_for_display();

		if ( 'creative' == $settings['section_layout_mode'] ) {
			unset( $GLOBALS['molla_section'] );
			echo '<div class="grid-space"></div>';
		}

		if ( 'tab' == $settings['section_layout_mode'] || 'accordion' == $settings['section_layout_mode'] ) {
			unset( $GLOBALS['molla_section'] );
		}
		?>

				<?php if ( 'yes' == $settings['video_banner_switch'] && $this->is_video_available ) : ?>
						</div>
					</div>
				<?php endif; ?>
			<?php if ( $this->is_legacy_mode ) : ?>
				</div>
			<?php endif; ?>
			</div>
		</<?php echo esc_html( $this->get_html_tag() ); ?>>
		<?php
	}

	/**
	 * Get HTML tag.
	 *
	 * Retrieve the section element HTML tag.
	 *
	 * @since 1.0
	 */
	private function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'section';
		}

		return $html_tag;
	}

	/**
	 * Print section shape divider.
	 *
	 * Used to generate the shape dividers HTML.
	 *
	 * @since 1.0
	 */
	private function print_shape_divider( $side ) {
		$settings         = $this->get_active_settings();
		$base_setting_key = "shape_divider_$side";
		$negative         = ! empty( $settings[ $base_setting_key . '_negative' ] );
		?>
		<div class="elementor-shape elementor-shape-<?php echo esc_attr( $side ); ?>" data-negative="<?php echo var_export( $negative ); ?>">
			<?php include \Elementor\Shapes::get_shape_path( $settings[ $base_setting_key ], ! empty( $settings[ $base_setting_key . '_negative' ] ) ); ?>
		</div>
		<?php
	}

	public function get_embed_params() {
		$settings = $this->get_settings_for_display();

		$params = [];

		if ( $settings['autoplay'] && ! $this->has_image_overlay() ) {
			$params['autoplay'] = '1';

			if ( $settings['play_on_mobile'] ) {
				$params['playsinline'] = '1';
			}
		}

		$params_dictionary = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$params_dictionary = [
				'loop',
				'controls',
				'mute',
				'rel',
				'modestbranding',
			];

			if ( $settings['loop'] ) {
				$video_properties = Embed::get_video_properties( $settings['youtube_url'] );

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['start'] = $settings['start'];

			$params['end'] = $settings['end'];

			$params['wmode'] = 'opaque';
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$params_dictionary = [
				'loop',
				'mute'           => 'muted',
				'vimeo_title'    => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline'   => 'byline',
			];

			$params['color'] = str_replace( '#', '', $settings['color'] );

			$params['autopause'] = '0';
		} elseif ( 'dailymotion' === $settings['video_type'] ) {
			$params_dictionary = [
				'controls',
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo'     => 'ui-logo',
			];

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			$params['start'] = $settings['start'];

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = $settings[ $setting_name ] ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Whether the video has an overlay image or not.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function has_image_overlay() {
		$settings = $this->get_settings_for_display();

		return ! empty( $settings['image_overlay']['url'] ) && 'yes' === $settings['show_image_overlay'];
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	private function get_embed_options() {
		$settings = $this->get_settings_for_display();

		$embed_options = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$embed_options['privacy'] = $settings['yt_privacy'];
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$embed_options['start'] = $settings['start'];
		}

		$embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

		return $embed_options;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	private function get_hosted_params() {
		$settings = $this->get_settings_for_display();

		$video_params = [];

		foreach ( [ 'autoplay', 'loop', 'controls' ] as $option_name ) {
			if ( $settings[ $option_name ] ) {
				$video_params[ $option_name ] = '';
			}
		}

		if ( $settings['mute'] ) {
			$video_params['muted'] = 'muted';
		}

		if ( $settings['play_on_mobile'] ) {
			$video_params['playsinline'] = '';
		}

		if ( ! $settings['download_button'] ) {
			$video_params['controlsList'] = 'nodownload';
		}

		if ( $settings['poster']['url'] ) {
			$video_params['poster'] = $settings['poster']['url'];
		}

		return $video_params;
	}

	/**
	 * Returns video url
	 *
	 * @since 1.0
	 */
	private function get_hosted_video_url() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['insert_url'] ) ) {
			$video_url = $settings['external_url']['url'];
		} else {
			$video_url = $settings['hosted_url']['url'];
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		if ( $settings['start'] || $settings['end'] ) {
			$video_url .= '#t=';
		}

		if ( $settings['start'] ) {
			$video_url .= $settings['start'];
		}

		if ( $settings['end'] ) {
			$video_url .= ',' . $settings['end'];
		}

		return $video_url;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	private function render_hosted_video() {
		$video_url = $this->get_hosted_video_url();
		if ( empty( $video_url ) ) {
			return;
		}

		$video_params = $this->get_hosted_params();
		unset( $video_params['controlsList'] );
		?>
		<video class="elementor-video" src="<?php echo esc_url( $video_url ); ?>" <?php echo Utils::render_html_attributes( $video_params ); ?>></video>
		<?php
	}
}
