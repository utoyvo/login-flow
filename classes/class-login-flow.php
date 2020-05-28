<?php
/**
 * The file that defines the core plugin class.
 *
 * @link       https://github.com/utoyvo/login-flow/blob/master/classes/class-login-flow.php
 * @since      1.0.0
 * @author     Oleksandr Klochko <utoyvo@protonmail.com>
 *
 * @package    Login_Flow
 * @subpackage Login_Flow/classes
 */

if ( ! class_exists( 'Login_Flow' ) ) {

	class Login_Flow {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
		 *
		 * @since  1.0.0
		 * @access protected
		 * @var    Login_Flow_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of plugin.
		 *
		 * @since  1.0.0
		 * @access protected
		 * @var    string    $plugin_name The string used to uniquely identify plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since  1.0.0
		 * @access protected
		 * @var    string    $version The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			if ( defined( 'LOGIN_FLOW_VERSION' ) ) {
				$this->version = LOGIN_FLOW_VERSION;
			} else {
				$this->version = '1.0.0';
			}

			$this->plugin_name = LOGIN_FLOW_PLUGIN_NAME;

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
			$this->errors();
			$this->redirects();
			$this->render();
			$this->register();
			$this->reset_password();

		}

		/**
		 * Load the required dependencies for plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Login_Flow_Loader.         Orchestrates the hooks of the plugin.
		 * - Login_Flow_i18n.           Defines internationalization functionality.
		 * - Login_Flow_Admin.          Defines all hooks for the admin area.
		 * - Login_Flow_Public.         Defines all hooks for the public side of the site.
		 * - Login_Flow_Errors.         ...
		 * - Login_Flow_Redirects.      Redirects the user to the custom wp-login pages.
		 * - Login_Flow_Render.         Render all plugin pages.
		 * - Login_Flow_Register.       ...
		 * - Login_Flow_Reset_Password. ...
		 *
		 * Create an instance of the loader which will be used to register the hooks with WordPress.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the core plugin.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-loader.php';

			/**
			 * The class responsible for defining internationalization functionality of the plugin.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/admin/class-login-flow-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing side of the site.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/public/class-login-flow-public.php';

			/**
			 * The class responsible for error messages.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-errors.php';

			/**
			 * The class responsible for redirects the user to the custom wp-login pages.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-redirects.php';

			/**
			 * The class responsible for render all plugin pages.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-render.php';

			/**
			 * The class responsible for user registration.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-register.php';

			/**
			 * The class responsible for resetting password.
			 */
			require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-reset-password.php';

			$this->loader = new Login_Flow_Loader();

		}

		/**
		 * Define the locale for plugin for internationalization.
		 *
		 * Uses the Login_Flow_i18n class in order to set the domain and to register the hook with WordPress.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function set_locale() {

			$plugin_i18n = new Login_Flow_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		 * Register all of the hooks related to the admin area functionality of the plugin.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function define_admin_hooks() {

			$plugin_admin = new Login_Flow_Admin();

			$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_login_flow_settings_submenu_page' );

			$this->loader->add_filter( 'display_post_states', $plugin_admin, 'add_page_state', 10, 2 );

		}

		/**
		 * Register all of the hooks related to the public-facing functionality of the plugin.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function define_public_hooks() {

			$plugin_public = new Login_Flow_Public();

			$this->loader->add_filter( 'body_class', $plugin_public, 'add_body_class' );

		}

		/**
		 * Errors ...
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function errors() {

			$plugin_errors = new Login_Flow_Errors();

		}

		/**
		 * Redirects the user to the custom wp-login pages.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function redirects() {

			$plugin_redirects = new Login_Flow_Redirects();

			$this->loader->add_action( 'login_form_login',        $plugin_redirects, 'redirect_to_sign_in' );
			$this->loader->add_action( 'login_form_register',     $plugin_redirects, 'redirect_to_sign_up' );
			$this->loader->add_action( 'wp_logout',               $plugin_redirects, 'redirect_after_sign_out' );
			$this->loader->add_action( 'login_form_lostpassword', $plugin_redirects, 'redirect_to_password_lost' );
			$this->loader->add_action( 'login_form_rp',           $plugin_redirects, 'redirect_to_password_reset' );
			$this->loader->add_action( 'login_form_resetpass',    $plugin_redirects, 'redirect_to_password_reset' );

			$this->loader->add_filter( 'login_redirect', $plugin_redirects, 'redirect_after_sign_in',   10,  3 );
			$this->loader->add_filter( 'authenticate',   $plugin_redirects, 'redirect_at_authenticate', 101, 3 );

		}

		/**
		 * Render all plugin pages.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function render() {

			$plugin_render = new Login_Flow_Render();

			$this->loader->add_shortcode( 'sign-in-form',        $plugin_render, 'render_sign_in_form' );
			$this->loader->add_shortcode( 'sign-up-form',        $plugin_render, 'render_sign_up_form' );
			$this->loader->add_shortcode( 'password-lost-form',  $plugin_render, 'render_password_lost_form' );
			$this->loader->add_shortcode( 'password-reset-form', $plugin_render, 'render_password_reset_form' );

		}

		/**
		 * Register ...
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function register() {

			$plugin_register = new Login_Flow_Register();

			$this->loader->add_action( 'login_form_register', $plugin_register, 'do_register_user' );

		}

		/**
		 * Reset Password ...
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function reset_password() {

			$plugin_reset_password = new Login_Flow_Reset_Password();

			$this->loader->add_action( 'login_form_lostpassword', $plugin_reset_password, 'do_password_lost' );
			$this->loader->add_action( 'login_form_rp',           $plugin_reset_password, 'do_password_reset' );
			$this->loader->add_action( 'login_form_resetpass',    $plugin_reset_password, 'do_password_reset' );

			$this->loader->add_filter( 'retrieve_password_message', $plugin_reset_password, 'replace_retrieve_password_message', 10, 4 );

		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function run() {

			$this->loader->run();

		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since  1.0.0
		 * @return string The name of the plugin.
		 */
		public function get_plugin_name() {

			return $this->plugin_name;

		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since  1.0.0
		 * @return Login_Flow_Loader Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {

			return $this->loader;

		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since  1.0.0
		 * @return string The version number of the plugin.
		 */
		public function get_version() {

			return $this->version;

		}

	}

}
