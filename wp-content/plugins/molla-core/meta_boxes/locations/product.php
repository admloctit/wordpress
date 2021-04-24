<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Molla product meta boxes
add_filter( 'rwmb_meta_boxes', 'molla_add_product_meta_boxes' );

function molla_add_product_meta_boxes( $meta_boxes ) {
	$general = array(
		'single_product_layout' => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Single Product Layout', 'molla-core' ),
			'id'         => 'single_product_layout',
			'options'    => array(
				''               => esc_html__( '-- Theme Option --', 'molla-core' ),
				'default'        => esc_html__( 'Default', 'molla-core' ),
				'gallery'        => esc_html__( 'Gallery', 'molla-core' ),
				'extended'       => esc_html__( 'Extended', 'molla-core' ),
				'sticky'         => esc_html__( 'Sticky Info', 'molla-core' ),
				'boxed'          => esc_html__( 'Boxed With Sidebar', 'molla-core' ),
				'full'           => esc_html__( 'Fullwidth With Sidebar', 'molla-core' ),
				'masonry_sticky' => esc_html__( 'Masonry Sticky Info', 'molla-core' ),
			),
			'save_field' => true,
		),
		'single_product_image'  => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Product Thumbnails', 'molla-core' ),
			'id'         => 'single_product_image',
			'options'    => array(
				''           => esc_html__( '-- Theme Option --', 'molla-core' ),
				'vertical'   => esc_html__( 'Vertical', 'molla-core' ),
				'horizontal' => esc_html__( 'Horizontal', 'molla-core' ),
			),
			'save_field' => true,
		),
		'single_product_center' => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Enable Center Mode', 'molla-core' ),
			'id'         => 'single_product_center',
			'options'    => array(
				''    => esc_html__( '-- Theme Option --', 'molla-core' ),
				'on'  => esc_html__( 'On', 'molla-core' ),
				'off' => esc_html__( 'Off', 'molla-core' ),
			),
			'save_field' => true,
		),
		'product_data_type'     => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Product Data Type', 'molla-core' ),
			'id'         => 'product_data_type',
			'options'    => array(
				''          => esc_html__( '-- Theme Option --', 'molla-core' ),
				'tab'       => esc_html__( 'Tab', 'molla-core' ),
				'accordion' => esc_html__( 'Accordion', 'molla-core' ),
			),
			'save_field' => true,
		),
		'product_deal_type'     => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Product Sale-Countdown Type', 'molla-core' ),
			'id'         => 'product_deal_type',
			'options'    => array(
				''       => esc_html__( '-- Theme Option --', 'molla-core' ),
				'block'  => esc_html__( 'Block', 'molla-core' ),
				'inline' => esc_html__( 'Inline', 'molla-core' ),
			),
			'save_field' => true,
		),
	);
	$tabs    = array(
		'tab_title_block'   => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Tab Title', 'molla-core' ),
			'id'         => 'tab_title_block',
			'save_field' => true,
		),
		'tab_content_block' => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Tab Block Name', 'molla-core' ),
			'id'         => 'tab_content_block',
			'save_field' => true,
		),
		'tab_title_1st'     => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Tab Title 1st', 'molla-core' ),
			'id'         => 'tab_title_1st',
			'save_field' => true,
		),
		'tab_content_1st'   => array(
			'type'       => 'wysiwyg',
			'name'       => esc_html__( 'Tab Content 1st', 'molla-core' ),
			'id'         => 'tab_content_1st',
			'save_field' => true,
		),
		'tab_title_2nd'     => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Tab Title 2nd', 'molla-core' ),
			'id'         => 'tab_title_2nd',
			'save_field' => true,
		),
		'tab_content_2nd'   => array(
			'type'       => 'wysiwyg',
			'name'       => esc_html__( 'Tab Content 2nd', 'molla-core' ),
			'id'         => 'tab_content_2nd',
			'save_field' => true,
		),
		'size_tab_name'     => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Size Tab', 'molla-core' ),
			'id'         => 'size_tab_name',
			'options'    => array(
				''      => esc_html__( '-- Theme Option --', 'molla-core' ),
				'block' => esc_html__( 'Tab Block', 'molla-core' ),
				'1st'   => esc_html__( 'Tab 1st', 'molla-core' ),
				'2nd'   => esc_html__( 'Tab 2nd', 'molla-core' ),
			),
			'save_field' => true,
		),
	);

	$meta_boxes[] = array(
		'title'      => esc_html__( 'Product Options', 'molla-core' ),
		'post_types' => array( 'product' ),
		'fields'     => $general,
	);
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Tabs', 'molla-core' ),
		'post_types' => array( 'product' ),
		'fields'     => $tabs,
	);

	return $meta_boxes;
}
