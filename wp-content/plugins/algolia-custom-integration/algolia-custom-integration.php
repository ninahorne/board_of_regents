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
require_once __DIR__ . '/api-client/autoload.php';
// If you're using Composer, require the Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/wp-cli.php';


global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("L1FLYTXGGK", "65d958e57e130f9ab14bfa0dfa0123f1");

