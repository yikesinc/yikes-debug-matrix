<?php
/**
 * Debug message structure.
 *
 * @package YIKES Debugger
 */

namespace YIKES\Debugger;

/**
 * Class Autoloader.
 *
 * This is a custom autoloader to replace the functionality that we would
 * normally get through the autoloader generated by Composer.
 *
 * @since   0.1.0
 *
 * @package YIKES\Debugger
 */
final class Autoloader {

	/**
	 * Array containing the registered namespace structures
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	private $namespaces = [];

	/**
	 * Destructor for the Autoloader class.
	 *
	 * The destructor automatically unregisters the autoload callback function
	 * with the SPL autoload system.
	 *
	 * @since  0.1.0
	 */
	public function __destruct() {
		$this->unregister();
	}

	/**
	 * Registers the autoload callback with the SPL autoload system.
	 *
	 * @since    0.1.0
	 */
	public function register() {
		spl_autoload_register( [ $this, 'autoload' ] );
	}

	/**
	 * Unregisters the autoload callback with the SPL autoload system.
	 *
	 * @since    0.1.0
	 */
	public function unregister() {
		spl_autoload_unregister( [ $this, 'autoload' ] );
	}

	/**
	 * Add a specific namespace structure with our custom autoloader.
	 *
	 * @since  0.1.0
	 *
	 * @param string  $root        Root namespace name.
	 * @param string  $base_dir    Directory containing the class files.
	 * @param string  $prefix      Prefix to be added before the class.
	 * @param string  $suffix      Suffix to be added after the class.
	 * @param boolean $lowercase   Whether the class should be changed to
	 *                             lowercase.
	 * @param boolean $underscores Whether the underscores should be changed to
	 *                             hyphens.
	 *
	 * @return self
	 */
	public function add_namespace(
		$root,
		$base_dir,
		$prefix = '',
		$suffix = '.php',
		$lowercase = false,
		$underscores = false
	) {
		$this->namespaces[] = [
			'root'        => $this->normalize_root( (string) $root ),
			'base_dir'    => trailingslashit( (string) $base_dir ),
			'prefix'      => (string) $prefix,
			'suffix'      => (string) $suffix,
			'lowercase'   => (bool) $lowercase,
			'underscores' => (bool) $underscores,
		];

		return $this;
	}

	/**
	 * The autoload function that gets registered with the SPL Autoloader
	 * system.
	 *
	 * @since 0.1.0
	 *
	 * @param string $class The class that got requested by the spl_autoloader.
	 */
	public function autoload( $class ) {

		// Iterate over namespaces to find a match.
		foreach ( $this->namespaces as $namespace ) {

			// Move on if the object does not belong to the current namespace.
			if ( 0 !== strpos( $class, $namespace['root'] ) ) {
				continue;
			}

			// Remove namespace root level to correspond with root filesystem.
			$filename = str_replace( $namespace['root'], '', $class );

			// Replace the namespace separator "\" by the system-dependent directory separator.
			$filename = str_replace( '\\', DIRECTORY_SEPARATOR, $filename );

			// Remove a leading backslash from the class name.
			$filename = $this->remove_leading_backslash( $filename );

			// Change to lower case if requested.
			if ( true === $namespace['lowercase'] ) {
				$filename = strtolower( $filename );
			}

			// Change underscores into hyphens if requested.
			if ( true === $namespace['underscores'] ) {
				$filename = str_replace( '_', '-', $filename );
			}

			// Add base_dir, prefix and suffix.
			$filepath = "{$namespace['base_dir']}{$namespace['prefix']}{$filename}{$namespace['suffix']}";

			// Require the file if it exists and is readable.
			if ( is_readable( $filepath ) ) {
				require $filepath;
			}
		}
	}

	/**
	 * Normalize a namespace root.
	 *
	 * @since 0.1.0
	 *
	 * @param string $root Namespace root that needs to be normalized.
	 *
	 * @return string Normalized namespace root.
	 */
	private function normalize_root( $root ) {
		$root = $this->remove_leading_backslash( $root );

		return $this->add_trailing_backslash( $root );
	}

	/**
	 * Remove a leading backslash from a string.
	 *
	 * @since 0.1.0
	 *
	 * @param string $string String to remove the leading backslash from.
	 *
	 * @return string Modified string.
	 */
	private function remove_leading_backslash( $string ) {
		return ltrim( $string, '\\' );
	}

	/**
	 * Make sure a string ends with a trailing backslash.
	 *
	 * @since 0.1.0
	 *
	 * @param string $string String to check the trailing backslash of.
	 *
	 * @return string Modified string.
	 */
	private function add_trailing_backslash( $string ) {
		return rtrim( $string, '\\' ) . '\\';
	}
}
