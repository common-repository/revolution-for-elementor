<?php

namespace RevolutionForElementor;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Class Settings
 *
 * @since 1.8.0
 */
class Settings extends Settings_Page
{
    const  PAGE_ID = 'revolution-for-elementor' ;
    // Tabs
    const  TAB_GENERAL = 'general' ;
    const  TAB_WIDGETS = 'widgets' ;
    const  TAB_EXTENSIONS = 'extensions' ;
    private  $_tabs ;
    /**
     * menu
     *
     * Adds the item to the menu
     *
     * @since 1.8.0
     *
     * @access public
     */
    public function menu()
    {
        $slug = 'revolution-for-elementor';
        $capability = 'manage_options';
        add_menu_page(
            'Revolution',
            'Revolution',
            $capability,
            $slug,
            [ $this, 'render_page' ],
            'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 161.64 223.98"><path fill="#eee" d="m75.066 166.68c13.7 6.3 20.2 7.2 34.6 4.3l-13.6 9.7-6.2 36.6-1.7-37.6zm-72.6-86.5c-2.9 4.5-3.5 7.7-0.4 12.2l47.9 68.7-9.4 62.9h86.4v-53.7l23.8-48.1c3.1-6.2 3.7-10.2 3.7-23.9l-28.5 29.5-24.1-12.4-7.3 38.9c-7.7-35.9-24.7-57.8-51.4-69.1l7.6-14.6c30.8 16.5 42.2-11.7 37.3-14l-48-23c-4-1.9-6.4-1.8-8.85 2.1zm143.3-13.6-33.3 36.7c-2.1 2.3 11.6 16.3 13.7 14.5l35.1-31.5c3-2.7-13-22.5-15.5-19.7zm-55.8 16.1c-1.8 2.4 17.5 19.4 19.2 17.5l35.7-39.6c3.7-4.1-20.1-25.4-22.55-22.05zm1.4-67.6-17.4 29.2 15.7 8.2c4 2.1 5.2 8 1.5 21.4l28-40.7c2.9-4.4-25.3-22.3-27.8-18.1zm-32.7-14.2-15.9 28.7 26.7 12.6 16.5-27.3c2.7-4.5-24.8-18.5-27.3-14z"/></svg>' )
        );
        add_submenu_page(
            $slug,
            'Settings',
            'Settings',
            $capability,
            $slug,
            null
        );
    }
    
    /**
     * enqueue_scripts
     *
     * Enqueue styles and scripts
     *
     * @since 1.8.0
     *
     * @access public
     */
    public function enqueue_scripts()
    {
    }
    
    /**
     * Hooked into admin_init action
     *
     * @since 1.8.0
     *
     * @access public
     */
    public function init()
    {
        parent::init();
    }
    
    /**
     * Creates the tabs object
     *
     * @since 1.8.0
     *
     * @access protected
     */
    protected function create_page_tabs()
    {
        return $this->_tabs;
    }
    
    /**
     * Gets the settings sections
     *
     * @since 1.8.0
     *
     * @access public
     */
    public function get_settings_sections()
    {
        $sections = [];
        $sections[] = [
            'id'    => $this->settings_prefix . 'widgets',
            'title' => __( 'Widgets', 'revolution-for-elementor' ),
            'desc'  => __( 'Here you can disable widgets from Revolution for Elementor. If disabled, a widget will no longer be available in the Elementor editor panel.' ),
        ];
        $sections[] = [
            'id'    => $this->settings_prefix . 'extensions',
            'title' => __( 'Extensions', 'revolution-for-elementor' ),
            'desc'  => __( 'Revolution for Elementor extensions are features added to the default Elementor elements. They display additional controls that can be found under the Advanced tab of each element. Below you can disable any extensions. If disabled, these additional controls will no longer be available in the Elementor editor panel.' ),
        ];
        return $sections;
    }
    
    /**
     * Gets the settings fields
     *
     * @since 1.8.0
     *
     * @access public
     */
    public function get_settings_fields()
    {
        $fields = [];
        $sections = $this->get_settings_sections();
        foreach ( $sections as $section ) {
            if ( $this->settings_api->is_tab_linked( $section ) ) {
                continue;
            }
            $fields[$section['id']] = call_user_func( array( $this, 'get_' . str_replace( $this->settings_prefix, '', $section['id'] ) . '_fields' ) );
        }
        return $fields;
    }
    
    /**
     * Returns current page title
     *
     * @since 1.8.0
     *
     * @access protected
     */
    protected function get_widgets_fields()
    {
        $fields = [];
        
        if ( Plugin::instance()->widgets_manager === null || !Plugin::instance()->widgets_manager->available_widgets || empty(Plugin::instance()->widgets_manager->available_widgets) ) {
            if ( !rfe_is_elementor_active() ) {
                $fields[] = [
                    'name'  => 'widget_warning',
                    'label' => __( 'Warning', 'revolution-for-elementor' ),
                    'type'  => 'html',
                    'note'  => __( 'You need Elementor installed and activated to enable or disable widgets.', 'revolution-for-elementor' ),
                ];
            }
            return $fields;
        }
        
        $available_widgets = Plugin::instance()->widgets_manager->available_widgets;
        foreach ( $available_widgets as $widget_id ) {
            //Get the class name (e. g. "Advanced_List")
            $class_name = str_replace( '-', ' ', $widget_id );
            $class_name = str_replace( ' ', '_', ucwords( $class_name ) );
            $class_name = '\\RevolutionForElementor\\Widgets\\' . $class_name;
            //Get the widget slug (e. g. advanced_list)
            $widget_slug = str_replace( '-', '_', $widget_id );
            //Get the widget title (e. g. Advanced List)
            $widget_title = ucwords( str_replace( '_', ' ', $widget_slug ) );
            $field = [
                'name'    => 'enable_' . $widget_slug,
                'label'   => $widget_title,
                'desc'    => __( 'Enable', 'revolution-for-elementor' ),
                'type'    => 'checkbox',
                'default' => 'on',
            ];
            
            if ( $class_name::requires_elementor_pro() && !rfe_is_elementor_pro_active() ) {
                $field['type'] = 'html';
                $field['note'] = __( 'You need Elementor Pro installed and activated for this widget to be available.', 'revolution-for-elementor' );
                unset( $field['desc'] );
            }
            
            $fields[] = $field;
        }
        return $fields;
    }
    
    /**
     * Returns current page title
     *
     * @since 1.8.0
     *
     * @access protected
     */
    protected function get_extensions_fields()
    {
        $fields = [];
        
        if ( Plugin::instance()->extensions_manager === null || !Plugin::instance()->extensions_manager->available_extensions || empty(Plugin::instance()->extensions_manager->available_extensions) ) {
            if ( !rfe_is_elementor_active() ) {
                $fields[] = [
                    'name'  => 'extension_warning',
                    'label' => __( 'Warning', 'revolution-for-elementor' ),
                    'type'  => 'html',
                    'note'  => __( 'You need Elementor installed and activated to enable or disable extensions.', 'revolution-for-elementor' ),
                ];
            }
            return $fields;
        }
        
        $extensions = Plugin::instance()->extensions_manager->available_extensions;
        foreach ( $extensions as $extension_id ) {
            $extension_name = str_replace( '-', '_', $extension_id );
            $class_name = 'RevolutionForElementor\\Extensions\\' . ucwords( $extension_name );
            $extension_title = str_replace( '-', ' ', $extension_id );
            $extension_title = ucwords( $extension_title );
            $description = $class_name::get_description();
            $fields[] = [
                'name'    => 'enable_' . $extension_name,
                'label'   => $extension_title,
                'desc'    => __( 'Enable', 'revolution-for-elementor' ),
                'type'    => 'checkbox',
                'default' => 'on',
                'note'    => $description,
            ];
        }
        return $fields;
    }
    
    protected function get_advanced_fields()
    {
        $fields = [];
        return $fields;
    }
    
    /**
     * Returns current page title
     *
     * @since 1.8.0
     *
     * @access protected
     */
    protected function get_page_title()
    {
        return __( 'Revolution for Elementor', 'revolution-for-elementor' );
    }

}
// initialize
new Settings();