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
use Elementor\Molla_Controls_Manager;

class Molla_Elementor_Block_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_block';
	}

	public function get_title() {
		return esc_html__( 'Molla Block', 'molla-core' );
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'block' );
	}

	public function get_script_depends() {
		$scripts = array( 'owl-carousel', 'isotope-pkgd' );
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_products',
			array(
				'label' => esc_html__( 'Block Selector', 'molla-core' ),
			)
		);

		$this->add_control(
			'name',
			array(
				'label'       => esc_html__( 'Select a Block', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'block',
				'label_block' => true,
			)
		);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_block.php';
	}
}
