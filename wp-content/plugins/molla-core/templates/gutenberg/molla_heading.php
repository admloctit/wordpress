<?php

extract(
	shortcode_atts(
		array(
			'title'                     => esc_html__( 'Add Your Heading Text Here', 'molla-core' ),
			'title_tag'                 => 'h2',
			'title_align'               => 'left',
			'subtitle'                  => '',
			'subtitle_tag'              => 'h4',
			'show_subtitle'             => true,
			'link_html'                 => '',
			'link_url'                  => '',
			'link_icon_class'           => '',
			'show_link'                 => false,
			'heading_align'             => '',
			'decoration_type'           => 't-decor-both',
			'decoration_spacing'        => 25,
			'title_font_family'         => 'Poppins',
			'title_font_size'           => '2.4rem',
			'title_font_weight'         => '600',
			'title_font_transform'      => 'capitalize',
			'title_font_style'          => 'normal',
			'title_font_decoration'     => 'none',
			'title_font_height'         => '1.4',
			'title_font_ltr_spacing'    => '0',
			'subtitle_font_family'      => 'Poppins',
			'subtitle_font_size'        => '1.8rem',
			'subtitle_font_weight'      => '400',
			'subtitle_font_transform'   => 'none',
			'subtitle_font_style'       => 'normal',
			'subtitle_font_decoration'  => 'none',
			'subtitle_font_height'      => '1.4',
			'subtitle_font_ltr_spacing' => '0',
			'title_color'               => '',
			'subtitle_color'            => '',
			'title_custom_class'        => '',
			'subtitle_custom_class'     => '',
		),
		$atts
	)
);

do_action( 'molla_save_used_widget', 'titles' );

$output = '<div class="heading' . ( $decoration_type ? ' ' . $decoration_type : '' ) . '"><div class="heading-content text-' . $title_align . '">';

$output .= sprintf( '<%1$s class="heading-title %3$s">%2$s</%1$s>', $title_tag, $title, $title_custom_class );

if ( isset( $show_subtitle ) && $show_subtitle && $subtitle ) {
	$output .= sprintf( '<%1$s class="heading-subtitle %3$s">%2$s</%1$s>', $subtitle_tag, $subtitle, $subtitle_custom_class );
}
$output .= '</div>';

if ( isset( $show_link ) && $show_link ) {
	$output .= '<div class="heading-link"><a href="' . $link_url . '">' . $link_html . ( $link_icon_class ? ( '<i class="' . $link_icon_class . '"></i>' ) : '' ) . '</a></div>';
}

$output .= '</div>';
echo $output;
