<?php

namespace RevolutionForElementor;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.janthielemann.de
 * @since      1.0.0
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/admin
 * @author     Jan Thielemann <contact@janthielemann.de>
 */
class Jt_Revolution_For_Elementor_Admin
{

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, false);

    }

    public function admin_menu()
    {
        require_once plugin_dir_path(__FILE__) . 'settings-api.php';
        require_once plugin_dir_path(__FILE__) . 'settings-page.php';
        require_once plugin_dir_path(__FILE__) . 'settings.php';
    }

    public function plugins_loaded()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'elementor_not_loaded']);
            return;
        }
    }

    public function elementor_not_loaded()
    {

        if (!\PAnD::is_admin_notice_active('revolution_for_elementor_elementor_not_loaded')) {
            return;
        }
        $button = '';
        if (rfe_is_elementor_installed()) {
            if (current_user_can('activate_plugins')) {
                $plugin = 'elementor/elementor.php';
                $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
                $button .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Elementor', 'revolution-for-elementor')) . '</p>';
            }
        } else {
            if (current_user_can('install_plugins')) {
                $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
                $button .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install Elementor', 'revolution-for-elementor')) . '</p>';
            }
        }

        ?>
        <div data-dismissible="revolution_for_elementor_elementor_not_loaded" class="notice notice-error is-dismissible">
            <p><?php _e('<strong>Revolution for Elementor</strong> needs the <strong>Elementor</strong> plugin to work. Please install and activate <strong>Elementor</strong>', 'revolution-for-elementor');?></p>
             <?php echo $button ?>
        </div>
        <?php
    }

}
