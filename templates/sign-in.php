<?php
/**
 * Sign In Form
 *
 * Relocated Login Form from login.php.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/templates/sign-in.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/templates
 */

?>

<div id="sign-in-form" class="">
	<?php if ( $sign_out ) : ?>
		<p class=""><?php _e( 'You have signed out. Would you like to sign in again?', 'login-flow' ); ?></p>
	<?php endif; ?>

	<?php if ( $lost_password_sent ) : ?>
		<p class=""><?php _e( 'Check your email for a link to reset your password.', 'login-flow' ); ?></p>
	<?php endif; ?>

	<?php if ( $password_updated ) : ?>
		<p class=""><?php _e( 'Your password has been changed. You can sign in now.', 'login-flow' ); ?></p>
	<?php endif; ?>

	<?php if ( count( $errors ) > 0 ) : ?>
		<?php foreach ( $errors as $error ) : ?>
			<p class=""><?php echo $error; ?></p>
		<?php endforeach; ?>
	<?php endif; ?>

	<form action="<?php echo wp_login_url(); ?>" method="POST">
		<p class="">
			<label for="user-login"><?php _e( 'Username or Email Address', 'login-flow' ); ?></label>
			<input id="user-login" class="" type="text" name="log" required>
		</p>

		<p class="">
			<label for="user-password"><?php _e( 'Password', 'login-flow' ); ?></label>
			<input id="user-password" class="" type="password" name="pwd" required>
		</p>

		<p class="">
			<input id="rememberme" type="checkbox" name="rememberme" value="forever" <?php checked( $rememberme ); ?>>
			<label for="rememberme"><?php _e( 'Remember Me', 'login-flow' ); ?></label>
		</p>

		<p class="">
			<button id="" class="" type="submit"><?php _e( 'Sign In', 'login-flow' ); ?></button>
		</p>
	</form>

	<p class="">
		<?php if ( get_option( 'users_can_register' ) ) : ?>
		<a class="" href="<?php echo wp_registration_url(); ?>"><?php _e( 'Sign Up', 'login-flow' ); ?></a>
		<span>|</span>
		<?php endif; ?>
		<a class="" href="<?php echo wp_lostpassword_url(); ?>"><?php _e( 'Lost your password?', 'login-flow' ); ?></a>
	</p>
</div>
