<?php
/**
 * Plugin Name:  Login Flow
 * Plugin URI:   https://github.com/utoyvo/login-flow/
 * Description:  Just another login flow plugin.
 * Version:      1.0.0
 * Requires PHP: 7.2
 * Author:       Oleksandr Klochko
 * Author URI:   https://utoyvo.github.io
 * License:      GPLv3.0
 * License URI:  https://github.com/utoyvo/login-flow/blob/master/LICENSE
 * Text Domain:  login-flow
 * Domain Path:  /languages
 *
 * @package   Login_Flow
 * @link      https://github.com/utoyvo/login-flow
 * @author    Oleksandr Klochko <utoyvo@protonmail.com>
 * @copyright 2020
 * @license   GPLv3.0
 */

defined( 'ABSPATH' ) or die();

define( 'LOGIN_FLOW_VERSION', '1.0.0' );

define( 'LOGIN_FLOW_PLUGIN', __FILE__ );

define( 'LOGIN_FLOW_PLUGIN_BASENAME', plugin_basename( LOGIN_FLOW_PLUGIN ) );

define( 'LOGIN_FLOW_PLUGIN_NAME', trim( dirname( LOGIN_FLOW_PLUGIN_BASENAME ), '/' ) );

define( 'LOGIN_FLOW_PLUGIN_DIR', untrailingslashit( dirname( LOGIN_FLOW_PLUGIN ) ) );

/**
 * The code that runs during plugin activation.
 */
function activate_login_flow() {

	require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-activator.php';
	Login_Flow_Activator::activate();

}

register_activation_hook( LOGIN_FLOW_PLUGIN, 'activate_login_flow' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_login_flow() {

	require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-deactivator.php';
	Login_Flow_Deactivator::deactivate();

}

register_deactivation_hook( LOGIN_FLOW_PLUGIN, 'deactivate_login_flow' );

/**
 * The code that runs during plugin uninstallation.
 */
function uninstallate_login_flow() {

	require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow-uninstallator.php';
	Login_Flow_Uninstaller::uninstallate();

}

register_uninstall_hook( LOGIN_FLOW_PLUGIN, 'uninstallate_login_flow' );

/**
 * The core plugin class.
 */
require_once LOGIN_FLOW_PLUGIN_DIR . '/classes/class-login-flow.php';

/**
 * Begins execution of the plugin.
 */
function run_login_flow() {

	$plugin = new Login_Flow();
	$plugin->run();

}

run_login_flow();
