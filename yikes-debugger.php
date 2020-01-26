<?php
/**
 * Initialize Debugger
 *
 * @package YIKES Debugger
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}


/**
 * Plugin Version
 */
if ( ! defined( 'YIKES_DEBUGGER_VERSION' ) ) {
	define( 'YIKES_DEBUGGER_VERSION', '0.1.0' );
}


/**
 * Minimum PHP Version
 */
if ( ! defined( 'YIKES_DEBUGGER_PHP' ) ) {
	define( 'YIKES_DEBUGGER_PHP', '5.6.0' );
}


/**
 * Minimum WordPress Version
 */
if ( ! defined( 'YIKES_DEBUGGER_WP' ) ) {
	define( 'YIKES_DEBUGGER_WP', '4.8' );
}


// Include Pre-Bootstrap Imperitive Functionality.
require_once __DIR__ . '/inc/functions.php';

// Check PHP Version - Exit if incompatable.
if ( function_exists( 'yks_debug_php_version_check' ) && false === yks_debug_php_version_check() ) {
	return;
}


// Check Required WordPress Version.
if ( function_exists( 'yks_debug_wp_version_check' ) && false === yks_debug_wp_version_check() ) {
	return;
}


// Bootstrap the plugin.
require_once __DIR__ . '/src/load.php';
