<?php
/**
 * YIKES Debugger
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */

namespace YIKES\Debugger;

/**
 * Trait PluginHelper.
 *
 * Handle basic WordPress plugin variables like the plugin's path and URL.
 *
 * @since   0.1.0
 * @package YIKES\Debugger
 */
trait PluginHelper {

	/**
	 * Get the version of the plugin.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	protected function get_version() {
		if ( defined( 'YIKES_DEBUGGER_VERSION' ) ) {
			return YIKES_DEBUGGER_VERSION;
		}
		return (string) time();
	}
}
