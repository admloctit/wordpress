<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Molla Posts definition
 */
class Molla_Posts_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-post',
			'description' => esc_html__( 'Display posts ordering by recent or popularity etc.', 'molla-core' ),
		);

		$control_ops = array( 'id_base' => 'posts-widget' );

		parent::__construct( 'posts-widget', esc_html__( 'Molla - Posts', 'molla-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		wp_enqueue_script( 'owl-carousel' );

		$count           = (int) $instance['count'];
		$count_per_slide = (int) $instance['count_per_slide'];
		$orderby         = $instance['orderby'];
		$order           = $instance['order'];
		$cat             = $instance['cat'];
		$show_op         = array();
		if ( $instance['show_image'] ) {
			$show_op[] = 'image';
		}
		if ( $instance['show_author'] ) {
			$show_op[] = 'author';
		}
		if ( $instance['show_date'] ) {
			$show_op[] = 'date';
		}
		if ( $instance['show_comment'] ) {
			$show_op[] = 'comment';
		}

		$item_class = apply_filters( 'molla_post_widget_item_class', '' );

		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $count,
			'orderby'        => $orderby,
			'order'          => $order,
		);

		if ( $cat ) {
			$args['cat'] = $cat;
		}

		$options['margin']     = 0;
		$options['autoHeight'] = true;
		$options['loop']       = false;
		$options['responsive'] = array(
			0 => array(
				'items' => 1,
				'dots'  => true,
				'nav'   => false,
			),
		);
		$options               = json_encode( $options );

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$posts = new WP_Query( $args );

		if ( $posts->have_posts() ) :

			echo $before_widget;

			if ( $title ) {
				echo $before_title . sanitize_text_field( $title ) . $after_title;
			}

			?>
			<div<?php echo $count > $count_per_slide ? ' class="post-carousel owl-carousel owl-simple c-xs-1" data-toggle="owl" data-owl-options="' . esc_attr( $options ) . '"' : ''; ?>>
				<?php
				$cur = 0;
				while ( $posts->have_posts() ) {
					$posts->the_post();

					if ( 0 == $cur % $count_per_slide ) {
						echo '<ul class="posts-list">';
					}
					echo '<li class="' . esc_attr( $item_class ) . '">';
					if ( in_array( 'image', $show_op ) ) {
						get_template_part( 'template-parts/posts/partials/post', 'image' );
					}
					echo '<div class="entry-list-content">';
					if ( ( $instance['show_author'] || $instance['show_date'] || $instance['show_comment'] ) && defined( 'MOLLA_VERSION' ) ) {
						molla_get_template_part(
							'template-parts/posts/partials/post',
							'meta',
							array(
								'showing'   => $show_op,
								'is_widget' => true,
							)
						);
					}
					get_template_part( 'template-parts/posts/partials/post', 'title' );
					echo '</div>';
					echo '</li>';
					if ( $cur % $count_per_slide == $count_per_slide - 1 || $cur == $count - 1 || $cur == count( $posts->posts ) - 1 ) {
						echo '</ul>';
					}
					$cur ++;
				}
				?>
			</div>
			<?php

			echo $after_widget;

		endif;
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['count']           = $new_instance['count'];
		$instance['count_per_slide'] = $new_instance['count_per_slide'];
		$instance['orderby']         = $new_instance['orderby'];
		$instance['order']           = $new_instance['order'];
		$instance['cat']             = $new_instance['cat'];
		$instance['show_image']      = $new_instance['show_image'];
		$instance['show_author']     = $new_instance['show_author'];
		$instance['show_date']       = $new_instance['show_date'];
		$instance['show_comment']    = $new_instance['show_comment'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'           => esc_html__( 'Popular Posts', 'molla-core' ),
			'count'           => 6,
			'count_per_slide' => 3,
			'orderby'         => 'comment_count',
			'order'           => 'DESC',
			'cat'             => '',
			'show_image'      => 'on',
			'show_author'     => 'off',
			'show_date'       => 'on',
			'show_comment'    => 'off',
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<strong><?php esc_html_e( 'Order By', 'molla-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="post_date"<?php echo ( isset( $instance['orderby'] ) && 'post_date' == $instance['orderby'] ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Date', 'molla-core' ); ?></option>
					<option value="comment_count"<?php echo ( isset( $instance['orderby'] ) && 'comment_count' == $instance['orderby'] ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Popularity', 'molla-core' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<strong><?php esc_html_e( 'Order', 'molla-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
					<option value="ASC"<?php echo ( isset( $instance['order'] ) && 'ASC' == $instance['order'] ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Ascending', 'molla-core' ); ?></option>
					<option value="DESC"<?php echo ( isset( $instance['order'] ) && 'DESC' == $instance['order'] ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Descending', 'molla-core' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>">
				<strong><?php esc_html_e( 'Category IDs', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>" value="<?php echo isset( $instance['cat'] ) ? esc_attr( $instance['cat'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_image'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Featured Image', 'molla-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_author'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php esc_html_e( 'Show Author', 'molla-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_date'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date', 'molla-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_comment'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_comment' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_comment' ) ); ?>"><?php esc_html_e( 'Show Comment Count', 'molla-core' ); ?></label>
		</p>
		<?php
	}
}
