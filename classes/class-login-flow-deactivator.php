<?php
/**
 * Fired during plugin deactivation.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-deactivator.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Deactivator {

	/**
	 * Plugin deactivation hook.
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {

		$pages = array(
			'sign-in',
			'sign-up',
			'password-lost',
			'password-reset'
		);

		foreach ( $pages as $page ) {
			wp_update_post( array(
				'ID'          => $page,
				'post_status' => 'draft',
			) );
		}

	}

}
