<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Molla Header Responsive Group Widget Render
 *
 * @since 1.2
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'item_list'    => array(),
			'mobile_label' => esc_html__( 'Links', 'molla-core' ),
		),
		$atts
	)
);
?>
<ul class="nav top-menu sf-arrows">
	<li class="top-link">
		<a href="#"><?php echo ! $mobile_label ? esc_html__( 'Links', 'molla-core' ) : $mobile_label; ?></a>
		<ul class="nav nav-dropdown">
			<?php
			foreach ( $item_list as $key => $item ) {

				$class = array();

				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							// Global Options
							'_id'                 => '',
							'item_type'           => '',
							'item_aclass'         => '',
							// Menu Options
							'menu'                => '',
							// Log In Form
							'show_register_label' => 'yes',
							'login_label'         => esc_html__( 'Log In', 'molla-core' ),
							'delimiter'           => ' / ',
							'register_label'      => esc_html__( 'Register', 'molla-core' ),
							'logout_label'        => esc_html__( 'Log Out', 'molla-core' ),
							'account_icon'        => '',
							// Wishlist
							'wishlist_label'      => esc_html__( 'Wishlist', 'molla-core' ),
							'wishlist_icon'       => '',
							// Custom Html
							'html'                => '',
						),
						$item
					)
				);

				$class[] = 'elementor-repeater-item-' . $_id;

				if ( 'menu' == $item_type ) {
					if ( $menu ) {
						wp_nav_menu(
							array(
								'menu'   => $menu,
								'target' => 'top_nav',
								'depth'  => 2,
								'walker' => new Molla_Custom_Nav_Walker(),
							)
						);
					}
				} elseif ( 'login_form' == $item_type ) {
					if ( ! function_exists( 'molla_get_template_part' ) ) {
						continue;
					}
					molla_get_template_part(
						'template-parts/header/elements/login',
						'form',
						array(
							'log_in_label'        => $login_label ? $login_label : esc_html__( 'Log In', 'molla-core' ),
							'register_label'      => $register_label ? $register_label : esc_html__( 'Register', 'molla-core' ),
							'log_out_label'       => $logout_label ? $logout_label : esc_html__( 'Log Out', 'molla-core' ),
							'log_icon_class'      => isset( $account_icon['value'] ) ? $account_icon['value'] : '',
							'show_register_label' => 'yes' == $show_register_label,
							'custom_class'        => $item_aclass . ( $item_aclass ? ' ' : '' ) . 'elementor-repeater-item-' . $_id,
							'tag'                 => 'li',
						)
					);
				} elseif ( 'wishlist' == $item_type ) {
					if ( ! function_exists( 'molla_get_template_part' ) ) {
						continue;
					}
					molla_get_template_part(
						'template-parts/header/elements/inline',
						'wishlist',
						array(
							'label'          => $wishlist_label ? $wishlist_label : esc_html__( 'Wishlist', 'molla-core' ),
							'wishlist_class' => isset( $wishlist_icon['value'] ) ? $wishlist_icon['value'] : '',
							'custom_class'   => $item_aclass . ( $item_aclass ? ' ' : '' ) . 'elementor-repeater-item-' . $_id,
						)
					);
				} elseif ( 'currency_switcher' == $item_type ) {
					if ( ! function_exists( 'molla_get_template_part' ) ) {
						continue;
					}
					molla_get_template_part(
						'template-parts/header/elements/currency_switcher',
						null,
						array(
							'custom_class' => $item_aclass . ( $item_aclass ? ' ' : '' ) . 'elementor-repeater-item-' . $_id,
						)
					);
				} elseif ( 'lang_switcher' == $item_type ) {
					if ( ! function_exists( 'molla_get_template_part' ) ) {
						continue;
					}
					molla_get_template_part(
						'template-parts/header/elements/lang_switcher',
						null,
						array(
							'custom_class' => $item_aclass . ( $item_aclass ? ' ' : '' ) . 'elementor-repeater-item-' . $_id,
						)
					);
				} elseif ( 'html' == $item_type ) {
					echo do_shortcode( $html );
				}
			}
			?>
		</ul>
	</li>
</ul>

<?php
