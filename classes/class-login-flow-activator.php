<?php
/**
 * Fired during plugin activation.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow-activator.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

class Login_Flow_Activator {

	/**
	 * Plugin activation hook.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {

		// Create pages
		$pages = array(
			'sign-in' => array(
				'title'   => __( 'Sign In', 'login-flow' ),
				'content' => '[sign-in-form]'
			),

			'sign-up' => array(
				'title'   => __( 'Sign Up', 'login-flow' ),
				'content' => '[sign-up-form]'
			),

			'password-lost' => array(
				'title'   => __( 'Lost Your Password?', 'login-flow' ),
				'content' => '[password-lost-form]'
			),

			'password-reset' => array(
				'title'   => __( 'Pick a New Password', 'login-flow' ),
				'content' => '[password-reset-form]'
			)
		);

		foreach ( $pages as $slug => $page ) {
			$query = new WP_Query( 'pagename=' . $slug );
			if ( ! $query->have_posts() ) {
				$page_id = wp_insert_post( array(
					'post_content'   => $page['content'],
					'post_name'      => $slug,
					'post_title'     => $page['title'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'ping_status'    => 'closed',
					'comment_status' => 'closed'
				) );
			} else {
				if ( $page = get_page_by_path( $slug, OBJECT, 'page' ) ) {
					$page_id = $page->ID;
				} else {
					$page_id = 0;
				}

				wp_update_post( array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				) );
			}
		}

	}

}
