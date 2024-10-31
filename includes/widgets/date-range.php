<?php

namespace RevolutionForElementor\Widgets;

// Revolution for Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

// Elementor Classes
use RevolutionForElementor\Base\Revolution_Widget;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Date_Range extends Revolution_Widget
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
        return 'date-range';
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
        return __('Date Range', 'revolution-for-elementor');
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
        return 'eicon-date';
    }

    /**
     * The Categories in which to show this widget in the editor
     */
    public function get_categories()
    {
        return ['revolution-for-elementor'];
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
            'section_date',
            [
                'label' => __('Date Range', 'revolution-for-elementor'),
            ]
        );

        $this->add_control('heading_from', [
            'label' => __('From', 'revolution-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('date_from_type', [
            'label' => __('Date Type', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'picker' => __('Datepicker', 'revolution-for-elementor'),
                'first_post' => __('First Post (Year)', 'revolution-for-elementor'),
                'last_post' => __('Latest Post (Year)', 'revolution-for-elementor'),
                'dynamic' => __('Dynamic', 'revolution-for-elementor'),
            ],
            'default' => 'first_post',
        ]);

        $this->add_control(
            'date_from_picker',
            [
                'label' => __('Date', 'elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'condition' => [
                    'date_from_type' => 'picker',
                ],
                'picker_options' => [
                    'enableTime' => false,
                ],
            ]
        );

        $this->add_control(
            'date_from_format',
            [
                'label' => __('Custom Format', 'revolution-for-elementor'),
                'default' => get_option('date_format'),
                'description' => sprintf('<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', __('Documentation on date and time formatting', 'revolution-for-elementor')),
                'condition' => [
                    'date_from_type' => 'picker',
                ],
            ]
        );

        $this->add_control(
            'date_from_dynamic',
            [
                'label' => __('Date', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'date_from_type' => 'dynamic',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control('heading_to', [
            'label' => __('To', 'revolution-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('date_to_type', [
            'label' => __('Date Type', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'none' => __('None', 'revolution-for-elementor'),
                'picker' => __('Datepicker', 'revolution-for-elementor'),
                'first_post' => __('First Post (Year)', 'revolution-for-elementor'),
                'last_post' => __('Latest Post (Year)', 'revolution-for-elementor'),
                'dynamic' => __('Dynamic', 'revolution-for-elementor'),
            ],
            'default' => 'last_post',
        ]);

        $this->add_control(
            'date_to_picker',
            [
                'label' => __('Date', 'elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'condition' => [
                    'date_to_type' => 'picker',
                ],
                'picker_options' => [
                    'enableTime' => false,
                ],
            ]
        );

        $this->add_control(
            'date_to_format',
            [
                'label' => __('Custom Format', 'revolution-for-elementor'),
                'default' => get_option('date_format'),
                'description' => sprintf('<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', __('Documentation on date and time formatting', 'revolution-for-elementor')),
                'condition' => [
                    'date_to_type' => 'picker',
                ],
            ]
        );

        $this->add_control(
            'date_to_dynamic',
            [
                'label' => __('Date', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'date_to_type' => 'dynamic',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control('heading_text', [
            'label' => __('Text', 'revolution-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control(
            'prefix',
            [
                'label' => __('Prefix', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Copyright &copy; ',
                'label_block' => true,
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => __('Suffix', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => ' by ' . get_bloginfo('name'),
                'label_block' => true,
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => sprintf(
                    __('Here you can enter a prefix and suffix for the date or date range. If you want to use this widget as a copyright notice, you can create the %1$s sign by entering %2$s', 'elementor-extras'),
                    '&copy;',
                    '&amp;copy;'
                ),
                'separator' => 'none',
                'content_classes' => 'rfe-raw-html rfe-raw-html__info',
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __('Separator', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '-',
                'condition' => [
                    'date_to_type' => ['picker', 'first_post', 'last_post', 'dynamic'],
                ],
            ]
        );

        $this->add_control('force_range', [
            'label' => __('Force Range', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
            'description' => __('Force the separator and the To date to show, even if From and To date are the same', 'revolution-for-elementor'),
            'condition' => [
                'date_to_type' => ['picker', 'first_post', 'last_post', 'dynamic'],
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Text', 'elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'elementor'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => __('Text Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'elementor'),
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}}',
            ]
        );

        $this->add_control(
            'link_options_title',
            [
                'label' => __('Link', 'revolution-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __('Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} a',
            ]
        );

        $this->add_control(
            'link_hover_options_title',
            [
                'label' => __('Link (Hover)', 'revolution-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => __('Color', 'revolution-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_hover_typography',
                'selector' => '{{WRAPPER}} a:hover',
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

        $prefix = $settings['prefix'];
        $suffix = $settings['suffix'];

        $date = '';
        if ('none' !== $settings['date_to_type']) {

            $date_from = $this->get_from_date($settings);
            $date_to = $this->get_to_date($settings);
            $separator = $settings['separator'];
            $force_range = $settings['force_range'];

            $date = sprintf(
                '<span class="date date-range">%1$s%2$s%3$s</span>',
                $date_from,
                ($date_from != $date_to || 'yes' === $force_range ? $separator : ''),
                ($date_from != $date_to || 'yes' === $force_range ? $date_to : '')
            );
        } else {
            $date = sprintf(
                '<span class="date">%1$s</span>',
                $this->get_from_date($settings)
            );
        }

        echo sprintf(
            '<span class="prefix">%1$s</span>%2$s<span class="suffix">%3$s</span>',
            $prefix,
            $date,
            $suffix
        );
    }

    public function get_from_date($settings)
    {
        $date_from_type = $settings['date_from_type'];
        $date_from_picker = $settings['date_from_picker'];
        $date_from_format = $settings['date_from_format'];
        $date_from_dynamic = $settings['date_from_dynamic'];
        return $this->get_date($date_from_type, $date_from_picker, $date_from_format, $date_from_dynamic);
    }

    public function get_to_date($settings)
    {
        $date_to_type = $settings['date_to_type'];
        $date_to_picker = $settings['date_to_picker'];
        $date_to_format = $settings['date_to_format'];
        $date_to_dynamic = $settings['date_to_dynamic'];
        return $this->get_date($date_to_type, $date_to_picker, $date_to_format, $date_to_dynamic);
    }

    public function get_date($type, $picker, $format, $dynamic)
    {
        switch ($type) {
            case 'picker':
                return date($format, strtotime($picker));
            case 'first_post':
                global $wpdb;
                $date = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS first_post FROM $wpdb->posts WHERE post_status = 'publish'");
                if ($date) {
                    return $date[0]->first_post;
                }
                return "";
            case 'last_post':
                global $wpdb;
                $date = $wpdb->get_results("SELECT YEAR(max(post_date_gmt)) AS last_post FROM $wpdb->posts WHERE post_status = 'publish'");
                if ($date) {
                    return $date[0]->last_post;
                }
                return "";
            case 'dynamic':
                return $dynamic;
            default:
                return '';
        }
    }
}
