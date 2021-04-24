<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Molla Product-Ordering definition
 */
class Molla_Product_Ordering_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-ordering widget_layered_nav',
			'description' => esc_html__( 'Product Ordering.', 'molla-core' ),
		);

		$control_ops = array( 'id_base' => 'product-ordering-widget' );

		parent::__construct( 'product-ordering-widget', esc_html__( 'Molla - Product Ordering', 'molla-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		add_filter( 'woocommerce_catalog_orderby', 'molla_woocommerce_catalog_ordering_type' );

		if ( class_exists( 'WooCommerce' ) ) {
			woocommerce_catalog_ordering();
		}

		remove_filter( 'woocommerce_catalog_orderby', 'molla_woocommerce_catalog_ordering_type' );

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<?php
	}
}
