<?php
/**
 * Creates the options page logic for the WPBasePlugin.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Admin;

/**
 * A class to handle options page logic for the rules builder.
 */
class OptionsPage implements \WPBasePlugin\RegistrationInterface {
	/**
	 * Determines if the object should be registered.
	 *
	 * @return bool True if the object should be registered, false otherwise.
	 */
	public function can_register() {
		return is_admin();
	}

	/**
	 * Registration method for the object.
	 *
	 * @return void
	 */
	public function register() {

	}
}
