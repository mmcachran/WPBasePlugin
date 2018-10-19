<?php
/**
 * The Example Taxonomy.
 * To obtain an instance of this class use the TaxonomyFactory.
 *
 * Usage:
 *
 * ```php
 *
 * $taxonomy = new ExampleTaxonomy();
 * $taxonomy->register();
 *
 * ```
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Taxonomy;

/**
 * A class for the Example Taxonomy.
 */
class ExampleTaxonomy extends AbstractTaxonomy {
	/**
	 * Returns the name of the taxonomy.
	 *
	 * @return string The name of the taxonomy.
	 */
	public function get_name() {
		return WPBASEPLUGIN_EXAMPLE_TAXONOMY;
	}

	/**
	 * Returns the singular name for the taxonomy.
	 *
	 * @return string The singular name for the taxonomy.
	 */
	public function get_singular_label() {
		return esc_html__( 'Example', 'wpbaseplugin' );
	}

	/**
	 * Returns the plural name for taxonomy.
	 *
	 * @return string The plural name for the taxonomy.
	 */
	public function get_plural_label() {
		return esc_html__( 'Examples', 'wpbaseplugin' );
	}

	/**
	 * Options for the taxonomy.
	 *
	 * @return array Options for the taxonomy.
	 */
	public function get_options() {
		return [
			'labels'            => $this->get_labels(),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'capability_type'   => 'post',
			'rewrite'           => [
				'slug' => 'example',
			],
		];
	}
}
