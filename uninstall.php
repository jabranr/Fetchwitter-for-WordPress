<?php

/**
 * Uninstall document
 *
 * @author: hello@jabran.me
 * @package: Fetchwitter for WordPress
 *
 */

// Include common settings
require_once( 'settings.php' );

if ( !defined('WP_UNINSTALL_PLUGIN') ) exit();

delete_option( JR_FW_OPTIONS );