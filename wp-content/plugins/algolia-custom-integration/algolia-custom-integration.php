<?php

/**
 * Plugin Name:     Algolia Custom Integration
 * Description:     Add Algolia Search feature
 * Text Domain:     algolia-custom-integration
 * Version:         1.0.0
 *
 * @package         Algolia_Custom_Integration
 */

// Your code starts here.
// require_once __DIR__ . '/api-client/autoload.php';
// If you're using Composer, require the Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/wp-cli.php';

add_action('admin_menu', 'plugin_setup_menu');

/**
 * Register the plugin on the WordPress Admin Dashboard
 */
function plugin_setup_menu()
{
    add_menu_page('Dual Enrollment Data', 'Dual Enrollment Data', 'manage_options', 'dual-enrollment-data', 'dual_enrollment_init');
}

/**
 * Initialize the Algolia Plugin Main page
 */
function dual_enrollment_init()
{
    include('../wp-content/plugins/algolia-custom-integration/dashboard.php');
}
