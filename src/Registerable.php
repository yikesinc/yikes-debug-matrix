<?php
/**
 * YIKES Debugger
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */

namespace YIKES\Debugger;

/**
 * Interface Registerable.
 *
 * An object that can be `register()`ed.
 *
 * @since   0.1.0
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */
interface Registerable {

	/**
	 * Register the current Registerable.
	 *
	 * @since 0.1.0
	 */
	public function register();
}
