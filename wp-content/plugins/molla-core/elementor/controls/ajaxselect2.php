<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor select2 control.
 *
 * @since 1.2
 */
class Control_Ajax_Select2 extends \Elementor\Base_Data_Control {

	/**
	 * Get select2 control type.
	 */
	public function get_type() {
		return 'ajaxselect2';
	}

	/**
	 * Get select2 control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options'        => [],
			'select2options' => [],
			'multiple'       => false,
		];
	}

	/**
	 * Enqueue ontrol scripts and styles.
	 */
	public function enqueue() {
		wp_register_script( 'ajaxselect2-editor', MOLLA_CORE_JS . '/ajaxselect2-editor.min.js' );
		wp_enqueue_script( 'ajaxselect2-editor' );
	}


	/**
	 * Render select2 control output in the editor.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		$restAPi     = get_site_url( '' ) . '/wp-json/ajaxselect2/v1';
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select 
					id="<?php echo esc_attr( $control_uid ); ?>"
					class="elementor-ajaxselect2" 
					type="ajaxselect2" {{ multiple }} 
					data-setting="{{ data.name }}"
					data-ajax-url="<?php echo esc_url( $restAPi ) . '/{{data.options}}/'; ?>""
				>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
