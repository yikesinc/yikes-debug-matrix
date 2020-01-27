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

	/**
	 * Register the plugin with the WordPress system.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'plugins_loaded', [ $this, 'register_services' ], 20 );
		add_action( 'plugins_loaded', function() {
			// Action fires after services have been registered.
			do_action( 'yikes_debugger_loaded', $this );
		}, 0 );
	}

	/**
	 * Register the individual services of this plugin.
	 *
	 * @since 0.1.0
	 */
	public function register_services() {
		$services = $this->get_services();
		$services = array_map( [ $this, 'instantiate_service' ], $services );
		array_walk( $services, function( Service $service ) {
			$service->register();
		} );
		$this->services = $services;
	}

	/**
	 * Get the list of services to register.
	 *
	 * @since 0.1.0
	 *
	 * @return string[] Array of fully qualified class names.
	 */
	protected function get_services() {
		/**
		 * Fires right before the YIKES Debugger services are retrieved.
		 *
		 * @param Container $container The services container object.
		 */
		do_action( 'yikes_debugger_pre_get_services', $this->container );

		return array_keys( $this->container->get_services() );
	}

	/**
	 * Instantiate a single service.
	 *
	 * @since 0.1.0
	 *
	 * @param string $class Service class to instantiate.
	 *
	 * @return Service
	 * @throws Exception\InvalidService If the service is not valid.
	 */
	protected function instantiate_service( $class ) {
		if ( ! class_exists( $class ) ) {
			throw InvalidClass::not_found( $class );
		}

		$service = new $class();

		if ( ! ( $service instanceof Service ) ) {
			throw InvalidClass::from_interface( $class, Service::class );
		}

		return $service;
	}
}
