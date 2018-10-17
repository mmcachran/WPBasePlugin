<?php
/**
 * Provides custom support for Google Tag Manager.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Admin;

/**
 * GTMSupport provides an admin page for custom functionality for Google Tag Manager.
 * This Page is build using the FieldManager plugin API.
 *
 * Settings are saved in the option, 'gtm_support' in the format
 *
 * [
 *   'container_id'     => string (required)
 * ]
 *
 * Usage: Register From the main Plugin.php
 *
 * $page = new GTMSupportAdmin();
 * $page->register();
 */
class GTMSupportAdmin {
	/**
	 * The metabox ID.
	 *
	 * @var string
	 */
	const META_BOX_ID = 'gtm_support';

	/**
	 * Registers the Field Manager submenu page and hooks to render that
	 * page.
	 */
	public function register() {
		// Register the submeu page.
		\fm_register_submenu_page(
			self::META_BOX_ID,
			'options-general.php',
			esc_html__( 'GTM Support', 'wpbaseplugin' )
		);

		// Render fields for the submenu page.
		\add_action(
			'fm_submenu_' . self::META_BOX_ID,
			[ $this, 'render_fields' ]
		);
	}

	/**
	 * Optional checks to conditional render this screen go here.
	 *
	 * @return True if the metabox can be registered, false otherwise.
	 */
	public function can_register() {
		return defined( 'FM_VERSION' );
	}

	/**
	 * Renders the Field Manager fields for the Site Alert.
	 *
	 * @return void
	 */
	public function render_fields() {
		$manager = new \Fieldmanager_Group(
			[
				'name'     => self::META_BOX_ID,
				'children' => [
					'container_id' => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Container ID', 'wpbaseplugin' ),
							'description'      => esc_html__( 'The container ID for GTM.', 'wpbaseplugin' ),
							'validation_rules' => [
								'required' => true,
							],
						]
					),
				],
			]
		);

		$manager->activate_submenu_page();
	}
}
