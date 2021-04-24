<?php

if ( function_exists( 'molla_option' ) ) :

	include MOLLA_LIB . '/functions/dynamic_css/parts/color.php';
	include MOLLA_LIB . '/functions/dynamic_css/parts/layout.php';

	$gutter    = molla_option( 'grid_gutter_width' );
	$width     = molla_option( 'container_width' );
	$base_font = molla_option( 'font_base' );
	$primary   = molla_option( 'primary_color' );
	$second    = molla_option( 'primary_color' );
	?>

	.wp-block[data-align="wide"] {
		width: <?php echo $width ? $width : '1200px'; ?>;
		max-width: 100%;
		padding-left: <?php echo intval( $gutter ) / 2; ?>px;
		padding-right: <?php echo intval( $gutter ) / 2; ?>px;
	}
	.wp-block .wp-block {
		max-width: 610px;
	}

	.block-editor-block-list__layout {
		font-family: '<?php echo esc_attr( $base_font['font-family'] ); ?>';
		font-weight: <?php echo esc_attr( 'regular' == $base_font['variant'] ? 400 : $base_font['variant'] ); ?>;
		line-height: <?php echo esc_attr( $base_font['line-height'] ); ?>;
		letter-spacing: <?php echo esc_attr( $base_font['letter-spacing'] ); ?>;
		color: <?php echo esc_attr( $base_font['color'] ); ?>;
		text-transform: <?php echo esc_attr( $base_font['text-transform'] ); ?>;
	}

	.wp-block-columns>.block-editor-inner-blocks>.block-editor-block-list__layout,
	.owl-carousel .block-editor-block-list__layout,
	.product-list,
	.blocks-gallery-grid.blocks-gallery-grid {
		margin-left: -<?php echo intval( $gutter ) / 2; ?>px;
		margin-right: -<?php echo intval( $gutter ) / 2; ?>px;
	}
	.wp-block-columns>.block-editor-inner-blocks>.block-editor-block-list__layout>[data-type="core/column"],
	.product-list > * {
		padding-left: <?php echo intval( $gutter ) / 2; ?>px;
		padding-right: <?php echo intval( $gutter ) / 2; ?>px;
	}
	.wp-block-gallery .blocks-gallery-item {
		padding: <?php echo intval( $gutter ) / 2; ?>px;
	}
	.icon-box.icon-box-bordered:before {
		right: -<?php echo intval( $gutter ) / 2; ?>px;
	}
	.btn {
		background-color: <?php echo esc_attr( $primary ); ?>;
		border: 1px solid <?php echo esc_attr( $primary ); ?>;
	}
	.btn-outline,
	.btn-outline:hover,
	.btn-outline:focus,
	.btn-link {
		color: <?php echo esc_attr( $primary ); ?>;
	}
	.btn-link:hover,
	.btn-link:focus {
		color: <?php echo esc_attr( $primary ); ?>;
		border-color: <?php echo esc_attr( $primary ); ?>;
	}
	.blocks-gallery-grid .blocks-gallery-image figcaption,
	.blocks-gallery-grid .blocks-gallery-item figcaption,
	.wp-block-gallery .blocks-gallery-image figcaption,
	.wp-block-gallery .blocks-gallery-item figcaption {
		left: <?php echo intval( $gutter ) / 2; ?>px;
		right: <?php echo intval( $gutter ) / 2; ?>px;
		bottom: <?php echo intval( $gutter ) / 2; ?>px;
	}

	<?php
	$base_font     = molla_option( 'font_base' );
	$heading_space = molla_option( 'font_heading_spacing' );
	$para_font     = molla_option( 'font_paragraph' );
	$para_space    = molla_option( 'font_paragraph_spacing' );
	$nav_font      = molla_option( 'font_nav' );
	$nav_space     = molla_option( 'font_nav_spacing' );
	$placeholder   = molla_option( 'font_placeholder' );

	$heading_font = [];
	for ( $i = 0; $i < 6; $i ++ ) {
		$heading_font[ $i ] = molla_option( 'font_heading_h' . ( $i + 1 ) );
	}
	?>
	<?php for ( $i = 0; $i < 6; $i ++ ) : ?>
	.editor-styles-wrapper h<?php echo intval( $i + 1 ); ?> {
		font-family: '<?php echo esc_attr( $heading_font[ $i ]['font-family'] ); ?>';
		font-weight: <?php echo esc_attr( 'regular' == $heading_font[ $i ]['variant'] ? 400 : $heading_font[ $i ]['variant'] ); ?>;
		font-size: <?php echo esc_attr( $heading_font[ $i ]['font-size'] ); ?>;
		line-height: <?php echo esc_attr( $heading_font[ $i ]['line-height'] ); ?>;
		letter-spacing: <?php echo esc_attr( $heading_font[ $i ]['letter-spacing'] ); ?>;
		color: <?php echo esc_attr( $heading_font[ $i ]['color'] ); ?>;
		text-transform: <?php echo esc_attr( $heading_font[ $i ]['text-transform'] ); ?>;
		margin: <?php echo esc_attr( '' == $heading_space['margin-top'] ? '0' : $heading_space['margin-top'] ) . ' ' . ( '' == $heading_space['margin-right'] ? '0' : $heading_space['margin-right'] ) . ' ' . ( '' == $heading_space['margin-bottom'] ? '1.4rem' : $heading_space['margin-bottom'] ) . ' ' . ( '' == $heading_space['margin-left'] ? '0' : $heading_space['margin-left'] ); ?>;
	}
	<?php endfor; ?>
	.editor-styles-wrapper .block-editor-block-list__layout p {
		font-family: '<?php echo esc_attr( $para_font['font-family'] ); ?>';
		font-weight: <?php echo esc_attr( 'regular' == $para_font['variant'] ? 400 : $para_font['variant'] ); ?>;
		font-size: <?php echo esc_attr( $para_font['font-size'] ); ?>;
		line-height: <?php echo esc_attr( $para_font['line-height'] ); ?>;
		letter-spacing: <?php echo esc_attr( $para_font['letter-spacing'] ); ?>;
		color: <?php echo esc_attr( $para_font['color'] ); ?>;
		text-transform: <?php echo esc_attr( $para_font['text-transform'] ); ?>;
		margin: <?php echo esc_attr( '' == $para_space['margin-top'] ? '0' : $para_space['margin-top'] ) . ' ' . ( '' == $para_space['margin-right'] ? '0' : $para_space['margin-right'] ) . ' ' . ( '' == $para_space['margin-bottom'] ? '1.5rem' : $para_space['margin-bottom'] ) . ' ' . ( '' == $para_space['margin-left'] ? '0' : $para_space['margin-left'] ); ?>;
	}
	<?php
endif;
?>
