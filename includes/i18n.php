<?php

namespace RevolutionForElementor;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.janthielemann.de
 * @since      1.0.0
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/includes
 * @author     Jan Thielemann <contact@janthielemann.de>
 */
class Jt_Revolution_For_Elementor_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'revolution-for-elementor',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
