<?php

/**
 * Functions document
 *
 * @author: hello@jabran.me
 * @package: Fetchwitter for WordPress
 *
 */

if (!defined('JR_FW_DIR')) exit;


/**
 * Activates the Fetchwitter plugin
 */

if ( ! function_exists('activate_fetchwitter_plugin') ) {
	function activate_fetchwitter_plugin() {
		if ( version_compare(get_bloginfo('version'), '3.0', '<') ) {
			deactivate_fetchwitter_plugin( basename(__FILE__) );
		}
		else {
			// Update plugin options
			update_option( JR_FW_OPTIONS, get_jr_fetchwitter_plugin_options() );
		}
	}
}


/**
 * Deactivates the Fetchwitter plugin
 */

if ( ! function_exists('deactivate_fetchwitter_plugin') ) {
	function deactivate_fetchwitter_plugin() {
		// No function to trigger on deactivation
		// delete_option( JR_FW_OPTIONS );
	}
}


/**
 * Setup plugin options
 * @return Array - returns array of options
 */

if ( ! function_exists('get_jr_fetchwitter_plugin_options') ) {
	function get_jr_fetchwitter_plugin_options() {
		return array(
			'jr_fetchwitter_api_key' => '',
			'jr_fetchwitter_api_secret' => '',
			'jr_fetchwitter_api_access_key' => ''
		);
	}
}


/**
 * Setup plugin defaults
 */

if ( ! function_exists('jr_fetchwitter_setup') ) {
	function jr_fetchwitter_setup() {

		// Setup settings panel in dashboard
		add_action('admin_menu', 'jr_fetchwitter_admin_setup');

		// Setup the widget
		add_action( 'widgets_init', 'register_jr_fetchwitter_widget' );
	}
}


/**
 * Dashboard settings page init
 */

if ( ! function_exists('jr_fetchwitter_admin_setup') ) {
	function jr_fetchwitter_admin_setup() {
		add_plugins_page('Fetchwitter', 'Fetchwitter', 'manage_options', 'fetchwitter-for-wordpress', 'fetchwitter_setting_page');
	}
}


/**
 * Dashboard settings page setup
 */

if ( ! function_exists('fetchwitter_setting_page') ) {
	function fetchwitter_setting_page() {
		include( JR_FW_INC_DIR . '/settings-page.php');
	}
}


/**
 * Widget setup
 */

if ( ! function_exists('register_jr_fetchwitter_widget') ) {
	function register_jr_fetchwitter_widget() {
		register_widget('Fetchwitter_Widget');
	}
}


/**
 * Widget setup form
 */

if ( ! function_exists('jr_fetchwitter_widget_form') ) {
	function jr_fetchwitter_widget_form( $info, $instance ) {

		if ( $instance && is_array($info) ) :
			ob_start();

		?>
			<p>
				<label for="<?php echo $instance->get_field_id('title'); ?>">Title:</label>
				<input type="text" class="widefat" name="<?php echo $instance->get_field_name('title'); ?>" id="<?php echo $instance->get_field_id('title'); ?>" value="<?php echo esc_attr($info['title']); ?>">
			</p>
			<p>
				<label for="<?php echo $instance->get_field_id('username'); ?>">Username:</label>
				<input type="text" class="widefat" name="<?php echo $instance->get_field_name('username'); ?>" id="<?php echo $instance->get_field_id('username'); ?>" value="<?php echo esc_attr($info['username']); ?>">
			</p>
			<p>
				<label for="<?php echo $instance->get_field_id('tweets'); ?>">Number of Tweets to show:</label>
				<input type="text" name="<?php echo $instance->get_field_name('tweets'); ?>" id="<?php echo $instance->get_field_id('tweets'); ?>" value="<?php echo esc_attr($info['tweets']); ?>" size="3">
			</p>

			<p>
				<input type="checkbox" class="checkbox" name="<?php echo $instance->get_field_name('formatted_tweet'); ?>" id="<?php echo $instance->get_field_id('formatted_tweet'); ?>" <?php checked($info['formatted_tweet'], 'on'); ?>>
				<label for="<?php echo $instance->get_field_id('formatted_tweet'); ?>">Formatted Tweets</label>
			</p>
		<?php

			$form = ob_get_clean();
		endif;

		echo $form;
	}
}
