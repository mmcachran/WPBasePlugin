<?php
/**
 * Holds configuration constants.
 *
 * @package WPBasePlugin
 */

$plugin_version = '0.1';

if ( file_exists( __DIR__ . '/.commit' ) ) {
	$plugin_version .= '-' . file_get_contents( __DIR__ . '/.commit' ); // @codingStandardsIgnoreLine
}

// Plugin Constants.
wpbaseplugin_define( 'WPBASEPLUGIN_PLUGIN', __DIR__ . '/wpbaseplugin.php' );
wpbaseplugin_define( 'WPBASEPLUGIN_PLUGIN_VERSION', $plugin_version );
wpbaseplugin_define( 'WPBASEPLUGIN_PLUGIN_DIR', __DIR__ );
wpbaseplugin_define( 'WPBASEPLUGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Post Types.
wpbaseplugin_define( 'WPBASEPLUGIN_POST_POST_TYPE', 'post' );
wpbaseplugin_define( 'WPBASEPLUGIN_PAGE_POST_TYPE', 'page' );
wpbaseplugin_define( 'WPBASEPLUGIN_EXAMPLE_POST_TYPE', 'wpbp-example-cpt' );

// Taxonomies.
wpbaseplugin_define( 'WPBASEPLUGIN_EXAMPLE_TAXONOMY', 'wpbp-example-taxonomy' );
