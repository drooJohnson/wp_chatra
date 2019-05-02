<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.droojohnson.com/
 * @since             1.0.0
 * @package           Wp_Chatra
 *
 * @wordpress-plugin
 * Plugin Name:       WP Chatra
 * Plugin URI:        http://www.droojohnson.com/wp-chatra/
 * Description:       Integrates Chatra live-chat widget on all public-facing pages.
 * Version:           1.0.0
 * Author:            Andrew Johnson
 * Author URI:        http://www.droojohnson.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-chatra
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
define( 'WP_CHATRA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-chatra-activator.php
 */
function activate_wp_chatra() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-chatra-activator.php';
	Wp_Chatra_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-chatra-deactivator.php
 */
function deactivate_wp_chatra() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-chatra-deactivator.php';
	Wp_Chatra_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_chatra' );
register_deactivation_hook( __FILE__, 'deactivate_wp_chatra' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-chatra.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_chatra() {

	$plugin = new Wp_Chatra();
	$plugin->run();

}
run_wp_chatra();
