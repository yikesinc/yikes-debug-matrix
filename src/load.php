<?php
/**
 * YIKES Debugger
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */

namespace YIKES\Debugger;

// Don't allow loading outside of WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

require_once __DIR__ . '/bootstrap-autoloader.php';
