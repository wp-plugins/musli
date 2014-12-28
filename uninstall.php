<?php
/**
 * Musli Uninstall
 *
 * Uninstalling Musli database table and all stored options
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}musli" );

    delete_option('musli_config');
    delete_option('musli_version');