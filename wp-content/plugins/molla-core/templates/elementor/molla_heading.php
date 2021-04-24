<?php

extract(
	shortcode_atts(
		array(
			'title'         => '',
			'subtitle'      => '',
			'subtitle_tag'  => 'h4',
			'show_subtitle' => 'yes',
			'link_html'     => '',
			'link_url'      => '',
			'icon'          => '',
			'icon_pos'      => 'after',
			'show_link'     => 'yes',
			'link_before'   => 'no',
			'heading_align' => '',
		),
		$atts
	)
);

$output = '';

$settings = $this->get_settings_for_display();

do_action( 'molla_save_used_widget', 'titles' );

if ( isset( $show_subtitle ) && 'yes' == $show_subtitle && $subtitle ) {
	$output .= sprintf( '<%1$s class="heading-subtitle">%2$s</%1$s>', $subtitle_tag, $subtitle );
}

if ( $title || ( $subtitle && 'yes' == $show_subtitle ) ) {
	$output .= '</div>';
}

if ( is_array( $icon ) && $icon['value'] ) {
	if ( 'before' == $icon_pos ) {
		$link_html = '<i class="' . $icon['value'] . '"></i>' . $link_html;
	} else {
		$link_html .= '<i class="' . $icon['value'] . '"></i>';
	}
}

if ( isset( $show_link ) && 'yes' == $show_link ) {
	$output .= sprintf( '<div class="heading-link' . ( isset( $link_before ) && 'yes' == $link_before ? ' order-first' : '' ) . '"><a href="%1$s"' . ( $link_url['is_external'] ? ' target="nofollow"' : '' ) . ( $link_url['nofollow'] ? ' rel="_blank"' : '' ) . ' class="title-link icon-' . esc_attr( $icon_pos ) . '">%2$s</a></div>', $link_url['url'], $link_html );
}

$output .= '</div>';

echo $output;
