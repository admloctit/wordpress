<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Core\Settings\Manager as SettingsManager;

class Molla_Elementor {

	protected $popup_css;

	public function __construct() {

		global $molla_animations;

		$molla_animations = array(
			'animate_in'  => array(
				'default'           => __( 'Default Animation', 'molla-core' ),
				'bounce'            => __( 'Bounce', 'molla-core' ),
				'flash'             => __( 'Flash', 'molla-core' ),
				'pulse'             => __( 'Pulse', 'molla-core' ),
				'rubberBand'        => __( 'RubberBand', 'molla-core' ),
				'shake'             => __( 'Shake', 'molla-core' ),
				'headShake'         => __( 'HeadShake', 'molla-core' ),
				'swing'             => __( 'Swing', 'molla-core' ),
				'tada'              => __( 'Tada', 'molla-core' ),
				'wobble'            => __( 'Wobble', 'molla-core' ),
				'jello'             => __( 'Jello', 'molla-core' ),
				'heartBeat'         => __( 'HearBeat', 'molla-core' ),
				'blurIn'            => __( 'BlurIn', 'molla-core' ),
				'bounceIn'          => __( 'BounceIn', 'molla-core' ),
				'bounceInUp'        => __( 'BounceInUp', 'molla-core' ),
				'bounceInDown'      => __( 'BounceInDown', 'molla-core' ),
				'bounceInLeft'      => __( 'BounceInLeft', 'molla-core' ),
				'bounceInRight'     => __( 'BounceInRight', 'molla-core' ),
				'fadeIn'            => __( 'FadeIn', 'molla-core' ),
				'fadeInUp'          => __( 'FadeInUp', 'molla-core' ),
				'fadeInUpBig'       => __( 'FadeInUpBig', 'molla-core' ),
				'fadeInDown'        => __( 'FadeInDown', 'molla-core' ),
				'fadeInDownBig'     => __( 'FadeInDownBig', 'molla-core' ),
				'fadeInLeft'        => __( 'FadeInLeft', 'molla-core' ),
				'fadeInLeftBig'     => __( 'FadeInLeftBig', 'molla-core' ),
				'fadeInRight'       => __( 'FadeInRight', 'molla-core' ),
				'fadeInRightBig'    => __( 'FadeInRightBig', 'molla-core' ),
				'flip'              => __( 'Flip', 'molla-core' ),
				'flipInX'           => __( 'FlipInX', 'molla-core' ),
				'flipInY'           => __( 'FlipInY', 'molla-core' ),
				'lightSpeedIn'      => __( 'LightSpeedIn', 'molla-core' ),
				'rotateIn'          => __( 'RotateIn', 'molla-core' ),
				'rotateInUpLeft'    => __( 'RotateInUpLeft', 'molla-core' ),
				'rotateInUpRight'   => __( 'RotateInUpRight', 'molla-core' ),
				'rotateInDownLeft'  => __( 'RotateInDownLeft', 'molla-core' ),
				'rotateInDownRight' => __( 'RotateInDownRight', 'molla-core' ),
				'hinge'             => __( 'Hinge', 'molla-core' ),
				'jackInTheBox'      => __( 'JackInTheBox', 'molla-core' ),
				'rollIn'            => __( 'RollIn', 'molla-core' ),
				'zoomIn'            => __( 'ZoomIn', 'molla-core' ),
				'zoomInUp'          => __( 'ZoomInUp', 'molla-core' ),
				'zoomInDown'        => __( 'ZoomInDown', 'molla-core' ),
				'zoomInLeft'        => __( 'ZoomInLeft', 'molla-core' ),
				'zoomInRight'       => __( 'ZoomInRight', 'molla-core' ),
				'slideInUp'         => __( 'SlideInUp', 'molla-core' ),
				'slideInDown'       => __( 'SlideInDown', 'molla-core' ),
				'slideInLeft'       => __( 'SlideInLeft', 'molla-core' ),
				'slideInRight'      => __( 'SlideInRight', 'molla-core' ),
			),
			'animate_out' => array(
				'default'            => __( 'Default Animation', 'molla-core' ),
				'blurOut'            => __( 'BlurOut', 'molla-core' ),
				'bounceOut'          => __( 'BounceOut', 'molla-core' ),
				'bounceOutUp'        => __( 'BounceOutUp', 'molla-core' ),
				'bounceOutDown'      => __( 'BounceOutDown', 'molla-core' ),
				'bounceOutLeft'      => __( 'BounceOutLeft', 'molla-core' ),
				'bounceOutRight'     => __( 'BounceOutRight', 'molla-core' ),
				'fadeOut'            => __( 'FadeOut', 'molla-core' ),
				'fadeOutUp'          => __( 'FadeOutUp', 'molla-core' ),
				'fadeOutUpBig'       => __( 'FadeOutUpBig', 'molla-core' ),
				'fadeOutDown'        => __( 'FadeOutDown', 'molla-core' ),
				'fadeOutDownBig'     => __( 'FadeOutDownBig', 'molla-core' ),
				'fadeOutLeft'        => __( 'FadeOutLeft', 'molla-core' ),
				'fadeOutLeftBig'     => __( 'FadeOutLeftBig', 'molla-core' ),
				'fadeOutRight'       => __( 'FadeOutRight', 'molla-core' ),
				'fadeOutRightBig'    => __( 'FadeOutRightBig', 'molla-core' ),
				'flipOutX'           => __( 'FlipOutX', 'molla-core' ),
				'flipOutY'           => __( 'FlipOutY', 'molla-core' ),
				'lightSpeedOut'      => __( 'LightSpeedOut', 'molla-core' ),
				'rotateOutUpLeft'    => __( 'RotateOutUpLeft', 'molla-core' ),
				'rotateOutRight'     => __( 'RotateOutUpRight', 'molla-core' ),
				'rotateOutDownLeft'  => __( 'RotateOutDownLeft', 'molla-core' ),
				'rotateOutDownRight' => __( 'RotateOutDownRight', 'molla-core' ),
				'rollOut'            => __( 'RollOut', 'molla-core' ),
				'zoomOut'            => __( 'ZoomOut', 'molla-core' ),
				'zoomOutUp'          => __( 'ZoomOutUp', 'molla-core' ),
				'zoomOutDown'        => __( 'ZoomOutDown', 'molla-core' ),
				'zoomOutLeft'        => __( 'ZoomOutLeft', 'molla-core' ),
				'zoomOutRight'       => __( 'ZoomOutRight', 'molla-core' ),
				'slideOutUp'         => __( 'SlideOutUp', 'molla-core' ),
				'slideOutDown'       => __( 'SlideOutDown', 'molla-core' ),
				'slideOutLeft'       => __( 'SlideOutLeft', 'molla-core' ),
				'slideOutRight'      => __( 'SlideOutRight', 'molla-core' ),
			),
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'elementor_scripts' ) );

		// Enqueue Elementor-admin js
		add_action(
			'elementor/editor/after_enqueue_scripts',
			function() {
				if ( defined( 'MOLLA_VERSION' ) ) {
					wp_enqueue_style( 'molla-font-icons', MOLLA_VENDOR . '/molla-fonts/css/font-icons.css', array(), MOLLA_VERSION );
				}
				wp_enqueue_script( 'molla-elementor-admin-js', MOLLA_CORE_URI . 'assets/js/elementor-admin.min.js', array( 'elementor-editor' ), MOLLA_CORE_VERSION, true );
			}
		);

		// Dequeue Elementor Default styles
		add_action(
			'elementor/frontend/after_register_styles',
			function() {
				// Animation Style
				wp_dequeue_style( 'elementor-animations' );
				wp_deregister_style( 'elementor-animations' );
			}
		);

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'elementor_style' ) );

		// Enqueue additional elementor css
		add_action( 'elementor/css-file/post/enqueue', array( $this, 'get_elementor_styles' ) );
		add_action( 'molla_before_theme_style', array( $this, 'add_global_css' ) );
		add_action( 'molla_before_custom_style', array( $this, 'add_page_css' ), 10 );

		// Register controls
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_elementor_controls' ) );
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ), 10, 1 );
		// Register elements
		add_action( 'elementor/elements/elements_registered', array( $this, 'register_elementor_elements' ), 10, 1 );
		// Upload Molla additional Icons
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'add_molla_icon_lib' ), 10, 1 );
		// Addtional animations in elementor default animations
		add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'add_animations' ) );

		// save blocks in post content
		add_action( 'save_post', array( $this, 'update_page_blocks' ), 99, 2 );

		// Builders.
		include_once MOLLA_ELEMENTOR_TEMPLATES . 'custom-product/MollaCustomProduct.php';

		// Display Conditional
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			require_once( MOLLA_CORE_DIR . 'elementor/conditional/' . 'init.php' );
		}

		// Elementor Custom Control Manager
		require_once( MOLLA_CORE_DIR . 'elementor/restapi/select2.php' );
		require_once( MOLLA_CORE_DIR . 'elementor/controls_manager/controls.php' );

		add_action(
			'elementor/elements/categories_registered',
			function( $self ) {

				// Add Molla elements category
				$self->add_category(
					'molla-elements',
					array(
						'title'  => esc_html__( 'Molla', 'molla-core' ),
						'active' => true,
					)
				);

				global $post;

				if ( 'product_layout' == $post->post_type ||
					'product' == get_post_meta( $post->ID, '_elementor_template_type', true ) ) {

					$self->add_category(
						'molla-single-layout',
						array(
							'title'  => esc_html__( 'Molla - Product Layout', 'molla-core' ),
							'active' => true,
						)
					);
				}
				if ( 'header' == $post->post_type ) {
					$self->add_category(
						'molla-header',
						array(
							'title'  => esc_html__( 'Molla - Header', 'molla-core' ),
							'active' => true,
						)
					);
				}
				if ( 'footer' == $post->post_type ) {
					$self->add_category(
						'molla-footer',
						array(
							'title'  => esc_html__( 'Molla - Footer', 'molla-core' ),
							'active' => true,
						)
					);
				}
			}
		);

		// For Changing page templates in Elementor Preview.
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			// For Changing page templates in Elementor Preview.
			add_filter(
				'template_include',
				function( $template ) {
					if ( is_singular() && defined( 'MOLLA_DIR' ) ) {

						if ( false !== strpos( $template, 'elementor' ) ) {
							return $template;
						}

						$document = Elementor\Plugin::$instance->documents->get_doc_for_frontend( get_the_ID() );
						if ( $document ) {
							$template_path = $document->get_meta( '_wp_page_template' );

							if ( 'default' == $template_path ) {
								$template_path = 'page.php';
							}

							if ( $template_path ) {
								$template = MOLLA_DIR . '/' . $template_path;
							}
						}
					}
					return $template;
				},
				14
			);
		}

		// Additional settings
		if ( wp_doing_ajax() ) {
			add_action(
				'elementor/document/before_save',
				function( $self, $data ) {
					if ( empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
						return;
					}
					$post_id = absint( $_REQUEST['editor_post_id'] );

					if ( ! empty( $data['settings']['page_css'] ) ) {
						update_post_meta( $post_id, 'page_css', wp_slash( $data['settings']['page_css'] ) );
					} else {
						delete_post_meta( $post_id, 'page_css' );
					}
					if ( ! empty( $data['settings']['page_script'] ) ) {
						update_post_meta( $post_id, 'page_script', wp_slash( $data['settings']['page_script'] ) );
					} else {
						delete_post_meta( $post_id, 'page_script' );
					}
				},
				10,
				2
			);
			add_action(
				'elementor/document/after_save',
				function( $self, $data ) {
					if ( current_user_can( 'unfiltered_html' ) || empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
						return;
					}
					$post_id = absint( $_REQUEST['editor_post_id'] );
					if ( ! empty( $data['settings']['page_css'] ) ) {
						$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
						if ( is_array( $elementor_settings ) ) {
							$elementor_settings['page_css']    = molla_strip_script_tags( get_post_meta( $post_id, 'page_css', true ) );
							$elementor_settings['page_script'] = molla_strip_script_tags( get_post_meta( $post_id, 'page_script', true ) );
							update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
						}
					}
				},
				10,
				2
			);
		}

		add_filter(
			'elementor/document/config',
			function( $config, $post_id ) {
				if ( empty( $config ) ) {
					$config = array();
				}
				if ( ! isset( $config['settings'] ) ) {
					$config['settings'] = array();
				}
				if ( ! isset( $config['settings']['settings'] ) ) {
					$config['settings']['settings'] = array();
				}

				$config['settings']['settings']['page_css']    = get_post_meta( $post_id, 'page_css', true );
				$config['settings']['settings']['page_script'] = get_post_meta( $post_id, 'page_script', true );
				return $config;
			},
			10,
			2
		);

		add_action(
			'elementor/documents/register_controls',
			function( $document ) {
				if ( ! $document instanceof Elementor\Core\DocumentTypes\PageBase && ! $document instanceof Elementor\Modules\Library\Documents\Page ) {
					return;
				}

				$id = (int) $document->get_main_id();
				if ( $id && 'popup' == get_post_type( $id ) ) {

					$selector = '.mfp-molla-lightbox-' . $id;

					$document->start_controls_section(
						'molla_popup_settings',
						array(
							'label' => __( 'Molla Popup Settings', 'molla-core' ),
							'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
						)
					);

					$document->add_responsive_control(
						'popup_width',
						array(
							'label'      => esc_html__( 'Width', 'molla-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 640,
							),
							'size_units' => array(
								'px',
								'vw',
							),
							'range'      => array(
								'vw' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'selectors'  => array(
								( $selector . ' .molla-lightbox-container' ) => 'width: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_height_type',
						array(
							'label'   => __( 'Height', 'molla-core' ),
							'type'    => Elementor\Controls_Manager::SELECT,
							'options' => array(
								''       => esc_html__( 'Fit To Content', 'molla-core' ),
								'custom' => esc_html__( 'Custom', 'molla-core' ),
							),
						)
					);

					$document->add_responsive_control(
						'popup_height',
						array(
							'label'      => esc_html__( 'Custom Height', 'molla-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 380,
							),
							'size_units' => array(
								'px',
								'vh',
							),
							'range'      => array(
								'vh' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'condition'  => array(
								'popup_height_type' => 'custom',
							),
							'selectors'  => array(
								( $selector . ' .molla-lightbox-container' ) => 'height: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_content_pos_heading',
						array(
							'label'     => __( 'Content Position', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_content_h_pos',
						array(
							'label'     => __( 'Horizontal', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'molla-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => __( 'Middle', 'molla-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'molla-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .molla-lightbox-container' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_content_v_pos',
						array(
							'label'     => __( 'Vertical', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'molla-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => __( 'Middle', 'molla-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'molla-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .molla-lightbox-container' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_pos_heading',
						array(
							'label'     => __( 'Position', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_h_pos',
						array(
							'label'     => __( 'Horizontal', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Left', 'molla-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => __( 'Center', 'molla-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => __( 'Right', 'molla-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_v_pos',
						array(
							'label'     => __( 'Vertical', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'molla-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => __( 'Middle', 'molla-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'molla-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_style_heading',
						array(
							'label'     => __( 'Style', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_control(
						'popup_overlay_color',
						array(
							'label'     => esc_html__( 'Overlay Color', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( '.mfp-bg' . $selector ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_content_color',
						array(
							'label'     => esc_html__( 'Content Color', 'molla-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( $selector . ' .molla-lightbox-container' ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_group_control(
						Elementor\Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'popup_box_shadow',
							'selector' => ( $selector . ' .molla-lightbox-container' ),
						)
					);

					global $molla_animations;

					$document->add_control(
						'popup_animation',
						array(
							'type'    => Elementor\Controls_Manager::SELECT2,
							'label'   => esc_html__( 'Popup Animation', 'molla-core' ),
							'default' => 'default',
							'options' => $molla_animations['animate_in'],
						)
					);

					$document->end_controls_section();
				}

				$document->start_controls_section(
					'molla_settings',
					array(
						'label' => esc_html__( 'Molla Custom Settings', 'molla-core' ),
						'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
					)
				);

				$document->add_control(
					'page_css',
					array(
						'type'  => Elementor\Controls_Manager::TEXTAREA,
						'rows'  => 30,
						'label' => esc_html__( 'Custom CSS', 'molla-core' ),
					)
				);

				$document->add_control(
					'page_script',
					array(
						'type'  => Elementor\Controls_Manager::TEXTAREA,
						'rows'  => 20,
						'label' => esc_html__( 'Custom JS Code', 'molla-core' ),
					)
				);

				$document->end_controls_section();
			}
		);
	}

	public function elementor_scripts() {

		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		if ( function_exists( 'molla_is_elementor_preview' ) && molla_is_elementor_preview() ) {
			wp_enqueue_style( 'molla-elementor-preview', MOLLA_CORE_CSS . 'elementor-preview.css' );
			wp_enqueue_script( 'molla-elementor-preview-js', MOLLA_CORE_JS . 'elementor-preview.min.js', array(), false, true );
		}

		wp_register_script( 'molla-elementor-widgets-js', MOLLA_CORE_JS . 'elementor.min.js', array(), false, true );

		$container_width   = get_theme_mod( 'container_width', 1188 );
		$grid_gutter_width = get_theme_mod( 'grid_gutter_width', 20 );
		if ( '' == $container_width ) {
			$container_width = 1188;
		}
		if ( '' == $grid_gutter_width ) {
			$grid_gutter_width = 20;
		}

		wp_localize_script(
			'molla-elementor-widgets-js',
			'plugin',
			array(
				'ajax_url'        => esc_js( admin_url( 'admin-ajax.php' ) ),
				'wpnonce'         => wp_create_nonce( 'molla_theme_action_nonce' ),
				'assets_url'      => MOLLA_CORE_JS,
				'breakpoints'     => Elementor\Core\Responsive\Responsive::get_breakpoints(),
				'container_width' => $container_width,
				'gutter_size'     => $grid_gutter_width,
			)
		);
	}

	public function elementor_style() {
		// styles
		wp_enqueue_style( 'molla-elementor', MOLLA_CORE_CSS . 'elementor.css' );
	}

	public function get_elementor_styles( $self ) {
		if ( 'file' === $self->get_meta()['status'] ) { // Re-check if it's not empty after CSS update.
			preg_match( '/post-(\d+).css/', $self->get_url(), $id );
			if ( count( $id ) == 2 ) {
				global $el_post_ids;

				wp_dequeue_style( 'elementor-post-' . $id[1] );

				if ( get_the_ID() == $id[1] ) {
					wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array( 'elementor-frontend', 'molla-dynamic-style' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				} else {
					wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array( 'elementor-frontend' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				}

				if ( ! isset( $el_post_ids ) ) {
					$el_post_ids = array();
				}
				$el_post_ids[] = $id[1];
			}
		}
	}
	public function add_global_css() {
		if ( molla_using_elementor_block() ) {
			wp_enqueue_style( '	' );
			wp_enqueue_style( 'elementor-animations' );
			wp_enqueue_style( 'elementor-frontend' );

			if ( isset( \Elementor\Plugin::$instance ) ) {
				$kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
				if ( $kit_id ) {
					wp_enqueue_style( 'elementor-post-' . $kit_id, wp_upload_dir()['baseurl'] . '/elementor/css/post-' . $kit_id . '.css' );
				}

				add_action(
					'wp_footer',
					function() {
						try {
							wp_enqueue_script( 'elementor-frontend' );
							$settings = \Elementor\Plugin::$instance->frontend->get_settings();
							\Elementor\Utils::print_js_config( 'elementor-frontend', 'elementorFrontendConfig', $settings );
						} catch ( Exception $e ) {
						}
					}
				);
			}

			$scheme_css_file = Global_CSS::create( 'global.css' );
			$scheme_css_file->enqueue();
		}

		global $el_post_ids;
		if ( is_array( $el_post_ids ) ) {
			foreach ( $el_post_ids as $id ) {
				if ( get_the_ID() != $id ) {
					wp_enqueue_style( 'elementor-post-' . $id );
				}
			}
		}
	}

	public function add_page_css() {

		// register block css after post css
		global $molla_settings;
		$page_id = get_the_ID();

		if ( ! empty( $molla_settings['page_blocks'] ) ) {
			$upload_dir = wp_upload_dir()['basedir'];
			$upload_url = wp_upload_dir()['baseurl'];

			foreach ( $molla_settings['page_blocks'] as $block_id => $enqueued ) {
				if ( ( ! molla_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $block_id ) && molla_is_elementor_block( $block_id ) ) { // Check if current elementor block is editing

					$block_css = get_post_meta( (int) $block_id, 'page_css', true );
					if ( $block_css && function_exists( 'molla_minify_css' ) ) {
						$block_css = molla_minify_css( $block_css, molla_option( 'minify_css_js' ) );
					}

					$css_file = Elementor\Core\Files\CSS\Post::create( $block_id );
					$css_file->enqueue();
					if ( ! wp_style_is( 'elementor-post-' . $block_id ) ) {
						wp_register_style( 'elementor-post-' . $block_id, wp_upload_dir()['baseurl'] . '/elementor/css/post-' . $block_id . '.css' );
						wp_add_inline_style( 'elementor-post-' . $block_id, $block_css );
						wp_enqueue_style( 'elementor-post-' . $block_id );
					}

					$molla_settings['page_blocks'][ $block_id ]['css'] = true;
				}
			}
		}

		// enqueue post css
		wp_enqueue_style( 'elementor-post-' . $page_id );
	}

	// register elementor custom coltrols
	public function register_elementor_controls( $self ) {

		$controls = array(
			'radio_image' => 'Radio_Image',
			'ajaxselect2' => 'Ajax_Select2',
		);

		foreach ( $controls as $elem => $control_id ) {
			include MOLLA_CORE_CONTROLS . $elem . '.php';

			$class_name = '\Control_' . $control_id;
			$self->register_control( $elem, new $class_name() );
		}
	}

	// register elementor widgets
	public function register_elementor_widgets( $self ) {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		$widgets = array(
			'heading',
			'button',
			'count_down',
			'count_to',
			'banner',
			'blog',
			'product',
			'product_category',
			'product_brand',
			'block',
			'nav_menu',
			'team_member',
			'testimonial',
			'image_carousel',
			'lightbox',
			'hotspot',
			'floating_image',
		);

		foreach ( $widgets as $elem ) {
			if ( 'lightbox' == $elem && 'popup' == get_post_type() ) {
				continue;
			}
			include MOLLA_CORE_WIDGETS . $elem . '.php';
			$class_name = 'Molla_Elementor_' . ucfirst( $elem ) . '_Widget';
			$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
		}

		$builder_elements = array(
			'custom-product' => array(
				'image',
				'navigation',
				'title',
				'meta',
				'rating',
				'price',
				'countdown',
				'excerpt',
				'cart_form',
				'share',
				'data_tab',
				'linked_products',
			),
			'custom-header'  => array(
				'login_popup',
				'search',
				'cart',
				'wishlist',
				'lang_switcher',
				'currency_switcher',
				'responsive_group',
				'mobile_toggle',
				'vertical_divider',
			),
		);

		global $post;

		foreach ( $builder_elements as $path => $value ) {
			$builder   = str_replace( 'custom-', '', $path );
			$post_type = ( 'product' == $builder ? 'product_layout' : $builder );
			if ( ! molla_is_elementor_preview() || ( $post && $post_type == $post->post_type ) ) {
				foreach ( $value as $class_name ) {
					include MOLLA_CORE_WIDGETS . ( $path ? $path . '/' : '' ) . $class_name . '.php';
					$class_name = 'Molla_Custom_' . ucfirst( $builder ) . '_' . ucfirst( $class_name ) . '_Widget';
					$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
				}
			}
		}
	}

	// register elementor elements
	public function register_elementor_elements( $self ) {
		// load molla element column
		require_once MOLLA_CORE_DIR . 'elementor/elements/column.php';
		// load molla element section
		require_once MOLLA_CORE_DIR . 'elementor/elements/section.php';
		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'section' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Molla_Element_Section() );
	}

	public function add_molla_icon_lib( $icons ) {
		if ( defined( 'MOLLA_VERSION' ) ) {
			$icons['molla-icons'] = array(
				'name'          => 'molla-icons',
				'label'         => esc_html__( 'Molla Icons', 'molla-core' ),
				'prefix'        => 'icon-',
				'displayPrefix' => '',
				'labelIcon'     => 'fab fa-font-awesome-flag',
				'fetchJson'     => MOLLA_CORE_URI . 'assets/js/icons/molla-icons.js',
				'ver'           => MOLLA_CORE_VERSION,
				'native'        => false,
			);
		}
		return $icons;
	}

	public function add_animations() {
		$additional = array(
			'Fliping' => array(
				'flip'    => esc_html__( 'Flip', 'molla-core' ),
				'flipInX' => esc_html__( 'FlipInX', 'molla-core' ),
				'flipInY' => esc_html__( 'FlipInY', 'molla-core' ),
			),
			'Blur'    => array(
				'blurIn' => esc_html__( 'BlurIn', 'molla-core' ),
			),
		);
		return $additional;
	}

	public function update_page_blocks( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			return;
		}

		if ( ! isset( $_POST['actions'] ) ) {
			return;
		}

		$blocks = array();
		$data   = $_POST['actions'];
		preg_match_all( '|lightbox_block_name\\\":\\\"([^\\\\]*)|', $data, $blocks );
		if ( ! empty( $blocks ) ) {
			for ( $i = 0; $i < count( $blocks[1] ); $i ++ ) {
				$blocks[1][ $i ] = molla_get_post_id_by_name( 'popup', $blocks[1][ $i ] );
			}
			update_post_meta( $post_id, '_molla_blocks_page_content', $blocks[1] );
		}
	}

}

new Molla_Elementor;
