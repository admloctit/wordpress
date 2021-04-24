<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$product_style = wc_get_loop_prop( 'product_style' );
$labels        = wc_get_loop_prop( 'product_labels' );
$label_style   = wc_get_loop_prop( 'product_label_type' );

if ( '' === $labels ) {
	$labels = molla_option( 'product_labels' );
}


if ( ! is_array( $labels ) ) {
	return;
}

$label_class = 'product-label' . ( $label_style ? ' label-circle' : '' );

if ( 'card' == $product_style ) {
	echo '<div class="product-labels">';
}

foreach ( $labels as $label ) {
	if ( 'featured' == $label && $product->is_featured() ) {
		echo apply_filters( 'molla_woocommerce_featured_flash', '<span class="' . $label_class . ' label-hot">' . esc_html__( 'Top', 'molla' ) . '</span>', $post, $product );
	}
	if ( 'onsale' == $label && $product->is_on_sale() ) {
		$sales_html = esc_html__( 'Sale', 'molla' );

		$label_sale_format = molla_option( 'label_sale_format' );

		if ( $label_sale_format && false !== strpos( $label_sale_format, '%s' ) ) {
			$percent = 0;
			if ( $product->get_regular_price() ) {
				$percent = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			} elseif ( 'variable' == $product->get_type() && $product->get_variation_regular_price() ) {
				$percent = round( ( ( $product->get_variation_regular_price() - $product->get_variation_sale_price() ) / $product->get_variation_regular_price() ) * 100 );
			}

			$sales_html = str_replace( '%s', $percent, $label_sale_format );
		}

		echo apply_filters( 'molla_woocommerce_sale_flash', '<span class="' . $label_class . ' label-sale">' . esc_html( $sales_html ) . '</span>', $post, $product );
	}
	if ( 'outstock' == $label && 'outofstock' == $product->get_stock_status() && ! wc_get_loop_prop( 'out_stock_style' ) ) {
		echo apply_filters( 'molla_woocommerce_outstock_flash', '<span class="' . $label_class . ' label-out">' . ( $label_style ? esc_html__( 'Out', 'molla' ) : esc_html__( 'Out of Stock', 'molla' ) ) . '</span>', $post, $product );
	}
	if ( 'new' == $label && strtotime( $product->get_date_created() ) > strtotime( apply_filters( 'molla_new_product_period', '-' . (int) molla_option( 'new_product_period' ) . ' day' ) ) ) {
		echo apply_filters( 'molla_woocommerce_new_flash', '<span class="' . $label_class . ' label-new">' . esc_html__( 'New', 'molla' ) . '</span>', $post, $product );
	}
	if ( 'hurry' == $label && molla_product_is_in_low_stock() ) {
		echo apply_filters( 'molla_woocommerce_hurry_flash', '<span class="' . $label_class . ' label-hurry">' . esc_html__( 'Hurry!', 'molla' ) . '</span>', $post, $product );
	}
}

if ( 'card' == $product_style ) {
	echo '</div>';
}

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
