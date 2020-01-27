<?php
/**
 * Debug message structure.
 *
 * @package YIKES Starter
 */

namespace YIKES\Debugger\Message;

/**
 * class Theme Message
 */
final class DebugMessage {
	/**
	 * Message
	 *
	 * @var string
	 */
	public $debug_message = '';

	/**
	 * Error type
	 *
	 * @var int
	 */
	public $type = '';

	/**
	 * Constructor
	 *
	 * @param string $debug_message Message you'd like displayed.
	 * @param string $type How bad is this error.
	 */
	public function __construct( string $debug_message = '', string $type ) {
		$this->debug_message = $debug_message;
		$this->type          = $type;
	}

	/**
	 * Get Message Formatted.
	 */
	public function get_message() {
		return array(
			'message' => $this->debug_message,
			'type'    => $this->type,
		);
	}
}
