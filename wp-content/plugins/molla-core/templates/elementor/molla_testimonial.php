<?php

use Elementor\Group_Control_Image_Size;

extract(
	shortcode_atts(
		array(
			'name'                => 'John Doe',
			'job'                 => 'Customer',
			'link'                => '',
			'title'               => '',
			'content'             => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
			'avatar'              => array( 'url' => '' ),
			'rating'              => '',
			'show_numeric_rating' => 'no',
			'star_icon'           => '',
			'star_shape'          => '',
			'avatar_pos'          => 'top',
			'commenter_pos'       => 'after',
			'rating_pos'          => 'before',
			'rating_sp'           => array( 'size' => 0 ),
		),
		$atts
	)
);

$output = '';

$image = Group_Control_Image_Size::get_attachment_image_html( $atts, 'avatar' );
if ( isset( $link['url'] ) && $link['url'] ) {
	$image = '<a href="' . esc_url( $link['url'] ) . '">' . $image . '</a>';
}

if ( $avatar['url'] ) {
	$image = '<div class="avatar">' . $image . '</div>';
} else {
	$image = '<div class="avatar icon"></div>';
}

if ( 'top' == $avatar_pos || 'bottom' == $avatar_pos || 'aside' == $avatar_pos ) {
	$image_info = '';
} else {
	$image_info = $image;
	$image      = '';
}

$title_escaped = trim( esc_html( $title ) );
$content       = '<p class="comment">' . esc_textarea( $content ) . '</p>';
if ( ! empty( $title_escaped ) ) {
	$content = '<h5 class="comment-title">' . $title_escaped . '</h5>' . $content;
}
if ( $rating ) {
	$rating_cls = '';
	if ( $star_icon ) {
		$rating_cls .= ' ' . $star_icon;
	}
	if ( $star_shape ) {
		$rating_cls .= ' ' . $star_shape;
	}
	$spacing           = $rating_sp['size'] ? $rating_sp['size'] : 0;
	$rating_w          = 'calc(' . 20 * $rating . '% - ' . $spacing * ( $rating - floor( $rating ) ) . 'px)'; // get rating width
	$rating_wrap_class = 'ratings-container';
	if ( 'yes' == $show_numeric_rating ) {
		$rating_wrap_class .= ' numeric';
	}
	if ( 'before' == $rating_pos ) {
		$content = '<div class="' . $rating_wrap_class . '" data-rating="' . $rating . ' / 5.0"><div class="star-rating' . $rating_cls . '" style="letter-spacing: ' . $spacing . 'px;"><span style="width: ' . $rating_w . ';"></span></div></div>' . $content;
	} else {
		$content .= '<div class="' . $rating_wrap_class . '" data-rating="' . $rating . ' / 5.0"><div class="star-rating' . $rating_cls . '" style="letter-spacing: ' . $spacing . 'px;"><span style="width: ' . $rating_w . ';"></span></div></div>';
	}
}
$commenter = '<cite><span class="name">' . esc_html( $name ) . '</span><span class="job">' . esc_html( $job ) . '</span></cite>';

$output .= '<blockquote class="testimonial ' . esc_attr( $avatar_pos ) . '">';
if ( 'bottom' != $avatar_pos ) {
	$output .= $image;
}

if ( 'aside' == $avatar_pos ) {
	$output .= '<div class="content">';
}

if ( 'before' == $commenter_pos ) {
	$output .= '<div class="commenter">' . $image_info . $commenter . '</div>';
}

$output .= $content;

if ( 'after' == $commenter_pos ) {
	$output .= '<div class="commenter">' . $image_info . $commenter . '</div>';
}

if ( 'aside' == $avatar_pos ) {
	$output .= '</div>';
}

if ( 'bottom' == $avatar_pos ) {
	$output .= $image;
}
$output .= '</blockquote>';

echo $output;

do_action( 'molla_save_used_widget', 'testimonials' );
