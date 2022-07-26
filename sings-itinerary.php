<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kubalock/sings-itinerary
 * @since             0.0.2
 * @package           Sings_Itinerary
 *
 * @wordpress-plugin
 * Plugin Name:       Sings Itinerary
 * Plugin URI:        https://github.com/kubalock/sings-itinerary
 * Description:       This plugin allows your customers to enter their booking references with password in order to see their Itineraries
 * Version:           0.0.2
 * Author:            Grzegorz Kubala
 * Author URI:
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Sings Itinerary
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
define( 'SINGS_ITINERARY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sings-itinerary-activator.php
 */
function activate_sings_itinerary() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sings-itinerary-activator.php';
	Sings_Itinerary_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sings-itinerary-deactivator.php
 */
function deactivate_sings_itinerary() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sings-itinerary-deactivator.php';
	Sings_Itinerary_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sings_itinerary' );
register_deactivation_hook( __FILE__, 'deactivate_sings_itinerary' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sings-itinerary.php';

/**
 * Include our updater below - it'll enable updating from Git
 */

if( ! class_exists( 'Sings_Updater' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'update.php' );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

$updater = new Sings_Updater( __FILE__ );
$updater->set_username( 'kubalock' );
$updater->set_repository( 'sings-itinerary' );
$updater->initialize(); // initialize the updater

function run_sings_itinerary() {

	$plugin = new Sings_Itinerary();
	$plugin->run();

}
run_sings_itinerary();

