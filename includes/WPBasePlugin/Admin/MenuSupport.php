<?php
/**
 * Adds menu support for plugin.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Admin;

/**
 * Class for adding menu support.
 */
class MenuSupport implements \WPBasePlugin\RegistrationInterface {
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
