<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bitwiseacademy.com/
 * @since             1.0.0
 * @package           Bitwise_Sidebar_Content
 *
 * @wordpress-plugin
 * Plugin Name:       Bitwise Sidebar Content
 * Plugin URI:        https://bitwiseacademy.com/
 * Description:       Show sidebar tabs on topic page to show videos, notes and help content.
 * Version:           1.0.0
 * Author:            Bitwise
 * Author URI:        https://bitwiseacademy.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bitwise-sidebar-content
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BITWISE_SIDEBAR_CONTENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bitwise-sidebar-content-activator.php
 */
function activate_bitwise_sidebar_content() {
	require_once __DIR__ . '/includes/class-bitwise-sidebar-content-activator.php';
	Bitwise_Sidebar_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bitwise-sidebar-content-deactivator.php
 */
function deactivate_bitwise_sidebar_content() {
	require_once __DIR__ . '/includes/class-bitwise-sidebar-content-deactivator.php';
	Bitwise_Sidebar_Content_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bitwise_sidebar_content' );
register_deactivation_hook( __FILE__, 'deactivate_bitwise_sidebar_content' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require __DIR__ . '/includes/class-bitwise-sidebar-content.php';

function bitscr_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'bitscr_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}