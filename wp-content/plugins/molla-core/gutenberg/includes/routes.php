<?php
add_action( 'rest_api_init', 'registerRestAPI' );
function registerRestAPI() {
	// Register router to get data for Woocommerce Products block
	if ( class_exists( 'WC_REST_Products_Controller' ) ) {
		include_once( MOLLA_CORE_DIR . '/gutenberg/includes/product-controller.php' );
		$controller = new MollaBlocksProductsController();
		$controller->register_routes();
	}

	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'molla_featured_image_src',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field(
		'post',
		'categories_name',
		array(
			'get_callback'    => 'molla_categories_name',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field(
		'post',
		'author_name',
		array(
			'get_callback'    => 'molla_author_name',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field(
		'post',
		'comment_count',
		array(
			'get_callback'    => 'molla_comment_count',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}


/**
 * Get featured image link for REST API
 *
 * @param array $object API Object
 *
 * @return mixed
 */
function molla_featured_image_src( $object ) {
	$featured_img_full   = wp_get_attachment_image_src(
		$object['featured_media'],
		'full',
		false
	);
	$featured_img_large  = wp_get_attachment_image_src(
		$object['featured_media'],
		'blog-large',
		false
	);
	$featured_img_list   = wp_get_attachment_image_src(
		$object['featured_media'],
		'blog-medium',
		false
	);
	$featured_img_medium = wp_get_attachment_image_src(
		$object['featured_media'],
		'medium',
		false
	);

	return array(
		'landsacpe' => $featured_img_large,
		'list'      => $featured_img_list,
		'medium'    => $featured_img_medium,
		'full'      => $featured_img_full,
	);
}

function molla_categories_name( $object ) {
	return wp_get_post_categories( $object['id'], array( 'fields' => 'names' ) );
}

function molla_author_name( $object ) {
	return get_the_author_meta( 'display_name', $object['author'] );
}

function molla_comment_count( $object ) {
	return get_comment_count( $object['id'] );
}
