<?php
/**
 * Base Debugger
 *
 * @package YIKES Debug Matrix
 */

namespace YIKES\Matrix\Debug;

/**
 * YIKES Base Debug Class
 */
abstract class BaseDebug {

	/**
	 * Default Types.
	 *
	 * Types to sort each debugger into groups and colors.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	protected $default_types = array(
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

	const WELCOME_MESSAGE = 'YIKES! Debugger Active';
	const CONSOLE_LABEL   = '_override_';

	/**
	 * Get Label.
	 *
	 * Helper method to remind you to implement get_label().
	 *
	 * @return string
	 */
	protected function get_label(): string {
		return 'You need to override the get_label() method in your class.';
	}

	/**
	 * Check debug mode.
	 *
	 * Helper function to determine if we should console log errors.
	 *
	 * @return boolean
	 */
	public function check_debug_mode(): bool {
		if ( defined( 'YIKES_DEBUG_ENABLED' ) && true === YIKES_DEBUG_ENABLED ) {
			return true;
		}
		return false;
	}

	/**
	 * Get default groups.
	 */
	public function get_default_groups(): array {
		$default_groups = $this->default_types;
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

	/**
	 * Organize by type.
	 *
	 * Reorder our types for console groups.
	 *
	 * @return array
	 */
	protected function organize_by_type(): array {
		$all_messages = $this->get_default_groups();

		foreach ( $this->message_log as $error ) {
			$error_type = isset( $error['type'] ) ? (string) $error['type'] : 'debug';

			// If we're not dealing with a default type make sure its formatted correctly.
			if ( ! isset( $all_messages[ $error_type ] ) ) {
				$fix_label = isset( $all_messages[ $error_type ]['label'] ) ? $all_messages[ $error_type ]['label'] : ucfirst( $error_type ) . ':';
				$fix_type  = array(
					'messages' => array(),
					'label'    => $fix_label,
				);

				$all_messages[ $error_type ] = $fix_type;
			}
			$all_messages[ $error_type ]['messages'][] = isset( $error['message'] ) ? (string) $error['message'] : '';
		}

		return $all_messages;
	}
}
