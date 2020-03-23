<?php

/**
 * Plugin Name: Fetchwitter for WordPress
 * Plugin URI: http://github.com/jabranr/fetchwitter-wordpress-plugin
 * Description: Get Tweets from Twitter API v1.1 for a user timeline, for a hashtag or for any search query. To use, active the plugin and in plugin settings page, enter API Key and API Secret by creating an app at <a href="https://apps.twitter.com" target="_blank">Twitter Apps</a>. This plugin extends functionality of <a href="http://j.mp/fetchwitter" target="_blank">Fetchwitter PHP Class</a> for WordPress.
 * Version: 1.0.0
 * Author: Jabran Rafique
 * Author URI: https://jabran.me?utm_source=fetchwitter-wordpress-plugin
 * License: MIT License

 Copyright (c) 2014 Jabran Rafique

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
  */

// Define the default constants
define('JR_FW_DIR', plugin_dir_path(__FILE__));
define('JR_FW_INC_DIR', JR_FW_DIR . 'inc');
define('JR_FW_LIB_DIR', JR_FW_DIR . 'lib');
define('JR_FW_OPTIONS', 'jr_fetchwitter_plugin_options');

// Include common settings
require_once( 'settings.php' );

// Include required plugin files
require_once( JR_FW_INC_DIR . '/Fetchwitter.php' );
require_once( JR_FW_INC_DIR . '/Fetchwitter_Widget.php' );

// Register hooks for activation and deactivation
register_activation_hook( __FILE__, 'activate_fetchwitter_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_fetchwitter_plugin' );

// Load plugin setup and defaults
add_action('plugins_loaded', 'jr_fetchwitter_setup', 100);
add_action('widgets_init', 'register_jr_fetchwitter_widget');
add_filter('plugin_action_links_'. plugin_basename(__FILE__), 'jr_fetchwitter_settings_link', 100, 3);

/**
 * Add settings link
 */
function jr_fetchwitter_settings_link( $links ) {
    $links[] = sprintf('<a href="%s">%s</a>', admin_url('widgets.php'), __('Widget'));
    $links[] = sprintf('<a href="%s">%s</a>', admin_url('plugins.php?page=fetchwitter-for-wordpress'), __('Settings'));
	return $links;
}
