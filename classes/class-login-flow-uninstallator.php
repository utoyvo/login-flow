<?php
/**
 * Fired during plugin uninstallation.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-uninstallator.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Uninstaller {

	/**
	 * Plugin uninstallation hook.
	 *
	 * @since 1.0.0
	 */
	public static function uninstallate() {

		// Remove pages
		$pages = array(
			'sign-in',
			'sign-up',
			'password-lost',
			'password-reset'
		);

		foreach ( $pages as $page ) {
			wp_delete_post( $page, true );
		}

	}

}
