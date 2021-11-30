<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://revmakx.com
 * @since      1.0.0
 *
 * @package    Local_Sync
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$table_name = $wpdb->base_prefix . 'local_sync_options';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_processed_iterator';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_current_process';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_activity_log';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_inc_exc_contents';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_local_site_files';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_delete_list';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->base_prefix . 'local_sync_local_site_new_attachments';
$wpdb->query("DROP TABLE IF EXISTS $table_name");