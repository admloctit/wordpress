<?php

extract(
	shortcode_atts(
		array(
			'type'                   => '',
			'avatar'                 => '',
			'avatar_size'            => '',
			'image_custom_dimension' => '',
			'name'                   => '',
			'job'                    => '',
			'desc'                   => '',
			'facebook'               => '#',
			'linkedin'               => '',
			'twitter'                => '#',
			'instagram'              => '#',
			'youtube'                => '',
			'pinterest'              => '',
			'tumblr'                 => '',
			'whatsapp'               => '',
		),
		$atts
	)
);

$output = '';
$size   = 'large';

if ( 'custom' == $avatar_size ) {
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
	$size = $avatar_size;
}

$img_src = wp_get_attachment_image_src( $avatar['id'], $size );

ob_start();

?>

<div class="member <?php echo esc_attr( $type ); ?> text-center">
	<figure class="member-media<?php echo esc_attr( $img_src[0] ? '' : ' img-placeholder' ); ?>">
		<?php echo wp_get_attachment_image( $avatar['id'], $size, false ); ?>

		<figcaption class="member-overlay">
			<div class="member-overlay-content">
				<?php if ( 'member-anim' == $type ) : ?>
				<h3 class="member-title"><?php echo esc_html( $name ); ?><span><?php echo esc_html( $job ); ?></span></h3>
				<?php endif; ?>
				<p><?php echo esc_html( $desc ); ?></p>
				<div class="social-icons social-icons-simple">
				<?php if ( $facebook['url'] ) : ?>
					<a href="#" class="social-icon" title="Facebook"<?php echo esc_attr( $facebook['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-facebook-f"></i></a>
				<?php endif; ?>
				<?php if ( $linkedin['url'] ) : ?>
					<a href="#" class="social-icon" title="Linkedin"<?php echo esc_attr( $linkedin['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-linkedin-in"></i></a>
				<?php endif; ?>
				<?php if ( $twitter['url'] ) : ?>
					<a href="#" class="social-icon" title="Twitter"<?php echo esc_attr( $twitter['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-twitter"></i></a>
				<?php endif; ?>
				<?php if ( $instagram['url'] ) : ?>
					<a href="#" class="social-icon" title="Instagram"<?php echo esc_attr( $instagram['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-instagram"></i></a>
				<?php endif; ?>
				<?php if ( $youtube['url'] ) : ?>
					<a href="#" class="social-icon" title="Youtube"<?php echo esc_attr( $youtube['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-youtube"></i></a>
				<?php endif; ?>
				<?php if ( $pinterest['url'] ) : ?>
					<a href="#" class="social-icon" title="Pinterest"<?php echo esc_attr( $pinterest['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-pinterest"></i></a>
				<?php endif; ?>
				<?php if ( $tumblr['url'] ) : ?>
					<a href="#" class="social-icon" title="Tumblr"<?php echo esc_attr( $tumblr['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-tumblr"></i></a>
				<?php endif; ?>
				<?php if ( $whatsapp['url'] ) : ?>
					<a href="#" class="social-icon" title="Whatsapp"<?php echo esc_attr( $whatsapp['nofollow'] ? ' rel=nofollow' : '' ); ?> target="_blank"><i class="icon-whatsapp"></i></a>
				<?php endif; ?>
				</div>
			</div><!-- End .member-overlay-content -->
		</figcaption><!-- End .member-overlay -->
	</figure>
	<div class="member-content">
		<h3 class="member-title"><?php echo esc_html( $name ); ?><span><?php echo esc_html( $job ); ?></span></h3>
	</div>
</div>


<?php
$output = ob_get_clean();

echo $output;

do_action( 'molla_save_used_widget', 'member' );
