## Usage

#### In Development Only:
Set this constant in your wp-config.php to allow the debugger to run. This is done as a safety measure in case you accidently ship this code into production.

```
define( 'YIKES_DEBUG_ENABLED', true );
```

#### Debugging Your Theme:
Lets say you're writing a complex query and something is not working correctly accross pages or with pagination. There are a million examples of when you might need to debug WordPress so I won't go into detail. This plugin includes a Factory class `YIKES\Matrix\Debug\Debugger` which will allow you to choose a single instance of an error log to add your messages to.

Currently there is only one instance, which is the theme debugger so I'll give an example of that. In your theme you'll need to "import" the class from the plugin. The plugin will also need to be activated or in your mu-plugins directory.

```
<?php

$logger = new \YIKES\Matrix\Debug\Debugger( 'theme' );
$some_query = new WP_Query( $some_args );

// Start debugging
$logger->add_message( $some_query->found_posts, 'Some Query Debug' );
```

Since that factory is referencing the same instance of `ThemeDebug()` no matter where you right your code it will end up in your same log. The second param passed is your label. So if you're debugging taxonomy templates and custom post types and whatever else you can group like messages together. Those groups will be printed as seperate `console.group()`

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
