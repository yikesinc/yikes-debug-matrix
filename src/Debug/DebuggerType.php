<?php
/**
 * YIKES Debugger
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */

namespace YIKES\Debugger\Debug;

/**
 * Interface DebuggerType.
 *
 * Properties required for all debuggers.
 *
 * @since   0.1.0
 *
 * @package YIKES\Debugger
 * @author  Freddie Mixell
 */
interface DebuggerType {
	public function add_message( string $debug_message, string $type = '' );
	public function print_error_log();
	public function get_label();
}
