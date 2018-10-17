<?php
/**
 * Unit tests the abstract post type class.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\PostType;

/**
 * Tests the abstract post type class.
 */
class AbstractPostTypeTest extends \WP_UnitTestCase {
	/**
	 * Holds an instance of a post type.
	 *
	 * @var \WPBasePlugin\PostType\ThingPostType
	 */
	public $post_type;

	/**
	 * Sets up unit tests.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->post_type = new ThingPostType();
	}

	/**
	 * Tests the post type has a name.
	 *
	 * @return void
	 */
	public function test_it_has_a_name() {
		$actual = $this->post_type->get_name();
		$this->assertEquals( 'thing', $actual );
	}

	/**
	 * Tests the post type has options.
	 *
	 * @return void
	 */
	public function test_it_has_post_type_options() {
		$actual = $this->post_type->get_options();
		$this->assertNotNull( $actual );
	}

	/**
	 * Tests the post type has supported taxonomies.
	 *
	 * @return void
	 */
	public function test_it_has_list_of_supported_taxonomies() {
		$actual = $this->post_type->get_supported_taxonomies();
		$this->assertContains( WPBASEPLUGIN_EXAMPLE_TAXONOMY, $actual );
	}

	/**
	 * Tests the post type can be registered.
	 *
	 * @return void
	 */
	public function test_it_can_register_post_type() {
		$this->post_type = new ThingPostType();
		$this->post_type->register();

		$this->assertTrue( post_type_exists( 'thing' ) );

		$taxonomies = get_object_taxonomies( 'thing' );
		$this->assertEquals( [ WPBASEPLUGIN_EXAMPLE_TAXONOMY ], $taxonomies );
	}

}

/**
 * Class to extend the abstract post type for testing.
 */
class ThingPostType extends AbstractPostType {
	/**
	 * Returns the name of the post type.
	 *
	 * @return string Post type name.
	 */
	public function get_name() {
		return 'thing';
	}

	/**
	 * Returns the singular label of the post type.
	 *
	 * @return string Post type singular label.
	 */
	public function get_singular_label() {
		return 'thing';
	}

	/**
	 * Returns the plural label of the post type.
	 *
	 * @return string Post type plural label.
	 */
	public function get_plural_label() {
		return 'things';
	}

	/**
	 * Returns the supported list of taxonomies for the post type.
	 *
	 * @return array Supported taxonomies for the post type.
	 */
	public function get_supported_taxonomies() {
		return [
			WPBASEPLUGIN_EXAMPLE_TAXONOMY,
		];
	}

}
