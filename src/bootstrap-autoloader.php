<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix;

// Don't allow loading outside of WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// Load and register the autoloader.
require_once __DIR__ . '/Autoloader.php';
$yidr_autoloader = new Autoloader();
$yidr_autoloader->add_namespace( __NAMESPACE__, __DIR__ );
$yidr_autoloader->register();

( new PluginFactory() )->create()->register();
