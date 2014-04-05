<?php

/**
 * Widget class document
 *
 * @author: hello@jabran.me
 * @package: Fetchwitter for WordPress
 *
 */

class Fetchwitter_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct( 'jr_fetchwitter_widget', 'Fetchwitter Widget', array( 'description' => __('Fetch Tweets from a Twitter user timeline or by searching any term i.e. a hashtag.') ) );
	}

	public function widget( $args, $instance ) {

		if ( is_active_widget(false, false, 'jr_fetchwitter_widget', true) ) {

			$title = apply_filters( 'widget_title', $instance['title'] );
			
			echo $args['before_widget'];

			if ( ! empty($title) )
				echo $args['before_title'] . $title . $args['after_title'];

			$jr_fetchwitter_widget_options = get_option( JR_FW_OPTIONS );

			if ( $jr_fetchwitter_widget_options !== false ) {
			
				$config = array(
					'api_key' => $jr_fetchwitter_widget_options['jr_fetchwitter_api_key'],
					'api_secret' => $jr_fetchwitter_widget_options['jr_fetchwitter_api_secret'],
				);

				try {
					$fetchwitter = new Fetchwitter( $config );
					$fetchwitter->set_access_token($jr_fetchwitter_widget_options['jr_fetchwitter_api_access_key']);
				} catch (Exception $e) {
					// echo $e->getMessage();
				}

				if ( $fetchwitter ) {
					$tweets = $fetchwitter->get_by_user($instance['username'], absint($instance['tweets']));
					$tweets = json_decode($tweets);
					if ( $tweets ) {
						foreach ($tweets as $tweet) {
							echo '<ul>';
							if ( checked($instance['formatted_tweet'], 'on', false) )
								echo '<li>' . $fetchwitter->to_tweet($tweet->text) . '</li>';
							else
								echo '<li>' . $tweet->text . '</li>';
							echo '</ul>';
						}
					}
				}
			}

			if ( isset($instance['username']) && ! empty($instance['username']) )
				echo '<p class="jr-fetchwitter-footer"><small><a href="https://twitter.com/intent/follow?screen_name=' . $instance['username'] . '" target="_blank">Follow ' . $instance['username'] . '</small></a></p>';

			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$options = get_option( JR_FW_OPTIONS );
		if ( $options && 
			isset($options['jr_fetchwitter_api_key']) && $options['jr_fetchwitter_api_key'] &&
			isset($options['jr_fetchwitter_api_secret']) && $options['jr_fetchwitter_api_secret'] && 
			isset($options['jr_fetchwitter_api_access_key']) && $options['jr_fetchwitter_api_access_key'] ) {
			$info['title'] = isset($instance['title']) ? $instance['title'] : __('Tweets');
			$info['username'] = isset($instance['username']) ? $instance['username'] : __('jabranr');
			$info['tweets'] = isset($instance['tweets']) ? $instance['tweets'] : __('10');
			$info['formatted_tweet'] = $instance['formatted_tweet'];
			return jr_fetchwitter_widget_form( $info, $this );
		}
		else {
			echo '<p>Fetchwitter plugin settings are not configured properly. Go to <a href="' . admin_url() . 'options-general.php?page=fetchwitter-for-wordpress">Plugin Settings</a> and provide the required information.</p>';
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['username'] = (! empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '';
		$instance['tweets'] = (! empty($new_instance['tweets'])) ? strip_tags($new_instance['tweets']) : '';
		$instance['formatted_tweet'] = ( 'on' === $new_instance['formatted_tweet'] ) ? 'on' : 'off';
		return $instance;
	}
}