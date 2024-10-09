<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase (ignore the file name as changing it will deactivate the plugin upon updating)
/**
 * Plugin Name: Ko-fi Button
 * Plugin URI:
 * Description: A Ko-fi donate button for your website!
 * Version: 1.3.7
 * Author: Ko-fi Team
 * Author URI: https://www.ko-fi.com
 * License: GPL2
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Write to the debug log is `WP_DEBUG` is enabled
	 * Appears to be unused
	 *
	 * @param mixed $log Input to send to the error log.
	 */
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

require_once 'class-ko-fi.php';

add_action( 'plugins_loaded', array( 'Ko_Fi', 'init' ) );
