<?php
/**
 * Unit tests the Example Taxonomy class.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Taxonomy;

/**
 * Tests the Example taxonomy.
 */
class ExampleTaxonomyTest extends \WP_UnitTestCase {

	/**
	 * Holds an instance of the Example Taxonomy class.
	 *
	 * @var \WPBasePlugin\Taxonomy\ExampleTaxonomy
	 */
	public $taxonomy;

	/**
	 * Sets up unit tests.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->taxonomy = new ExampleTaxonomy();
	}

	/**
	 * Tests the taxonomy has a name.
	 *
	 * @return void
	 */
	public function test_it_has_a_name() {
		$actual = $this->taxonomy->get_name();
		$this->assertEquals( WPBASEPLUGIN_EXAMPLE_TAXONOMY, $actual );
	}

	/**
	 * Tests the taxonomy has a singular label.
	 *
	 * @return void
	 */
	public function test_it_has_a_singular_label() {
		$actual = $this->taxonomy->get_singular_label();
		$this->assertEquals( 'Example', $actual );
	}

	/**
	 * Tests the taxonomy has a plural label.
	 *
	 * @return void
	 */
	public function test_it_has_a_plural_label() {
		$actual = $this->taxonomy->get_plural_label();
		$this->assertEquals( 'Examples', $actual );
	}

	/**
	 * Tests the taxonomy is public.
	 *
	 * @return void
	 */
	public function test_it_is_a_public_taxonomy() {
		$actual = $this->taxonomy->get_options();
		$this->assertTrue( $actual['public'] );
	}

}

