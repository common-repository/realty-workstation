<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://realtyworkstation.com/
 * @since             1.0.34
 * @package           Workstation
 *
 * @wordpress-plugin
 * Plugin Name:       Realty Workstation
 * Plugin URI:        http://realtyworkstation.com/
 * Description:       With Realty Workstation real estate brokers and team leaders can to process their agents’ transactions, archive all transaction related documentation and calculate commissions.
 * Version:           1.0.34
 * Author:            Realty Workstation
 * Author URI:        http://realtyworkstation.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       workstation
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.34 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WORKSTATION_VERSION', '1.0.34' );
$path_array  = wp_upload_dir();
$upload_url=$path_array['baseurl'];
$upload_dir=$path_array['basedir'];
define('workstation_DIR', plugin_dir_path( __FILE__ ) );
define('workstation_URI', plugin_dir_url( __FILE__ ) );
define('workstation_UPLOAD_URI', $upload_url);
define('workstation_UPLOAD_DIR', $upload_dir);


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-workstation-activator.php
 */
function activate_workstation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-workstation-activator.php';
	//Workstation_Activator::activate();

	$activate = new Workstation_Activator();
	$activate->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-workstation-deactivator.php
 */
function deactivate_workstation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-workstation-deactivator.php';
	Workstation_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_workstation' );
register_deactivation_hook( __FILE__, 'deactivate_workstation' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-workstation.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_workstation() {

	$plugin = new Workstation();
	$plugin->run();

}
run_workstation();
