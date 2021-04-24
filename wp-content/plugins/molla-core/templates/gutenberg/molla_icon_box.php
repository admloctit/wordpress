<?php

extract(
	shortcode_atts(
		array(
			'icon_class'         => '',
			'icon_view'          => 'default',
			'icon_padding'       => '20px',
			'icon_shape'         => 'circle',
			'icon_align'         => 'center',
			'icon_position'      => 'outer',
			'$icon_margin_top'   => '',
			'icon_margin_bottom' => '',
			'icon_margin_left'   => '',
			'icon_margin_right'  => '',
			'icon_font_size'     => '',
			'icon_color'         => '',
			'icon_back_color'    => '',
			'icon_heading'       => 'This is the heading',
			'icon_heading_tag'   => 'h3',
			'icon_heading_class' => '',
			'icon_description'   => '',
			'icon_desc_tag'      => 'p',
			'icon_desc_class'    => '',
			'content_style'      => 'horizontal',
			'content_align'      => 'center',
			'border_enable'      => false,
		),
		$atts
	)
);

$icon_box_class = 'icon-box' .
				( 'horizontal' == $content_style ? ' icon-box-side' : '' ) .
				' icon-' . $icon_position . '-content' .
				( $border_enable ? ' icon-box-bordered' : '' );

?>

<div class="<?php echo esc_attr( $icon_box_class ); ?>">
	<div class="icon-box-icon icon-<?php echo esc_attr( $icon_view ); ?> icon-<?php echo esc_attr( $icon_shape ); ?>">
	<?php if ( $icon_class ) : ?>
		<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
	<?php endif; ?>
	<?php if ( 'vertical' != $content_style && 'inner' == $icon_position && $icon_heading ) : ?>
		<?php echo sprintf( '<%1$s class="icon-box-title %2$s">%3$s</%1$s>', $icon_heading_tag, $icon_heading_class, $icon_heading ); ?>
	<?php endif; ?>
	</div>
	<div class="icon-box-content">
	<?php if ( ( 'vertical' == $content_style || 'outer' == $icon_position ) && $icon_heading ) : ?>
		<?php echo sprintf( '<%1$s class="icon-box-title %2$s">%3$s</%1$s>', $icon_heading_tag, $icon_heading_class, $icon_heading ); ?>
	<?php endif; ?>
	<?php echo sprintf( '<%1$s class="icon-box-desc %2$s">%3$s</%1$s>', $icon_desc_tag, $icon_desc_class, $icon_description ); ?>
	</div>
</div>
