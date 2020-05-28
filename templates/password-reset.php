<?php
/**
 * Password Reset Form
 *
 * Lorem ipsum...
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/templates/password-reset.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/templates
 */

?>

<div id="password-reset-form" class="">
	<form id="resetpassform" name="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="POST" autocomplete="off">
		<input id="user_login" type="hidden" name="rp_login" value="<?php echo esc_attr( $login ); ?>" autocomplete="off">
		<input id="user_key" type="hidden" name="rp_key" value="<?php echo esc_attr( $key ); ?>">

		<?php if ( count( $errors ) > 0 ) : ?>
			<?php foreach ( $errors as $error ) : ?>
				<p class=""><?php echo $error; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>

		<p class="">
			<label for="pass1"><?php _e( 'New password', 'login-flow' ) ?></label>
			<input id="pass1" class="" type="password" name="pass1" size="20" autocomplete="off">
		</p>

		<p class="">
			<label for="pass2"><?php _e( 'Repeat new password', 'login-flow' ) ?></label>
			<input id="pass2" class="" type="password" name="pass2" size="20" autocomplete="off">
		</p>

		<p class=""><?php echo wp_get_password_hint(); ?></p>

		<p class="">
			<button id="resetpass-button" class="" type="submit" name="submit"><?php _e( 'Reset Password', 'login-flow' ); ?></button>
		</p>
	</form>
</div>
