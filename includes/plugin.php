<?php

namespace RevolutionForElementor;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.janthielemann.de
 * @since      1.0.0
 *
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Jt_Revolution_For_Elementor
 * @subpackage Jt_Revolution_For_Elementor/includes
 * @author     Jan Thielemann <contact@janthielemann.de>
 */
class Plugin
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Jt_Revolution_For_Elementor_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected  $loader ;
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected  $plugin_name ;
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected  $version ;
    /**
     * The singleton instance of the plugin.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $instance    The singleton instance of the plugin.
     */
    public static  $instance = null ;
    /**
     * Extension manager (used for handling extensions for existing elements)
     *
     * @since    1.0.0
     * @access   public
     * @var Extensions_Manager
     */
    public  $extensions_manager ;
    /**
     * Widgets manager (used for handling widgets)
     *
     * @since    1.0.0
     * @access   public
     * @var Widgets_Manager
     */
    public  $widgets_manager ;
    /**
     * Settings for this plugin e. g. which extensions are enabled
     *
     * @since    1.0.0
     * @access   public
     * @var Settings
     */
    public  $settings ;
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        
        if ( defined( 'REVOLUTION_FOR_ELEMENTOR_VERSION' ) ) {
            $this->version = REVOLUTION_FOR_ELEMENTOR_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        
        $this->plugin_name = 'revolution-for-elementor';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_global_hooks();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_elementor_hooks();
    }
    
    /**
     * Plugin instance
     *
     * @since 1.0.0
     * @return Jt_Revolution_For_Elementor
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Jt_Revolution_For_Elementor_Loader. Orchestrates the hooks of the plugin.
     * - Jt_Revolution_For_Elementor_i18n. Defines internationalization functionality.
     * - Jt_Revolution_For_Elementor_Admin. Defines all hooks for the admin area.
     * - Jt_Revolution_For_Elementor_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/i18n.php';
        /**
         * The class responsible for managing extensions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/managers/extensions.php';
        /**
         * The class responsible for managing widgets
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/managers/widgets.php';
        /*
         * Library to handle permanent dismissal of admin notices
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin.php';
        /**
         * The class responsible for defining all settings that are used in the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings-api.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/public.php';
        /**
         * The class responsible for loading/adding actions and filters
         */
        $this->loader = new Jt_Revolution_For_Elementor_Loader();
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Jt_Revolution_For_Elementor_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Jt_Revolution_For_Elementor_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    public function define_global_hooks()
    {
        $this->settings = new Settings_API();
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Jt_Revolution_For_Elementor_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
        $this->loader->add_action( 'plugins_loaded', $plugin_admin, 'plugins_loaded' );
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Jt_Revolution_For_Elementor_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }
    
    /**
     * Register all of the hooks related to the elementor functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_elementor_hooks()
    {
        $this->loader->add_action( 'elementor/init', $this, 'elementor_init' );
        $this->loader->add_action( 'elementor/editor/after_enqueue_styles', $this, 'enqueue_editor_styles' );
        $this->loader->add_action( 'elementor/elements/categories_registered', $this, 'add_elementor_widget_categories' );
        $this->loader->add_action( 'elementor/controls/controls_registered', $this, 'elementor_controls_registered' );
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Jt_Revolution_For_Elementor_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
    
    public function elementor_init()
    {
        $this->extensions_manager = new Managers\Extensions_Manager();
        $this->widgets_manager = new Managers\Widgets_Manager();
        // $this->page_settings_manager     = new SettingsManager();
    }
    
    public function elementor_controls_registered()
    {
        /**
         * Include star rating group controlsw
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/controls/groups/star-rating.php';
        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        $controls_manager->add_group_control( \RevolutionForElementor\Controls\Groups\Group_Control_Star_Rating::get_type(), new \RevolutionForElementor\Controls\Groups\Group_Control_Star_Rating() );
    }
    
    /**
     * Add custom categories to Elementor editor panel
     *
     * @param    Elementor\Elements_Manager  $elements_manager    The elements manager class from Elementor
     * @since    1.0.0
     */
    public function add_elementor_widget_categories( $elements_manager )
    {
        $elements_manager->add_category( 'revolution-for-elementor', [
            'title' => __( 'Revolution for Elementor', 'revolution-for-elementor' ),
            'icon'  => 'fa fa-hand-rock-o',
        ] );
    }
    
    /**
     * Enqueue styles for Elementor editor.
     *
     * @since    1.0.0
     */
    public function enqueue_editor_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/editor.css',
            [],
            $this->version,
            'all'
        );
    }

}