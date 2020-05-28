<?php
/**
 * Redirects the user to the custom wp-login pages.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-redirects.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Redirects {

	/**
	 * Redirect the user to the custom login page instead of wp-login.php.
	 */
	public function redirect_to_sign_in() {

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			$redirect_to = $_REQUEST['redirect_to'] ?? NULL;

			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user( $redirect_to );

				exit;
			}

			$sign_in_slug = get_post_field( 'post_name', 'sign-in' );
			$login_url    = home_url( $sign_in_slug );

			if ( ! empty( $redirect_to ) ) {
				$login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
			}

			wp_redirect( $login_url );

			exit;
		}

	}

	/**
	 * Redirects the user to the custom registration page instead of wp-login.php?action=register.
	 */
	public function redirect_to_sign_up() {

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
			} else {
				$sign_up_slug = get_post_field( 'post_name', 'sign-up' );

				wp_redirect( home_url( $sign_up_slug ) );
			}

			exit;
		}

	}

	/**
	 * Redirects the user to the custom "Lost Your Password?" page instead of wp-login.php?action=lostpassword.
	 */
	public function redirect_to_password_lost() {

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();

				exit;
			}

			$password_lost_slug = get_post_field( 'post_name', 'password-lost' );

			wp_redirect( home_url( $password_lost_slug ) );

			exit;
		}

	}

	/**
	 * Redirects to the custom password reset page, or the login page if there are errors.
	 */
	public function redirect_to_password_reset() {

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );

			if ( ! $user || is_wp_error( $user ) ) {
				$sign_in_slug = get_post_field( 'post_name', 'sign-in' );

				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( $sign_in_slug . '?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( $sign_in_slug . '?login=invalidkey' ) );
				}

				exit;
			}

			$password_reset_slug = get_post_field( 'post_name', 'password-lost' );

			$redirect_url = home_url( $password_reset_slug );
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
			 
			wp_redirect( $redirect_url );

			exit;
		}

	}

	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string Redirect URL
	 */
	public function redirect_after_sign_in( $redirect_to, $requested_redirect_to, $user ) {

		$redirect_url = home_url();

		if ( ! isset( $user->ID ) ) {
			return $redirect_url;
		}

		if ( user_can( $user, 'manage_options' ) ) {
			if ( $requested_redirect_to == '' ) {
				$redirect_url = admin_url();
			} else {
				$redirect_url = $requested_redirect_to;
			}
		} else {
			$redirect_url = home_url( '/' );
		}

		return wp_validate_redirect( $redirect_url, home_url() );

	}

	/**
	 * Redirect to custom login page after the user has been logged out.
	 */
	public function redirect_after_sign_out() {

		$sign_in_slug = get_post_field( 'post_name', 'sign-in' );
		$redirect_url = home_url( $sign_in_slug . '?sign_out=true' );

		wp_safe_redirect( $redirect_url );

		exit;

	}

	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 * @param Wp_User|Wp_Error  $user     The signed in user, or the errors that have occurred during login.
	 * @param string            $username The user name used to log in.
	 * @param string            $password The password used to log in.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	public function redirect_at_authenticate( $user, $username, $password ) {

		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( is_wp_error( $user ) ) {
				$error_codes = join( ',', $user->get_error_codes() );

				$sign_in_slug = get_post_field( 'post_name', 'sign-in' );

				$login_url = home_url( $sign_in_slug );
				$login_url = add_query_arg( 'login', $error_codes, $login_url );

				wp_redirect( $login_url );

				exit;
			}
		}

		return $user;

	}

	/**
	 * Redirects the user to the correct page depending on whether user is an admin or not.
	 *
	 * @param string $redirect_to An optional redirect_to URL for admin users.
	 */
	private function redirect_logged_in_user( $redirect_to = NULL ) {

		$user = wp_get_current_user();

		if ( user_can( $user, 'manage_options' ) ) {
			if ( $redirect_to ) {
				wp_safe_redirect( $redirect_to );
			} else {
				wp_redirect( admin_url() );
			}
		} else {
			wp_redirect( home_url( '/' ) );
		}

	}

}
