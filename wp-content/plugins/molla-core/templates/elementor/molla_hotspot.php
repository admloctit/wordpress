<?php
extract(
	shortcode_atts(
		array(
			'type'           => '',
			'html'           => '',
			'block'          => '',
			'link'           => '#',
			'product'        => '',
			'icon'           => '',
			'popup_position' => '',
			'el_class'       => '',
		),
		$atts
	)
);

$url = isset( $link['url'] ) ? esc_url( $link['url'] ) : '#';

$product_id = '';
if ( $product ) {
	$product_id = molla_get_post_id_by_name( 'product', $product );
}

ob_start();

?>

<div class="hotspot-wrapper<?php echo ' hotspot-' . $type; ?> tooltip-wrapper">
	<span class="hotspot">
		<a href="<?php echo 'product' == $type ? '#' : esc_url( $url ); ?>"<?php echo ( ( isset( $link['is_external'] ) && $link['is_external'] ) ? ' target="nofollow"' : '' ) . ( ( isset( $link['nofollow'] ) && $link['nofollow'] ) ? ' rel="_blank"' : '' ); ?> class="hotspot-inner<?php echo esc_attr( $el_class ? ( ' ' . $el_class ) : '' ) . ( ( 'product' == $type && $product_id ) ? ' btn-quickview' : '' ); ?>"<?php echo ( 'product' == $type && $product_id ) ? ( ' data-product-id="' . $product_id . '"' ) : ''; ?>>
		<?php if ( $icon['value'] ) : ?>
			<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
		<?php endif; ?>
		</a>
	</span>
	<div class="tooltip <?php echo esc_attr( $popup_position ); ?>-tooltip">
	<?php
	if ( 'html' == $type ) {
		echo do_shortcode( $html );
	} elseif ( 'block' == $type ) {
		molla_print_custom_post( 'block', $block );
	} elseif ( $product_id && class_exists( 'WooCommerce' ) ) {
		$args = array(
			'post_type' => 'product',
			'post__in'  => array( $product_id ),
		);

		$product = new WP_Query( $args );
		while ( $product->have_posts() ) {
			$product->the_post();
			global $post;
			?>
			<div <?php wc_product_class( 'woocommerce product-widget mb-0', $post ); ?>>
				<div class="product-media">
					<?php
					echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
					echo woocommerce_get_product_thumbnail();
					echo '</a>';
					?>
				</div>
				<div class="product-body">
					<?php
					echo '<h3 class="woocommerce-loop-product__title product-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h3>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					woocommerce_template_loop_price();
					echo '<div class="product-action">';
					woocommerce_template_loop_add_to_cart();
					echo '</div>';
					?>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
	}
	?>
	</div>
</div>


<?php

$output = ob_get_clean();

echo $output;

do_action( 'molla_save_used_widget', 'hotspot' );
do_action( 'molla_save_used_widget', 'tooltips' );
