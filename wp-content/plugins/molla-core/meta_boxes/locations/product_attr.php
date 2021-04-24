<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Attribute Type
add_filter(
	'product_attributes_type_selector',
	function( $types ) {
		$types['pick'] = esc_html__( 'Pick', 'molla-core' );
		return $types;
	}
);

add_action( 'woocommerce_product_option_terms', 'molla_wc_product_option_terms', 10, 3 );

function molla_wc_product_option_terms( $attribute_taxonomy, $i, $attribute ) {
	if ( 'pick' == $attribute_taxonomy->attribute_type ) :
		?>
	<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
		<?php
		$args      = array(
			'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
			'hide_empty' => 0,
		);
		$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
		if ( $all_terms ) {
			foreach ( $all_terms as $term ) {
				$options = $attribute->get_options();
				$options = ! empty( $options ) ? $options : array();
				echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
			}
		}
		?>
	</select>
	<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
	<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
	<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button>
		<?php
	endif;
}

if ( class_exists( 'WooCommerce' ) && $attribute_taxonomies = wc_get_attribute_taxonomies() ) {
	foreach ( $attribute_taxonomies as $tax ) {
		if ( 'pick' === $tax->attribute_type ) {
			add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_add_form_fields', 'molla_attr_add_form_fields', 100 );
			add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_edit_form_fields', 'molla_attr_edit_form_fields', 100, 2 );
			add_action( 'created_term', 'molla_save_attr_meta_values', 100, 3 );
			add_action( 'edit_term', 'molla_save_attr_meta_values', 100, 3 );
			add_action( 'delete_term', 'molla_delete_attr_meta_values', 10, 5 );
		}
	}
}

function molla_save_attr_meta_values( $term_id, $tt_id, $taxonomy ) {
	if ( strpos( $taxonomy, 'pa_' ) === false ) {
		return;
	}

	$fields = array( 'attr_label', 'attr_color' );

	foreach ( $fields as $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			update_term_meta( $term_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		} else {
			delete_term_meta( $term_id, $field );
		}
	}
}

function molla_delete_attr_meta_values( $term_id, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
	if ( strpos( $taxonomy, 'pa_' ) === false ) {
		return;
	}

	$fields = array( 'attr_label', 'attr_color' );

	foreach ( $fields as $field ) {
		delete_term_meta( $term_id, $field );
	}
}

function molla_attr_add_form_fields( $taxonomy ) {
	if ( strpos( $taxonomy, 'pa_' ) === false ) {
		return;
	}
	if ( $attribute_taxonomies = wc_get_attribute_taxonomies() ) {
		foreach ( $attribute_taxonomies as $tax ) {
			if ( 'pick' === $tax->attribute_type && $taxonomy === wc_attribute_taxonomy_name( $tax->attribute_name ) ) {
				?>
			<div class="form-field term-cat-icon-wrap">
				<label for="attr_label"><?php esc_html_e( 'Label', 'molla-core' ); ?></label>
				<input type="text" name="attr_label" id="attr_label">
			</div>
			<div class="form-field term-cat-icon-wrap">
				<label for="attr_color"><?php esc_html_e( 'Color', 'molla-core' ); ?></label>
				<input type="text" class="color-picker" name="attr_color" id="attr_color">
			</div>
				<?php
			}
		}
	}
}


function molla_attr_edit_form_fields( $tag, $taxonomy ) {
	if ( strpos( $taxonomy, 'pa_' ) === false ) {
		return;
	}
	if ( $attribute_taxonomies = wc_get_attribute_taxonomies() ) {
		foreach ( $attribute_taxonomies as $tax ) {
			if ( 'pick' === $tax->attribute_type && $taxonomy === wc_attribute_taxonomy_name( $tax->attribute_name ) ) {
				?>
			<tr class="form-field">
				<th scope="row"><label for="name"><?php esc_html_e( 'Label', 'molla-core' ); ?></label></th>
				<td>
					<input name="attr_label" id="attr_label" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_label', true ) ); ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="name"><?php esc_html_e( 'Color', 'molla-core' ); ?></label></th>
				<td>
					<input type="text" class="color-picker" id="attr_color" name="attr_color" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_color', true ) ); ?>">
				</td>
			</tr>
				<?php
			}
		}
	}
}
