<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-public.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/public
 */

class Login_Flow_Public {

	/**
	 * Adding page class to body tag.
	 *
	 * @since  1.0.0
	 * @return array $classes Body class for plugin page.
	 */
	public function add_body_class() {

		$pages = array(
			'sign-in',
			'sign-up',
			'password-lost',
			'password-reset'
		);

		$classes = array();

		foreach ( $pages as $page => $class ) {
			if ( is_page( $page ) ) {
				$classes[] = $class;
			}
		}

		return $classes;

	}

}
