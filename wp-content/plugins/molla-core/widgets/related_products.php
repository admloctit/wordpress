<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Molla Related Products definition
 */
class Molla_Related_Products_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-related-products',
			'description' => esc_html__( 'Display related products.', 'molla-core' ),
		);

		$control_ops = array( 'id_base' => 'related-products-widget' );

		parent::__construct( 'related-products-widget', esc_html__( 'Molla - Related Products', 'molla-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		wp_enqueue_script( 'owl-carousel' );

		$count           = (int) $instance['count'];
		$count_per_slide = (int) $instance['count_per_slide'];
		$before_content  = $instance['before_content'];
		$after_content   = $instance['after_content'];

		$item_class = apply_filters( 'molla_post_widget_item_class', '' );

		$args = array(
			'posts_per_page' => $count,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
			'order'          => 'desc',
		);

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		echo do_shortcode( $before_content );

		global $product;

		if ( $product ) {

			$args = wp_parse_args( $args );

			// Get visible related products then sort them at random.
			$related_products = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

			// Handle orderby.
			$related_products = wc_products_array_orderby( $related_products, $args['orderby'], $args['order'] );

			wc_set_loop_prop( 'columns', 1 );
			wc_set_loop_prop( 'product_style', 'widget' );
			wc_set_loop_prop( 'elem', 'product' );
			wc_set_loop_prop( 'layout_mode', 'slider' );
			wc_set_loop_prop( 'slider_autoheight', true );
			wc_set_loop_prop( 'slider_nav', array( false, false, false ) );
			wc_set_loop_prop( 'slider_dot', array( true, true, true ) );
			wc_set_loop_prop( 'type', 'custom' );
			wc_set_loop_prop( 'product_show_op', array( 'name', 'price' ) );
			wc_set_loop_prop( 'product_align', 'left' );
			wc_set_loop_prop( 'widget', true );

			add_filter( 'woocommerce_product_is_visible', '__return_true' );

			woocommerce_product_loop_start();

			$cur = 0;
			foreach ( $related_products as $related_product ) :

				if ( 0 == $cur % $count_per_slide ) {
					echo '<ul class="products-list">';
				}

				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				echo '<li class="' . esc_attr( $item_class ) . '">';
				wc_get_template_part( 'content', 'product' );
				echo '</li>';

				if ( $cur % $count_per_slide == $count_per_slide - 1 || $cur == $count - 1 ) {
					echo '</ul>';
				}
				$cur ++;

			endforeach;

			woocommerce_product_loop_end();

			remove_filter( 'woocommerce_product_is_visible', '__return_true' );

		}

		echo do_shortcode( $after_content );

		echo $after_widget;

		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['count']           = $new_instance['count'];
		$instance['count_per_slide'] = $new_instance['count_per_slide'];
		$instance['before_content']  = $new_instance['before_content'];
		$instance['after_content']   = $new_instance['after_content'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'           => esc_html__( 'Related Products', 'molla-core' ),
			'count'           => 9,
			'count_per_slide' => 3,
			'before_content'  => '',
			'after_content'   => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo isset( $instance['title'] ) ? ( defined( 'MOLLA_VERSION' ) ? molla_strip_script_tags( $instance['title'] ) : strip_tags( $instance['title'] ) ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<strong><?php esc_html_e( 'Number of posts', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo isset( $instance['count'] ) ? esc_attr( $instance['count'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count_per_slide' ) ); ?>">
				<strong><?php esc_html_e( 'Count per slide', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count_per_slide' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_per_slide' ) ); ?>" value="<?php echo isset( $instance['count_per_slide'] ) ? esc_attr( $instance['count_per_slide'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'before_content' ) ); ?>">
				<strong><?php esc_html_e( 'Before Content', 'molla-core' ); ?>:</strong>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'before_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'before_content' ) ); ?>" ><?php echo isset( $instance['before_content'] ) ? esc_attr( $instance['before_content'] ) : ''; ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'after_content' ) ); ?>">
				<strong><?php esc_html_e( 'After Content', 'molla-core' ); ?>:</strong>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'after_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'after_content' ) ); ?>" ><?php echo isset( $instance['after_content'] ) ? esc_attr( $instance['after_content'] ) : ''; ?></textarea>
			</label>
		</p>
		<?php
	}
}
