<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
* Molla Price filter checkable
*/
class Molla_Price_Filter_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-price-filter',
			'description' => esc_html__( 'Display list of price to filter products.', 'molla-core' ),
		);

		$control_ops = array( 'id_base' => 'price-filter-widget' );

		parent::__construct( 'price-filter-widget', esc_html__( 'Molla - Price Filter', 'molla-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args ); // @codingStandardsIgnoreLine

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		if ( $instance['range'] ) {
			$steps = array();
			$range = explode( ',', trim( $instance['range'] ) );
			foreach ( $range as $range ) {
				$range = explode( '-', trim( $range ) );
				if ( 1 === count( $range ) ) {
					$steps[] = array( trim( $range[0] ) );
				} elseif ( 2 === count( $range ) ) {
					if ( trim( $range[1] ) ) {
						$steps[] = array( trim( $range[0] ), trim( $range[1] ) );
					} else {
						$steps[] = array( trim( $range[0] ) );
					}
				}
			}
			if ( empty( $steps ) ) {
				$prices = $this->get_filtered_price();
				if ( $prices->min_price < 1 ) {
					$min = 0;
				} else {
					$min_base = pow( 10, strlen( floor( $prices->min_price ) ) );
					$min      = ceil( $prices->min_price / $min_base ) * $min_base / 10;
				}
				if ( $prices->max_price < 1 ) {
					$max = 1;
				} else {
					$max_base = pow( 10, strlen( floor( $prices->max_price ) ) );
					$max      = ceil( $prices->max_price / $max_base ) * $max_base;
				}
				for ( $step = $min; $step < $max; $step = $step * 10 ) {
					$steps[] = array( $step, $step * 10 );
				}
			}
			$steps = apply_filters( 'molla_products_filter_price_range', $steps );
			echo '<ul class="molla-product-prices">';
			foreach ( $steps as $step ) {
				$count = $this->get_products_count( $step[0], isset( $step[1] ) ? $step[1] : false );
				if ( 0 === (int) $count ) {
					continue;
				}
				if ( 0 === (int) $step[0] ) {
					$format_text_escaped = sprintf( esc_html__( 'Under %s', 'molla-core' ), wc_price( floatval( $step[1] ) ) );
				} elseif ( ! isset( $step[1] ) ) {
					$format_text_escaped = sprintf( esc_html__( '%s &amp; Up', 'molla-core' ), wc_price( floatval( $step[0] ) ) );
				} elseif ( ! empty( $instance['format'] ) ) {
					$format_text_escaped = str_replace( '$from', wc_price( floatval( $step[0] ) ), esc_html( $instance['format'] ) );
					$format_text_escaped = str_replace( '$to', ( isset( $step[1] ) ? wc_price( floatval( $step[1] ) ) : '' ), $format_text_escaped );
				} else {
					$format_text_escaped = $step[0] . ' - ' . ( isset( $step[1] ) ? wc_price( floatval( $step[1] ) ) : '' );
				}
				$format_text_escaped = apply_filters( 'molla_products_filter_price_range_html', $format_text_escaped, $step );
				$link                = add_query_arg( 'min_price', $step[0], wc_get_page_permalink( 'shop' ) );
				if ( isset( $step[1] ) ) {
					$link = add_query_arg( 'max_price', $step[1], $link );
				}
				echo '<li><a href="' . esc_url( $link ) . '">' . $format_text_escaped . ' <span>(' . intval( $count ) . ')</span></a></li>';
			}
			echo '</ul>';
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  = $new_instance['title'];
		$instance['range']  = $new_instance['range'];
		$instance['format'] = $new_instance['format'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'range' ); ?>">
				<strong><?php esc_html_e( 'Price Range', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'range' ); ?>" name="<?php echo $this->get_field_name( 'range' ); ?>" value="<?php echo isset( $instance['range'] ) ? esc_attr( $instance['range'] ) : ''; ?>" />
				<small><?php esc_html_e( 'Example: 0-10, 10-100, 100-200, 200-500', 'molla-core' ); ?></small>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'format' ); ?>">
				<strong><?php esc_html_e( 'Price Pattern', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>" value="<?php echo isset( $instance['format'] ) ? esc_attr( $instance['format'] ) : ''; ?>" />
				<small><?php esc_html_e( 'Example: $from to $to', 'molla-core' ); ?></small>
			</label>
		</p>
		<?php
	}

	private function get_products_count( $min_price = 0, $max_price = false ) {
		global $wpdb;

		if ( $max_price ) {
			return $wpdb->get_var( $wpdb->prepare( "select count(product_id) from {$wpdb->wc_product_meta_lookup} as l where l.min_price >= %f AND l.max_price <= %f", $min_price, $max_price ) );
		} else {
			return $wpdb->get_var( $wpdb->prepare( "select count(product_id) from {$wpdb->wc_product_meta_lookup} as l where l.min_price >= %f", $min_price ) );
		}
	}

	private function get_filtered_price() {
		global $wpdb;

		if ( wc()->query->get_main_query() ) {
			$args = wc()->query->get_main_query()->query_vars;
		} else {
			$args = array();
		}
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= "   WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = %s
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		if ( wc()->query->get_main_query() && $search = WC_Query::get_main_search_query_sql() ) { // @codingStandardsIgnoreLine
			$sql .= ' AND ' . $search;
		}

		return $wpdb->get_row( $wpdb->prepare( $sql, 'publish' ) ); // @codingStandardsIgnoreLine
	}
}
