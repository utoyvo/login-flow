<?php
/**
 * Define the internationalization functionality.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-i18n.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'login-flow',
			false,
			LOGIN_FLOW_PLUGIN_BASENAME . '/languages/'
		);

	}

}
