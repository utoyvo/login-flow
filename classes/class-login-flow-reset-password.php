<?php
/**
 * Password Reset ...
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-reset-password.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Reset_Password {

	/**
	 * Initiates password reset.
	 */
	public function do_password_lost() {

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$errors = retrieve_password();
			if ( is_wp_error( $errors ) ) {
				$password_lost_slug = get_post_field( 'post_name', get_option( 'login-flow-password-lost-page' ) );

				$redirect_url = home_url( $password_lost_slug );
				$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
			} else {
				$sign_in_slug = get_post_field( 'post_name', get_option( 'login-flow-sign-in-page' ) );

				$redirect_url = home_url( $sign_in_slug );
				$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
			}

			wp_redirect( $redirect_url );

			exit;
		}

	}

	/**
	 * Resets the user's password if the password reset form was submitted.
	 */
	public function do_password_reset() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$rp_key   = $_REQUEST['rp_key'];
			$rp_login = $_REQUEST['rp_login'];

			$user = check_password_reset_key( $rp_key, $rp_login );

			if ( ! $user || is_wp_error( $user ) ) {
				$sign_in_slug = get_post_field( 'post_name', get_option( 'login-flow-sign-in-page' ) );

				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( $sign_in_slug . '?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( $sign_in_slug . '?login=invalidkey' ) );
				}

				exit;
			}

			if ( isset( $_POST['pass1'] ) ) {
				if ( $_POST['pass1'] != $_POST['pass2'] ) {
					// Passwords don't match
					$password_reset_slug = get_post_field( 'post_name', get_option( 'login-flow-password-reset-page' ) );

					$redirect_url = home_url( $password_reset_slug );
					$redirect_url = add_query_arg( 'key',    $rp_key,                  $redirect_url );
					$redirect_url = add_query_arg( 'login',  $rp_login,                $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

					wp_redirect( $redirect_url );

					exit;
				}

				if ( empty( $_POST['pass1'] ) ) {
					// Password is empty
					$redirect_url = home_url( 'password-reset' );

					$redirect_url = add_query_arg( 'key',   $rp_key,                $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login,              $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

					wp_redirect( $redirect_url );

					exit;
				}

				// Parameter checks OK, reset password
				reset_password( $user, $_POST['pass1'] );

				wp_redirect( home_url( 'sign-in?password=changed' ) );
			} else {
				echo 'Invalid request :(';
			}

			exit;
		}
	}

	/**
	 * Returns the message body for the password reset email.
	 * Called through the retrieve_password_message filter.
	 *
	 * @param string  $message    Default email message.
	 * @param string  $key        The activation key.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user_data  WP_User object.
	 *
	 * @return string The email message to send.
	 */
	public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {

		// Create new message
		$msg  = __( 'Hello!', 'login-flow' );
		$msg .= "\r\n\r\n";
		$msg .= sprintf(
			__( 'You asked us to reset your password for your account using the email address %s.', 'login-flow' ),
			$user_login
		);
		$msg .= "\r\n\r\n";
		$msg .= __( 'If this was a mistake, or you didn\'t ask for a password reset, just ignore this email and nothing will happen.', 'login-flow' );
		$msg .= "\r\n\r\n";
		$msg .= __( 'To reset your password, visit the following address:', 'login-flow' );
		$msg .= "\r\n\r\n";
		$msg .= site_url( 'wp-login.php?action=rp&key=' . $key . '&login=' . rawurlencode( $user_login ), 'login' );
		$msg .= "\r\n\r\n";
		$msg .= __( 'Thanks!', 'login-flow' );
		$msg .= "\r\n";

		return $msg;

	}

}
