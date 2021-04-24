<?php

extract( /* @codingStandardsIgnoreLine */
	shortcode_atts(
		array(
			'text'          => 'Click here',
			'button_type'   => '',
			'button_size'   => '',
			'button_skin'   => 'btn-primary',
			'shadow'        => '',
			'button_border' => 'btn-rounded',
			'link'          => '',
			'icon'          => '',
			'icon_pos'      => 'after',
			'btn_class'     => '',
			'show_icon'     => 'no',
			'video_btn'     => 'no',
		),
		$atts
	)
);
$html = '';
if ( $text ) {
	$text = '<span ' . $this->get_render_attribute_string( 'text' ) . '>' . esc_html( $text ) . '</span>';
}
if ( is_array( $icon ) && $icon['value'] ) {
	$html = '<i class="' . $icon['value'] . '"></i>';
}
if ( 'before' == $icon_pos ) {
	$html .= $text;
} else {
	$html = $text . $html;
}

$class  = 'btn elementor-button ';
$class .= esc_attr( $button_skin ) . ' ' . esc_attr( $button_size ) . ( esc_attr( $button_type ? ( ' ' . $button_type ) : '' ) ) . esc_attr( $button_border ? ( ' ' . $button_border ) : '' ) . ' icon-' . esc_attr( $icon_pos ) . ( $shadow ? ( ' ' . $shadow ) : '' ) . ( 'yes' == $show_icon ? ' icon-hidden' : '' ) . esc_attr( $btn_class ? ( ' ' . $btn_class ) : '' );

$url = $link['url'] ? esc_url( $link['url'] ) : '#';

global $molla_section;
if ( isset( $molla_section['video'] ) && 'yes' == $video_btn ) {
	$class  .= ' btn-video elementor-custom-embed-image-overlay';
	$options = array();
	if ( isset( $molla_section['lightbox'] ) ) {
		$options = $molla_section['lightbox'];
	}
	echo '<div class="' . $class . '" role="button"' . ( $options ? ( ' data-elementor-open-lightbox="yes" data-elementor-lightbox="' . esc_attr( json_encode( $options ) ) . '"' ) : '' ) . '>' . $html . '</div>';
} else {
	echo '<a href="' . $url . '"' . ( $link['is_external'] ? 'target="nofollow"' : '' ) . ( $link['nofollow'] ? 'rel="_blank"' : '' ) . ' class="' . $class . '">' . $html . '</a>';
}

do_action( 'molla_save_used_widget', 'buttons' );
