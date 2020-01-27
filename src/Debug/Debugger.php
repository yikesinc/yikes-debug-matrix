<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix\Debug;

use YIKES\Matrix\Service;

/**
 * Class Debugger
 *
 * Factory class that will return a single instance of a debugger.
 *
 * @since 0.1.0
 */
final class Debugger implements Service {

	public function register() {
		$theme_debugger = $this->get_debugger( 'theme' );
		add_action( 'shutdown', [ $theme_debugger, 'print_error_log' ] );
	}

	/**
	 * Get Debugger
	 *
	 * Returns a single static instance of a debugger to preserve the log.
	 *
	 * @param string $debugger Which debugger to use.
	 * @return DebuggerType
	 */
	public function get_debugger( string $debugger ): DebuggerType {
		static $debuggers = array(
			'theme'      => null,
			'plugin'     => null,
			'critical'   => null,
			'regression' => null,
			'default'    => null,
		);

		try {
			if ( ! array_key_exists( $debugger, $debuggers ) ) {
				throw new Error( "Invalid debugger. Got {$debugger}." );
				return $debuggers['default'];
			}

			// Return single instance of the class
			if ( null !== $debuggers[ $debugger ] ) {
				return $debuggers[ $debugger ];
			}

			switch ( $debugger ) {
				case 'theme':
					$debuggers['theme'] = new ThemeDebug();
					break;
				default:
					throw new Error( 'Not a valid debug class.' );
					return $debuggers['default'];
			}
			return $debuggers[ $debugger ];
		} catch ( Exception $e ) {
			print_r( $e->getMessage() );
		}
	}
}
