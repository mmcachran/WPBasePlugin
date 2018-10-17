<?php
/**
 * Unit tests for the Post Type Factory.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\PostType;

/**
 * Class to unit test the Post Type Factory.
 */
class PostTypeFactoryTest extends \WP_UnitTestCase {
	/**
	 * Holds an instance of the post type factory.
	 *
	 * @var \WPBasePlugin\PostType\PostTypeFactory
	 */
	public $factory;

	/**
	 * Sets up unit tests.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->factory = new PostTypeFactory();
	}

	/**
	 * Tests an instance can be created.
	 *
	 * @return void
	 */
	public function test_it_can_be_created() {
		$this->assertInstanceOf(
			'WPBasePlugin\PostType\PostTypeFactory',
			$this->factory
		);
	}

	/**
	 * Test the factory knows if a post type doesn't exist.
	 *
	 * @return void
	 */
	public function test_it_knows_if_post_type_has_not_been_built() {
		$actual = $this->factory->exists( 'foo' );
		$this->assertFalse( $actual );
	}

	/**
	 * Test a post type can be built.
	 *
	 * @return void
	 */
	public function test_it_can_build_a_post_type() {
		$actual = $this->factory->build( WPBASEPLUGIN_POST_POST_TYPE );

		$this->assertInstanceOf(
			'WPBasePlugin\PostType\PostPostType',
			$actual
		);
	}

	/**
	 * Test a post type returns the cached version.
	 *
	 * @return void
	 */
	public function test_it_returns_cached_post_type_if_already_built() {
		$instance                         = new \stdClass();
		$this->factory->post_types['foo'] = $instance;

		$actual = $this->factory->build_if( 'foo' );
		$this->assertSame( $instance, $actual );
	}

	/**
	 * Test the post type factory can build all post types.
	 *
	 * @return void
	 */
	public function test_it_can_build_all_post_types() {
		$this->factory->build_all();

		$this->assertTrue( post_type_exists( WPBASEPLUGIN_POST_POST_TYPE ) );
	}

}
