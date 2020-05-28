<?php
/**
 * Sign Up Form
 *
 * Relocated Registration Form from wp-login.php?action=register.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/templates/sign-up.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/templates
 */

?>

<div id="sign-up-form" class="">
	<?php if ( $registered ) : ?>
		<p class="">
			<?php
				printf(
					__( 'You have successfully registered to <strong>%s</strong>.', 'login-flow' ),
					get_bloginfo( 'name' )
				);
			?>
		</p>
	<?php endif; ?>

	<?php if ( count( $errors ) > 0 ) : ?>
		<?php foreach ( $errors as $error ) : ?>
			<p class=""><?php echo $error; ?></p>
		<?php endforeach; ?>
	<?php endif; ?>

	<form action="<?php echo wp_registration_url(); ?>" method="POST">
		<p class="">
			<label for="username"><?php _e( 'Username', 'login-flow' ); ?></label>
			<input id="username" class="" type="text" name="username" required>
		</p>

		<p class="">
			<label for="email"><?php _e( 'Email', 'login-flow' ); ?></label>
			<input id="email" class="" type="email" name="email" required>
		</p>

		<p class="">
			<label for="password"><?php _e( 'Password', 'login-flow' ); ?></label>
			<input id="password" class="" type="password" name="password" required>
		</p>

		<p class="">
			<label for="password-confirm"><?php _e( 'Confirm Password', 'login-flow' ); ?></label>
			<input id="password-confirm" class="" type="password" name="password-confirm" required>
		</p>

		<?php //if ( $recaptcha_site_key ) : ?>
			<!--<p class="recaptcha-container">
				<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
			</p>-->
		<?php //endif; ?>

		<p class="">
			<button id="" class="" type="submit"><?php _e( 'Sign Up', 'login-flow' ); ?></button>
		</p>
	</form>

	<p class="">
		<a class="" href="<?php echo wp_login_url(); ?>"><?php _e( 'Sign In', 'login-flow' ); ?></a>
	</p>
</div>
