<?php
/**
 * YIKES Debug Helper Methods.
 *
 * @package YIKES Starter
 */

namespace YIKES\Debugger\Debug;

trait DebugTrait {
	/**
	 * Organize by type.
	 *
	 * @param array $message_log Array of messages.
	 * @example array( array( 'type' => 'critical', 'message' => 'YIKES! Turn on the bat signal!' ) )
	 * @return array
	 */
	protected function organize_by_type( array $message_log ): array {
		$all_messages = $this->get_default_groups();

		foreach ( $message_log as $error ) {
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
