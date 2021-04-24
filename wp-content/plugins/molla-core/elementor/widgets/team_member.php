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
use Elementor\Group_Control_Image_Size;

class Molla_Elementor_Team_Member_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_team_member';
	}

	public function get_title() {
		return esc_html__( 'Molla Team Member', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'member', 'name', 'description' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_categories',
			array(
				'label' => esc_html__( 'Member Content', 'molla-core' ),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'member-anim',
				'options' => array(
					'member-anim'  => esc_html__( 'Default', 'molla-core' ),
					'member-frame' => esc_html__( 'Frame', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'avatar',
			array(
				'label' => esc_html__( 'Avatar', 'molla-core' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'avatar',
				'default'   => 'large',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'name',
			array(
				'label'       => esc_html__( 'Name', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Name',
			)
		);

		$this->add_control(
			'job',
			array(
				'label'       => esc_html__( 'Job', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Job',
			)
		);

		$this->add_control(
			'desc',
			array(
				'label'       => esc_html__( 'Description', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'Description Here...',
			)
		);
		$this->add_control(
			'facebook',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Facebook', 'molla-core' ),
				'default'     => array(
					'url' => '#',
				),
				'placeholder' => 'Facebook Link Url',
			)
		);

		$this->add_control(
			'linkedin',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'LinkedIn', 'molla-core' ),
				'default'     => array(
					'url' => '',
				),
				'placeholder' => 'LinkedIn Link Url',
			)
		);

		$this->add_control(
			'twitter',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Twitter', 'molla-core' ),
				'default'     => array(
					'url' => '#',
				),
				'placeholder' => 'Twitter Link Url',
			)
		);

		$this->add_control(
			'instagram',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Instagram', 'molla-core' ),
				'default'     => array(
					'url' => '#',
				),
				'placeholder' => 'Instagram Link Url',
			)
		);

		$this->add_control(
			'youtube',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Youtube', 'molla-core' ),
				'default'     => array(
					'url' => '',
				),
				'placeholder' => 'Youtube Link Url',
			)
		);

		$this->add_control(
			'pinterest',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Pinterest', 'molla-core' ),
				'default'     => array(
					'url' => '',
				),
				'placeholder' => 'Pinterest Link Url',
			)
		);

		$this->add_control(
			'tumblr',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Tumblr', 'molla-core' ),
				'default'     => array(
					'url' => '',
				),
				'placeholder' => 'Tumblr Link Url',
			)
		);

		$this->add_control(
			'whatsapp',
			array(
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'WhatsApp', 'molla-core' ),
				'default'     => array(
					'url' => '',
				),
				'placeholder' => 'WhatsApp Link Url',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_team_member.php';
	}

}
