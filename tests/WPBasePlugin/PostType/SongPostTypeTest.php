<?php
/**
 * Unit tests the Example Post Type class.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\PostType;

/**
 * Tests the Auction Post Type class.
 */
class SongPostTypeTest extends \WP_UnitTestCase {

	/**
	 * Holds an instance of the Auction Post Type.
	 *
	 * @var \WPBasePlugin\PostType\AuctionPostType
	 */
	public $post_type;

	/**
	 * Sets up unit tests.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->post_type = new ExamplePostType();
	}

	/**
	 * Tests the post type has a name.
	 *
	 * @return void
	 */
	public function test_it_has_a_name() {
		$actual = $this->post_type->get_name();
		$this->assertEquals( WPBASEPLUGIN_EXAMPLE_POST_TYPE, $actual );
	}

	/**
	 * Tests the post type has a singular name.
	 *
	 * @return void
	 */
	public function test_it_has_singular_label() {
		$actual = $this->post_type->get_singular_label();
		$this->assertEquals( 'Example', $actual );
	}

	/**
	 * Tests the post type has a plural name.
	 *
	 * @return void
	 */
	public function test_it_has_plural_label() {
		$actual = $this->post_type->get_plural_label();
		$this->assertEquals( 'Examples', $actual );
	}
}
