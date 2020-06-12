<?php // phpcs:disable WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Class to extend the base Page post type functionality.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\PostType;

/**
 * Class to extend functionality for the Page post type.
 */
class PagePostType extends AbstractPostType implements \WPBasePlugin\RegistrationInterface {
	/**
	 * Returns the name of the post type.
	 *
	 * @return string The name of the post type.
	 */
	public function get_name() {
		return WPBASEPLUGIN_POST_POST_TYPE;
	}

	/**
	 * Returns the singular name for the post type.
	 *
	 * @return string The singular name for the post type.
	 */
	public function get_singular_label() {
		return esc_html__( 'Page', 'wpbaseplugin' );
	}

	/**
	 * Returns the plural name for the post type.
	 *
	 * @return string The plural name for the post type.
	 */
	public function get_plural_label() {
		return esc_html__( 'Pages', 'wpbaseplugin' );
	}

	/**
	 * Returns the supported taxonomies for the post type.
	 *
	 * @return array The supported taxonomies for the post type.
	 */
	public function get_supported_taxonomies() {
		return [];
	}

	/**
	 * Overrides the default register since this post type already exists in core WP.
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Remove or add post type support here...
	}

	/**
	 * Registers taxonomies for this post type.
	 *
	 * @return void
	 */
	public function register_taxonomies() {
		// Unregister default taxnomies then register the new taxonomies.
		parent::register_taxonomies();
	}
}
