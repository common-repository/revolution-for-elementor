<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.revolution-for-elementor.com
 * @since             1.0.0
 * @package           Jt_Revolution_For_Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Revolution for Elementor
 * Plugin URI:        www.revolution-for-elementor.com
 * Description:       Revolution for Elementor adds new features and widgets for Elementor and Elementor Pro.
 * Version:           0.0.19
 * Author:            Jan Thielemann
 * Author URI:        www.janthielemann.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       revolution-for-elementor
 * Domain Path:       /languages
 *
 * @fs_premium_only /includes/widgets/dynamic-template.php, /includes/widgets/taxonomy-related.php
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !function_exists( 'jt_revolution_for_elementor' ) ) {
    // Exit if accessed directly
    define( 'REVOLUTION_FOR_ELEMENTOR_VERSION', '1.0.0' );
    define( 'REVOLUTION_FOR_ELEMENTOR__FILE__', __FILE__ );
    define( 'REVOLUTION_FOR_ELEMENTOR_PLUGIN_BASE', plugin_basename( REVOLUTION_FOR_ELEMENTOR__FILE__ ) );
    define( 'REVOLUTION_FOR_ELEMENTOR_URL', plugins_url( '/', REVOLUTION_FOR_ELEMENTOR__FILE__ ) );
    define( 'REVOLUTION_FOR_ELEMENTOR_PATH', plugin_dir_path( REVOLUTION_FOR_ELEMENTOR__FILE__ ) );
    define( 'REVOLUTION_FOR_ELEMENTOR_ASSETS_URL', REVOLUTION_FOR_ELEMENTOR_URL . 'assets/' );
    define( 'REVOLUTION_FOR_ELEMENTOR_ELEMENTOR_VERSION_REQUIRED', '1.8.0' );
    define( 'REVOLUTION_FOR_ELEMENTOR_ELEMENTOR_PRO_VERSION_REQUIRED', '1.6.0' );
    define( 'REVOLUTION_FOR_ELEMENTOR_PHP_VERSION_REQUIRED', '5.0' );
    define( 'REVOLUTION_FOR_ELEMENTOR_PHP_VERSION_RECOMMENDED', '7.0' );
    // If this file is called directly, abort.
    if ( !defined( 'WPINC' ) ) {
        die;
    }
    
    if ( !function_exists( 'jt_revolution_for_elementor' ) ) {
        // Create a helper function for easy SDK access.
        function jt_revolution_for_elementor()
        {
            global  $jt_revolution_for_elementor ;
            
            if ( !isset( $jt_revolution_for_elementor ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/includes/freemius/start.php';
                $jt_revolution_for_elementor = fs_dynamic_init( array(
                    'id'              => '1772',
                    'slug'            => 'revolution-for-elementor',
                    'type'            => 'plugin',
                    'public_key'      => 'pk_c68e688f5c42fe80dec0fbdd84ba8',
                    'is_premium'      => false,
                    'has_addons'      => false,
                    'has_paid_plans'  => true,
                    'has_affiliation' => 'all',
                    'menu'            => array(
                    'slug' => 'revolution-for-elementor',
                ),
                    'is_live'         => true,
                ) );
            }
            
            return $jt_revolution_for_elementor;
        }
        
        // Init Freemius.
        jt_revolution_for_elementor();
        // Signal that SDK was initiated.
        do_action( 'jt_revolution_for_elementor_loaded' );
    }
    
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/activator.php
     */
    
    if ( !function_exists( 'activate_jt_revolution_for_elementor' ) ) {
        function activate_jt_revolution_for_elementor()
        {
            require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';
            RevolutionForElementor\Jt_Revolution_For_Elementor_Activator::activate();
        }
        
        register_activation_hook( __FILE__, 'activate_jt_revolution_for_elementor' );
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/deactivator.php
     */
    
    if ( !function_exists( 'deactivate_jt_revolution_for_elementor' ) ) {
        function deactivate_jt_revolution_for_elementor()
        {
            require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
            RevolutionForElementor\Jt_Revolution_For_Elementor_Deactivator::deactivate();
        }
        
        register_deactivation_hook( __FILE__, 'deactivate_jt_revolution_for_elementor' );
    }
    
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/plugin.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    
    if ( !function_exists( 'run_jt_revolution_for_elementor' ) ) {
        function run_jt_revolution_for_elementor()
        {
            $plugin = RevolutionForElementor\Plugin::instance();
            $plugin->run();
        }
        
        run_jt_revolution_for_elementor();
    }
    
    /**
     * Check if Elementor Pro is active
     *
     * @since 1.0.0
     *
     */
    if ( !function_exists( 'rfe_is_elementor_pro_active' ) ) {
        function rfe_is_elementor_pro_active()
        {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( 'elementor-pro/elementor-pro.php' );
        }
    
    }
    /**
     * Check if Elementor is active
     *
     * @since 1.0.0
     *
     * @access public
     */
    if ( !function_exists( 'rfe_is_elementor_active' ) ) {
        function rfe_is_elementor_active()
        {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( 'elementor/elementor.php' );
        }
    
    }
    /**
     * Check if Elementor is installed
     *
     * @since 1.0.0
     *
     * @access public
     */
    if ( !function_exists( 'rfe_is_elementor_installed' ) ) {
        function rfe_is_elementor_installed()
        {
            $path = 'elementor/elementor.php';
            $plugins = get_plugins();
            return isset( $plugins[$path] );
        }
    
    }
    if ( !function_exists( 'rfe_format_number' ) ) {
        function rfe_format_number(
            $num,
            $thousands_separator,
            $decimal_separator,
            $min_fraction,
            $max_fraction
        )
        {
            //Parse the number to a usable one
            $dotPos = strrpos( $num, '.' );
            $commaPos = strrpos( $num, ',' );
            $sep = ( $dotPos > $commaPos && $dotPos ? $dotPos : (( $commaPos > $dotPos && $commaPos ? $commaPos : false )) );
            if ( !$sep ) {
                //return floatval(preg_replace("/[^0-9]/", "", $num));
                $sep = strlen( $num );
            }
            $integers = preg_replace( "/[^0-9]/", "", substr( $num, 0, $sep ) );
            $fraction = preg_replace( "/[^0-9]/", "", substr( $num, $sep + 1, strlen( $num ) ) );
            //The actual number as a floating point representation string
            $number = $integers . '.' . $fraction;
            //Length of the fractions e. g. 1.315 has 3 fraction digits
            $actual_fraction = strlen( $fraction );
            //Calculate the number we need to use for the decimals argument of number_format. If min > actual -> use min.
            $decimals = $actual_fraction;
            if ( '' !== $min_fraction && $min_fraction > $actual_fraction ) {
                $decimals = $min_fraction;
            }
            if ( '' !== $max_fraction && $actual_fraction > $max_fraction ) {
                $decimals = $max_fraction;
            }
            return number_format(
                $number,
                $decimals,
                $decimal_separator,
                $thousands_separator
            );
        }
    
    }
}
