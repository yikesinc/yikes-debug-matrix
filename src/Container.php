<?php
/**
 * YIKES Debug Matrix
 *
 * @package YIKES\Matrix
 * @author  Freddie Mixell
 */

namespace YIKES\Matrix;

/**
 * Class Container
 *
 * @since   0.1.0
 * @package YIKES\Matrix
 */
final class Container {

	/**
	 * The registered services for the container.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	protected $services = [];

	/**
	 * Container constructor.
	 *
	 * @param array $services Services to register with the container.
	 */
	public function __construct( array $services = [] ) {
		$this->services = $services ?: [];
	}

	/**
	 * Get the services from the container.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function get_services() {
		return $this->services;
	}

	/**
	 * Add a service to the container.
	 *
	 * @since 0.1.0
	 *
	 * @param string $service Service class name.
	 */
	public function add_service( $service ) {
		$this->services[ $service ] = true;
	}

	/**
	 * Remove a service from the container.
	 *
	 * @since 0.1.0
	 *
	 * @param string $service Service class name.
	 */
	public function remove_service( $service ) {
		unset( $this->services[ $service ] );
	}
}
