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


global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("L1FLYTXGGK", "03caa5e233bd994477a0d3416be67e70");

add_action('admin_menu', 'test_plugin_setup_menu');
 
function test_plugin_setup_menu(){
    add_menu_page( 'Algolia Search', 'Algolia Search', 'manage_options', 'algolia-search', 'algolia_init' );
}
 
function algolia_init(){
    echo "<h1>Algolia Search</h1>";
}