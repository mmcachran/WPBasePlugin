<?php
/**
 * An interface for registration objects to implement.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin;

/**
 * Interface for registration objects to implement.
 */
interface RegistrationInterface {
	/**
	 * Determines if the object should be registered.
	 *
	 * @return bool True if the object should be registered, false otherwise.
	 */
	public function can_register();

	/**
	 * Registration method for the object.
	 *
	 * @return void
	 */
	public function register();
}
