<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix;

use YIKES\Matrix\Debug\Debugger;

/**
 * Class PluginFactory
 *
 * @since   0.1.0
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */
final class PluginFactory {

	use PluginHelper;

	/**
	 * Create and return an instance of the plugin.
	 *
	 * This always returns a shared instance.
	 *
	 * @since 0.1.0
	 *
	 * @return Plugin The plugin instance.
	 */
	public function create() {
		static $plugin = null;

		if ( null === $plugin ) {
			$plugin = new Plugin( $this->get_service_container() );
		}

		return $plugin;
	}

	/**
	 * Get the service container for our class.
	 *
	 * @since  0.1.0
	 * @return Container
	 */
	private function get_service_container() {

		$services = new Container();

		$services->add_service( Debugger::class );

		return $services;
	}
}
