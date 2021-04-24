<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Meta fields when add taxonomy
add_action( 'product_cat_add_form_fields', 'molla_add_product_cat_meta_fields' );

function molla_add_product_cat_meta_fields() {
	?>
	<div class="form-field term-cat-icon-wrap">
		<label for="cat_icon_class"><?php esc_html_e( 'Category Icon Class', 'molla-core' ); ?></label>
		<input type="text" name="cat_icon_class" id="cat_icon_class">
	</div>
	<div class="form-field term-product-columns-wrap">
		<label for="product_columns"><?php esc_html_e( 'Columns', 'molla-core' ); ?></label>
		<select id="product_columns" name="product_columns" class="postform">
			<option value="" selected="true"><?php echo esc_html( 'Default' ); ?></option>
		<?php
		for ( $i = 1; $i <= 6; $i ++ ) :
			?>
			<option value="<?php echo intval( $i ); ?>"><?php echo esc_html( $i ); ?></option>
			<?php
		endfor;
		?>
		</select>
	</div>
	<div class="form-group">
		<div class="form-field term-cat-header-width-wrap">
			<label for="cat_header_width"><?php esc_html_e( 'Header Width', 'molla-core' ); ?></label>
			<select id="cat_header_width" name="cat_header_width" class="postform">
				<option value="default" selected="true"><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<option value="container"><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
				<option value="container-fluid"><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
			?>
			</select>
		</div>
		<div class="form-field term-cat-page-width-wrap">
			<label for="cat_page_width"><?php esc_html_e( 'Page Content Width', 'molla-core' ); ?></label>
			<select id="cat_page_width" name="cat_page_width" class="postform">
				<option value="default" selected="true"><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<option value="container"><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
				<option value="container-fluid"><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
				<option value=""><?php esc_html_e( 'Full', 'molla-core' ); ?></option>
			?>
			</select>
		</div>
		<div class="form-field term-cat-page-width-wrap">
			<label for="cat_footer_width"><?php esc_html_e( 'Footer Width', 'molla-core' ); ?></label>
			<select id="cat_footer_width" name="cat_footer_width" class="postform">
				<option value="default" selected="true"><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<option value="container"><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
				<option value="container-fluid"><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="form-field term-sidebar-wrap form-sidebar-op">
			<label for="cat_sidebar"><?php esc_html_e( 'Sidebar Option', 'molla-core' ); ?></label>
			<select id="cat_sidebar" name="cat_sidebar" class="postform">
				<option value="default" selected="true"><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<option value=""><?php esc_html_e( 'Sticky Sidebar', 'molla-core' ); ?></option>
				<option value="filter-sidebar"><?php esc_html_e( 'Toggle Sidebar', 'molla-core' ); ?></option>
			?>
			</select>
		</div>
		<div class="form-field term-sidebar-pos-wrap">
			<label for="cat_sidebar_pos"><?php esc_html_e( 'Sidebar Position', 'molla-core' ); ?></label>
			<select id="cat_sidebar_pos" name="cat_sidebar_pos" class="postform">
				<option value="default" selected="true"><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<option value="left"><?php esc_html_e( 'Left', 'molla-core' ); ?></option>
				<option value="right"><?php esc_html_e( 'Right', 'molla-core' ); ?></option>
				<option value="top"><?php esc_html_e( 'Top', 'molla-core' ); ?></option>
			?>
			</select>
		</div>
	</div>
	<div class="form-field term-top-block-wrap">
		<label for="content_top_block"><?php esc_html_e( 'Content Top Block', 'molla-core' ); ?></label>
		<input type="text" name="content_top_block" id="content_top_block">
	</div>
	<div class="form-field term-top-block-wrap">
		<label for="content_inner_top_block"><?php esc_html_e( 'Content Inner Top Block', 'molla-core' ); ?></label>
		<input type="text" name="content_inner_top_block" id="content_inner_top_block">
	</div>
	<div class="form-field term-top-block-wrap">
		<label for="content_inner_bottom_block"><?php esc_html_e( 'Content Inner Bottom Block', 'molla-core' ); ?></label>
		<input type="text" name="content_inner_bottom_block" id="content_inner_bottom_block">
	</div>
	<div class="form-field term-top-block-wrap">
		<label for="content_bottom_block"><?php esc_html_e( 'Content Bottom Block', 'molla-core' ); ?></label>
		<input type="text" name="content_bottom_block" id="content_bottom_block">
	</div>
	<?php
}

// Add Meta fields when edit taxonomy
add_action( 'product_cat_edit_form_fields', 'molla_edit_product_cat_meta_fields', 100, 2 );
function molla_edit_product_cat_meta_fields( $tag, $taxonomy ) {
	if ( 'product_cat' !== $taxonomy ) {
		return;
	}
	?>
		<tr class="form-field">
			<th scope="row"><label for="cat_icon_class"><?php esc_html_e( 'Category Icon Class', 'molla-core' ); ?></label></th>
			<td>
				<input name="cat_icon_class" id="cat_icon_class" type="text" value="<?php echo ( get_term_meta( $tag->term_id, 'cat_icon_class', true ) ); ?>">
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="product_columns"><?php esc_html_e( 'Product Columns', 'molla-core' ); ?></label></th>
			<td>
				<select id="product_columns" name="product_columns">
					<option value="" <?php selected( get_term_meta( $tag->term_id, 'product_columns', true ), '', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<option value="<?php echo intval( $i ); ?>" <?php selected( get_term_meta( $tag->term_id, 'product_columns', true ), $i, true ); ?>><?php echo intval( $i ); ?></option>
				<?php endfor; ?>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="cat_header_width"><?php esc_html_e( 'Header Width', 'molla-core' ); ?></label></th>
			<td>
				<select id="cat_header_width" name="cat_header_width">
					<option value="<?php echo 'default'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_header_width', true ), 'default', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="<?php echo 'container'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_header_width', true ), 'container', true ); ?>><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
					<option value="<?php echo 'container-fluid'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_header_width', true ), 'container-fluid', true ); ?>><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="cat_page_width"><?php esc_html_e( 'Page Content Width', 'molla-core' ); ?></label></th>
			<td>
				<select id="cat_page_width" name="cat_page_width">
					<option value="<?php echo 'default'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_page_width', true ), 'default', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="<?php echo 'container'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_page_width', true ), 'container', true ); ?>><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
					<option value="<?php echo 'container-fluid'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_page_width', true ), 'container-fluid', true ); ?>><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
					<option value="<?php echo ''; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_page_width', true ), '', true ); ?>><?php esc_html_e( 'Full', 'molla-core' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="cat_footer_width"><?php esc_html_e( 'Footer Width', 'molla-core' ); ?></label></th>
			<td>
				<select id="cat_footer_width" name="cat_footer_width">
					<option value="<?php echo 'default'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_footer_width', true ), 'default', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="<?php echo 'container'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_footer_width', true ), 'container', true ); ?>><?php esc_html_e( 'Container', 'molla-core' ); ?></option>
					<option value="<?php echo 'container-fluid'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_footer_width', true ), 'container-fluid', true ); ?>><?php esc_html_e( 'Container-Fluid', 'molla-core' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field form-sidebar-op">
			<th scope="row"><label for="cat_sidebar"><?php esc_html_e( 'Sidebar Option', 'molla-core' ); ?></label></th>
			<td>
				<select id="cat_sidebar" name="cat_sidebar">
					<option value="<?php echo 'default'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar', true ), 'default', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="<?php echo ''; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar', true ), '', true ); ?>><?php esc_html_e( 'Sticky Sidebar', 'molla-core' ); ?></option>
					<option value="<?php echo 'filter-sidebar'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar', true ), 'filter-sidebar', true ); ?>><?php esc_html_e( 'Toggle Sidebar', 'molla-core' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="cat_sidebar_pos"><?php esc_html_e( 'Sidebar Position', 'molla-core' ); ?></label></th>
			<td>
				<select id="cat_sidebar_pos" name="cat_sidebar_pos">
					<option value="<?php echo 'default'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar_pos', true ), 'default', true ); ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="<?php echo 'left'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar_pos', true ), 'left', true ); ?>><?php esc_html_e( 'Left', 'molla-core' ); ?></option>
					<option value="<?php echo 'right'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar_pos', true ), 'right', true ); ?>><?php esc_html_e( 'Right', 'molla-core' ); ?></option>
					<option value="<?php echo 'top'; ?>" <?php selected( get_term_meta( $tag->term_id, 'cat_sidebar_pos', true ), 'top', true ); ?>><?php esc_html_e( 'Top', 'molla-core' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="content_top_block"><?php esc_html_e( 'Content Top Block', 'molla-core' ); ?></label></th>
			<td>
				<input name="content_top_block" id="content_top_block" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'content_top_block', true ) ); ?>">
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="content_inner_top_block"><?php esc_html_e( 'Content Inner Top Block', 'molla-core' ); ?></label></th>
			<td>
				<input name="content_inner_top_block" id="content_inner_top_block" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'content_inner_top_block', true ) ); ?>">
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="content_inner_bottom_block"><?php esc_html_e( 'Content Inner Bottom Block', 'molla-core' ); ?></label></th>
			<td>
				<input name="content_inner_bottom_block" id="content_inner_bottom_block" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'content_inner_bottom_block', true ) ); ?>">
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="content_bottom_block"><?php esc_html_e( 'Content Bottom Block', 'molla-core' ); ?></label></th>
			<td>
				<input name="content_bottom_block" id="content_bottom_block" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'content_bottom_block', true ) ); ?>">
			</td>
		</tr>
	<?php
}

// Save Meta Values
add_action( 'created_term', 'molla_save_product_cat_meta_values', 10, 3 );
add_action( 'edit_term', 'molla_save_product_cat_meta_values', 100, 3 );
function molla_save_product_cat_meta_values( $term_id, $tt_id, $taxonomy ) {
	if ( 'product_cat' !== $taxonomy ) {
		return;
	}

	$fields = array(
		'cat_icon_class',
		'product_columns',
		'cat_header_width',
		'cat_page_width',
		'cat_footer_width',
		'cat_sidebar',
		'cat_sidebar_pos',
		'content_top_block',
		'content_inner_top_block',
		'content_inner_bottom_block',
		'content_bottom_block',
	);

	foreach ( $fields as $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			if ( 'product_columns' == $field ) {
				$val = intval( $_POST[ $field ] );
			} elseif ( 'cat_icon_class' == $field ) {
				$val = sanitize_html_class( $_POST[ $field ] );
			} else {
				$val = sanitize_title( $_POST[ $field ] );
			}
			update_term_meta( $term_id, $field, $val );
		} else {
			delete_term_meta( $term_id, $field );
		}
	}
}

// Delete Meta Values
add_action( 'delete_term', 'molla_delete_product_cat_meta_values', 10, 5 );
function molla_delete_product_cat_meta_values( $term_id, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
	if ( 'product_cat' !== $taxonomy ) {
		return;
	}

	$fields = array(
		'cat_icon_class',
		'product_columns',
		'cat_header_width',
		'cat_page_width',
		'cat_footer_width',
		'cat_sidebar',
		'cat_sidebar_pos',
		'content_top_block',
		'content_inner_top_block',
		'content_inner_bottom_block',
		'content_bottom_block',
	);
	foreach ( $fields as $field ) {
		delete_term_meta( $term_id, $field );
	}
}
