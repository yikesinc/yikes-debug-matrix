<?php

use \YIKES\Matrix\Debug\Debugger;

if ( ! function_exists( 'yikes_debugger_php_version_check' ) ) {
	/**
	 * Required PHP Version.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	function yks_debug_php_version_check(): bool {
		if ( version_compare( YIKES_DEBUGGER_PHP, PHP_VERSION, '>' ) ) {
			add_action( 'admin_notices', 'yikes_debugger_php_version_notice' );

			return false;
		}
		return true;
	}
}

if ( ! function_exists( 'yikes_debugger_php_version_notice' ) ) {
	/**
	 * Display admin notice for incompatible PHP version.
	 *
	 * @since 0.1.0
	 */
	function yks_debug_php_version_notice(): void {
		printf(
			'<div class="error"><p>%s</p></div>',
			sprintf(
				/* translators: %1$s is the required PHP version, %2$s is the current version */
				esc_html__( 'YIKES Debug Matrix requires PHP version %1$s or above. Your site is using PHP version %2$s.', 'yikes-debug-matrix' ),
				esc_html( YIKES_DEBUGGER_PHP ),
				esc_html( PHP_VERSION )
			)
		);
	}
}


if ( ! function_exists( 'yks_debug_wp_version_check' ) ) {
	/**
	 * Required WordPress Version.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	function yks_debug_wp_version_check(): bool {
		if ( version_compare( YIKES_DEBUGGER_WP, $GLOBALS['wp_version'], '>' ) ) {
			add_action( 'admin_notices', 'yks_debug_wp_version_notice' );

			return false;
		}
		return true;
	}
}


if ( ! function_exists( 'yks_debug_wp_version_notice' ) ) {
	/**
	 * Display admin notice for incompatible WP version.
	 *
	 * @since 0.1.0
	 */
	function yks_debug_wp_version_notice(): void {
		printf(
			'<div class="error"><p>%s</p></div>',
			sprintf(
				/* translators: %1$s is the required WP version, %2$s is the current version */
				esc_html__( 'YIKES Debug Matrix requires WordPress version %1$s or above. Your site is using WordPress version %2$s.', 'yikes-debug-matrix' ),
				esc_html( YIKES_DEBUGGER_WP ),
				esc_html( $GLOBALS['wp_version'] )
			)
		);
	}
}


if ( ! function_exists( 'yks_debug_theme' ) ) {

	/**
	 * Debug Theme.
	 *
	 * Imperitive function for debugging your theme in development mode.
	 *
	 * @param string $debug_message Message to display in js console.
	 * @param string $type Seperate errors by type.
	 * @return void
	 */
	function yks_debug_theme( string $message, $type = '' ): void {
		$theme_logger = ( new Debugger )->get_debugger( 'theme' );
		$theme_logger->add_message( $message, $type );
	}
}
