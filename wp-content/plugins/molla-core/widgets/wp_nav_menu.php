<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Molla Navigation Menu definition
 */
class Molla_Nav_Menu_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'description'                 => esc_html__( 'Add a navigation menu to page.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'nav-menu-widget', esc_html__( 'Molla - Navigation Menu', 'molla-core' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		// Get menu.
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$vertical = ! empty( $instance['nav_menu_vertical'] ) ? $instance['nav_menu_vertical'] : false;
		$skin     = ! empty( $instance['nav_menu_skin'] ) ? $instance['nav_menu_skin'] : '0';

		$menu_class = 'menu';
		if ( $skin ) {
			$menu_class .= ' menu-skin' . $skin;
		}
		if ( $vertical ) {
			$menu_class .= ' menu-vertical';
		}
		if ( defined( 'MOLLA_VERSION' ) ) {
			$menu_class .= ( molla_option( 'skin' . $skin . '_menu_arrow' ) ? ' sf-arrows' : '' ) . ( molla_option( $skin . '_menu_divider' ) ? ' sf-dividers' : '' ) . esc_attr( ' ' . molla_option( $skin . '_menu_effect' ) );

			if ( molla_option( 'lazy_load_menu' ) ) {
				$menu_class .= ' lazy-menu';
			}
		}

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu,
			'menu_class'  => $menu_class,
		);

		wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

		echo $args['after_widget'];
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}
		if ( ! empty( $new_instance['nav_menu_skin'] ) ) {
			$instance['nav_menu_skin'] = $new_instance['nav_menu_skin'];
		}
		if ( ! empty( $new_instance['nav_menu_vertical'] ) ) {
			$instance['nav_menu_vertical'] = $new_instance['nav_menu_vertical'];
		}
		return $instance;
	}


	public function form( $instance ) {
		global $wp_customize;
		$title             = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu          = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$nav_menu_skin     = isset( $instance['nav_menu_skin'] ) ? $instance['nav_menu_skin'] : '0';
		$nav_menu_vertical = isset( $instance['nav_menu_vertical'] ) ? $instance['nav_menu_vertical'] : false;

		// Get menus.
		$menus = wp_get_nav_menus();

		$empty_menus_style     = '';
		$not_empty_menus_style = '';
		if ( empty( $menus ) ) {
			$empty_menus_style = ' style="display:none" ';
		} else {
			$not_empty_menus_style = ' style="display:none" ';
		}

		$nav_menu_style = '';
		if ( ! $nav_menu ) {
			$nav_menu_style = 'display: none;';
		}

		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php echo $not_empty_menus_style; ?>>
			<?php
			if ( $wp_customize instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}

			/* translators: %s: URL to create a new menu. */
			printf( esc_html__( 'No menus have been created yet', 'molla-core' ) . '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Create some', 'molla-core' ) . '</a>.' );
			?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php echo $empty_menus_style; ?>>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
					<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_menu_skin' ); ?>"><?php _e( 'Select Menu Skin:' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'nav_menu_skin' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu_skin' ); ?>">
					<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
						<option value="1" <?php selected( $nav_menu_skin, '1' ); ?>>
							<?php esc_html_e( 'Skin 1', 'molla-core' ); ?>
						</option>
						<option value="2" <?php selected( $nav_menu_skin, '2' ); ?>>
							<?php esc_html_e( 'Skin 2', 'molla-core' ); ?>
						</option>
						<option value="3" <?php selected( $nav_menu_skin, '3' ); ?>>
							<?php esc_html_e( 'Skin 3', 'molla-core' ); ?>
						</option>
				</select>
			</p>
			<p>
				<label><input type="checkbox" id="<?php echo $this->get_field_id( 'nav_menu_vertical' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu_vertical' ); ?>"<?php echo ! $nav_menu_vertical ? '' : ' checked'; ?>><?php esc_html_e( 'Show as vertical menu', 'molla-core' ); ?></label>
			</p>
			<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
				<p class="edit-selected-nav-menu" style="<?php echo $nav_menu_style; ?>">
					<button type="button" class="button"><?php esc_html_e( 'Edit Menu', 'molla-core' ); ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
