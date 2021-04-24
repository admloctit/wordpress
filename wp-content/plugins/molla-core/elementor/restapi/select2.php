<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ajax_Api {

	protected $request = [];

	public function action( $request ) {
		if ( isset( $request['method'] ) && method_exists( $this, $request['method'] ) ) {
			$this->request = $request;
			return $this->{$request['method']}();
		}
	}

	public function page() {
		$query_args = [
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = $this->parse_post_args( $this->request['ids'], 'page' );
			$query_args['post__in'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function post() {
		$query_args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = $this->parse_post_args( $this->request['ids'], 'post' );
			$query_args['post__in'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function category() {
		$taxonomy   = 'category';
		$query_args = [
			'taxonomy'   => [ 'category' ], // taxonomy name
			'hide_empty' => false,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->parse_term_args( $this->request['ids'], 'category' );
			$query_args['include'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms( $query_args );

		$options = [];
		$count   = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => $term->term_id,
					'text' => htmlspecialchars_decode( $term->name ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}

	public function product() {
		$query_args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = $this->parse_post_args( $this->request['ids'], 'product' );
			$query_args['post__in'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function product_cat() {
		$query_args = [
			'taxonomy'   => [ 'product_cat' ], // taxonomy name
			'hide_empty' => false,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->parse_term_args( $this->request['ids'], 'product_cat' );
			$query_args['include'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms( $query_args );

		$options = [];
		$count   = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => $term->term_id,
					'text' => htmlspecialchars_decode( $term->name ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}

	public function product_brand() {
		$query_args = [
			'taxonomy'   => [ 'product_brand' ], // taxonomy name
			'hide_empty' => false,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->parse_term_args( $this->request['ids'], 'product_brand' );
			$query_args['include'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms( $query_args );

		$options = [];
		$count   = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => $term->term_id,
					'text' => htmlspecialchars_decode( $term->name ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}


	public function block() {
		$query_args = [
			'post_type'      => 'block',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = $this->parse_post_args( $this->request['ids'], 'block' );
			$query_args['post__in'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function popup() {
		$query_args = [
			'post_type'      => 'popup',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = $this->parse_post_args( $this->request['ids'], 'popup' );
			$query_args['post__in'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function parse_term_args( $ids, $term ) {
		$ret = array();
		if ( ! is_array( $ids ) ) {
			$ids = explode( ',', $ids );
		}

		for ( $i = 0; $i < count( $ids );  $i ++ ) {
			if ( '0' !== $ids[ $i ] && ! intval( $ids[ $i ] ) ) {
				$ids[ $i ] = get_term_by( 'slug', $ids[ $i ], $term );
				$ids[ $i ] = $ids[ $i ] ? $ids[ $i ]->term_id : -1;
			}
			if ( get_term( $ids[ $i ], $term ) ) {
				$ret[] = $ids[ $i ];
			}
		}
		return $ret;
	}

	public function parse_post_args( $ids, $post ) {
		if ( ! is_array( $ids ) ) {
			$ids = explode( ',', $ids );
		}
		for ( $i = 0; $i < count( $ids );  $i ++ ) {
			if ( '0' !== $ids[ $i ] && ! intval( $ids[ $i ] ) ) {
				if ( defined( 'MOLLA_VERSION' ) ) {
					$ids[ $i ] = molla_get_post_id_by_name( $post, $ids[ $i ] );
				}
			}
		}
		return $ids;
	}

}

function ajax_select_api( WP_REST_Request $request ) {
	$class = new Ajax_Api();
	return $class->action( $request );
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ajaxselect2/v1',
			'/(?P<method>\w+)/',
			array(
				'methods'             => 'GET',
				'callback'            => 'ajax_select_api',
				'permission_callback' => '__return_true',
			)
		);
	}
);
