<?php
/**
 * YIKES Base Debug.
 *
 * @package YIKES Starter
 */

/**
 * YIKES Base Debug Class
 */
class YIKES_Base_Debug implements YIKES_Singleton {
	use YIKES_Debug_Helpers;

	/**
	 * Instance.
	 *
	 * @var YIKES_Debug
	 */
	private static $instance = null;

	const WELCOME_MESSAGE = 'YIKES, Inc. Debugger Active';
	const DEFAULT_GROUPS  = array(
		'debug'      => array(
			'label'        => 'Debug:',
			'messages'     => array(),
			'console_type' => 'warn',
		),
		'regression' => array(
			'label'        => 'Regression:',
			'messages'     => array(),
			'console_type' => 'warn',
		),
		'critical'   => array(
			'label'        => 'Critical:',
			'messages'     => array(),
			'console_type' => 'error',
		),
	);

	/**
	 * Get Instance.
	 */
	public static function get_instance(): YIKES_Debug {
		if ( ! self::$instance ) {
			self::$instance = new YIKES_Debug();
		}

		return self::$instance;
	}

	/**
	 * Get default groups.
	 */
	public function get_default_groups() {
		$default_groups = self::DEFAULT_GROUPS;
		$add_groups     = (array) apply_filters( 'yikes_debugger_default_groups', array() );

		if ( ! empty( $add_groups ) ) {
			$next_groups      = array();
			$count_new_groups = count( $add_groups );

			for ( $x = 0; $x >= $count_new_groups; $x++ ) {
				$next = array();
				// Make sure we have something if not skip.
				if ( ! isset( $add_groups[ $x ] ) ) {
					continue;
				}
				// Exit out if we don't have a label.
				if ( ! array_key_exists( 'label', $add_groups[ $x ] ) ) {
					continue;
				} else {
					$next['label'] = $add_groups[ $x ]['label'];
				}
				if ( ! array_key_exists( 'messages', $add_groups[ $x ] ) ) {
					$next['messages'] = array();
				} else {
					$next['messages'] = $add_groups[ $x ]['messages'];
				}
				if ( ! array_key_exists( 'console_type', $add_groups[ $x ] ) ) {
					$next['console_type'] = 'log';
				} else {
					$next['console_type'] = $add_groups[ $x ]['console_type'];
				}

				// Replace with our filtered group.
				$add_groups[ $x ] = $next;
			}

			// Merge our new groups.
			$default_groups = array_merge( $default_groups, $add_groups );
		}

		return $default_groups;
	}
}
