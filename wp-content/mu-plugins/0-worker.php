<?php

/*
Plugin Name: ManageWP - Worker Loader
Plugin URI: https://managewp.com
Description: This is automatically generated by the ManageWP Worker plugin to increase performance and reliability. It is automatically disabled when disabling the main plugin.
Author: GoDaddy
Version: 1.0.0
Author URI: https://godaddy.com
License: GPL2
Network: true
*/

if (!function_exists('untrailingslashit') || !defined('WP_PLUGIN_DIR')) {
    // WordPress is probably not bootstrapped.
    exit;
}

if (file_exists(untrailingslashit(WP_PLUGIN_DIR).'/worker/init.php')) {
    if (in_array('worker/init.php', (array) get_option('active_plugins')) ||
        (function_exists('get_site_option') && array_key_exists('worker/init.php', (array) get_site_option('active_sitewide_plugins')))) {
        $GLOBALS['mwp_is_mu'] = true;
        include_once untrailingslashit(WP_PLUGIN_DIR).'/worker/init.php';
    }
}
