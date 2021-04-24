<?php

extract(
	shortcode_atts(
		array(
			'btn_type'         => '',
			'btn_corner_type'  => 'rounded',
			'btn_text'         => 'Click here',
			'btn_link_url'     => '#',
			'btn_link_new_tab' => false,
			'btn_link_rel'     => '',
			'btn_size'         => 'md',
			'btn_icon_class'   => '',
			'icon_show_hover'  => false,
			'btn_custom_class' => '',
		),
		$atts
	)
);

$icon = '';
if ( $btn_icon_class ) {
	$icon = '<i class=' . $btn_icon_class . '></i>';
}

$btn_class = 'btn btn-' . ( $btn_corner_type ? $btn_corner_type : 'rect' ) .
			' btn-' . ( $btn_type ? $btn_type : 'primary' ) .
			' btn-' . $btn_size .
			' ' . $btn_custom_class;
if ( $icon_show_hover ) {
	$btn_class .= ' icon-hidden';
}

?>

<div class="btn-wrap">
	<a href="<?php echo esc_url( $btn_link_url ); ?>" class="<?php echo esc_attr( $btn_class ); ?>"<?php echo esc_attr( $btn_link_new_tab ? 'target=_blank rel="' . $btn_link_rel . '' : '' ); ?>><span><?php echo molla_strip_script_tags( $btn_text ); ?></span><?php echo molla_strip_script_tags( $icon ); ?></a>
</div>
