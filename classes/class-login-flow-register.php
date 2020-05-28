<?php
/**
 * Registeren new user ...
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-register.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Register {

	/**
	 * Validates and then completes the new user sign up process if all went well.
	 *
	 * @param string $username The new user's username.
	 * @param string $email    The new user's email.
	 * @param array  $password The new user's password. Primary and confirm.
	 *
	 * @return int|WP_Error The id of the user that was created, or error if failed.
	 */
	private function register_user( $username, $email, $password ) {

		$errors = new WP_Error();

		// Username verification
		if ( username_exists( $username ) ) {
			$errors->add( 'username_exists', Login_Flow_Errors::get_error_message( 'username_exists' ) );
			return $errors;
		}

		// Email verification
		if ( ! is_email( $email ) ) {
			$errors->add( 'email', Login_Flow_Errors::get_error_message( 'email' ) );
			return $errors;
		} elseif ( email_exists( $email ) ) {
			$errors->add( 'email_exists', Login_Flow_Errors::get_error_message( 'email_exists' ) );
			return $errors;
		}

		// Password verification
		if ( $password['primary'] !== $password['confirm'] ) {
			$errors->add( 'password_reset_mismatch', Login_Flow_Errors::get_error_message( 'password_reset_mismatch' ) );
			return $errors;
		}

		// Insert user
		$user_id = wp_insert_user( array(
			'user_login' => $username,
			'user_email' => $email,
			'user_pass'  => $password['primary'],
		) );

		wp_new_user_notification( $user_id, $password );

		return $user_id;

	}

	/**
	 * Handles the registration of a new user.
	 *
	 * Used through the action hook "login_form_register" activated on wp-login.php
	 * when accessed through the registration action.
	 */
	public function do_register_user() {

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$redirect_url = home_url( 'sign-up' );

			if ( ! get_option( 'users_can_register' ) ) {
				$redirect_url = add_query_arg( 'errors', 'closed', $redirect_url );
			} else {
				$username = sanitize_user( $_POST['username'] );
				$email    = sanitize_email( $_POST['email'] );
				$password = array(
					'primary' => sanitize_text_field( $_POST['password'] ),
					'confirm' => sanitize_text_field( $_POST['password-confirm'] ),
				);

				$result = $this->register_user( $username, $email, $password );

				if ( is_wp_error( $result ) ) {
					$errors = join( ',', $result->get_error_codes() );
					$redirect_url = add_query_arg( 'errors', $errors, $redirect_url );
				} else {
					$redirect_url = home_url( 'sign-in' );
					$redirect_url = add_query_arg( 'registered', $username, $redirect_url );
				}
			}

			wp_redirect( $redirect_url );
			exit;
		}

	}

}
