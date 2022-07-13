<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://customer.singstravel.co.uk/
 * @since      1.0.0
 *
 * @package    Sings_Itinerary
 * @subpackage Sings_Itinerary/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sings_Itinerary
 * @subpackage Sings_Itinerary/includes
 * @author     Grzegorz Kubala <grzegorz.kubala@thetravelnetworkgroup.co.uk>
 */
class Sings_Itinerary_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sings-itinerary',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
