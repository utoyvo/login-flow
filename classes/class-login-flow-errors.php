<?php
/**
 * Error messages for plugin.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-errors.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Errors {

	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code The error code to look up.
	 *
	 * @return string An error message.
	 */
	static function get_error_message( $error_code ) {

		switch ( $error_code ) {
			case 'empty_username' :
				return __( 'You do have an email address, right?', 'login-flow' );

			case 'empty_password' :
				return __( 'You need to enter a password to login.', 'login-flow' );

			case 'invalid_username' :
				return __( 'We don\'t have any users with that username or email address. Maybe you used a different one when signing up?', 'login-flow' );

			case 'incorrect_password' :
				return sprintf(
					__( 'The password you entered wasn\'t quite right. <a href="%s">Did you forget your password</a>?', 'login-flow' ),
					wp_lostpassword_url()
				);

			case 'confirm_password' :
				return __( 'Passwords doesn\'t match', 'login-flow' );

			case 'email' :
				return __( 'The email address you entered is not valid.', 'login-flow' );

			case 'email_exists' :
				return __( 'An account exists with this email address.', 'login-flow' );

			case 'username_exists' :
				return __( 'An account exists with this username.', 'login-flow' );

			case 'closed' :
				return __( 'Registering new users is currently not allowed.', 'login-flow' );

			case 'invalid_email' :
			case 'invalidcombo' :
				return __( 'There are no users registered with this email address.', 'login-flow' );

			case 'expiredkey' :
			case 'invalidkey' :
				return __( 'The password reset link you used is not valid anymore.', 'login-flow' );

			case 'password_reset_mismatch' :
				return __( 'The two passwords you entered don\'t match.', 'login-flow' );

			case 'password_reset_empty' :
				return __( 'Sorry, we don\'t accept empty passwords.', 'login-flow' );

			default:
				break;
		}

		return __( 'An unknown error occurred. Please try again later.', 'login-flow' );
	}

}
