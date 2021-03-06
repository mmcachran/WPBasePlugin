<?php
/**
 * Helper functions for rendering template files.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin;

/**
 * Helper function for including a template.
 *
 * @param string $template  The template name to include.
 * @param array  $params    An array of parameters to include with the template.
 * @param array  $opts      Options for including the template.
 * @return string           Markup for the template.
 */
function include_template( $template, array $params = [], array $opts = [] ) {
	$template_dir = WPBASEPLUGIN_PLUGIN_DIR . '/templates/';

	// Bail early if the template does not exist.
	if ( ! file_exists( $template_dir . $template ) ) {
		return '';
	}

	// Extract params array to make keys available as direct variables.
	extract( $params ); // @codingStandardsIgnoreLine
	include $template_dir . $template;
}
