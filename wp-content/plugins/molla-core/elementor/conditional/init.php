<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Display Condition
 *
 *
 * @since 1.2
 */
class Molla_Builder_Module extends Elementor\Core\Base\Module {

	protected $builders = '';

	protected $condition_network = '';

	protected $template_conditions = '';

	protected $post_type = '';

	public function __construct() {

		$this->builders = array(
			'header',
			'footer',
			'sidebar',
			'popup',
			'product_layout',
		);

		// Ajax
		add_action( 'wp_ajax_molla_template_ids_search', array( $this, 'condition_ids_search' ) );
		add_action( 'wp_ajax_nopriv_molla_template_ids_search', array( $this, 'condition_ids_search' ) );
		add_action( 'wp_ajax_molla_save_conditions', array( $this, 'save_conditions' ) );
		add_action( 'wp_ajax_nopriv_molla_save_conditions', array( $this, 'save_conditions' ) );

		if ( is_admin() && molla_is_elementor_preview() ) {
			add_action(
				'elementor/editor/after_enqueue_scripts',
				function() {
					global $post;

					wp_localize_script(
						'molla-elementor-admin-js',
						'elementor_admin',
						array(
							'theme_assets'      => MOLLA_URI,
							'ajax_url'          => esc_url( admin_url( 'admin-ajax.php' ) ),
							'nonce'             => wp_create_nonce( 'molla-elementor-admin' ),
							'post_id'           => get_the_ID(),
							'builder_type'      => $post->post_type,
							'condition_network' => $this->condition_network,
							'i18n'              => array(
								'modal_heading'          => esc_html__( 'Builder Conditionals', 'molla-core' ),
								'save_action'            => esc_html__( 'Save & Close', 'molla-core' ),
								'add_condition'          => esc_html__( 'Add Condition', 'molla-core' ),
								'conditions_title'       => esc_html__( 'Where Do You Want to Display Your %s?', 'molla-core' ),
								'conditions_description' => esc_html__( 'Set the conditions that determine where your %s is used throughout your site overriding global & local options.', 'molla-core' ) . '<br>' . __( 'For example, choose \'Entire Site\' to display the template across your site.', 'molla-core' ),
								'archive_label'          => esc_html__( 's Archive', 'molla-core' ),
								'all'                    => esc_html__( 'All', 'molla-core' ),
								'popup_description'      => esc_html__( 'On Page Load Within (sec)', 'molla-core' ),
								'width'                  => esc_html__( 'Width (%)', 'molla-core' ),
								'left'                   => esc_html__( 'Left', 'molla-core' ),
								'right'                  => esc_html__( 'Right', 'molla-core' ),
								'clone_condition'        => esc_html__( 'Clone Condition', 'molla-core' ),
								'remove_condition'       => esc_html__( 'Remove Condition', 'molla-core' ),
							),
							'conditions'        => $this->print_condition(),
						)
					);
				}
			);

			if ( isset( $_REQUEST['post'] ) && $_REQUEST['post'] ) {
				$this->post_type = get_post_type( $_REQUEST['post'] );
				if ( in_array( $this->post_type, $this->builders ) ) {
					add_action(
						'init',
						function() {
							$this->register_condition();
						}
					);

					add_action( 'admin_print_footer_scripts', array( $this, 'print_condition' ), 1 );

					add_action(
						'elementor/editor/after_enqueue_styles',
						function() {
							if ( defined( 'MOLLA_VERSION' ) ) {
								wp_enqueue_script(
									'jquery-autocomplete',
									MOLLA_JS . '/plugins/jquery.autocomplete.min.js',
									array( 'jquery-core' ),
									false,
									true
								);
							}
						}
					);
				}
			}
		}

	}

	public function get_name() {
		return 'molla-builder-conditionals';
	}

	public function register_condition() {
		// Save old conditions.
		$type                      = $this->post_type;
		$this->template_conditions = get_post_meta( $_REQUEST['post'], 'molla_builder_conditions', true );

		// Create condition network
		$this->condition_network = array();

		if ( 'product_layout' != $type ) {
			$this->condition_network['all'] = array(
				'name'    => esc_html__( 'Entire Site', 'molla-core' ),
				'subcats' => array(),
			);

			$this->condition_network['archive'] = array(
				'name'    => esc_html__( 'Archives', 'molla-core' ),
				'subcats' => array(
					''     => esc_html__( 'All Archives', 'molla-core' ),
					'post' => array(
						'post_archive' => esc_html__( 'Posts Archive', 'molla-core' ),
						'category'     => esc_html__( 'Categories', 'molla-core' ),
						'post_tag'     => esc_html__( 'Tags', 'molla-core' ),
					),
				),
			);

			$this->condition_network['single'] = array(
				'name'    => esc_html__( 'Singular', 'molla-core' ),
				'subcats' => array(
					''      => esc_html__( 'All Singular', 'molla-core' ),
					'front' => esc_html__( 'Front Page', 'molla-core' ),
					'error' => esc_html__( 'Error 404', 'molla-core' ),
					'post'  => array(
						'post'     => esc_html__( 'Posts', 'molla-core' ),
						'category' => esc_html__( 'In Category', 'molla-core' ),
						'post_tag' => esc_html__( 'In Tag', 'molla-core' ),
					),
					'page'  => array(
						'page' => esc_html__( 'Pages', 'molla-core' ),
					),
				),
			);

		}

		if ( class_exists( 'WooCommerce' ) ) {

			if ( 'product_layout' == $type ) {
				$this->condition_network['single']            = array( 'name' => esc_html__( 'Singular', 'molla-core' ) );
				$this->condition_network['single']['subcats'] = array();
			} else {
				$this->condition_network['archive']['subcats']['product'] = array(
					'product_archive' => esc_html__( 'All Product Archives', 'molla-core' ),
					'shop'            => esc_html__( 'Shop Page', 'molla-core' ),
					'product_cat'     => esc_html__( 'Product categories', 'molla-core' ),
					'product_tag'     => esc_html__( 'Product tags', 'molla-core' ),
				);
			}

			$this->condition_network['single']['subcats']['product'] = array(
				'product'     => esc_html__( 'Products', 'molla-core' ),
				'product_cat' => esc_html__( 'In Category', 'molla-core' ),
				'product_tag' => esc_html__( 'In Tag', 'molla-core' ),
			);
		}

		if ( 'product_layout' != $type ) {
			// Other registered post types
			$post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );
			foreach ( $post_types as $type ) {
				if ( in_array( $type->name, array( 'post', 'page', 'product', 'block' ) ) || in_array( $type->name, $this->builders ) ) {
					continue;
				}

				$taxonomies = get_object_taxonomies( $type->name, 'objects' );
				$taxonomies = wp_filter_object_list(
					$taxonomies,
					array(
						'public'            => true,
						'show_in_nav_menus' => true,
					)
				);

				$suffix_escaped = esc_html__( 's', 'molla-core' );

				$archive_parts = array( $type->name . '_archive' => ucwords( $type->labels->name ) . $suffix_escaped . ' ' . esc_html__( 'Archive', 'molla-core' ) );
				$single_parts  = array( $type->name => ucwords( $type->labels->name ) . $suffix_escaped );

				if ( $taxonomies ) {
					foreach ( $taxonomies as $key => $value ) {
						$archive_parts[ $key ] = ucwords( $value->labels->name ) . $suffix_escaped . ' ';
						$single_parts[ $key ]  = esc_html__( 'In ', 'molla-core' ) . ucwords( $value->labels->name );
					}
				}
				$this->condition_network['archive']['subcats'][ $type->name ] = $archive_parts;
				$this->condition_network['single']['subcats'][ $type->name ]  = $single_parts;
			}
		}
	}

	public function print_condition() {
		$conditions   = get_post_meta( $_REQUEST['post'], 'molla_builder_conditions', true );
		$builder_type = get_post_type( $_REQUEST['post'] );
		ob_start();
		?>
		<ul class="conditions">
			<?php
			if ( $conditions ) {
				foreach ( $conditions as $condition ) {
					echo '<li class="condition">';

					$this->initialize_conditional_controls(
						array(
							'post_type'   => isset( $condition['subcategory'] ) ? $this->get_condition_post_type( $condition['subcategory'] ) : $this->get_condition_post_type( $condition['category'] ),
							'category'    => isset( $condition['category'] ) ? $condition['category'] : 'single',
							'subcategory' => isset( $condition['subcategory'] ) ? $condition['subcategory'] : '',
							'id'          => isset( $condition['id'] ) ? $condition['id'] : false,
						)
					);

					if ( 'popup' == $builder_type ) { // Popup Builder
						echo '<div class="condition-wrap condition-input-wrap condition-popup-within">
								<input type="number" placeholder="' . esc_html__( 'On Page Load Within (sec)', 'molla-core' ) . '"' . ( ( isset( $condition['popup_within'] ) && '' !== $condition['popup_within'] ) ? ( ' value="' . $condition['popup_within'] . '"' ) : '' ) . '>
							</div>';
					} elseif ( 'sidebar' == $builder_type ) {
						echo '<div class="condition-wrap condition-sidebar-pos">
							<select>
								<option value="left" ' . selected( 'left', $condition['sidebar_pos'], false ) . '>' . esc_html__( 'Left', 'molla-core' ) . '</option>
								<option value="right" ' . selected( 'right', $condition['sidebar_pos'], false ) . '>' . esc_html__( 'Right', 'molla-core' ) . '</option>
							</select>
						</div>
						<div class="condition-wrap condition-input-wrap condition-sidebar-width">
							<input type="number" placeholder="' . esc_html__( 'Width (%)', 'molla-core' ) . '"' . ( ( isset( $condition['sidebar_width'] ) && '' !== $condition['sidebar_width'] && 0 < floatval( $condition['sidebar_width'] ) && 100 > floatval( $condition['sidebar_width'] ) ) ? ( ' value="' . floatval( $condition['sidebar_width'] ) . '"' ) : '' ) . '>
						</div>';
					}

					echo '<a href="#" class="btn clone_condition" title="' . esc_html__( 'Clone Condition', 'molla-core' ) . '"><i class="fas fa-copy"></i></a>';
					echo '<a href="#" class="btn remove_condition" title="' . esc_html__( 'Remove Condition', 'molla-core' ) . '"><i class="fas fa-times"></i></a>';
					echo '</li>';
				}
			}
			?>
		</ul>
		<button class="elementor-button elementor-button-default" id="molla-add-condition"><?php esc_html_e( 'Add Condition', 'molla-core' ); ?></button>
		<?php
		return ob_get_clean();
	}

	public function initialize_conditional_controls( $cond = array() ) {
		// Print condition category select box
		if ( 'product_layout' != get_post_type() ) {
			?>
		<div class="condition-wrap condition-category">
			<select>
			<?php
			foreach ( $this->condition_network as $cat => $values ) {
				?>
				<option value="<?php echo esc_attr( $cat ); ?>" <?php selected( $cat, $cond['category'] ); ?>><?php echo esc_html( $values['name'] ); ?></option>
			<?php } ?>
			</select>
		</div>
			<?php
		} else {
			$cond['post_type'] = 'product';
		}

		// If Entire Site is selected no need to print subcategories
		if ( 'all' == $cond['category'] ) {
			return;
		}

		?>
		<div class="condition-wrap condition-subcategory">
			<select>
			<?php
			$ary_keys = array();
			foreach ( $this->condition_network[ $cond['category'] ]['subcats'] as $key => $value ) {
				if ( is_array( $value ) ) :
					?>
					<optgroup label="<?php echo ucfirst( $key . 's' ); ?>">
					<?php
					foreach ( $value as $subkey => $subvalue ) {
						?>
						<option value="<?php echo esc_attr( $subkey ); ?>" <?php selected( $subkey, $cond['subcategory'] ); ?>><?php echo esc_html( $subvalue ); ?></option>
						<?php
					}
					?>
					</optgroup>
					<?php
				else :
					?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $cond['subcategory'] ); ?>><?php echo esc_html( $value ); ?></option>
					<?php
				endif;
			}
			?>
		
			</select>
		</div>
		<?php

		// If subcategory is not available for ids select box
		if ( ! $cond['subcategory'] || false !== strpos( $cond['subcategory'], '_archive' ) || 'shop' == $cond['subcategory'] || 'front' == $cond['subcategory'] || 'error' == $cond['subcategory'] ) {
			return;
		}

		?>
		<div class="condition-wrap condition-ids">
			<div class="ids-select">
				<span class="ids-select-toggle" data-id="<?php echo esc_attr( $cond['id']['id'] ); ?>"><mark><?php echo esc_html( $cond['id']['title'] ); ?></mark></span>
				<div class="dropdown-box">
					<input type="hidden" name="post_type" value="<?php echo esc_attr( $cond['post_type'] ); ?>">
					<input type="hidden" name="taxonomy" value="<?php echo esc_attr( post_type_exists( $cond['subcategory'] ) ? '' : $cond['subcategory'] ); ?>">
					<input type="search" class="form-control" name="s" required="" autocomplete="off">
					<div class="live-search-list">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function get_condition_post_type( $category ) {
		if ( 'all' == $category ) {
			return 'all';
		} elseif ( 0 == strpos( $category, 'post' ) || 'category' == $category ) {
			return 'post';
		} elseif ( 0 == strpos( $category, 'product' ) ) {
			return 'product';
		} elseif ( 'page' == $category ) {
			return 'page';
		} else {
			return preg_replace( '/_archive$|_single$/', '', $category );
		}
	}

	public function condition_ids_search() {
		check_ajax_referer( 'molla-elementor-admin', 'nonce' );
		$taxonomy  = isset( $_REQUEST['taxonomy'] ) ? $_REQUEST['taxonomy'] : '';
		$post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : '';
		if ( $post_type == $taxonomy ) {
			$taxonomy = '';
		}

		global $wpdb;
		$results = $wpdb->get_results(
			$taxonomy ?
			$wpdb->prepare(
				"SELECT terms.term_id AS id, terms.name AS title
					FROM {$wpdb->terms} AS terms LEFT JOIN {$wpdb->term_taxonomy} AS taxonomy
					ON terms.term_id = taxonomy.term_id 
					WHERE taxonomy.taxonomy = '{$taxonomy}' AND terms.name LIKE '%%%s%%'",
				$wpdb->esc_like( stripslashes( $_REQUEST['query'] ) )
			) :
			$wpdb->prepare(
				"SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = '{$post_type}' AND post_status = 'publish' AND post_title LIKE '%%%s%%'",
				$wpdb->esc_like( stripslashes( $_REQUEST['query'] ) )
			),
			ARRAY_A
		);

		wp_send_json( array( 'suggestions' => $results ) );
	}

	public function save_conditions() {
		check_ajax_referer( 'molla-elementor-admin', 'nonce' );

		$conditions     = $_POST['conditions'];
		$old_conditions = get_post_meta( $_POST['post_id'], 'molla_builder_conditions', true );

		if ( empty( $old_conditions ) ) {
			$old_conditions = array();
		}

		$type = get_post_type( $_POST['post_id'] );

		foreach ( array( 'old', 'new' ) as $status ) {
			foreach ( ( 'new' == $status ? $conditions : $old_conditions ) as $condition ) {
				$cat = $condition['category'];
				if ( 'product_layout' == get_post_type( $_POST['post_id'] ) ) {
					$cat = 'single';
				}
				$is_single = 'single' == $cat;
				$subcat    = isset( $condition['subcategory'] ) ? $condition['subcategory'] : false;
				$id        = isset( $condition['id'] ) ? $condition['id']['id'] : false;
				if ( false !== $id ) {
					if ( 'archive' == $cat ) {
						if ( 0 == $id ) {
							$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, $subcat, $is_single );
						} else {
							$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, 'term', $is_single );
						}
					} else {
						if ( 0 == $id ) {
							$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, $subcat, $is_single );
						} else {
							if ( post_type_exists( $subcat ) ) {
								$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, $subcat, $is_single );
							} else {
								$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, 'term', $is_single );
							}
						}
					}
				} else {
					if ( 'all' == $cat ) {
						$subcat    = 'default';
						$is_single = $subcat;
					} elseif ( 'archive' == $cat && ! $subcat ) {
						$subcat    = 'all_archive';
						$is_single = $subcat;
					} elseif ( 'single' == $cat && ! $subcat ) {
						$subcat    = 'all_single';
						$is_single = $subcat;
					}

					$this->update_builder_conditions( $type, $id, $condition, 'old' == $status, $subcat, $is_single );
				}
			}
		}

		// Update condition postmeta
		if ( empty( $_POST['conditions'] ) ) {
			delete_post_meta( $_POST['post_id'], 'molla_builder_conditions' );
		} else {
			update_post_meta( $_POST['post_id'], 'molla_builder_conditions', $_POST['conditions'] );
		}

		wp_send_json( 'success' );
	}

	protected function update_builder_conditions( $type, $id, $condition, $remove = false, $method = false, $is_single = false ) {
		if ( false === $is_single ) {
			if ( 'term' == $method ) { // for single posts in specific taxonomies
				$builders = get_term_meta( $id, 'molla_builders', true );
				if ( $builders ) {
					$builders = json_decode( $builders, true );
				} else {
					$builders = array( 'archive' => array() );
				}
				if ( ! isset( $builders['archive'] ) ) {
					$builders['archive'] = array();
				}
				if ( $remove ) {
					if ( isset( $builders['archive'][ $type ] ) ) {
						unset( $builders['archive'][ $type ] );
						if ( ! count( $builders['archive'] ) ) {
							unset( $builders['archive'] );
						}
					}
				} else {
					if ( 'popup' == $type ) {
						$builders['archive'][ $type ] = array(
							'popup_id'    => $_POST['post_id'],
							'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
						);
					} elseif ( 'sidebar' == $type ) {
						$s_width                      = floatval( $condition['sidebar_width'] );
						$builders['archive'][ $type ] = array(
							'sidebar_id'    => $_POST['post_id'],
							'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
							'sidebar_pos'   => $condition['sidebar_pos'],
						);
					} else {
						$builders['archive'][ $type ] = $_POST['post_id'];
					}
				}
				if ( count( $builders ) ) {
					update_term_meta( $id, 'molla_builders', json_encode( $builders ) );
				} else {
					delete_term_meta( $id, 'molla_builders' );
				}
			} else { // for taxonomy archive
				$builders = get_theme_mod( 'builders' );

				if ( ! $builders ) {
					$builders = array();
				}
				$builders = json_decode( $builders, true );
				if ( ! isset( $builders['archive'] ) ) {
					$builders['archive'] = array();
				}

				if ( ! isset( $builders['archive'][ $method ] ) ) {
					$builders['archive'][ $method ] = array();
				}
				if ( $remove ) {
					if ( isset( $builders['archive'][ $method ][ $type ] ) ) {
						unset( $builders['archive'][ $method ][ $type ] );
						if ( ! count( $builders['archive'][ $method ] ) ) {
							unset( $builders['archive'][ $method ] );
						}
					}
				} else {
					if ( 'popup' == $type ) {
						$builders['archive'][ $method ][ $type ] = array(
							'popup_id'    => $_POST['post_id'],
							'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
						);
					} elseif ( 'sidebar' == $type ) {
						$s_width                                 = floatval( $condition['sidebar_width'] );
						$builders['archive'][ $method ][ $type ] = array(
							'sidebar_id'    => $_POST['post_id'],
							'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
							'sidebar_pos'   => $condition['sidebar_pos'],
						);
					} else {
						$builders['archive'][ $method ][ $type ] = $_POST['post_id'];
					}
				}
				set_theme_mod( 'builders', json_encode( $builders ) );
			}
		} elseif ( true === $is_single ) {
			if ( 'term' == $method ) {
				$builders = get_term_meta( $id, 'molla_builders', true );
				if ( $builders ) {
					$builders = json_decode( $builders, true );
				} else {
					$builders = array( 'single' => array() );
				}
				if ( ! isset( $builders['single'] ) ) {
					$builders['single'] = array();
				}
				if ( $remove ) {
					if ( isset( $builders['single'][ $type ] ) ) {
						unset( $builders['single'][ $type ] );
						if ( ! count( $builders['single'] ) ) {
							unset( $builders['single'] );
						}
					}
				} else {
					if ( 'popup' == $type ) {
						$builders['single'][ $type ] = array(
							'popup_id'    => $_POST['post_id'],
							'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
						);
					} elseif ( 'sidebar' == $type ) {
						$s_width                     = floatval( $condition['sidebar_width'] );
						$builders['single'][ $type ] = array(
							'sidebar_id'    => $_POST['post_id'],
							'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
							'sidebar_pos'   => $condition['sidebar_pos'],
						);
					} else {
						$builders['single'][ $type ] = $_POST['post_id'];
					}
				}
				if ( count( $builders ) ) {
					update_term_meta( $id, 'molla_builders', json_encode( $builders ) );
				} else {
					delete_term_meta( $id, 'molla_builders' );
				}
			} elseif ( $id ) {
				$builders = get_post_meta( $id, 'molla_builders', true );
				if ( $builders ) {
					$builders = json_decode( $builders, true );
				} else {
					$builders = array( 'single' => array() );
				}
				if ( ! isset( $builders['single'] ) ) {
					$builders['single'] = array();
				}
				if ( $remove ) {
					if ( isset( $builders['single'][ $type ] ) ) {
						unset( $builders['single'][ $type ] );
						if ( ! count( $builders['single'] ) ) {
							unset( $builders['single'] );
						}
					}
				} else {
					if ( 'popup' == $type ) {
						$builders['single'][ $type ] = array(
							'popup_id'    => $_POST['post_id'],
							'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
						);
					} elseif ( 'sidebar' == $type ) {
						$s_width                     = floatval( $condition['sidebar_width'] );
						$builders['single'][ $type ] = array(
							'sidebar_id'    => $_POST['post_id'],
							'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
							'sidebar_pos'   => $condition['sidebar_pos'],
						);
					} else {
						$builders['single'][ $type ] = $_POST['post_id'];
					}
				}
				if ( count( $builders ) ) {
					update_post_meta( $id, 'molla_builders', json_encode( $builders ) );
				} else {
					delete_post_meta( $id, 'molla_builders' );
				}
			} else {
				$builders = get_theme_mod( 'builders' );

				if ( ! $builders ) {
					$builders = array();
				}
				$builders = json_decode( $builders, true );
				if ( ! isset( $builders['single'] ) ) {
					$builders['single'] = array();
				}

				if ( ! isset( $builders['single'][ $method ] ) ) {
					$builders['single'][ $method ] = array();
				}
				if ( $remove ) {
					if ( isset( $builders['single'][ $method ][ $type ] ) ) {
						unset( $builders['single'][ $method ][ $type ] );
						if ( ! count( $builders['single'][ $method ] ) ) {
							unset( $builders['single'][ $method ] );
						}
					}
				} else {
					if ( 'popup' == $type ) {
						$builders['single'][ $method ][ $type ] = array(
							'popup_id'    => $_POST['post_id'],
							'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
						);
					} elseif ( 'sidebar' == $type ) {
						$s_width                                = floatval( $condition['sidebar_width'] );
						$builders['single'][ $method ][ $type ] = array(
							'sidebar_id'    => $_POST['post_id'],
							'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
							'sidebar_pos'   => $condition['sidebar_pos'],
						);
					} else {
						$builders['single'][ $method ][ $type ] = $_POST['post_id'];
					}
				}
				set_theme_mod( 'builders', json_encode( $builders ) );
			}
		} else {
			$builders = get_theme_mod( 'builders' );

			if ( ! $builders ) {
				$builders = array();
			}
			$builders = json_decode( $builders, true );
			if ( ! isset( $builders[ $is_single ] ) ) {
				$builders[ $is_single ] = array();
			}

			if ( $remove ) {
				if ( isset( $builders[ $is_single ][ $type ] ) ) {
					unset( $builders[ $is_single ][ $type ] );
					if ( ! count( $builders[ $is_single ] ) ) {
						unset( $builders[ $is_single ] );
					}
				}
			} else {
				if ( 'popup' == $type ) {
					$builders[ $is_single ][ $type ] = array(
						'popup_id'    => $_POST['post_id'],
						'popup_delay' => ! empty( $condition['popup_within'] ) ? $condition['popup_within'] : 0,
					);
				} elseif ( 'sidebar' == $type ) {
					$s_width                         = floatval( $condition['sidebar_width'] );
					$builders[ $is_single ][ $type ] = array(
						'sidebar_id'    => $_POST['post_id'],
						'sidebar_width' => ( 0 < $s_width && 100 > $s_width ) ? $s_width : '',
						'sidebar_pos'   => $condition['sidebar_pos'],
					);
				} else {
					$builders[ $is_single ][ $type ] = $_POST['post_id'];
				}
			}

			set_theme_mod( 'builders', json_encode( $builders ) );
		}
	}

}

new Molla_Builder_Module;
