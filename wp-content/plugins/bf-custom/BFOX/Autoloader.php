<?php

namespace BFOX;

/**
 * Class Autoloader
 * @package BFOX
 *
 * @author Hoang Phan <hoang.phan@bfoxint.com>
 */
class Autoloader
{
    /**
     * autoload
     */
    public static function init() {
        spl_autoload_register( function ( $class ) {
            if ( substr( $class, 0, 4 ) === 'BFOX' ) {
                require realpath( dirname( __FILE__ ) ) . '/../' . str_replace( '\\', '/', $class ) . '.php';
            }
        } );
    }
}

Autoloader::init();