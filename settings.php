<?php

/**
 * Default settings document
 *
 * @author: hello@jabran.me
 * @package: Fetchwitter for WordPress
 *
 */

// Plugin title, version
$jr_fetchwitter_version = '0.0.2';

// Define the default constants
define('JR_FW_DIR', plugin_dir_path(__FILE__));
define('JR_FW_INC_DIR', JR_FW_DIR . 'inc');
define('JR_FW_LIB_DIR', JR_FW_DIR . 'lib');
define('JR_FW_OPTIONS', 'jr_fetchwitter_plugin_options');

// Include plugin functions file
require_once( JR_FW_LIB_DIR . '/functions.php' );