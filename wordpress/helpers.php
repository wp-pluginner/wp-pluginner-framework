<?php
use WpPluginner\Illuminate\Support\Debug\Dumper;

if (! function_exists('wp_pluginner_timezone')) {
    function wp_pluginner_timezone()
    {
        $timezone = get_option('timezone_string');

		if (!empty($timezone)) {
			return $timezone;
		} else {
			$offset = get_option( 'gmt_offset' );
			$amount = abs( $offset );

			if ( $offset > 0 ) {
				$offset = sprintf( '+%02d:%02d', $amount, 0 );
			} else {
				$offset = sprintf( '-%02d:%02d', $amount, 0 );
			}
			return $offset;
		}
    }
}

if (! function_exists('wp_pluginner_dump')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     * @return void
     */
    function wp_pluginner_dump(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}
