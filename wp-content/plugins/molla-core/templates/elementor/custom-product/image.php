<?php
extract(
	shortcode_atts(
		array(
			'cl_image_type'              => 'horizontal',
			'cl_image_columns'           => 3,
			'cl_image_columns_tablet'    => '',
			'cl_image_columns_mobile'    => '',
			'cl_image_cols_under_mobile' => '',
			'cl_image_spacing'           => array( 'size' => 10 ),
		),
		$atts
	)
);

global $product;

$this->cl_image_type = $cl_image_type;

wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'jquery-elevateZoom' );
wp_enqueue_script( 'jquery-magnific-popup' );

$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $cl_image_columns ),
		'images',
		'images-' . esc_attr( $cl_image_type ),
		( 'grid' == $cl_image_type ? 'product-gallery-separated' : '' ),
	)
);

// print single product main image
add_action(
	'molla_wc_single_main_image',
	function() {
		global $product;

		echo '<figure class="woocommerce-product-gallery__wrapper product-main-image">';
		// woocommerce_show_product_sale_flash - 10
		do_action( 'molla_woocommerce_after_single_image' );

		if ( $product->get_image_id() ) {
			$html = wc_get_gallery_image_html( $product->get_image_id(), true );
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $product->get_image_id() ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		echo '</figure>';
	}
);

// print single product thumbnails
add_action(
	'molla_wc_single_product_thumbnails',
	function() {
		global $product;

		if ( 'horizontal' == $this->cl_image_type || 'vertical' == $this->cl_image_type ) {
			$attachment_ids = array( $product->get_image_id() );
			foreach ( $product->get_gallery_image_ids() as $id ) {
				$attachment_ids[] = $id;
			};
		} else {
			$attachment_ids = $product->get_gallery_image_ids();
		}

		if ( $attachment_ids && $product->get_image_id() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id, ( 'horizontal' == $this->cl_image_type || 'vertical' == $this->cl_image_type ) ? 0 : -1 ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}
	}
);

// Print Single Product Images
$cols = array(
	0   => array(
		'items' => intval( $cl_image_cols_under_mobile ),
	),
	576 => array(
		'items' => intval( $cl_image_columns_mobile ),
	),
	768 => array(
		'items' => intval( $cl_image_columns_tablet ),
	),
	992 => array(
		'items' => intval( $cl_image_columns ),
	),
);

echo '<style>';
echo '.woocommerce .product-intro .elementor-widget-container .woocommerce-product-gallery > .row { margin-left: -' . $cl_image_spacing['size'] / 2 . 'px; margin-right: -' . $cl_image_spacing['size'] / 2 . 'px; }';
echo '.woocommerce .product-intro .elementor-widget-container .woocommerce-product-gallery > .row .product-label { left: calc(20px + ' . $cl_image_spacing['size'] / 2 . 'px) }';
echo '.woocommerce .product-intro .elementor-widget-container .woocommerce-product-gallery.images > .row > * { padding-left: ' . $cl_image_spacing['size'] / 2 . 'px; padding-right: ' . $cl_image_spacing['size'] / 2 . 'px; }';
echo '.woocommerce .product-intro .elementor-widget-container .woocommerce-product-gallery .woocommerce-product-gallery__image, .woocommerce div.product div.images .woocommerce-product-gallery__wrapper { margin-bottom: ' . $cl_image_spacing['size'] . 'px; }';
echo '@media (min-width: 992px), (max-width: 767px) and (min-width: 576px) { .woocommerce div.product div.images .woocommerce-product-gallery__wrapper { margin-bottom: 0; } }';
echo '.woocommerce .product-intro .elementor-widget-container .woocommerce-product-gallery .product-main-image .woocommerce-product-gallery__image { margin-bottom: 0; }';
echo '.woocommerce-product-gallery.images-masonry .thumbnails-outer { width: calc(100% + ' . $cl_image_spacing['size'] . 'px); }';
echo '</style>';

echo '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ) . '" data-columns="' . esc_attr( $cl_image_columns ) . '">';
if ( 'gallery' != $cl_image_type && 'masonry' != $cl_image_type ) {
	if ( 'grid' == $cl_image_type ) {
		echo '<div class="row' . molla_carousel_responsive_classes( $cols ) . '">';
	} else {
		echo '<div class="row' . ( 'horizontal' == $cl_image_type ? ' thumb-horizontal' : '' ) . '">';
	}
} elseif ( 'gallery' == $cl_image_type ) {
	$outer_attr               = array();
	$outer_class              = 'product-gallery-carousel owl-carousel owl-simple owl-nav-inside owl-full';
	$outer_attr['loop']       = false;
	$outer_attr['nav']        = true;
	$outer_attr['dots']       = false;
	$outer_attr['margin']     = intval( $cl_image_spacing['size'] );
	$outer_attr['responsive'] = molla_carousel_options( $cols );
	$outer_class             .= molla_carousel_responsive_classes( $outer_attr['responsive'] ) . ' sp-' . $cl_image_spacing['size'];

	$breakpoints = array(
		0,
		576,
		768,
		992,
		1200,
	);

	foreach ( $breakpoints as $brk ) {
		if ( isset( $outer_attr['responsive'][ $brk ] ) ) {
			$outer_attr['responsive'][ $brk ]['nav']  = true;
			$outer_attr['responsive'][ $brk ]['dots'] = false;
		}
	}

	$outer_attr = 'data-toggle="owl" data-owl-options=' . json_encode( $outer_attr );

	echo '<div class="' . $outer_class . '" ' . $outer_attr . '>';
}

	do_action( 'molla_wc_single_main_image' );

if ( 'horizontal' == $cl_image_type || 'vertical' == $cl_image_type ) {
	$outer_class = '';
	$outer_attr  = '';

	if ( 'horizontal' == $cl_image_type ) {
		$outer_class .= ' owl-carousel ';
		$outer_attr  .= 'data-toggle="owl"';
	} else {
		$outer_class .= ' vertical';
	}
	$outer_class .= ' owl-simple owl-nav-inside owl-full';
	$outer_attr  .= ' data-owl-options=' . json_encode(
		array(
			'margin'     => intval( $cl_image_spacing['size'] ),
			'items'      => 4,
			'loop'       => false,
			'nav'        => true,
			'dots'       => false,
			'responsive' => array(
				0   => array(
					'items' => 3,
				),
				576 => array(
					'items' => 4,
				),
			),
		)
	);

	echo '<div id="product-zoom-gallery" class="product-image-gallery">
				<div class="thumbnails-wrap">
					<div class="thumbnails-outer' . $outer_class . '" ' . $outer_attr . '>';
} elseif ( 'masonry' == $cl_image_type ) {
	wp_enqueue_script( 'isotope-pkgd' );
	$outer_class = ' grid sp-' . intval( $cl_image_spacing['size'] ) . molla_carousel_responsive_classes( $cols );
	$outer_attr  = ' data-toggle="isotope" data-isotope-options={"itemSelector":".woocommerce-product-gallery__image"}';
	echo '<div class="gallery-masonry' . $outer_class . '" ' . $outer_attr . '>';
}

		do_action( 'molla_wc_single_product_thumbnails' );

if ( 'horizontal' == $cl_image_type || 'vertical' == $cl_image_type ) {

	echo        '</div>';
	if ( 'vertical' == $cl_image_type ) {
			echo '<div class="vertical-nav">
						<button type="button" class="nav-prev">
							<i class="icon-angle-up"></i>
						</button>
						<button type="button" class="nav-next">
							<i class="icon-angle-down"></i>
						</button>
					</div>';
	}
	echo    '</div>
			</div>';
}

echo '</div></div>';
