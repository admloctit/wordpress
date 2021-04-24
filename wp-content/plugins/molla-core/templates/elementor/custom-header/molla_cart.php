<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

extract( /* @codingStandardsIgnoreLine */
	shortcode_atts(
		array(
			'canvas_type'   => 'no',
			'canvas_action' => '',
			'show_label'    => 'yes',
			'cart_label'    => esc_html__( 'Cart', 'molla-core' ),
			'show_count'    => 'yes',
			'count_pos'     => 'type-full',
			'delimiter'     => ' / ',
			'icon'          => '',
			'icon_pos'      => 'left',
			'show_price'    => 'yes',
		),
		$atts
	)
);

if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}
$wc_link  = YITH_WCWL()->get_wishlist_url();
$wc_count = yith_wcwl_count_products();

$wrap_classes  = 'shop-icon dropdown cart cart-dropdown';
$wrap_classes .= ( 'yes' != $show_label || 'left' == $icon_pos ? ' hdir' : ' vdir' );
$wrap_classes .= ' ' . $count_pos;


$cart_classes = 'cart-popup widget_shopping_cart';
if ( 'yes' == $canvas_type ) {
	$cart_classes .= ' cart-canvas canvas-container';
	$cart_classes .= $canvas_action ? ' after-added-product' : ' cart-link-click';
	echo '<div class="sidebar-overlay canvas-overlay"></div>';
} else {
	$cart_classes .= ' dropdown-menu with-arrows';
}
?>
<div class="<?php echo esc_attr( $wrap_classes ); ?>">
	<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'cart' ) : '#' ); ?>" class="dropdown-toggle">
	<?php if ( is_array( $icon ) && $icon['value'] ) : ?>
		<div class="icon">
			<i class="<?php echo esc_attr( $icon['value'] ? $icon['value'] : 'icon-shopping-cart' ); ?>"></i>
			<?php if ( 'count-linear' != $count_pos && 'yes' == $show_count ) : ?>
				<span class="cart-count">0</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( 'yes' == $show_label ) : ?>
		<p class="custom-label"><?php echo esc_html( molla_option( 'shop_icon_label_cart' ) ); ?></p>
	<?php endif; ?>
	</a>
	<?php if ( 'count-linear' == $count_pos && 'yes' == $show_count ) : ?>
		<span class="cart-count">0</span>
	<?php endif; ?>
	<?php if ( 'yes' == $show_price ) : ?>
	<span class="cart-price"></span>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $cart_classes ); ?>">
	<?php if ( 'yes' == $canvas_type ) : ?>
		<div class="cart-canvas-header">
			<h4><?php esc_html_e( 'Shopping Cart', 'molla-core' ); ?></h4>
			<a href="#" class="canvas-close"><?php esc_html_e( 'Close', 'molla-core' ); ?><i class="icon-close"></i></a>
		</div>
	<?php endif; ?>
		<div class="widget_shopping_cart_content">
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="cart-loading"></div>
		<?php else : ?>
			<ul class="cart_list"><li class="empty"><?php esc_html_e( 'Woocommerce is not installed.', 'molla-core' ); ?></li></ul>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php
