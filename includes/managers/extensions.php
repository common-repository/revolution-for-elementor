<?php
namespace RevolutionForElementor\Managers;

use RevolutionForElementor\Base\Extension_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Extensions_Manager {

	private $_extensions = null;

	public $available_extensions = [];

	/**
	 * Loops though available extensions and registers them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function register_extensions() {

		$this->_extensions = [];

		$available_extensions = $this->available_extensions;

		foreach ( $available_extensions as $index => $extension_id ) {
			$extension_filename = str_replace( '_', '-', $extension_id );
			$extension_name = str_replace( '-', '_', $extension_id );

			$extension_filename = REVOLUTION_FOR_ELEMENTOR_PATH . "includes/extensions/{$extension_filename}.php";

			require( $extension_filename );

			$class_name = str_replace( '-', '_', $extension_id );

			$class_name = 'RevolutionForElementor\Extensions\\' . ucwords( $class_name );

			if ( ! $this->is_available( $extension_name ) )
				unset( $this->available_extensions[ $index ] );

			// Skip extension if it's disabled in admin settings or is dependant on non-exisiting Elementor Pro plugin
			if ( $this->is_disabled( $extension_name ) ) {
				continue;
			}

			$this->register_extension( $extension_id, new $class_name() );
		}

		do_action( 'jt_revolution_for_elementor/extensions/extensions_registered', $this );
	}

	/**
	 * Check if extension is disabled through admin settings
	 *
	 * @since 1.8.0
	 *
	 * @access public
	 * @return bool
	 */
	public function is_disabled( $extension_name ) {
		if ( ! $extension_name )
			return false;

		$option_name 	= 'enable_' . $extension_name;
		$section 		= 'jt_revolution_for_elementor_extensions';
		$option 		= \RevolutionForElementor\Plugin::instance()->settings->get_option( $option_name, $section, false );

		if ( 'off' === $option ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if extension is available at all
	 *
	 * @since 1.8.0
	 *
	 * @access public
	 * @return bool
	 */
	public function is_available( $extension_name ) {
		if ( ! $extension_name )
			return false;

		$class_name = str_replace( '-', '_', $extension_name );
		$class_name = 'RevolutionForElementor\Extensions\\' . ucwords( $class_name );

		if ( $class_name::requires_elementor_pro() && ! rfe_is_elementor_pro_active() )
			return false;

		return true;
	}

	/**
	 * @since 1.0.0
	 *
	 * @param $extension_id
	 * @param Extension_Base $extension_instance
	 */
	public function register_extension( $extension_id, \RevolutionForElementor\Base\Extension_Base $extension_instance ) {
		$this->_extensions[ $extension_id ] = $extension_instance;
	}

	/**
	 * @since 1.0.0
	 *
	 * @param $extension_id
	 * @return bool
	 */
	public function unregister_extension( $extension_id ) {
		if ( ! isset( $this->_extensions[ $extension_id ] ) ) {
			return false;
		}

		unset( $this->_extensions[ $extension_id ] );

		return true;
	}

	/**
	 * @since 1.0.0
	 *
	 * @return Extension_Base[]
	 */
	public function get_extensions() {
		if ( null === $this->_extensions ) {
			$this->register_extensions();
		}

		return $this->_extensions;
	}

	/**
	 * @since 1.0.0
	 *
	 * @param $extension_id
	 * @return bool|\RevolutionForElementor\Extension_Base
	 */
	public function get_extension( $extension_id ) {
		$extensions = $this->get_extensions();

		return isset( $extensions[ $extension_id ] ) ? $extensions[ $extension_id ] : false;
	}

	private function require_files() {
		require( REVOLUTION_FOR_ELEMENTOR_PATH . 'includes/base/extension.php' );
	}

	public function __construct() {
        
        $this->available_extensions[] = 'particles';
        $this->available_extensions[] = 'flex-columns';

		$this->require_files();
		$this->register_extensions();
	}
}
