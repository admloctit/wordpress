<?php

extract(
	shortcode_atts(
		array(
			'banner_img'     => '',
			'banner_img_url' => '',
			'fixed_img'      => false,
			'parallax'       => false,
			'parallax_speed' => 4,
			'x_pos'          => 50,
			'y_pos'          => 50,
			't_x_pos'        => 'left',
			't_y_pos'        => 'center',
			'pd_top'         => 20,
			'pd_right'       => 20,
			'pd_bottom'      => 20,
			'pd_left'        => 20,
		),
		$atts
	)
);

do_action( 'molla_save_used_widget', 'banners' );

$banner_class  = 'banner';
$content_class = 'banner-content';

if ( ! $fixed_img ) {
	$content_class .= ' fixed';
	$content_class .= ' x-' . $x_pos;
	$content_class .= ' y-' . $y_pos;
	$content_class .= ' t-x-' . $t_x_pos;
	$content_class .= ' t-y-' . $t_y_pos;
} else {
	if ( $banner_img_url && ! $parallax ) {
		if ( molla_option( 'lazy_load_img' ) ) {
			$banner_class .= ' molla-lazy-back';
		}
	}
}
$plx_options = '';
if ( $parallax && $fixed_img ) {
	$banner_class .= ' parallax-container';

	$plx_options  = ' data-plx-img=' . esc_url( $banner_img_url );
	$plx_options .= ' data-plx-speed=' . $parallax_speed;
	if ( molla_option( 'lazy_load_img' ) ) {
		$plx_options .= ' data-lazyload=true';
		$plx_options .= ' data-plx-color=' . molla_option( 'lazy_load_img_back' );
	}
}
?>
<div class="<?php echo esc_attr( $banner_class ); ?>"<?php echo esc_attr( $plx_options ); ?>>
	<?php if ( ! $fixed_img && $banner_img_url ) : ?>
		<figure class="banner-img">
			<?php echo wp_get_attachment_image( (int) $banner_img, 'full' ); ?>
		</figure>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $content_class ); ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>
</div>

<?php
