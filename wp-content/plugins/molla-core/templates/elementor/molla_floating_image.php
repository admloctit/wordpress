<?php

extract(
	shortcode_atts(
		array(
			'image'      => '',
			'image_size' => '',
			'direction'  => '',
			'speed'      => '',
			'relative'   => '',
		),
		$atts
	)
);

$output = '';
$size   = 'large';

if ( 'custom' == $image_size ) {
	if ( defined( 'ELEMENTOR_PATH' ) ) {
		require_once( ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php' );
	}
	$size = array(
		0           => null, // Width.
		1           => null, // Height.
		'bfi_thumb' => true,
		'crop'      => true,
	);
	if ( ! empty( $image_custom_dimension['width'] ) ) {
		$size[0] = $image_custom_dimension['width'];
	}

	if ( ! empty( $image_custom_dimension['height'] ) ) {
		$size[1] = $image_custom_dimension['height'];
	}
} else {
	$size = $image_size;
}

$img_src = wp_get_attachment_image_src( $image['id'], $size );

$options = array();
if ( 'yes' == $relative ) {
	$options['relativeInput']     = true;
	$options['clipRelativeInput'] = true;
} else {
	$options['relativeInput']     = false;
	$options['clipRelativeInput'] = false;
}
if ( 'direct' == $direction ) {
	$options['invertX'] = false;
	$options['invertY'] = false;
} else {
	$options['invertX'] = true;
	$options['invertY'] = true;
}

ob_start();

?>

<?php if ( $img_src ) : ?>

<div class="floating-wrapper" data-toggle="floating" data-options=<?php echo esc_attr( json_encode( $options ) ); ?>>
	<figure class="layer<?php echo esc_attr( $img_src[0] ? '' : ' img-placeholder' ); ?>" data-depth="<?php echo esc_attr( $speed['size'] ); ?>">
		<?php echo wp_get_attachment_image( $image['id'], $size, false ); ?>
	</figure>
</div>

	<?php
endif;

$output = ob_get_clean();

echo $output;

do_action( 'molla_save_used_widget', 'floating_image' );
