<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Molla Follow us widget
*/
class Molla_Follow_Us_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-follow-us',
			'description' => esc_html__( 'Add Social Links.', 'molla-core' ),
		);

		$control_ops = array( 'id_base' => 'follow-us-widget' );

		parent::__construct( 'follow-us-widget', esc_html__( 'Molla - Follow Us', 'molla-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title            = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$nofollow         = isset( $instance['nofollow'] ) ? $instance['nofollow'] : '';
		$follow_before    = isset( $instance['follow_before'] ) ? $instance['follow_before'] : '';
		$follow_after     = isset( $instance['follow_after'] ) ? $instance['follow_after'] : '';
		$social_icon_type = isset( $instance['social_icon_type'] ) ? $instance['social_icon_type'] : '';
		$social_icon_size = isset( $instance['social_icon_size'] ) ? $instance['social_icon_size'] : 'small';
		$atts             = array(
			'facebook'    => isset( $instance['facebook'] ) ? $instance['facebook'] : '',
			'twitter'     => isset( $instance['twitter'] ) ? $instance['twitter'] : '',
			'rss'         => isset( $instance['rss'] ) ? $instance['rss'] : '',
			'pinterest'   => isset( $instance['pinterest'] ) ? $instance['pinterest'] : '',
			'youtube'     => isset( $instance['youtube'] ) ? $instance['youtube'] : '',
			'instagram'   => isset( $instance['instagram'] ) ? $instance['instagram'] : '',
			'skype'       => isset( $instance['skype'] ) ? $instance['skype'] : '',
			'linkedin'    => isset( $instance['linkedin'] ) ? $instance['linkedin'] : '',
			'google-plus' => isset( $instance['googleplus'] ) ? $instance['googleplus'] : '',
			'vk'          => isset( $instance['vk'] ) ? $instance['vk'] : '',
			'xing'        => isset( $instance['xing'] ) ? $instance['xing'] : '',
			'tumblr'      => isset( $instance['tumblr'] ) ? $instance['tumblr'] : '',
			'reddit'      => isset( $instance['reddit'] ) ? $instance['reddit'] : '',
			'vimeo'       => isset( $instance['vimeo'] ) ? $instance['vimeo'] : '',
			'telegram'    => isset( $instance['telegram'] ) ? $instance['telegram'] : '',
			'yelp'        => isset( $instance['yelp'] ) ? $instance['yelp'] : '',
			'flickr'      => isset( $instance['flickr'] ) ? $instance['flickr'] : '',
			'whatsapp'    => isset( $instance['whatsapp'] ) ? $instance['whatsapp'] : '',
		);
		if ( defined( 'MOLLA_DIR' ) ) {
			include MOLLA_DIR . '/template-parts/header/elements/social.php';
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']            = strip_tags( $new_instance['title'] );
		$instance['nofollow']         = $new_instance['nofollow'];
		$instance['follow_before']    = $new_instance['follow_before'];
		$instance['facebook']         = $new_instance['facebook'];
		$instance['twitter']          = $new_instance['twitter'];
		$instance['rss']              = $new_instance['rss'];
		$instance['pinterest']        = $new_instance['pinterest'];
		$instance['youtube']          = $new_instance['youtube'];
		$instance['instagram']        = $new_instance['instagram'];
		$instance['skype']            = $new_instance['skype'];
		$instance['linkedin']         = $new_instance['linkedin'];
		$instance['googleplus']       = $new_instance['googleplus'];
		$instance['vk']               = $new_instance['vk'];
		$instance['xing']             = $new_instance['xing'];
		$instance['tumblr']           = $new_instance['tumblr'];
		$instance['reddit']           = $new_instance['reddit'];
		$instance['vimeo']            = $new_instance['vimeo'];
		$instance['telegram']         = $new_instance['telegram'];
		$instance['yelp']             = $new_instance['yelp'];
		$instance['flickr']           = $new_instance['flickr'];
		$instance['whatsapp']         = $new_instance['whatsapp'];
		$instance['follow_after']     = $new_instance['follow_after'];
		$instance['social_icon_type'] = $new_instance['social_icon_type'];
		$instance['social_icon_size'] = $new_instance['social_icon_size'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'            => esc_html__( 'Follow Us', 'molla-core' ),
			'nofollow'         => '',
			'follow_before'    => '',
			'facebook'         => '',
			'twitter'          => '',
			'rss'              => '',
			'pinterest'        => '',
			'youtube'          => '',
			'instagram'        => '',
			'skype'            => '',
			'linkedin'         => '',
			'googleplus'       => '',
			'vk'               => '',
			'xing'             => '',
			'tumblr'           => '',
			'reddit'           => '',
			'vimeo'            => '',
			'telegram'         => '',
			'yelp'             => '',
			'flickr'           => '',
			'whatsapp'         => '',
			'follow_after'     => '',
			'social_icon_type' => '',
			'social_icon_size' => 'small',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nofollow' ) ); ?>" <?php checked( $instance['nofollow'], 'on' ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>"><?php esc_html_e( 'Add rel="nofollow" to links', 'molla-core' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'follow_before' ) ); ?>">
				<strong><?php esc_html_e( 'Before Content', 'molla-core' ); ?>:</strong>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'follow_before' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'follow_before' ) ); ?>" ><?php echo isset( $instance['follow_before'] ) ? esc_attr( $instance['follow_before'] ) : ''; ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">
				<strong><?php esc_html_e( 'Facebook', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" value="<?php echo isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">
				<strong><?php esc_html_e( 'Twitter', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" value="<?php echo isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>">
				<strong><?php esc_html_e( 'Rss', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" value="<?php echo isset( $instance['rss'] ) ? esc_attr( $instance['rss'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>">
				<strong><?php esc_html_e( 'Pinterest', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" value="<?php echo isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>">
				<strong><?php esc_html_e( 'Youtube', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" value="<?php echo isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">
				<strong><?php esc_html_e( 'Instagram', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" value="<?php echo isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'skype' ) ); ?>">
				<strong><?php esc_html_e( 'Skype', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'skype' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'skype' ) ); ?>" value="<?php echo isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>">
				<strong><?php esc_html_e( 'Linkedin', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" value="<?php echo isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>">
				<strong><?php esc_html_e( 'Googleplus', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus' ) ); ?>" value="<?php echo isset( $instance['googleplus'] ) ? esc_attr( $instance['googleplus'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>">
				<strong><?php esc_html_e( 'Vk', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vk' ) ); ?>" value="<?php echo isset( $instance['vk'] ) ? esc_attr( $instance['vk'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'xing' ) ); ?>">
				<strong><?php esc_html_e( 'Xing', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'xing' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'xing' ) ); ?>" value="<?php echo isset( $instance['xing'] ) ? esc_attr( $instance['xing'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>">
				<strong><?php esc_html_e( 'Tumblr', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>" value="<?php echo isset( $instance['tumblr'] ) ? esc_attr( $instance['tumblr'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'reddit' ) ); ?>">
				<strong><?php esc_html_e( 'Reddit', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'reddit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'reddit' ) ); ?>" value="<?php echo isset( $instance['reddit'] ) ? esc_attr( $instance['reddit'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>">
				<strong><?php esc_html_e( 'Vimeo', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vimeo' ) ); ?>" value="<?php echo isset( $instance['vimeo'] ) ? esc_attr( $instance['vimeo'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'telegram' ) ); ?>">
				<strong><?php esc_html_e( 'Telegram', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'telegram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'telegram' ) ); ?>" value="<?php echo isset( $instance['telegram'] ) ? esc_attr( $instance['telegram'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'yelp' ) ); ?>">
				<strong><?php esc_html_e( 'Yelp', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'yelp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'yelp' ) ); ?>" value="<?php echo isset( $instance['yelp'] ) ? esc_attr( $instance['yelp'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>">
				<strong><?php esc_html_e( 'Flickr', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr' ) ); ?>" value="<?php echo isset( $instance['flickr'] ) ? esc_attr( $instance['flickr'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'whatsapp' ) ); ?>">
				<strong><?php esc_html_e( 'Whatsapp', 'molla-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'whatsapp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'whatsapp' ) ); ?>" value="<?php echo isset( $instance['whatsapp'] ) ? esc_attr( $instance['whatsapp'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'follow_after' ) ); ?>">
				<strong><?php esc_html_e( 'After Content', 'molla-core' ); ?>:</strong>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'follow_after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'follow_after' ) ); ?>" ><?php echo isset( $instance['follow_after'] ) ? esc_attr( $instance['follow_after'] ) : ''; ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_icon_type' ) ); ?>">
				<strong><?php esc_html_e( 'Type', 'molla-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_icon_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_icon_type' ) ); ?>">
					<option value=""<?php echo isset( $instance['social_icon_type'] ) && ! $instance['social_icon_type'] ? ' selected' : ''; ?>><?php esc_html_e( 'Default', 'molla-core' ); ?></option>
					<option value="colored-simple"<?php echo isset( $instance['social_icon_type'] ) && 'colored-simple' == $instance['social_icon_type'] ? ' selected' : ''; ?>><?php esc_html_e( 'Colored', 'molla-core' ); ?></option>
					<option value="circle"<?php echo isset( $instance['social_icon_type'] ) && 'circle' == $instance['social_icon_type'] ? ' selected' : ''; ?>><?php esc_html_e( 'Circle', 'molla-core' ); ?></option>
					<option value="colored-circle"<?php echo isset( $instance['social_icon_type'] ) && 'colored-circle' == $instance['social_icon_type'] ? ' selected' : ''; ?>><?php esc_html_e( 'Circle Colored', 'molla-core' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_icon_size' ) ); ?>">
				<strong><?php esc_html_e( 'Size', 'molla-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_icon_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_icon_size' ) ); ?>">
					<option value=""<?php echo isset( $instance['social_icon_size'] ) && ! $instance['social_icon_size'] ? ' selected' : ''; ?>><?php esc_html_e( 'Large', 'molla-core' ); ?></option>
					<option value="small"<?php echo isset( $instance['social_icon_size'] ) && 'small' == $instance['social_icon_size'] ? ' selected' : ''; ?>><?php esc_html_e( 'Small', 'molla-core' ); ?></option>
				</select>
			</label>
		</p>
		<?php
	}
}
