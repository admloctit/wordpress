<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Custom Product Image
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Molla_Custom_Product_Image_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_cl_image'; // custom layout image
	}

	public function get_title() {
		return esc_html__( 'Molla Product Image', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_categories() {
		return array( 'molla-single-layout' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'image' );
	}

	public function get_script_depends() {
		$scripts = array();
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_image',
			array(
				'label' => esc_html__( 'Content', 'molla-core' ),
			)
		);
			$this->add_control(
				'cl_image_type',
				array(
					'label'   => esc_html__( 'Product Image Type', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'vertical',
					'options' => array(
						'horizontal' => esc_html__( 'Horizontal Thumbs', 'molla-core' ),
						'vertical'   => esc_html__( 'Vertical Thumbs', 'molla-core' ),
						'gallery'    => esc_html__( 'Gallery Type', 'molla-core' ),
						'grid'       => esc_html__( 'Grid Type', 'molla-core' ),
						'masonry'    => esc_html__( 'Masonry Grid', 'molla-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'cl_image_columns',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Columns', 'molla-core' ),
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
						'cl_image_type' => array(
							'gallery',
							'grid',
							'masonry',
						),
					),
				)
			);

			$this->add_control(
				'cl_image_cols_under_mobile',
				array(
					'label'     => esc_html__( 'Columns Under Mobile', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '1',
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
					),
					'condition' => array(
						'cl_image_type' => array(
							'gallery',
							'grid',
							'masonry',
						),
					),
				)
			);

			$this->add_control(
				'cl_image_spacing',
				array(
					'type'    => Controls_Manager::SLIDER,
					'label'   => esc_html__( 'Spacing (px)', 'molla-core' ),
					'default' => array(
						'size' => 10,
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

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		do_action( 'molla_custom_layout_image', $atts );
	}
}
