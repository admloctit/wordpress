<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Molla post & page meta boxes
add_filter( 'rwmb_meta_boxes', 'molla_add_post_meta_boxes' );

function molla_add_post_meta_boxes( $meta_boxes ) {
	$fields = array(
		'title'                      => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Page Title', 'molla-core' ),
			'id'         => 'title',
			'save_field' => true,
		),
		'subtitle'                   => array(
			'type'       => 'text',
			'name'       => esc_html__( 'Page SubTitle', 'molla-core' ),
			'id'         => 'subtitle',
			'save_field' => true,
		),
		'page_header'                => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Show Page Header', 'molla-core' ),
			'id'         => 'page_header',
			'options'    => array(
				''     => esc_html__( '-- Theme Option --', 'molla-core' ),
				'show' => esc_html__( 'Show', 'molla-core' ),
				'hide' => esc_html__( 'Hide', 'molla-core' ),
			),
			'save_field' => true,
		),
		'page_header_type'           => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Page Header Type', 'molla-core' ),
			'class'      => 'parent-option option-page_header_type',
			'id'         => 'page_header_type',
			'options'    => array(
				''       => esc_html__( '-- Theme Option --', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
			'save_field' => true,
		),
		'page_header_background'     => array(
			'type'       => 'background',
			'name'       => esc_html__( 'Background', 'molla-core' ),
			'class'      => 'sub-option-page_header_type',
			'id'         => 'page_header_background',
			'save_field' => true,
		),
		'page_header_content'        => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Content Type', 'molla-core' ),
			'class'      => 'sub-option-page_header_type',
			'id'         => 'page_header_content',
			'options'    => array(
				''           => esc_html__( '-- Theme Option --', 'molla-core' ),
				'empty'      => '',
				'subtitle'   => esc_html__( 'Subtitle', 'molla-core' ),
				'breadcrumb' => esc_html__( 'Breadcrumb', 'molla-core' ),
			),
			'save_field' => true,
		),
		'breadcrumb'                 => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Show Breadcrumb', 'molla-core' ),
			'class'      => 'parent-option option-breadcrumb',
			'id'         => 'breadcrumb',
			'options'    => array(
				''     => esc_html__( '-- Theme Option --', 'molla-core' ),
				'show' => esc_html__( 'Show', 'molla-core' ),
				'hide' => esc_html__( 'Hide', 'molla-core' ),
			),
			'save_field' => true,
		),
		'breadcrumb_width'           => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Breadcrumb Width', 'molla-core' ),
			'class'      => 'sub-option-breadcrumb',
			'id'         => 'breadcrumb_width',
			'options'    => array(
				''                => esc_html__( '-- Theme Option --', 'molla-core' ),
				'page-width'      => esc_html__( 'Page Width', 'molla-core' ),
				'container'       => esc_html__( 'Container', 'molla-core' ),
				'container-fluid' => esc_html__( 'Container-Fluid', 'molla-core' ),
			),
			'save_field' => true,
		),
		'breadcrumb_divider'         => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Show Breadcrumb Divider', 'molla-core' ),
			'class'      => 'sub-option-breadcrumb',
			'id'         => 'breadcrumb_divider',
			'options'    => array(
				''     => esc_html__( '-- Theme Option --', 'molla-core' ),
				'show' => esc_html__( 'Show', 'molla-core' ),
				'hide' => esc_html__( 'Hide', 'molla-core' ),
			),
			'save_field' => true,
		),
		'breadcrumb_divider_width'   => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Breadcrumb Divider Width', 'molla-core' ),
			'class'      => 'sub-option-breadcrumb',
			'id'         => 'breadcrumb_divider_width',
			'options'    => array(
				''        => esc_html__( '-- Theme Option --', 'molla-core' ),
				'content' => esc_html__( 'Content Width', 'molla-core' ),
				'full'    => esc_html__( 'Full Width', 'molla-core' ),
			),
			'save_field' => true,
		),
		'content_top_block'          => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Content Top Block', 'molla-core' ),
			'id'         => 'content_top_block',
			'save_field' => true,
		),
		'content_inner_top_block'    => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Content Inner Top Block', 'molla-core' ),
			'id'         => 'content_inner_top_block',
			'save_field' => true,
		),
		'content_inner_bottom_block' => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Content Inner Bottom Block', 'molla-core' ),
			'id'         => 'content_inner_bottom_block',
			'save_field' => true,
		),
		'content_bottom_block'       => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Content Bottom Block', 'molla-core' ),
			'id'         => 'content_bottom_block',
			'save_field' => true,
		),
	);

	$page_layouts   = get_posts(
		array(
			'post_type'   => 'page_layout',
			'post_status' => 'publish',
		)
	);
	$page_layout_op = array(
		'' => esc_html__( 'Custom', 'molla-core' ),
	);
	foreach ( $page_layouts as $p ) {
		$page_layout_op[ $p->post_name ] = $p->post_title;
	}

	$page_layout_field = array(
		'page_layout_mode' => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Select Layout Mode', 'molla-core' ),
			'id'         => 'page_layout_mode',
			'options'    => $page_layout_op,
			'save_field' => true,
		),
	);

	$header_layouts = get_theme_mod( 'molla_header_builder_layouts', array() );
	if ( ! empty( $header_layouts ) ) {
		foreach ( $header_layouts as $key => $layout ) {
			if ( isset( $layout['name'] ) ) {
				$header_layouts[ $key ] = $layout['name'];
			}
		}
	}
	$header_layouts[''] = esc_html__( '-- Theme Option --', 'molla-core' );

	$layout_fields = array(
		'header_show'             => array(
			'type'       => 'radio',
			'name'       => esc_html__( 'Enable Header', 'molla-core' ),
			'id'         => 'header_show',
			'options'    => array(
				'show' => esc_html__( 'Show', 'molla-core' ),
				'hide' => esc_html__( 'Hide', 'molla-core' ),
			),
			'save_field' => true,
		),
		'header_layout_type'      => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Header Layout Type', 'molla-core' ),
			'id'         => 'header_layout_type',
			'options'    => $header_layouts,
			'save_field' => true,
		),
		'header'                  => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Header Skin', 'molla-core' ),
			'class'      => 'parent-option option-header',
			'id'         => 'header',
			'options'    => array(
				''       => esc_html__( '-- Theme Option --', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
			'save_field' => true,
		),
		'header_width'            => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Header Width', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_width',
			'options'    => array(
				'container'       => esc_html__( 'Container', 'molla-core' ),
				'container-fluid' => esc_html__( 'Container-Fluid', 'molla-core' ),
			),
			'save_field' => true,
		),
		'header_fixed'            => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Position Fixed Header', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_fixed',
			'options'    => array(
				''          => esc_html__( 'Fixed', 'molla-core' ),
				'not-fixed' => esc_html__( 'Not Fixed', 'molla-core' ),
			),
			'save_field' => true,
		),
		'header_bg'               => array(
			'type'       => 'background',
			'name'       => esc_html__( 'Header', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_bg',
			'save_field' => true,
		),
		'header_top_bg'           => array(
			'type'       => 'background',
			'name'       => esc_html__( 'Header Top', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_top_bg',
			'save_field' => true,
		),
		'header_main_bg'          => array(
			'type'       => 'background',
			'name'       => esc_html__( 'Header Main', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_main_bg',
			'save_field' => true,
		),
		'header_bottom_bg'        => array(
			'type'       => 'background',
			'name'       => esc_html__( 'Header Bottom', 'molla-core' ),
			'class'      => 'sub-option-header',
			'id'         => 'header_bottom_bg',
			'save_field' => true,
		),
		'sticky_header'           => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Sticky Header', 'molla-core' ),
			'class'      => 'parent-option option-sticky_header',
			'id'         => 'sticky_header',
			'options'    => array(
				''       => esc_html__( '-- Theme Option --', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
			'save_field' => true,
		),
		'header_top_in_sticky'    => array(
			'type'       => 'checkbox',
			'name'       => esc_html__( 'Header Top', 'molla-core' ),
			'class'      => 'sub-option-sticky_header',
			'id'         => 'header_top_in_sticky',
			'save_field' => true,
		),
		'header_main_in_sticky'   => array(
			'type'       => 'checkbox',
			'name'       => esc_html__( 'Header Main', 'molla-core' ),
			'class'      => 'sub-option-sticky_header',
			'id'         => 'header_main_in_sticky',
			'save_field' => true,
		),
		'header_bottom_in_sticky' => array(
			'type'       => 'checkbox',
			'name'       => esc_html__( 'Header Bottom', 'molla-core' ),
			'class'      => 'sub-option-sticky_header',
			'id'         => 'header_bottom_in_sticky',
			'save_field' => true,
		),
		'page_width'              => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Page Width', 'molla-core' ),
			'id'         => 'page_width',
			'options'    => array(
				''                => esc_html__( '-- Theme Option --', 'molla-core' ),
				'container'       => esc_html__( 'Container', 'molla-core' ),
				'container-fluid' => esc_html__( 'Container-Fluid', 'molla-core' ),
			),
			'save_field' => true,
		),
		'sidebar_pos'             => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Sidebar', 'molla-core' ),
			'id'         => 'sidebar_pos',
			'options'    => array(
				''      => esc_html__( '-- Theme Option --', 'molla-core' ),
				'no'    => esc_html__( 'No Sidebar', 'molla-core' ),
				'left'  => esc_html__( 'Left Sidebar', 'molla-core' ),
				'right' => esc_html__( 'Right Sidebar', 'molla-core' ),
			),
			'save_field' => true,
		),
		'footer_show'             => array(
			'type'       => 'radio',
			'name'       => esc_html__( 'Enable Footer', 'molla-core' ),
			'id'         => 'footer_show',
			'options'    => array(
				'show' => esc_html__( 'Show', 'molla-core' ),
				'hide' => esc_html__( 'Hide', 'molla-core' ),
			),
			'save_field' => true,
		),
		'footer_width'            => array(
			'type'       => 'select',
			'name'       => esc_html__( 'Footer Width', 'molla-core' ),
			'id'         => 'footer_width',
			'options'    => array(
				''                => esc_html__( '-- Theme Option --', 'molla-core' ),
				'container'       => esc_html__( 'Container', 'molla-core' ),
				'container-fluid' => esc_html__( 'Container-Fluid', 'molla-core' ),
			),
			'save_field' => true,
		),
	);
	$custom_css    = array(
		'page_css'    => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Custom CSS', 'molla-core' ),
			'id'         => 'page_css',
			'rows'       => 15,
			'save_field' => true,
		),
		'page_script' => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Custom JS Code', 'molla-core' ),
			'id'         => 'page_script',
			'rows'       => 15,
			'save_field' => true,
		),
	);
	$post_fields   = array(
		'featured_images'  => array(
			'type'       => 'file_advanced',
			'name'       => esc_html__( 'Featured Images', 'molla-core' ),
			'id'         => 'featured_images',
			'save_field' => true,
		),
		'media_embed_code' => array(
			'type'       => 'textarea',
			'name'       => esc_html__( 'Video & Audio Embed Code or Content', 'molla-core' ),
			'desc'       => esc_html__( 'Input embed code or use shortcodes', 'molla-core' ) . '* [video src="*.mp4 url"] *',
			'id'         => 'media_embed_code',
			'save_field' => true,
		),
	);

	if ( 'post.php' == $GLOBALS['pagenow'] && isset( $_GET['post'] ) ) {
		$post = get_post( $_GET['post'] );
		if ( $post && 'post' == $post->post_type ) {
			$fields = array_merge( $fields, $post_fields );
		}
		if ( $post && 'page' == $post->post_type ) {
			unset( $layout_fields['page_width'] );
			unset( $layout_fields['sidebar_pos'] );
		}
	} elseif ( 'post-new.php' == $GLOBALS['pagenow'] && ( ! isset( $_GET['post_type'] ) || ( 'page' != $_GET['post_type'] && 'page_layout' != $_GET['post_type'] ) ) ) {
		$fields = array_merge( $fields, $post_fields );
	}
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Page Layout Mode', 'molla-core' ),
		'post_types' => array( 'post', 'page', 'product' ),
		'fields'     => $page_layout_field,
	);
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Page Layout', 'molla-core' ),
		'post_types' => array( 'post', 'page', 'page_layout', 'product' ),
		'fields'     => $layout_fields,
	);
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Page Content', 'molla-core' ),
		'post_types' => array( 'post', 'page', 'product' ),
		'fields'     => $fields,
	);
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Page Content', 'molla-core' ),
		'post_types' => array( 'page_layout' ),
		'fields'     => array_slice( $fields, 2 ),
	);
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Custom CSS / JS', 'molla-core' ),
		'post_types' => array( 'page', 'product', 'post', 'block' ),
		'fields'     => $custom_css,
	);

	return $meta_boxes;
}
