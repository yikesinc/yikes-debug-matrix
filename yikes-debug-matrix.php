<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 *
 * Plugin Name:  YIKES Debug Matrix
 * Plugin URI:   http://www.yikesplugins.com
 * Description:  Tooling for development and production debugging.
 * Author:       YIKES, Inc.
 * Author URI:   http://www.yikesinc.com
 * Text Domain:  yikes-debug-matrix
 * Domain Path:  /languages
 * Version:      0.1.0
 * Requires PHP: 5.6
 * License:      GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}


/**
 * Plugin Version
 */
if ( ! defined( 'YIKES_MATRIX_VERSION' ) ) {
	define( 'YIKES_MATRIX_VERSION', '0.1.0' );
}


/**
 * Minimum PHP Version
 */
if ( ! defined( 'YIKES_MATRIX_PHP' ) ) {
	define( 'YIKES_MATRIX_PHP', '5.6.0' );
}


/**
 * Minimum WordPress Version
 */
if ( ! defined( 'YIKES_MATRIX_WP' ) ) {
	define( 'YIKES_MATRIX_WP', '4.8' );
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
