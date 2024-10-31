<?php

namespace RevolutionForElementor\Managers;

use  RevolutionForElementor\Base\Revolution_Widget ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Widgets_Manager
{
    // const ADVANCED_LIST 	= 'advanced-list';
    private  $_widgets = null ;
    public  $available_widgets = array() ;
    /**
     * Loops though available widgets and registers them
     *
     * @since 1.0.0
     *
     * @access public
     * @return void
     */
    public function register_widgets()
    {
        $this->_widgets = [];
        $available_widgets = $this->available_widgets;
        foreach ( $available_widgets as $index => $widget_id ) {
            //Get the widget filename
            $widget_filename = str_replace( '_', '-', $widget_id );
            $widget_filename = REVOLUTION_FOR_ELEMENTOR_PATH . "includes/widgets/{$widget_filename}.php";
            require_once $widget_filename;
            //Get the class name (e. g. "Advanced_List")
            $class_name = str_replace( '-', ' ', $widget_id );
            $class_name = str_replace( ' ', '_', ucwords( $class_name ) );
            $class_name = '\\RevolutionForElementor\\Widgets\\' . $class_name;
            
            if ( !$this->is_available( $class_name ) ) {
                unset( $this->available_widgets[$index] );
                continue;
            }
            
            // Skip widget if it's disabled in admin settings or is dependant on non-exisiting Elementor Pro plugin
            if ( $this->is_disabled( $widget_id ) ) {
                continue;
            }
            $this->register_widget( $widget_id, $class_name );
        }
        do_action( 'jt_revolution_for_elementor/widgets/widgets_registered', $this );
    }
    
    /**
     * Check if widget is disabled through admin settings
     *
     * @since 1.8.0
     *
     * @access public
     * @param string $widget_name The name of the widget (e. g. "advanced-list")
     * @return bool
     */
    public function is_disabled( $widget_id )
    {
        if ( !$widget_id ) {
            return false;
        }
        //Get the widget slug (e. g. advanced_list)
        $widget_slug = str_replace( '-', '_', $widget_id );
        $option_name = 'enable_' . $widget_slug;
        $section = 'jt_revolution_for_elementor_widgets';
        $option = \RevolutionForElementor\Plugin::instance()->settings->get_option( $option_name, $section, false );
        if ( 'off' === $option ) {
            return true;
        }
        return false;
    }
    
    /**
     * Check if widget is available at all
     *
     * @since 1.8.0
     *
     * @access public
     * @param string $class_name The class name of the widget (e. g. "Advanced_List")
     * @return bool
     */
    public function is_available( $class_name )
    {
        if ( !$class_name ) {
            return false;
        }
        if ( $class_name::requires_elementor_pro() && !rfe_is_elementor_pro_active() ) {
            return false;
        }
        return true;
    }
    
    /**
     * @since 1.0.0
     *
     * @param $widget_id
     * @param $widget_class
     */
    public function register_widget( $widget_id, $widget_class )
    {
        $this->_widgets[$widget_id] = $widget_class;
    }
    
    /**
     * @since 1.0.0
     *
     * @param $widget_id
     * @return bool
     */
    public function unregister_widget( $widget_id )
    {
        if ( !isset( $this->_widgets[$widget_id] ) ) {
            return false;
        }
        unset( $this->_widgets[$widget_id] );
        return true;
    }
    
    /**
     * @since 1.0.0
     *
     * @return Revolution_Widget[]
     */
    public function get_widgets()
    {
        if ( null === $this->_widgets ) {
            $this->register_widgets();
        }
        return $this->_widgets;
    }
    
    /**
     * @since 1.0.0
     *
     * @param $widget_id
     * @return bool|\RevolutionForElementor\Base\Revolution_Widget
     */
    public function get_widget( $widget_id )
    {
        $widgets = $this->get_widgets();
        return ( isset( $widgets[$widget_id] ) ? $widgets[$widget_id] : false );
    }
    
    private function require_files()
    {
        require REVOLUTION_FOR_ELEMENTOR_PATH . 'includes/base/widget.php';
    }
    
    /**
     * Register the enabled widgets in Elementors Widget Manager
     * 
     * @since 1.0.0
     *
     * @param $widget_manager
     */
    function widgets_registered( $widgets_manager )
    {
        $widgets = $this->get_widgets();
        foreach ( $widgets as $widget ) {
            $widgets_manager->register_widget_type( new $widget() );
        }
    }
    
    public function __construct()
    {
        $this->available_widgets = [];
        $this->available_widgets[] = 'star-rating';
        $this->available_widgets[] = 'advanced-list';
        $this->available_widgets[] = 'date-range';
        $this->available_widgets[] = 'term-list';
        sort( $this->available_widgets );
        $this->require_files();
        $this->register_widgets();
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );
    }

}