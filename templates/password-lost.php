<?php
/**
 * Password Lost Form
 *
 * Relocated Password Lost Form from wp-login.php?action=lostpassword
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/templates/password-lost.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/templates
 */

?>

<div id="password-lost-form" class="">
	<p class=""><?php _e( 'Enter your email address and we\'ll send you a link you can use to pick a new password.', 'login-flow' ); ?></p>

	<?php if ( count( $errors ) > 0 ) : ?>
		<?php foreach ( $errors as $error ) : ?>
			<p class=""><?php echo $error; ?></p>
		<?php endforeach; ?>
	<?php endif; ?>

	<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="POST">
		<p class="">
			<label for="user_login"><?php _e( 'Email', 'login-flow' ); ?>
			<input id="user_login" class="" type="email" name="user_login" required>
		</p>

		<p class="">
			<button class="lostpassword-button" type="submit" name="submit"><?php _e( 'Reset Password', 'login-flow' ); ?></button>
		</p>
	</form>
</div>
