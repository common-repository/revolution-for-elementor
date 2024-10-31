<?php

namespace RevolutionForElementor\Widgets;

// Revolution for Elementor Classes
use RevolutionForElementor\Base\Revolution_Widget;
use RevolutionForElementor\Controls\Groups\Group_Control_Star_Rating;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Star_Rating extends Revolution_Widget
{

    /**
     * Retrieve divider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'star-rating';
    }

    /**
     * Retrieve divider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Star Rating', 'revolution-for-elementor');
    }

    /**
     * Retrieve divider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-star';
    }

    /**
     * The Categories in which to show this widget in the editor
     */
    public function get_categories() {
		return [ 'revolution-for-elementor' ];
	}

    /**
     * Register divider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_rating',
            [
                'label' => __('Rating', 'revolution-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Star_Rating::get_type(),
            [
                'name' => 'star_rating',
            ]
        );

        $this->end_controls_section();

        //Font Controls

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Text', 'revolution-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'revolution-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'revolution-for-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'revolution-for-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'revolution-for-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'revolution-for-elementor'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rfe-star-rating' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'revolution-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();
    }

    public function get_script_depends()
    {
        return [];
    }

    protected function render($instance = [])
    {
        //Get the items
        $settings = $this->get_settings_for_display();
        echo sprintf(
            '<div class="rfe-star-rating">%1$s</div>',
            Group_Control_Star_Rating::render('star_rating', $settings)
        );
    }
}
