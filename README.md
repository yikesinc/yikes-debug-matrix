## Debug Examples:

#### Pre Get Posts
This action fires with the current instance of WP_Query. The following example will show you the output from all conditionals the start with 'is_'. This is useful if you're trying to figure out what conditionals are valid when your current page is loaded.

```
add_action( 'pre_get_posts', 'alter_posts_query' );

/**
 * Query Modifications.
 *
 * @param WP_Query $query current executing query.
 */
function alter_posts_query( $query ) {
    	/**
	 * Debug WP Query Conditional Methods
	 *
	 * @example $query->is_home()
	 */
	$methods = get_class_methods( $query );
	$group   = 'Pre Get Posts';
	foreach ( $methods as $method ) {
		if ( false !== strpos( $method, 'is_' ) ) {
			try {
				$test = $query->{$method}();
			} catch ( Throwable $e ) {
				$message = $e->getMessage();
				yks_debug_theme( "{$method} threw this error: {$message}", $group );
			}
			if ( true === $test ) {
				yks_debug_theme( "{$method} was true", $group );
			}
		} else {
			yks_debug_theme( "{$method}", $group . ' Skipped' );
		}
	}
}
```


#### Recursive Debug

```
function recursive_debug( $key, $value ) {
	if ( is_array( $value ) ) {
		foreach ( $value as $k => $v ) {
			recursive_debug( $k, $v );
		}
		return;
	}
	$type = gettype( $value );
	switch ( $type ) {
		case 'integer':
		case 'string':
		case 'float':
		case 'doubles':
			$final = $value;
			break;
		case 'object':
			$final = yks_debug_theme( esc_js( wp_json_encode( $value ) ) );
			break;
		case 'null':
			$final = 'null';
	}
	return yks_debug_theme( 'var: ' . $key . ' ' . $final, $type . ' Debug' );
}
```
