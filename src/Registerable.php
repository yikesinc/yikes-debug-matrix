<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix;

/**
 * Interface Registerable.
 *
 * An object that can be `register()`ed.
 *
 * @since   0.1.0
 *
 * @package YIKES\Matrix
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
