<?php

// Woocommerce actions
add_action(
	'init',
	function() {
		add_action( 'woocommerce_review_after_comment_text', 'molla_woocommerce_add_review_action' );
		/**
		 * Woocommerce share
		 */
		add_action( 'woocommerce_share', 'molla_print_share', 10, 4 );
	},
	8
);
if ( ! function_exists( 'molla_woocommerce_add_review_action' ) ) :
	/**
	 * Single product review actions
	 */
	function molla_woocommerce_add_review_action() {
		?>
		<div class="review-action">
			<button class="recommend like fade-out" data-id="<?php echo esc_attr( get_comment_ID() ); ?>"><i class="icon-thumbs-up"></i>Helpful (<span class="review-count"><?php echo molla_review_like_count( get_comment_ID() ); ?></span>)</button>
			<button class="recommend dislike fade-out" data-id="<?php echo esc_attr( get_comment_ID() ); ?>"><i class="icon-thumbs-down"></i>Unhelpful (<span class="review-count"><?php echo molla_review_dislike_count( get_comment_ID() ); ?></span>)</button>
		</div>
		<?php
	}
endif;

add_action( 'molla_print_share', 'molla_print_share', 10, 3 );
if ( ! function_exists( 'molla_print_share' ) ) :
	function molla_print_share( $label = '', $sticky = '', $size = '' ) {
		?>
		<div class="social-icons<?php echo esc_attr( ( $sticky ? ' social-icons-vertical' : '' ) ); ?>">
			<span class="social-label"><?php echo esc_html( $label ); ?></span>
			<?php
			$share_icon_type = molla_option( 'share_icon_type' );
			$share_icon_size = molla_option( 'share_icon_size' );

			?>
			<div class="social-icons<?php echo ( 'colored-simple' == $share_icon_type || ( 'colored-circle' ) == $share_icon_type ? ' social-icons-colored' : '' ) . ( 'circle' == $share_icon_type || ( 'colored-circle' ) == $share_icon_type ? ' circle-type' : '' ) . ( $share_icon_size ? ' social-icons-sm' : '' ); ?>">
				<?php
				$ary_social = molla_option( 'share_icons' );
				$title      = esc_attr( get_the_title() );

				$image     = wp_get_attachment_url( get_post_thumbnail_id() );
				$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );

				foreach ( $ary_social as $elem ) {
					if ( 'facebook' == $elem ) {
						echo '<a href="https://www.facebook.com/sharer.php?u=' . esc_url( $permalink ) . '" class="social-icon social-facebook" title="' . esc_attr( 'Facebook', 'molla-core' ) . '" target="_blank"><i class="icon-facebook-f"></i></a>';
					} elseif ( 'linkedin' == $elem ) {
						echo '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url( $permalink ) . '&amp;title=' . urlencode( $title ) . '" class="social-icon social-linkedin" title="' . esc_attr( 'Linkedin', 'molla-core' ) . '" target="_blank"><i class="icon-linkedin-in"></i></a>';
					} elseif ( 'twitter' == $elem ) {
						echo '<a href="https://twitter.com/intent/tweet?text=' . urlencode( $title ) . '&amp;url=' . esc_url( $permalink ) . '" class="social-icon social-twitter" title="' . esc_attr( 'Twitter', 'molla-core' ) . '" target="_blank"><i class="icon-twitter"></i></a>';
					} elseif ( 'email' == $elem ) {
						echo '<a href="mailto:?subject=' . urlencode( $title ) . '&amp;body=' . esc_url( $permalink ) . '" class="social-icon social-email" title="' . esc_attr( 'Email', 'molla-core' ) . '" target="_blank"><i class="icon-envelope"></i></a>';
					} elseif ( 'pinterest' == $elem ) {
						echo '<a href="https://pinterest.com/pin/create/button/?url=' . esc_url( $permalink ) . '&amp;media=' . esc_url( $image ) . '" class="social-icon social-pinterest" title="' . esc_attr( 'Pinterest', 'molla-core' ) . '" target="_blank"><i class="icon-pinterest-p"></i></a>';
					} elseif ( 'googleplus' == $elem ) {
						echo '<a href="https://plus.google.com/share?url=' . esc_url( $permalink ) . '" class="social-icon social-googleplus" title="' . esc_attr( 'Google +', 'molla-core' ) . '" target="_blank"><i class="icon-google-plus"></i></a>';
					} elseif ( 'vk' == $elem ) {
						echo '<a href="https://vk.com/share.php?url=' . esc_url( $permalink ) . '&amp;title=' . urlencode( $title ) . '&amp;image=' . esc_url( $image ) . '&amp;noparse=true" class="social-icon social-vk" title="' . esc_attr( 'VK', 'molla-core' ) . '" target="_blank"><i class="icon-vk"></i></a>';
					} elseif ( 'tumblr' == $elem ) {
						echo '<a href="http://www.tumblr.com/share/link?url=' . esc_url( $permalink ) . '&amp;name=' . urlencode( $title ) . '&amp;description=' . urlencode( get_the_excerpt() ) . '" class="social-icon social-tumblr" title="' . esc_attr( 'Tumblr', 'molla-core' ) . '" target="_blank"><i class="icon-tumblr"></i></a>';
					} elseif ( 'whatsapp' == $elem ) {
						echo '<a href="whatsapp://send?text=' . rawurlencode( $title ) . '-' . esc_url( $permalink ) . '" class="social-icon social-whatsapp" title="' . esc_attr( 'WhatsApp', 'molla-core' ) . '" target="_blank"><i class="icon-whatsapp"></i></a>';
					}
				}
				?>
			</div>
		</div>
		<?php
	}
endif;
