<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/admin/class-login-flow-admin.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/admin
 */

class Login_Flow_Admin {

	/**
	 * Registered plugin setting submenu page for options-general.php.
	 *
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
	 */
	public function register_login_flow_settings_submenu_page() {

		add_submenu_page(
			'options-general.php',
			__( 'Login Settings', 'user-flow' ),
			__( 'Login', 'user-flow' ),
			'manage_options',
			'login-flow-settings',
			array( $this, 'login_flow_settings_submenu_page_callback' ),
			3
		);

	}

	/**
	 * Settings submenu callback.
	 *
	 * @since 1.0.0
	 */
	public function login_flow_settings_submenu_page_callback() {

		require_once LOGIN_FLOW_PLUGIN_DIR . '/admin/partials/login-flow-admin-display.php';

	}

	/**
	 * Add page state to the plugin pages ...
	 *
	 * @since 1.0.0
	 * @param string $post_states ...
	 * @param object $post        ...
	 *
	 * @return string $post_states ...
	 */
	public function add_page_state( $post_states, $post ) {

		if ( $post->ID == get_option( 'login-flow-sign-in-page' ) ) {
			$post_states[] = __( 'Authorization Page', 'login-flow' );
		}

		if ( $post->ID == get_option( 'login-flow-sign-up-page' ) ) {
			$post_states[] = __( 'Registration Page', 'login-flow' );
		}

		if ( $post->ID == get_option( 'login-flow-password-lost-page' ) ) {
			$post_states[] = __( 'Password Lost Page', 'login-flow' );
		}

		if ( $post->ID == get_option( 'login-flow-password-reset-page' ) ) {
			$post_states[] = __( 'Password Reset Page', 'login-flow' );
		}

		return $post_states;

	}

}
