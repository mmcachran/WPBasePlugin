<?php
/**
 * Plugin Name: WPBasePlugin
 * Description: Plugin Support for WPBasePlugin.
 * Version:     0.1.0
 * Author:
 * Text Domain: wpbaseplugin
 * Domain Path: /languages/
 *
 * @package WPBasePlugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wrapper around PHP's define function. The defined constant is
 * ignored if it has already been defined. This allows the
 * config.local.php to override any constant in config.php.
 *
 * @param string $name  The constant name.
 * @param mixed  $value The constant value.
 * @return void
 */
function wpbaseplugin_define( $name, $value ) {
	// Bail early if already defined.
	if ( defined( $name ) ) {
		return;
	}

	// Define the constant.
	define( $name, $value );
}

if ( file_exists( __DIR__ . '/config.test.php' ) && defined( 'PHPUNIT_RUNNER' ) ) {
	require_once __DIR__ . '/config.test.php';
}

if ( file_exists( __DIR__ . '/config.local.php' ) ) {
	require_once __DIR__ . '/config.local.php';
}

require_once __DIR__ . '/config.php';

/**
 * Loads the WPBasePlugin PHP autoloader if possible.
 *
 * @return bool True or false if autoloading was successful.
 */
function wpbaseplugin_autoload() {
	// Bail early if it cannot be autoloaded.
	if ( ! wpbaseplugin_can_autoload() ) {
		return false;
	}

	require_once wpbaseplugin_autoloader();
	return true;
}

/**
 * In server mode we can autoload if autoloader file exists. For
 * test environments we prevent autoloading of the plugin to prevent
 * global pollution and for better performance.
 *
 * @return bool True if the plugin can be autoloaded, false otherwise.
 */
function wpbaseplugin_can_autoload() {
	// Bail early if the autoloader doesn't exist.
	if ( ! file_exists( wpbaseplugin_autoloader() ) ) {
		error_log( 'Fatal Error: Composer not setup in ' . WPBASEPLUGIN_PLUGIN_DIR ); // @codingStandardsIgnoreLine
		return false;
	}

	return true;
}

/**
 * Default is Composer's autoloader
 *
 * @return string The path to the composer autoloader.
 */
function wpbaseplugin_autoloader() {
	return WPBASEPLUGIN_PLUGIN_DIR . '/vendor/autoload.php';
}

/**
 * Plugin code entry point. Singleton instance is used to maintain a common single
 * instance of the plugin throughout the current request's lifecycle.
 *
 * If autoloading failed an admin notice is shown and logged to
 * error_log.
 *
 * @return void
 */
function wpbaseplugin_autorun() {
	// Bail early if plugin cannot be autoloded.
	if ( ! wpbaseplugin_autoload() ) {
		add_action( 'admin_notices', 'wpbaseplugin_autoload_notice' );
		return;
	}

	$plugin = \WPBasePlugin\Plugin::get_instance();
	$plugin->enable();
}

/**
 * Displays notice if the plugin cannot be autoloaded.
 *
 * @return void
 */
function wpbaseplugin_autoload_notice() {
	$class   = 'notice notice-error';
	$message = 'Error: Please run $ composer install in the WPBasePlugin plugin directory.';

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $message ) );
	error_log( $message ); // @codingStandardsIgnoreLine
}

// Kick off the plugin.
wpbaseplugin_autorun();
