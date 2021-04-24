<?php

extract(
	shortcode_atts(
		array(
			'lightbox_content'    => 'custom',
			'youtube_url'         => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
			'vimeo_url'           => 'https://vimeo.com/235215203',
			'lightbox_show'       => 'onload',
			'lightbox_timeout'    => 0,
			'selector'            => '',
			'lightbox_style'      => 'fadeIn',
			'content_type'        => 'html',
			'lightbox_block_name' => '',
			'html_content'        => '',
			'el_class'            => '',
		),
		$atts
	)
);

wp_enqueue_script( 'jquery-cookie' );

$html = '<div class="molla-lightbox-wrapper">';

if ( 'youtube' == $lightbox_content || 'vimeo' == $lightbox_content ) {
	$lightbox_id = $atts[ $modal_contain . '_url' ];
	$type        = 'iframe';
} else {
	$lightbox_id = 'molla-lightbox-' . molla_get_post_id_by_name( 'popup', $lightbox_block_name );
	$type        = 'inline';
}

if ( 'onload' == $lightbox_show && ( ! isset( $_COOKIE['molla_modal_disable_onload'] ) || ! $_COOKIE['molla_modal_disable_onload'] ) ) {
	$html .= '<div data-lightbox-id="' . esc_attr( $lightbox_id ) . '" data-type="' . $type . '" data-lightbox-animate="' . esc_attr( $lightbox_style ) . '" class="molla-lightbox-open molla-onload"' . ( $lightbox_timeout ? ' data-timeout="' . ( (float) $lightbox_timeout * 1000 ) . '"' : '' ) . '></div>';
} elseif ( 'selector' == $lightbox_show && $selector ) {
	$html .= '<script>
	(function($){
		$(document).ready(function(){
			var selector = "' . esc_js( $selector ) . '";
			$(selector).addClass("molla-lightbox-open");
			$(selector).attr("data-lightbox-id", "' . esc_js( $lightbox_id ) . '");
			$(selector).attr("data-type", "' . esc_js( $type ) . '");
			$(selector).attr("data-lightbox-animate", "' . esc_attr( $lightbox_style ) . '");
		});
	})(jQuery);
	</script>';
}

$html     .= '<div id="' . esc_attr( $lightbox_id ) . '" class="molla-lightbox-container mfp-hide mfp-fade' . ' ' . esc_attr( $el_class ) . '">';
	$html .= '<div class="molla-lightbox-content">';
if ( 'html' == $content_type ) {
	$html .= do_shortcode( $html_content );
} elseif ( $lightbox_block_name ) {
	$html .= do_shortcode( '[molla_block name="' . $lightbox_block_name . '" type="popup"]' );
}
	$html .= '</div>';
$html     .= '</div>';
$html     .= '</div>';

echo $html;
