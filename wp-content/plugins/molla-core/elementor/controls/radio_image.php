<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor radio-image control.
 *
 * @since 1.0
 */
class Control_Radio_Image extends \Elementor\Base_Data_Control {

	/**
	 * Get radio-image control type.
	 */
	public function get_type() {
		return 'radio_image';
	}

	/**
	 * Render radio-image control output in the editor.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid( '{{value}}' );
		?>
		<div class="elementor-control-field elementor-radio-image-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-choices elementor-radio-image-choices">
					<#
					_.each( data.options, function( options, value ) { 
						let width = options.width;
						if ( width ) {
							width = 'w-' + width;
						}
						#>
					<div class="elementor-radio-image-choice {{ width }}">
						<input id="<?php echo $control_uid; ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}" data-setting="{{ data.name }}">
						<label class="elementor-choices-label tooltip-target" for="<?php echo $control_uid; ?>" data-tooltip="{{ options.title }}" title="{{ options.title }}">
							<img src="{{ options.image }}">
							<span class="elementor-screen-only">{{{ options.title }}}</span>
						</label>
					</div>
						<#
						}
					);
					#>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Get choose control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options' => [],
			'toggle'  => true,
		];
	}
}
