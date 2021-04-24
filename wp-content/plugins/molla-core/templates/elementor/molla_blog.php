<?php

extract(
	shortcode_atts(
		array(
			'shortcode'             => 'blogs',
			'title'                 => '',
			'desc'                  => '',
			'count'                 => 5,
			'orderby'               => 'date',
			'order'                 => 'desc',
			'ids'                   => '',
			'category'              => '',
			'layout_mode'           => '',
			'spacing'               => 20,
			'cols_upper_desktop'    => '',
			'columns'               => 4,
			'columns_tablet'        => '',
			'columns_mobile'        => '',
			'cols_under_mobile'     => '',
			'blog_slider_nav_pos'   => '',
			'blog_slider_nav_type'  => '',
			'slider_nav'            => 'no',
			'slider_nav_show'       => 'yes',
			'slider_nav_tablet'     => 'no',
			'slider_nav_mobile'     => 'no',
			'slider_dot'            => 'no',
			'slider_dot_tablet'     => 'no',
			'slider_dot_mobile'     => 'no',
			'slider_loop'           => 'no',
			'slider_auto_play'      => 'no',
			'slider_auto_play_time' => 10000,
			'slider_center'         => 'no',
			'view_more'             => 'button',
			'view_more_label'       => '',
			'view_more_icon'        => '',

			'blog_type'             => '',
			'post_style'            => 'default',
			'blog_img_width'        => '',
			'post_align'            => 'left',
			'post_show_op'          => array(
				'f_image',
				'date',
				'comment',
				'category',
				'content',
				'read_more',
			),
			'excerpt'               => 'theme',
			'excerpt_by'            => 'word',
			'excerpt_length'        => 20,
			'blog_more_label'       => '',
			'blog_more_icon'        => 'yes',

		),
		$atts
	)
);

// For running shortcode
if ( is_string( $post_show_op ) ) {
	$post_show_op = explode( ',', $post_show_op );
}
if ( is_string( $view_more_icon ) ) {
	$view_more_icon = json_decode( $view_more_icon, true );
}
if ( is_string( $excerpt_length ) ) {
	$excerpt_length = json_decode( $excerpt_length, true );
}

$output       = '';
$heading_html = '';

if ( $title ) {
	$heading_html .= '<h2 class="heading-title">' . $title . '</h2>';
}
if ( $desc ) {
	$heading_html .= '<p class="heading-desc">' . $desc . '</p>';
}

if ( $heading_html ) {
	$output = '<div class="title-wrapper">' . $heading_html . '</div>';
}

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => is_array( $count ) && isset( $count['size'] ) ? $count['size'] : $count,
);

if ( $category ) {
	if ( ! is_array( $category ) ) {
		$category = str_replace( ' ', '', $category );
		$cat_arr  = explode( ',', $category );
	} else {
		$cat_arr = $category;
	}
	if ( isset( $cat_arr[0] ) && is_numeric( trim( $cat_arr[0] ) ) ) {
		$args['cat'] = $category;
	} else {
		$args['category_name'] = $category;
	}
}

if ( $ids ) {
	if ( ! is_array( $ids ) ) {
		$ids = str_replace( ' ', '', $ids );
		$ids = explode( ',', $ids );
	}

	for ( $i = 0; $i < count( $ids );  $i ++ ) {
		if ( '0' !== $ids[ $i ] && ! intval( $ids[ $i ] ) ) {
			if ( defined( 'MOLLA_VERSION' ) ) {
				$ids[ $i ] = molla_get_post_id_by_name( 'post', $ids[ $i ] );
			}
		}
	}

	$args['post__in'] = $ids;
	$args['orderby']  = 'post__in';
}

if ( $view_more ) {
	if ( is_front_page() ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = get_query_var( 'paged' );
	}

	if ( $paged ) {
		$args['paged'] = $paged;
	} else {
		$args['paged'] = 1;
	}
}

if ( $orderby ) {
	$args['orderby'] = $orderby;
}
if ( $order ) {
	$args['order'] = $order;
}

$posts = new WP_Query( $args );
if ( $spacing ) {
	if ( is_array( $spacing ) ) {
		$spacing = $spacing['size'] ? $spacing['size'] : 20;
	} else {
		$spacing = $spacing;
	}
}

ob_start();

if ( defined( 'MOLLA_VERSION' ) ) {

	do_action( 'molla_save_used_widget', 'blog' );
	if ( 'slider' == $layout_mode ) {
		do_action( 'molla_save_used_widget', 'slider' );
	}

	molla_get_template_part(
		'template-parts/posts/loop/loop-content',
		'',
		array(
			'posts_query'           => $posts,
			'spacing'               => $spacing,
			'layout_mode'           => $layout_mode,
			'blog_slider_nav_pos'   => $blog_slider_nav_pos,
			'blog_slider_nav_type'  => $blog_slider_nav_type,
			'cols_upper_desktop'    => $cols_upper_desktop,
			'columns'               => $columns,
			'columns_tablet'        => $columns_tablet,
			'columns_mobile'        => $columns_mobile,
			'cols_under_mobile'     => $cols_under_mobile,
			'slider_nav'            => $slider_nav,
			'slider_nav_show'       => $slider_nav_show,
			'slider_dot'            => $slider_dot,
			'slider_nav_tablet'     => $slider_nav_tablet,
			'slider_dot_tablet'     => $slider_dot_tablet,
			'slider_nav_mobile'     => $slider_nav_mobile,
			'slider_dot_mobile'     => $slider_dot_mobile,
			'slider_loop'           => 'yes' == $slider_loop ? true : false,
			'slider_auto_play'      => 'yes' == $slider_auto_play ? true : false,
			'slider_auto_play_time' => $slider_auto_play_time,
			'slider_center'         => 'yes' == $slider_center ? true : false,
			'view_more'             => $view_more,
			'blog_type'             => $blog_type,
			'img_width'             => isset( $blog_img_width['size'] ) ? $blog_img_width['size'] : 5,
			'show_op'               => $post_show_op,
			'align'                 => $post_align,
			'excerpt_type'          => $excerpt,
			'excerpt_by'            => $excerpt_by,
			'excerpt_length'        => isset( $excerpt_length['size'] ) ? $excerpt_length['size'] : 20,
			'blog_more_label'       => $blog_more_label,
			'blog_more_icon'        => $blog_more_icon,
			'view_more_label'       => $view_more_label,
			'view_more_icon'        => isset( $view_more_icon['value'] ) ? $view_more_icon['value'] : '',
			'args'                  => $args,
			'is_widget'             => true,
		)
	);
};

$output .= ob_get_clean();

echo $output;
