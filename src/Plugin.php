<?php
/**
 * YIKES Debugger
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */

namespace YIKES\Debugger;

/**
 * Class Plugin.
 *
 * Main plugin controller class that hooks the plugin's functionality into the
 * WordPress request lifecycle.
 *
 * @since   0.1.0
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */
final class Plugin implements Registerable {

	use PluginHelper {
		get_version as public;
	}

	/**
	 * Container instance.
	 *
	 * @since 0.1.0
	 * @var Container
	 */
	protected $container;

	/**
	 * Array of registered services.
	 *
	 * @since 0.1.0
	 * @var Service[]
	 */
	private $services = [];

	/**
	 * Instantiate a Plugin object.
	 *
	 * @since 0.1.0
	 *
	 * @param Container $container The container object.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}
}
