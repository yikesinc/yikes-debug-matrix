<?php
/**
 * Debug message structure.
 *
 * @package YIKES Debugger
 */

namespace YIKES\Debugger\Debug;

/**
 * Class Console Logger
 */
final class ConsoleLog {
	/**
	 * Current Log
	 *
	 * @var string
	 */
	private $current_log = '';

	/**
	 * Log setter
	 *
	 * @param string $new_message set another message in the log.
	 */
	private function set_log( string $new_message ): void {
		$this->current_log .= $new_message . "\n";
	}

	/**
	 * Console with type
	 *
	 * @param string $value value for the log.
	 * @param string $console_type 'log', 'warn', 'error', 'group', 'groupEnd'.
	 */
	public function console_with_type( string $value, string $console_type = 'log' ): void {
		$formatted_string = 'console.' . $console_type . '("' . $value . '");';
		$this->set_log( (string) $formatted_string );
	}

	/**
	 * Console Group
	 *
	 * @param string $value value for the label.
	 */
	public function group( string $value ): void {
		$this->console_with_type( $value, 'group' );
	}

	/**
	 * Console Log
	 *
	 * @param string $value value for the console.
	 */
	public function log( string $value ): void {
		$this->console_with_type( $value, 'log' );
	}

	/**
	 * Console Group End
	 */
	public function groupend(): void {
		$this->set_log( 'console.groupEnd();' );
	}

	/**
	 * Print Log
	 */
	public function print(): void {
		$current_log = $this->current_log;
		echo wp_kses( "<script>\n{$current_log}</script>", array( 'script' => array() ) );

		// Clean up the log just to be safe.
		$this->reset_log();
	}

	/**
	 * Reset Log
	 */
	private function reset_log(): void {
		$this->current_log = '';
	}
}
