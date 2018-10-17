<?php
/**
 * Unit tests the Taxonomy factory.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Taxonomy;

/**
 * Class to unit tests the taxonomy factory.
 */
class TaxonomyFactoryTest extends \WP_UnitTestCase {
	/**
	 * Holds an instance of the taxonomy factory class.
	 *
	 * @var \WPBasePlugin\Taxonomy\TaxonomyFactory
	 */
	public $factory;

	/**
	 * Sets up the unit tests.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->factory = new TaxonomyFactory();
	}

	/**
	 * Tests an instance of the class can be created.
	 *
	 * @return void
	 */
	public function test_it_can_be_created() {
		$this->assertInstanceOf(
			'\WPBasePlugin\Taxonomy\TaxonomyFactory',
			$this->factory
		);
	}

	/**
	 * Tests the factory knows if a taxonomy that doesn't exist.
	 *
	 * @return void
	 */
	public function test_it_knows_if_taxonomy_does_not_exist() {
		$actual = $this->factory->exists( 'bar' );
		$this->assertFalse( $actual );
	}

	/**
	 * Tests the factory knows if a taxonomy does exist.
	 *
	 * @return void
	 */
	public function test_it_knows_if_taxonomy_exists() {
		$this->factory->taxonomies['foo'] = new \stdClass();
		$actual                           = $this->factory->exists( 'foo' );
		$this->assertTrue( $actual );
	}

	/**
	 * Tests the factory can register a taxonomy in WP.
	 *
	 * @return void
	 */
	public function test_it_registers_the_taxonomy_with_wordpress_on_build() {
		$this->factory->build( WPBASEPLUGIN_EXAMPLE_TAXONOMY );
		$actual = taxonomy_exists( WPBASEPLUGIN_EXAMPLE_TAXONOMY );
		$this->assertTrue( $actual );
	}

	/**
	 * Tests the factory does not rebuild existing taxonomies.
	 *
	 * @return void
	 */
	public function test_it_will_not_rebuild_existing_taxonomy() {
		$this->factory->taxonomies['foo'] = 'cached';
		$actual                           = $this->factory->build_if( 'foo' );
		$this->assertEquals( 'cached', $actual );
	}

	/**
	 * Tests the factory can build all taxonomies.
	 *
	 * @return void
	 */
	public function test_it_can_build_all_supported_taxonomies() {
		$this->factory->build_all();

		$actual = taxonomy_exists( WPBASEPLUGIN_EXAMPLE_TAXONOMY );
		$actual = $this->factory->exists( WPBASEPLUGIN_EXAMPLE_TAXONOMY );
		$this->assertTrue( $actual );
	}

	/**
	 * Tests the factory can build the Vehicle Make taxonomy.
	 *
	 * @return void
	 */
	public function test_it_can_build_the_vehicle_make_taxonomy() {
		$actual = $this->factory->build( WPBASEPLUGIN_EXAMPLE_TAXONOMY );
		$this->assertInstanceOf(
			'\WPBASEPLUGIN\Taxonomy\ExampleTaxonomy',
			$actual
		);
	}



}
