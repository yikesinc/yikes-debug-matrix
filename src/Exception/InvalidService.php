<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix\Exception;

/**
 * Class InvalidService.
 *
 * @since   0.1.0
 *
 * @package YIKES\Matrix\Exception
 * @author  Freddie Mixell
 */
class InvalidService extends \InvalidArgumentException implements Exception {

	/**
	 * Create a new instance of the exception for a service class name that is
	 * not recognized.
	 *
	 * @since 0.1.0
	 *
	 * @param string $service Class name of the service that was not recognized.
	 *
	 * @return static
	 */
	public static function from_service( $service ) {
		$message = sprintf(
			'The service "%s" is not recognized and cannot be registered.',
			is_object( $service )
				? get_class( $service )
				: (string) $service
		);

		return new static( $message );
	}
}
