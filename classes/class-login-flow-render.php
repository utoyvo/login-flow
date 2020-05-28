<?php
/**
 * The render plugin pages ...
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-render.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Render {

	/**
	 * Renders the contents of the given template to a string and returns it.
	 *
	 * @param string $template_name The name of the template to render (without .php)
	 * @param array  $attr          The variables for the template
	 *
	 * @return string The contents of the template.
	 */
	private function get_template_html( $template_name, $attr = NULL ) {

		if ( is_array( $attr ) ) {
			extract( $attr );
		}

		ob_start();

		do_action( 'login_flow_before_' . $template_name );

		if ( file_exists( get_template_directory() . '/login-flow/' . $template_name . '.php' ) ) {
			require_once( get_template_directory() . '/login-flow/' . $template_name . '.php' );
		} else {
			require_once( LOGIN_FLOW_PLUGIN_DIR . '/templates/' . $template_name . '.php' );
		}

		do_action( 'login_flow_after_' . $template_name );

		$html = ob_get_contents();

		ob_end_clean();

		return $html;

	}

	/**
	 * A shortcode for rendering the login form.
	 *
	 * @param array  $attr    Shortcode attributes.
	 * @param string $content The text content for shortcode. Not used.
	 *
	 * @return string The shortcode output.
	 */
	public function render_sign_in_form( $attr, $content = NULL ) {

		if ( is_user_logged_in() ) {
			return '<p>' . __( 'You are already signed in.', 'login-flow' ) . '</p>';
		} else {
			$attr = [];

			$attr['redirect'] = '';
			if ( isset( $_REQUEST['redirect_to'] ) ) {
				$attr['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attr['redirect'] );
			}

			$attr['sign_out']           = isset( $_REQUEST['sign_out'] )   && $_REQUEST['sign_out']   == true;
			$attr['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';
			$attr['password_updated']   = isset( $_REQUEST['password'] )   && $_REQUEST['password']   == 'changed';

			$attr['errors'] = [];
			if ( isset( $_REQUEST['login'] ) ) {
				$error_codes = explode( ',', $_REQUEST['login'] );
				foreach ( $error_codes as $code ) {
					$attr['errors'][] = Login_Flow_Errors::get_error_message( $code );
				}
			}

			return $this->get_template_html( 'sign-in', $attr );
		}

	}

	/**
	 * A shortcode for rendering the new user registration form.
	 *
	 * @param array  $attr    Shortcode attributes.
	 * @param string $content The text content for shortcode. Not used.
	 *
	 * @return string The shortcode output.
	 */
	public function render_sign_up_form( $attr, $content = NULL ) {

		if ( ! get_option( 'users_can_register' ) ) {
			return '<p>' . __( 'Registering new users is currently not allowed.', 'login-flow' ) . '</p>';
		} elseif ( is_user_logged_in() ) {
			return '<p>' . __( 'You are already signed in.', 'login-flow' ) . '</p>';
		} else {
			$attr = [];

			$attr['registered'] = isset( $_REQUEST['registered'] );

			$attr['errors'] = [];
			if ( isset( $_REQUEST['errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['errors'] );
				foreach ( $error_codes as $error_code ) {
					$attr['errors'][] = Login_Flow_Errors::get_error_message( $error_code );
				}
			}

			return $this->get_template_html( 'sign-up', $attr );
		}

	}

	/**
	 * A shortcode for rendering the form used to initiate the password reset.
	 *
	 * @param array  $attr    Shortcode attributes.
	 * @param string $content The text content for shortcode. Not used.
	 *
	 * @return string The shortcode output.
	 */
	public function render_password_lost_form( $attr, $content = NULL ) {

		if ( is_user_logged_in() ) {
			return '<p>' . __( 'You are already signed in.', 'login-flow' ) . '</p>';
		} else {
			$attr = [];

			$attr['errors'] = [];
			if ( isset( $_REQUEST['errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['errors'] );
				foreach ( $error_codes as $error_code ) {
					$attr['errors'][] = Login_Flow_Errors::get_error_message( $error_code );
				}
			}

			return $this->get_template_html( 'password-lost', $attr );
		}

	}

	/**
	 * A shortcode for rendering the form used to reset a user's password.
	 *
	 * @param array  $attr    Shortcode attributes.
	 * @param string $content The text content for shortcode. Not used.
	 *
	 * @return string The shortcode output.
	 */
	public function render_password_reset_form( $attr, $content = NULL ) {

		if ( is_user_logged_in() ) {
			return '<p>' . __( 'You are already signed in.', 'login-flow' ) . '</p>';
		} else {
			if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
				$attr = [];

				$attr['login'] = $_REQUEST['login'];
				$attr['key']   = $_REQUEST['key'];

				$attr['errors'] = [];
				if ( isset( $_REQUEST['error'] ) ) {
					$error_codes = explode( ',', $_REQUEST['error'] );
					foreach ( $error_codes as $code ) {
						$attr['errors'][] = Login_Flow_Errors::get_error_message( $code );
					}
				}

				return $this->get_template_html( 'password-reset', $attr );
			} else {
				return '<p>' . __( 'Invalid password reset link.', 'login-flow' ) . '</p>';
			}
		}

	}

}
