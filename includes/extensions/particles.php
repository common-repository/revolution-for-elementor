<?php

namespace RevolutionForElementor\Extensions;

use  Elementor\Controls_Manager ;
use  Elementor\Scheme_Color ;
use  RevolutionForElementor\Base\Extension_Base ;
class Particles extends Extension_Base
{
    /**
     * A list of scripts that the extension depends on
     *
     * @since 1.0.0
     **/
    public function get_script_depends()
    {
        return [ 'particle' ];
    }
    
    /**
     * The description of the extension
     *
     * @since 1.0.0
     **/
    public static function get_description()
    {
        return __( 'Add particle effects to the background of sections. The settings can be found on sections under Advanced &rarr; Revolution &rarr; Particles', 'revolution-for-elementor' );
    }
    
    /**
     * Add controls for the extension
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function add_controls( $element, $args )
    {
        $element->add_control( 'particles_heading', [
            'label'     => __( 'Particles', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $element->add_control( 'particles_warning', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( 'Particles should not be activated if the "Stretch Section" setting is enabled. If you activate it, it might get distorted', 'revolution-for-elementor' ),
            'content_classes' => 'rfe-raw-html rfe-raw-html__danger',
            'condition'       => [
            'stretch_section' => 'section-stretched',
        ],
            'hide_in_inner'   => true,
        ] );
        $element->add_control( 'particles_enabled', [
            'label'              => __( 'Particles', 'revolution-for-elementor' ),
            'type'               => Controls_Manager::SWITCHER,
            'default'            => '',
            'label_on'           => __( 'Yes', 'revolution-for-elementor' ),
            'label_off'          => __( 'No', 'revolution-for-elementor' ),
            'return_value'       => 'yes',
            'frontend_available' => true,
        ] );
        //Type selection fields
        if ( !jt_revolution_for_elementor()->is_premium() ) {
            $element->add_control( 'particles_upgrade_notice', [
                'label'           => __( 'Upgrade to Premium', 'revolution-for-elementor' ),
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(
                '%1$s <a href="%2$s">%3$s</a>',
                __( 'Upgrade to the premium version of this plugin to enable custom particle settings.', 'revolution-for-elementor' ),
                jt_revolution_for_elementor()->get_upgrade_url(),
                __( 'Upgrade Now!', 'revolution-for-elementor' )
            ),
                'content_classes' => 'rfe-raw-html rfe-raw-html__info',
            ] );
        }
        $particles_style_options = [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'nasa'    => __( 'NASA', 'revolution-for-elementor' ),
            'bubble'  => __( 'Bubble', 'revolution-for-elementor' ),
            'snow'    => __( 'Snow', 'revolution-for-elementor' ),
        ];
        $element->add_control( 'particles_style', [
            'label'              => __( 'Particle Style', 'revolution-for-elementor' ),
            'type'               => Controls_Manager::SELECT,
            'frontend_available' => true,
            'default'            => 'default',
            'options'            => $particles_style_options,
            'condition'          => [
            'particles_enabled' => [ 'yes' ],
        ],
        ] );
        $element->add_control( 'particles_color_options', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'condition' => [
            'particles_enabled' => [ 'yes' ],
        ],
        ] );
        $element->add_control( 'particles_color', [
            'label'              => __( 'Particle Color', 'revolution-for-elementor' ),
            'type'               => Controls_Manager::COLOR,
            'default'            => '',
            'scheme'             => [
            'type'  => Scheme_Color::get_type(),
            'value' => Scheme_Color::COLOR_4,
        ],
            'condition'          => [
            'particles_enabled' => [ 'yes' ],
        ],
            'frontend_available' => true,
        ] );
        $element->add_control( 'particles_link_color', [
            'label'              => __( 'Link Color', 'revolution-for-elementor' ),
            'type'               => Controls_Manager::COLOR,
            'default'            => '',
            'scheme'             => [
            'type'  => Scheme_Color::get_type(),
            'value' => Scheme_Color::COLOR_4,
        ],
            'condition'          => [
            'particles_enabled' => [ 'yes' ],
        ],
            'frontend_available' => true,
        ] );
    }
    
    /**
     * Add Actions
     *
     * @since 1.0.0
     *
     * @access private
     */
    protected function add_actions()
    {
        // Activate Revolution section
        add_action(
            'elementor/element/section/section_advanced/after_section_end',
            function ( $element, $args ) {
            $this->add_common_advanced_section( $element, $args );
        },
            10,
            2
        );
        // Activate controls for Revolution section
        add_action(
            'elementor/element/section/jt_revolution_for_elementor_advanced/before_section_end',
            function ( $element, $args ) {
            $this->add_controls( $element, $args );
        },
            10,
            2
        );
    }

}