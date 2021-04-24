<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract( /* @codingStandardsIgnoreLine */
	shortcode_atts(
		array(
			'show_label'     => 'yes',
			'wishlist_label' => esc_html__( 'Wishlist', 'molla-core' ),
			'show_count'     => 'yes',
			'count_pos'      => 'type-full',
			'delimiter'      => ' / ',
			'icon'           => '',
			'icon_pos'       => 'left',
		),
		$atts
	)
);

if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}
$wc_link  = YITH_WCWL()->get_wishlist_url();
$wc_count = yith_wcwl_count_products();

$classes  = 'shop-icon wishlist';
$classes .= ( 'left' == $icon_pos ? ' hdir' : ' vdir' );
$classes .= ' ' . $count_pos;
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<a href="<?php echo esc_url( $wc_link ); ?>">
	<?php if ( is_array( $icon ) && $icon['value'] ) : ?>
		<div class="icon">
			<i class="<?php echo esc_attr( $icon['value'] ? $icon['value'] : 'icon-heart-o' ); ?>"></i>

			<?php if ( 'count-linear' != $count_pos && 'yes' == $show_count ) : ?>
				<span class="wishlist-count"><?php echo esc_html( $wc_count ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( 'yes' == $show_label ) : ?>
		<p class="custom-label"><?php echo esc_html( $wishlist_label ? $wishlist_label : esc_html__( 'Wishlist', 'molla-core' ) ); ?></p>
	<?php endif; ?>
	</a>
	<?php if ( 'count-linear' == $count_pos && 'yes' == $show_count ) : ?>
		<span class="wishlist-count"><?php echo esc_html( $wc_count ); ?></span>
	<?php endif; ?>
</div>
<?php
