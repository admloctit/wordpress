<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Products Widget
 *
 * Molla Elementor widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Molla_Controls_Manager;

class Molla_Elementor_Lightbox_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_modal';
	}

	public function get_title() {
		return esc_html__( 'Molla Modal', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-lightbox';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'modal', 'popup', 'lightbox' );
	}

	public function get_script_depends() {
		$scripts = array( 'jquery-magnific-popup' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_products',
			array(
				'label' => esc_html__( 'Lightbox Options', 'molla-core' ),
			)
		);

		$this->add_control(
			'lightbox_content',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'What type to display?', 'molla-core' ),
				'default' => 'custom',
				'options' => array(
					'custom'  => esc_html__( 'Custom', 'molla-core' ),
					'youtube' => esc_html__( 'Youtube', 'molla-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'Url', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your URL', 'molla-core' ) . ' (YouTube)',
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition'   => array(
					'lightbox_content' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'Url', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your URL', 'molla-core' ) . ' (Vimeo)',
				'default'     => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition'   => array(
					'lightbox_content' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'lightbox_show',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Show on', 'molla-core' ),
				'default' => 'onload',
				'options' => array(
					'onload'   => esc_html__( 'Page Load', 'molla-core' ),
					'selector' => esc_html__( 'Selector', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'lightbox_timeout',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Timeout ( second )', 'molla-core' ),
				'default'   => '',
				'condition' => array(
					'lightbox_show' => 'onload',
				),
			)
		);

		$this->add_control(
			'selector',
			array(
				'label'     => esc_html__( 'CSS Selector', 'molla-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'lightbox_show' => 'selector',
				),
			)
		);

		global $molla_animations;

		$this->add_control(
			'lightbox_style',
			array(
				'type'    => Controls_Manager::SELECT2,
				'label'   => esc_html__( 'Popup Animation', 'molla-core' ),
				'default' => 'fadeIn',
				'options' => $molla_animations['animate_in'],
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'     => esc_html__( 'Content Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'html',
				'options'   => array(
					'block' => esc_html__( 'Popup', 'molla-core' ),
					'html'  => esc_html__( 'Custom Html', 'molla-core' ),
				),
				'condition' => array(
					'lightbox_content' => 'custom',
				),
			)
		);

		$this->add_control(
			'lightbox_block_name',
			array(
				'label'       => esc_html__( 'Select a Popup', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'popup',
				'label_block' => true,
				'condition'   => array(
					'content_type' => 'block',
				),
			)
		);

		$this->add_control(
			'html_content',
			array(
				'type'      => Controls_Manager::WYSIWYG,
				'label'     => esc_html__( 'Content', 'molla-core' ),
				'condition' => array(
					'content_type'     => 'html',
					'lightbox_content' => 'custom',
				),
			)
		);

		$this->add_control(
			'el_class',
			array(
				'type'  => Controls_Manager::TEXT,
				'label' => esc_html__( 'Custom Class', 'molla-core' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_lightbox.php';
	}
}

