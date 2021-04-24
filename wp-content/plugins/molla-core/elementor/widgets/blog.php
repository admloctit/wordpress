<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Blogs Widget
 *
 * Molla Elementor widget to display posts.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Molla_Controls_Manager;

class Molla_Elementor_Blog_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_blog';
	}

	public function get_title() {
		return esc_html__( 'Molla Blogs', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'blog', 'posts', 'article' );
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
			'section_blogs',
			array(
				'label' => esc_html__( 'Blog Selector', 'molla-core' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'Title', 'molla-core' ),
			)
		);

		$this->add_control(
			'desc',
			array(
				'label'       => esc_html__( 'Description', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Description', 'molla-core' ),
			)
		);

		$this->add_control(
			'title_align',
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
					'{{WRAPPER}} .title-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'Select posts', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'post',
				'label_block' => true,
				'multiple'    => 'true',
			)
		);

		$this->add_control(
			'category',
			array(
				'label'       => esc_html__( 'Select categories', 'molla-core' ),
				'type'        => Molla_Controls_Manager::AJAXSELECT2,
				'options'     => 'category',
				'label_block' => true,
				'multiple'    => 'true',
			)
		);

		$this->add_control(
			'count',
			array(
				'type'  => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Posts Count Per Page', 'molla-core' ),
				'range' => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order by', 'molla-core' ),
				'options' => array(
					'',
					'title'         => esc_html__( 'Title', 'molla-core' ),
					'ID'            => esc_html__( 'ID', 'molla-core' ),
					'author'        => esc_html__( 'Author', 'molla-core' ),
					'date'          => esc_html__( 'Date', 'molla-core' ),
					'modified'      => esc_html__( 'Modified', 'molla-core' ),
					'rand'          => esc_html__( 'Random', 'molla-core' ),
					'comment_count' => esc_html__( 'Comment count', 'molla-core' ),
					'menu_order'    => esc_html__( 'Menu order', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order way', 'molla-core' ),
				'options' => array(
					'',
					'DESC' => esc_html__( 'Descending', 'molla-core' ),
					'ASC'  => esc_html__( 'Ascending', 'molla-core' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blogs_layout',
			array(
				'label' => esc_html__( 'Blog Layout', 'molla-core' ),
			)
		);

		$this->add_control(
			'layout_mode',
			array(
				'label'   => esc_html__( 'Layout Mode', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'molla-core' ),
					'creative' => esc_html__( 'Grid - Creative', 'molla-core' ),
					'slider'   => esc_html__( 'Slider', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Column Spacing (px)', 'molla-core' ),
				'description' => esc_html__( 'Leave blank if you use theme default value.', 'molla-core' ),
				'range'       => array(
					'px' => array(
						'step' => 5,
						'min'  => 0,
						'max'  => 40,
					),
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
					'layout_mode!' => array( 'creative' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Columns', 'molla-core' ),
				'default' => '4',
				'options' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
				),
			)
		);

		$this->add_control(
			'cols_under_mobile',
			array(
				'label'   => esc_html__( 'Columns Under Mobile ( <= 575px )', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''  => 'Default',
					'1' => 1,
					'2' => 2,
					'3' => 3,
				),
			)
		);

		$this->add_control(
			'blog_slider_nav_pos',
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
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_control(
			'blog_slider_nav_type',
			array(
				'label'     => esc_html__( 'Nav Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''                => esc_html__( 'Type 1', 'molla-core' ),
					'owl-full'        => esc_html__( 'Type 2', 'mollaa-core' ),
					'owl-nav-rounded' => esc_html__( 'Type 3', 'mollaa-core' ),
				),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show navigation?', 'molla-core' ),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
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
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show slider dots?', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'layout_mode' => array( 'slider' ),
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
					'layout_mode' => 'slider',
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
					'layout_mode' => 'slider',
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
					'layout_mode'      => 'slider',
					'slider_auto_play' => 'yes',
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
					'layout_mode' => 'slider',
				),
			)
		);

		$this->add_control(
			'view_more',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Ajax Load More', 'molla-core' ),
				'default' => 'button',
				'options' => array(
					''       => esc_html__( 'Do not load more', 'molla-core' ),
					'button' => esc_html__( 'View More Button', 'molla-core' ),
					'scroll' => esc_html__( 'Infinite Scroll', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'view_more_label',
			array(
				'label'       => esc_html__( 'Button Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'View More Articles', 'molla-core' ),
				'condition'   => array(
					'view_more' => 'button',
				),
			)
		);

		$this->add_control(
			'view_more_icon',
			array(
				'label'     => esc_html__( 'Icon', 'molla-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'icon-long-arrow-down',
					'library' => '',
				),
				'condition' => array(
					'view_more' => 'button',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blogs_style',
			array(
				'label' => esc_html__( 'Blog Style', 'molla-core' ),
			)
		);

		$this->add_control(
			'blog_type',
			array(
				'label'   => esc_html__( 'Blog Post Type', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'molla-core' ),
					'list'    => esc_html__( 'List', 'molla-core' ),
					'mask'    => esc_html__( 'Mask', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'blog_img_width',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Featured Image Width (cols)', 'molla-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 11,
					),
				),
				'condition' => array(
					'blog_type' => 'list',
				),
			)
		);

		$this->add_control(
			'post_align',
			array(
				'label'   => esc_html__( 'Content Align', 'molla-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
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
			)
		);

		$this->add_control(
			'post_show_op',
			array(
				'label'    => esc_html__( 'Show Options', 'molla-core' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'default'  => array(
					'f_image',
					'date',
					'comment',
					'category',
					'content',
					'read_more',
				),
				'options'  => array(
					'f_image'   => esc_html__( 'Featured Image', 'molla-core' ),
					'date'      => esc_html__( 'Date', 'molla-core' ),
					'author'    => esc_html__( 'Author', 'molla-core' ),
					'comment'   => esc_html__( 'Comment', 'molla-core' ),
					'category'  => esc_html__( 'Category', 'molla-core' ),
					'content'   => esc_html__( 'Content', 'molla-core' ),
					'read_more' => esc_html__( 'Read More', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'excerpt',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Excerpt Type', 'molla-core' ),
				'default' => 'theme',
				'options' => array(
					'theme'  => esc_html__( 'Theme options', 'molla-core' ),
					'custom' => esc_html__( 'Custom', 'molla-core' ),
				),
			)
		);

		$this->add_control(
			'excerpt_by',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Excerpt By', 'molla-core' ),
				'default'   => 'word',
				'options'   => array(
					'word'      => esc_html__( 'Words', 'molla-core' ),
					'character' => esc_html__( 'Characters', 'molla-core' ),
				),
				'condition' => array(
					'excerpt' => 'custom',
				),
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Excerpt Length', 'molla-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
					),
				),
				'condition' => array(
					'excerpt' => 'custom',
				),
			)
		);

		$this->add_control(
			'blog_more_label',
			array(
				'label'       => esc_html__( 'Read More Label', 'molla-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Continue Reading', 'molla-core' ),
			)
		);

		$this->add_control(
			'blog_more_icon',
			array(
				'type'    => Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Enable Icon on Hover', 'molla-core' ),
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_dim',
			array(
				'label' => esc_html__( 'Dimensions', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'heading_dimension',
			array(
				'label'      => esc_html__( 'Title Wrapper', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_dimension',
			array(
				'label'      => esc_html__( 'Title', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_dimension',
			array(
				'label'      => esc_html__( 'Description', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .heading-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'more_btn_dimension',
			array(
				'label'      => esc_html__( 'Load More Button', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .more-container .btn-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_dimension',
			array(
				'label'      => esc_html__( 'Post Meta', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .entry-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'name_dimension',
			array(
				'label'      => esc_html__( 'Post Title', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cat_dimension',
			array(
				'label'      => esc_html__( 'Post Category', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .entry-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_dimension',
			array(
				'label'      => esc_html__( 'Post Excerpt', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .entry-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'read_more_link_dimension',
			array(
				'label'      => esc_html__( 'Post Read More Link', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_style',
			array(
				'label' => esc_html__( 'Typography', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_heading_typography',
				'label'    => esc_html__( 'Heading', 'molla-core' ),
				'selector' => '{{WRAPPER}} .heading-title',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_desc_typography',
				'label'    => esc_html__( 'Description', 'molla-core' ),
				'selector' => '{{WRAPPER}} .heading-desc',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_meta_typography',
				'label'    => esc_html__( 'Post Meta', 'molla-core' ),
				'selector' => '{{WRAPPER}} .entry-meta a',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_title_typography',
				'label'    => esc_html__( 'Post Title', 'molla-core' ),
				'selector' => '{{WRAPPER}} .entry-title',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_cat_typography',
				'label'    => esc_html__( 'Post Category', 'molla-core' ),
				'selector' => '{{WRAPPER}} .entry-cats a',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_content_typography',
				'label'    => esc_html__( 'Post Content', 'molla-core' ),
				'selector' => '{{WRAPPER}} .entry-content p',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'blog_more_typography',
				'label'    => esc_html__( 'Read More', 'molla-core' ),
				'selector' => '{{WRAPPER}} .entry-content .read-more',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_color',
			array(
				'label' => esc_html__( 'Color', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'blog_heading_color',
			array(
				'label'     => esc_html__( 'Heading', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'blog_desc_color',
			array(
				'label'     => esc_html__( 'Description', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .heading-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_post_meta' );

		$this->start_controls_tab(
			'tab_post_meta_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'post_meta_color',
			array(
				'label'     => esc_html__( 'Post Meta', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-meta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_title_color',
			array(
				'label'     => esc_html__( 'Post Title', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_cat_color',
			array(
				'label'     => esc_html__( 'Post Category', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-cats' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_more_color',
			array(
				'label'     => esc_html__( 'Read More', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .read-more' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_post_meta_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'post_meta_color_hover',
			array(
				'label'     => esc_html__( 'Post Meta', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-meta a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_title_color_hover',
			array(
				'label'     => esc_html__( 'Post Title', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-title a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_cat_color_hover',
			array(
				'label'     => esc_html__( 'Post Category', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-cats:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_more_color_hover',
			array(
				'label'     => esc_html__( 'Read More', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .read-more:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'entry_content_color',
			array(
				'label'     => esc_html__( 'Post Content', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .entry-content p' => 'color: {{VALUE}};',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_btn_color' );
		$this->start_controls_tab(
			'tab_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);
		$this->add_control(
			'more_btn_color',
			array(
				'label'     => esc_html__( 'More Button Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'more_btn_bg_color',
			array(
				'label'     => esc_html__( 'More Button Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'more_btn_border',
				'selector' => '{{WRAPPER}} .more-container .btn-more',
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
			'more_btn_color_hover',
			array(
				'label'     => esc_html__( 'More Button Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'more_btn_bg_color_hover',
			array(
				'label'     => esc_html__( 'More Button Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'more_btn_border_hover',
				'selector' => '{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus',
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
			'more_btn_color_active',
			array(
				'label'     => esc_html__( 'More Button Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more:active' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'more_btn_bg_color_active',
			array(
				'label'     => esc_html__( 'More Button Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .more-container .btn-more:active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'more_btn_border_active',
				'selector' => '{{WRAPPER}} .more-container .btn-more:active',
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blogs_overlay',
			array(
				'label' => esc_html__( 'Overlay', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .entry-media > a:after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_dimension',
			array(
				'label'      => esc_html__( 'Spacing', 'molla-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .entry-media a:after' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .entry-media a:after',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'post_box_shadow',
			array(
				'label' => esc_html__( 'Shadow Effect', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_post_box_shadow' );

		$this->start_controls_tab(
			'tab_box_shadow_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'post_box_shadow',
				'selector' => '{{WRAPPER}} article.type-post',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_box_shadow_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'post_box_shadow_hover',
				'selector' => '{{WRAPPER}} article.type-post:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'post_slider_style',
			array(
				'label' => esc_html__( 'Slider', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			'post_slider_nav_width',
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
			'post_slider_nav_height',
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
					'blog_slider_nav_pos!' => 'owl-nav-top',
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
					'blog_slider_nav_pos' => 'owl-nav-top',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_nav_bg_color' );

		$this->start_controls_tab(
			'tab_nav_bg_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'molla-core' ),
			)
		);

		$this->add_control(
			'post_slider_nav_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_slider_nav_color',
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
				'name'     => 'post_slider_nav_border',
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
			'tab_nav_bg_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'molla-core' ),
			)
		);

		$this->add_control(
			'post_slider_nav_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'molla-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'post_slider_nav_color_hover',
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
				'name'     => 'post_slider_nav_border_hover',
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
					'blog_slider_nav_pos!' => array( 'owl-nav-outside' ),
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
					'blog_slider_nav_pos!' => array( '' ),
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
					'blog_slider_nav_pos' => array( '' ),
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
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_blog.php';
	}
}
