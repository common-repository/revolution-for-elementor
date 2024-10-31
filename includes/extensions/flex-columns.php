<?php

namespace RevolutionForElementor\Extensions;

use Elementor\Controls_Manager;
use RevolutionForElementor\Base\Extension_Base;

class Flex_Columns extends Extension_Base
{
    /**
     * A list of scripts that the extension depends on
     *
     * @since 1.0.0
     **/
    public function get_script_depends()
    {
        return [];
    }

    /**
     * The description of the extension
     *
     * @since 1.0.0
     **/
    public static function get_description()
    {
        return __('Use Flexbox styling on columns without writing CSS. The settings can be found on columns under Style &rarr; Revolution &rarr; Flexbox', 'revolution-for-elementor');
    }

    /**
     * Add controls for the extension
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function add_controls($element, $args)
    {
        $element->add_control(
            'flex_columns_flexbox_heading',
            [
                'label' => __('Flexbox', 'revolution-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'flex_columns_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => sprintf(
                    __('Here you can configure the flexbox settings for this column. If you want to learn more about flexbox and how it works, you can checkout this %s', 'elementor-extras'),
                    sprintf(
                        '<a href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank">%s</a>',
                        __('Flexbox CSS Guide', 'revolution-for-elementor')
                    )
                ),
                'condition' => [
                    'flex_columns_flexbox_enabled' => 'yes',
                ],
                'separator' => 'none',
                'content_classes' => 'rfe-raw-html rfe-raw-html__info',
            ]
        );

        $element->add_control(
            'flex_columns_flexbox_enabled',
            [
                'label' => __('Enable Flexbox', 'revolution-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'revolution-for-elementor'),
                'label_off' => __('No', 'revolution-for-elementor'),
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
        );

        $element->add_control('flex_columns_flex_direction', [
            'label' => __('Flex Direction', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'row' => 'Row',
                'column' => 'Column',
                'row-reverse' => 'Row Reverse',
                'column-reverse' => 'Column Reverse',
            ],
            'condition' => [
                'flex_columns_flexbox_enabled' => 'yes',
            ],
            'default' => 'row',
            'frontend_available' => true,
        ]);

        $element->add_control('flex_columns_align_items', [
            'label' => __('Align Items', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'flex-start' => 'Flex Start',
                'flex-end' => 'Flex End',
                'center' => 'Center',
                'stretch' => 'Stretch',
                'baseline' => 'Baseline',
            ],
            'condition' => [
                'flex_columns_flexbox_enabled' => 'yes',
            ],
            'default' => 'baseline',
            'frontend_available' => true,
        ]);

        $element->add_control('flex_columns_justify_content', [
            'label' => __('Justify Content', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'space-between',
            'options' => [
                'flex-start' => 'Flex Start',
                'flex-end' => 'Flex End',
                'center' => 'Center',
                'space-between' => 'Space Between',
                'space-around' => 'Space Around',
                'space-evenly' => 'Space Evenly',
            ],
            'condition' => [
                'flex_columns_flexbox_enabled' => 'yes',
            ],
            'frontend_available' => true,
        ]);

        $element->add_control('flex_columns_align_content', [
            'label' => __('Justify Content', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'flex-start',
            'options' => [
                'flex-start' => 'Flex Start',
                'flex-end' => 'Flex End',
                'center' => 'Center',
                'stretch' => 'Stretch',
                'space-between' => 'Space Between',
                'space-around' => 'Space Around',
            ],
            'condition' => [
                'flex_columns_flexbox_enabled' => 'yes',
            ],
            'frontend_available' => true,
        ]);

        $element->add_control('flex_columns_flex_wrap', [
            'label' => __('Flex Wrap', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'wrap',
            'options' => [
                'wrap' => 'Wrap',
                'nowrap' => 'No Wrap',
                'wrap-reverse' => 'Wrap Reverse',
            ],
            'condition' => [
                'flex_columns_flexbox_enabled' => 'yes',
            ],
            'frontend_available' => true,
        ]);

    }

    public function add_renderer_attributes($element)
    {
        if ('yes' === $element->get_settings('flexbox_enabled')) {
            $element->add_render_attribute('_wrapper', 'class', 'rfe-flex');
        } else {
            $element->add_render_attribute('_wrapper', 'class', 'rfe-no-flex');
        }
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
        add_action('elementor/element/column/section_typo/after_section_end', function ($element, $args) {

            $this->add_common_style_sections($element, $args);

        }, 10, 2);

        add_action('elementor/element/column/jt_revolution_for_elementor_style/before_section_end', function ($element, $args) {

            $this->add_controls($element, $args);

        }, 10, 2);
    }
}
