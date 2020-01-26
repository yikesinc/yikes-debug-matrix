<?php
/**
 * Initialize Debugger
 *
 * @package YIKES Debugger
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

require_once __DIR__ . '/interface-singleton.php';
require_once __DIR__ . '/trait-debug-helpers.php';
require_once __DIR__ . '/class-yikes-logger.php';
require_once __DIR__ . '/class-debug-message.php';
require_once __DIR__ . '/class-yikes-base-debug.php';
require_once __DIR__ . '/class-yikes-debug.php';
