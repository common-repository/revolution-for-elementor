<?php

namespace RevolutionForElementor;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.janthielemann.de
 * @since      1.0.0
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/public
 * @author     Jan Thielemann <contact@janthielemann.de>
 */
class Jt_Revolution_For_Elementor_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jt_Revolution_For_Elementor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jt_Revolution_For_Elementor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jt_Revolution_For_Elementor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jt_Revolution_For_Elementor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script( 'particle', plugin_dir_url( __FILE__ ) . 'js/particles.min.js', array(), '2.0.0', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
		



		// wp_register_script( 'my-script', 'myscript_url' );
		// wp_enqueue_script( 'my-script' );
		$translation_array = array( 'template_url' => plugin_dir_url( __FILE__ ) ); //get_stylesheet_directory_uri()
		//after wp_enqueue_script
		wp_localize_script( $this->plugin_name, 'object_name', $translation_array );



	}

}
