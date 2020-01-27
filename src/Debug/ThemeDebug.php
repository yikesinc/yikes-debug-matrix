<?php
/**
 * YIKES Debug.
 *
 * @package YIKES Starter
 */

namespace YIKES\Debugger\Debug;

use YIKES\Debugger\Message\ThemeMessage;
use YIKES\Debugger\Service;

/**
 * Class ThemeDebug
 */
final class ThemeDebug extends BaseDebug implements Service, DebugType {

	/**
	 * Message log.
	 *
	 * @var array
	 */
	private $message_log = array();

	const CONSOLE_LABEL = 'Theme Debugger';

	/**
	 * Register debugger functionality.
	 *
	 * Hook into WordPress during development to output error messages.
	 *
	 * @return void
	 */
	public function register(): void {
		if ( $this->check_debug_mode() ) {
			add_action( 'shutdown', [ $this, 'print_error_log' ] );
		}
	}

	/**
	 * Get Label.
	 *
	 * Main console group label.
	 *
	 * @return string
	 */
	protected function get_label(): string {
		return self::CONSOLE_LABEL;
	}

	/**
	 * Print Error Messages
	 *
	 * @return void
	 */
	public function print_error_log(): void {
		try {
			$console = new ConsoleLog();
			// Start Debugger Group.
			$console->group( static::WELCOME_MESSAGE );

			if ( ! empty( $this->get_message_log() ) ) {
				$messages = $this->organize_by_type(
					$this->get_message_log()
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
				$this->set_log(
					new ThemeMessage( $debug_message, $type )
				);
			} catch ( Exception $e ) {
				echo wp_kses( '<script>console.log("Error occured when trying to create a new debug error.");</script>', array( 'script' => array() ) );
			}
		}
	}

	/**
	 * Add to log.
	 *
	 * @param ThemeMessage $message New message to add to the log.
	 * @return void
	 */
	private function set_log( ThemeMessage $message ): void {
		try {
			$this->message_log[] = $message->get_message();
		} catch ( Exception $e ) {
			if ( $this->check_debug_mode() ) {
				echo wp_kses( '<script>console.log("Uncaught Exception: Found In ThemeMessage->set_log();");</script>', array( 'script' => array() ) );
			}
		}
	}
}
