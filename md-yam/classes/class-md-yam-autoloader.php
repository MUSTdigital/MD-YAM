<?php

/**
 * Autoloads MD YAM classes using WordPress convention.
 *
 * @link        http://mustdigital.ru
 * @since       0.7.5
 *
 * @package     MD_YAM
 * @subpackage  MD_YAM/classes
 */

/**
 * Autoloads MD YAM classes using WordPress convention.
 *
 * @since       0.7.5
 * @package     MD_YAM
 * @subpackage  MD_YAM/classes
 * @author      Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Autoloader {

    /**
     * Registers MD_YAM_Autoloader as an SPL autoloader.
     *
     * @param  boolean  $prepend  If true, spl_autoload_register() will prepend the autoloader on the autoload queue instead of appending it.
     * @since  0.7.5
     */
    public static function register( $prepend = false ) {

        if ( version_compare( phpversion(), '5.3.0', '>=' ) ) {
            spl_autoload_register( [new self, 'autoload'], true, $prepend );
        } else {
            spl_autoload_register( [new self, 'autoload'] );
        }

    }

    /**
     * Handles autoloading of MD_YAM classes.
     *
     * @param  string  $class  Class name.
     * @since  0.7.5
     */
    public static function autoload( $class ) {

        if ( is_file( $file = MDYAM_PROJECT_DIR . '/classes/' . 'class-' . strtolower( str_replace( ['_', "\0"], ['-', ''], $class ) . '.php' ) ) ) {
            require_once $file;
        }

    }
}
