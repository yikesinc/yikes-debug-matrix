<?php
/**
 * YIKES Debug.
 *
 * @package YIKES Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

/**
 * Class YIKES Debug
 */
class YIKES_Debug extends YIKES_Base_Debug {
	/**
	 * Message log.
	 *
	 * @var array
	 */
	private $message_log = array();

	const WELCOME_MESSAGE = 'YIKES, Inc. Theme Debugger';

	/**
	 * Print Error Messages
	 */
	public function print_error_log() {
		if ( $this->check_debug_mode() ) {
			try {
				$console = new YIKES_Logger();
				// Start Debugger Group.
				$console->group( static::WELCOME_MESSAGE );

				if ( ! empty( $this->message_log ) ) {
					$messages = $this->organize_by_type(
						$this->message_log
					);

					foreach ( $messages as $group => $values ) {
						// Start Individual Groups.
						$console->group( $values['label'] );
						$console_type = isset( $values['console_type'] ) ? $values['console_type'] : 'log';
						$console_type = apply_filters( 'yikes_debugger_console_type', $console_type, $group );

						if ( is_array( $values['messages'] ) && ! empty( $values['messages'] ) ) {
							foreach ( $values['messages'] as $bug_message ) {
								$console->console_with_type( $bug_message, $console_type );
							}
						} else {

							$console->log( "No {$group} errors detected." );
						}
						// End Individual Groups.
						$console->groupend();
					}
				} else {
					$console->log( 'No errors detected.' );
				}

				// End Debugger Group.
				$console->groupend();

				// Print console log.
				$console->print();
			} catch ( Exception $e ) {
				if ( $this->check_debug_mode() ) {
					$error_message  = '<pre>';
					$error_message .= 'class YIKES_Logger failed at ( YIKES_Debug() )->print_error_log().';
					$error_message .= '</pre>';
					echo wp_kses( $error_message, array( 'pre' => array() ) );
				}
			}
		}
	}

	/**
	 * Debug message.
	 *
	 * @param string $debug_message Message to display in js console.
	 * @param string $type Seperate errors by type.
	 * @return void
	 */
	public function add_message( string $debug_message, string $type = '' ): void {
		if ( $this->check_debug_mode() ) {
			try {
				$this->add_to_log(
					new Debug_Message( $debug_message, $type )
				);
			} catch ( Exception $e ) {
				echo wp_kses( '<script>console.log("Error occured when trying to create a new debug error.");</script>', array( 'script' => array() ) );
			}
		}
	}

	/**
	 * Add to log.
	 *
	 * @param Debug_Message $message New message to add to the log.
	 * @return void
	 */
	private function add_to_log( Debug_Message $message ): void {
		try {
			$new_message       = (array) $message->format();
			$new_log           = array_merge( $this->message_log, $new_message );
			$this->message_log = $new_log;
		} catch ( Exception $e ) {
			if ( $this->check_debug_mode() ) {
				echo wp_kses( '<script>console.log("Uncaught Exception: Found In Debug_Message->add_to_log();");</script>', array( 'script' => array() ) );
			}
		}
	}

	/**
	 * Check debug mode
	 */
	private function check_debug_mode() {
		if ( defined( 'YIKES_DEBUG_ENABLED' ) && true === YIKES_DEBUG_ENABLED ) {
			return true;
		}
		return false;
	}
}
