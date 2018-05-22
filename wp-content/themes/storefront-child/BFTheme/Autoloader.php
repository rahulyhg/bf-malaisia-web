<?php

namespace BFTheme;

/**
 * Class Autoloader
 * @package BFOX\Theme
 *
 * @author Hoang Phan <hoang.phan@bfoxint.com>
 */
class Autoloader {
	/**
	 * autoload
	 */
	public static function init() {
		spl_autoload_register( function ( $class ) {
			if ( substr( $class, 0, 7 ) === 'BFTheme' ) {
				require realpath( dirname( __FILE__ ) ) . '/../' . str_replace( '\\', '/', $class ) . '.php';
			}
		} );
	}
}

Autoloader::init();
