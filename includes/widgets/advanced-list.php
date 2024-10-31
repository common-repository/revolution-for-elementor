<?php

namespace RevolutionForElementor\Widgets;

// Revolution for Elementor Classes
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Typography ;
// Elementor Classes
use  Elementor\Repeater ;
use  Elementor\Utils ;
use  RevolutionForElementor\Base\Revolution_Widget ;
use  RevolutionForElementor\Controls\Groups\Group_Control_Star_Rating ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Advanced_List extends Revolution_Widget
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
        return 'advanced-list';
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
        return __( 'Advanced List', 'revolution-for-elementor' );
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
        return 'eicon-animation-text';
    }
    
    /**
     * The Categories in which to show this widget in the editor
     */
    public function get_categories()
    {
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
        $this->start_controls_section( 'section_content_list', [
            'label' => __( 'List', 'revolution-for-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        //Add the fields on the content tab
        $this->add_content_tab_controls();
        //Add the fields on the layout tab
        $this->add_layout_tab_controls();
        //Add the fields on the style tab
        $this->add_style_tab_controls();
    }
    
    public function add_content_tab_controls()
    {
        $repeater = new Repeater();
        if ( !jt_revolution_for_elementor()->is_premium() ) {
            $repeater->add_control( 'advanced_list_upgrade_notice', [
                'label'           => __( 'Upgrade to Premium', 'revolution-for-elementor' ),
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(
                '%1$s <a href="%2$s">%3$s</a>',
                __( 'Upgrade to the premium version of this plugin to get even more types and features.', 'revolution-for-elementor' ),
                jt_revolution_for_elementor()->get_upgrade_url(),
                __( 'Upgrade Now!', 'revolution-for-elementor' )
            ),
                'content_classes' => 'rfe-raw-html rfe-raw-html__info',
            ] );
        }
        $repeater->start_controls_tabs( 'advanced_list_repeater_tabs' );
        $repeater->start_controls_tab( 'tab_content', [
            'label' => __( 'Content', 'elementor-extras' ),
        ] );
        /**
         * Label
         */
        $repeater->add_control( 'label', [
            'label'              => __( 'Label', 'revolution-for-elementor' ),
            'type'               => Controls_Manager::TEXT,
            'default'            => 'Label',
            'separator'          => 'before',
            'frontend_available' => true,
            'label_block'        => true,
        ] );
        /**
         * Field Type
         */
        $field_type_options = [
            'text'    => __( 'Text', 'revolution-for-elementor' ),
            'number'  => __( 'Number', 'revolution-for-elementor' ),
            'image'   => __( 'Image', 'revolution-for-elementor' ),
            'wysiwyg' => __( 'WYSIWYG', 'revolution-for-elementor' ),
        ];
        $repeater->add_control( 'field_type', [
            'label'   => __( 'Item Type', 'revolution-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'text',
            'options' => $field_type_options,
        ] );
        /**
         * Text field
         */
        $repeater->add_control( 'text', [
            'label'       => __( 'Text', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => [ 'text' ],
        ],
            'placeholder' => __( 'Enter your text', 'revolution-for-elementor' ),
            'default'     => __( 'Add Your Text Here', 'revolution-for-elementor' ),
        ] );
        /**
         * Number field
         */
        $repeater->add_control( 'number', [
            'label'     => __( 'Number', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => [ 'number' ],
        ],
        ] );
        $repeater->add_control( 'number_thousands_separator', [
            'label'     => __( 'Thousands Separator', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
            'default'   => ',',
        ] );
        $repeater->add_control( 'number_decimal_separator', [
            'label'     => __( 'Decimal Separator', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
            'default'   => '.',
        ] );
        $repeater->add_control( 'number_prefix', [
            'label'     => __( 'Prefix', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
        ] );
        $repeater->add_control( 'number_suffix', [
            'label'     => __( 'Suffix', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
        ] );
        $repeater->add_control( 'number_min_fraction', [
            'label'     => __( 'Min Fraction Digits', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
            'min'       => 0,
            'step'      => 1,
            'default'   => 0,
        ] );
        $repeater->add_control( 'number_max_fraction', [
            'label'     => __( 'Max Fraction Digits', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'condition' => [
            'field_type' => [ 'number' ],
        ],
            'min'       => 0,
            'step'      => 1,
            'default'   => 100,
        ] );
        /**
         * Image fields
         */
        $repeater->add_control( 'image', [
            'label'     => __( 'Choose Image', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
            'active' => true,
        ],
            'default'   => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'condition' => [
            'field_type' => [ 'image' ],
        ],
        ] );
        $repeater->add_control( 'image_size', [
            'label'     => __( 'Size', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => self::get_all_image_sizes(),
            'condition' => [
            'field_type' => [ 'image' ],
        ],
        ] );
        /**
         * WYSIWYG fields
         */
        $repeater->add_control( 'wysiwyg', [
            'label'     => __( 'Content', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::WYSIWYG,
            'condition' => [
            'field_type' => [ 'wysiwyg' ],
        ],
            'default'   => __( 'I am text block. Click edit button to change this text.', 'revolution-for-elementor' ),
        ] );
        $repeater->add_control( 'link', [
            'label'       => __( 'Link', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::URL,
            'dynamic'     => [
            'active' => true,
        ],
            'placeholder' => __( 'https://your-link.com', 'revolution-for-elementor' ),
            'default'     => [
            'url' => '',
        ],
            'condition'   => [
            'field_type' => [ 'text', 'number', 'image' ],
        ],
            'separator'   => 'before',
        ] );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( 'tab_layout', [
            'label' => __( 'Layout', 'elementor-extras' ),
        ] );
        $repeater->add_control( 'item_custom_layout', [
            'label'        => __( 'Custom Layout', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'return_value' => 'yes',
        ] );
        $repeater->add_control( 'item_show_label', [
            'label'     => __( 'Show Label', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'No', 'revolution-for-elementor' ),
            'yes'     => __( 'Yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_layout' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_show_empty_item', [
            'label'     => __( 'Show Empty Item', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'No', 'revolution-for-elementor' ),
            'yes'     => __( 'Yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_layout' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_show_separator', [
            'label'     => __( 'Show Separator', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'No', 'revolution-for-elementor' ),
            'yes'     => __( 'Yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_layout' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_item_element', [
            'label'       => __( 'Item HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'h1'      => 'H1',
            'h2'      => 'H2',
            'h3'      => 'H3',
            'h4'      => 'H4',
            'h5'      => 'H5',
            'h6'      => 'H6',
            'div'     => 'div',
            'span'    => 'span',
            'p'       => 'p',
        ],
            'default'     => 'default',
            'description' => __( 'The HTML element in which to wrap the items.', 'revolution-for-elementor' ),
            'condition'   => [
            'item_custom_layout' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_label_element', [
            'label'       => __( 'Label HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'h1'      => 'H1',
            'h2'      => 'H2',
            'h3'      => 'H3',
            'h4'      => 'H4',
            'h5'      => 'H5',
            'h6'      => 'H6',
            'div'     => 'div',
            'span'    => 'span',
            'p'       => 'p',
        ],
            'condition'   => [
            'item_custom_layout' => [ 'yes' ],
        ],
            'default'     => 'default',
            'description' => __( 'The HTML element in which to wrap the label.', 'revolution-for-elementor' ),
        ] );
        $repeater->add_control( 'item_separator_element', [
            'label'       => __( 'Separator HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'h1'      => 'H1',
            'h2'      => 'H2',
            'h3'      => 'H3',
            'h4'      => 'H4',
            'h5'      => 'H5',
            'h6'      => 'H6',
            'div'     => 'div',
            'span'    => 'span',
            'p'       => 'p',
        ],
            'condition'   => [
            'item_custom_layout' => [ 'yes' ],
        ],
            'default'     => 'default',
            'description' => __( 'The HTML element in which to wrap the separator.', 'revolution-for-elementor' ),
        ] );
        $repeater->add_control( 'item_content_element', [
            'label'       => __( 'Content HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'h1'      => 'H1',
            'h2'      => 'H2',
            'h3'      => 'H3',
            'h4'      => 'H4',
            'h5'      => 'H5',
            'h6'      => 'H6',
            'div'     => 'div',
            'span'    => 'span',
            'p'       => 'p',
        ],
            'condition'   => [
            'item_custom_layout' => [ 'yes' ],
        ],
            'default'     => 'default',
            'description' => __( 'The HTML element in which to wrap the content. Not applied if content is a WYSIWYG field.', 'revolution-for-elementor' ),
        ] );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( 'tab_style', [
            'label' => __( 'Style', 'revolution-for-elementor' ),
        ] );
        $repeater->add_control( 'item_custom_style', [
            'label'        => __( 'Custom Style', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => 'yes',
        ] );
        $repeater->add_control( 'item_align', [
            'label'       => __( 'Alignment', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'default'   => __( 'Default', 'revolution-for-elementor' ),
            'left'      => __( 'Left', 'revolution-for-elementor' ),
            'center'    => __( 'Center', 'revolution-for-elementor' ),
            'right'     => __( 'Right', 'revolution-for-elementor' ),
            'justified' => __( 'Justified', 'revolution-for-elementor' ),
        ],
            'default'     => 'default',
            'condition'   => [
            'item_custom_style' => 'yes',
        ],
            'description' => __( 'How to align the content of each item. Has no effect if using the flex item style (CSS flexbox).', 'revolution-for-elementor' ),
        ] );
        $repeater->add_control( 'item_item_flex', [
            'label'     => __( 'Item Flex', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'no', 'revolution-for-elementor' ),
            'yes'     => __( 'yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_item_label_flex_grow', [
            'label'     => __( 'Prevent Label Shrinking', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'no', 'revolution-for-elementor' ),
            'yes'     => __( 'yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_item_flex_align_items', [
            'label'     => __( 'Align Items', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default'    => __( 'Default', 'revolution-for-elementor' ),
            'baseline'   => 'Baseline',
            'center'     => 'Center',
            'flex-start' => 'Flex Start',
            'flex-end'   => 'Flex End',
            'stretch'    => 'Stretch',
        ],
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
            'default'   => 'default',
        ] );
        $repeater->add_control( 'item_item_flex_justify_content', [
            'label'     => __( 'Justify Content', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'default',
            'options'   => [
            'default'       => __( 'Default', 'revolution-for-elementor' ),
            'flex-start'    => 'Flex Start',
            'flex-end'      => 'Flex End',
            'center'        => 'Center',
            'space-around'  => 'Space Around',
            'space-between' => 'Space Between',
            'space-evenly'  => 'Space Evenly',
        ],
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
        ] );
        /**
         * Separator Fields
         */
        $repeater->add_control( 'item_separator_options', [
            'label'     => __( 'Separator', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'condition' => [
            'item_custom_style' => 'yes',
        ],
        ] );
        $repeater->add_control( 'item_separator_inline_block', [
            'label'     => __( 'Inline Block', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'no'      => __( 'No', 'revolution-for-elementor' ),
            'yes'     => __( 'Yes', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_separator_style', [
            'label'     => __( 'Separator Style', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'default' => __( 'Default', 'revolution-for-elementor' ),
            'solid'   => __( 'Solid', 'revolution-for-elementor' ),
            'dotted'  => __( 'Dotted', 'revolution-for-elementor' ),
            'dashed'  => __( 'Dashed', 'revolution-for-elementor' ),
            'double'  => __( 'Double', 'revolution-for-elementor' ),
            'none'    => __( 'None', 'revolution-for-elementor' ),
        ],
            'default'   => 'default',
            'condition' => [
            'item_custom_style' => [ 'yes' ],
        ],
        ] );
        $repeater->add_control( 'item_separator_weight', [
            'label'     => __( 'Weight', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 10,
        ],
        ],
            'condition' => [
            'item_custom_style' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .rfe-advanced-list-item-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
        ],
        ] );
        $repeater->add_control( 'item_separator_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .rfe-advanced-list-item-separator' => 'border-bottom-color: {{VALUE}};',
        ],
            'condition' => [
            'item_custom_style' => 'yes',
        ],
        ] );
        $repeater->add_control( 'item_separator_width', [
            'label'     => __( 'Width', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 500,
        ],
        ],
            'condition' => [
            'item_custom_style' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .rfe-advanced-list-item-separator' => 'width: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $repeater->add_control( 'item_separator_spacing', [
            'label'     => __( 'Spacing', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 500,
        ],
        ],
            'condition' => [
            'item_custom_style' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .rfe-advanced-list-item-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $this->add_control( 'advanced_list', [
            'label'       => __( 'List Items', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => array_values( $repeater->get_controls() ),
            'default'     => [ [
            'label' => __( 'Item #1', 'revolution-for-elementor' ),
            'text'  => 'Wake up Neo',
        ], [
            'label' => __( 'Item #2', 'revolution-for-elementor' ),
            'text'  => 'The matrix has you...',
        ], [
            'label' => __( 'Item #3', 'revolution-for-elementor' ),
            'text'  => 'Follow the white rabbit',
        ] ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();
    }
    
    public function add_layout_tab_controls()
    {
        $this->start_controls_section( 'section_layout_list_layout', [
            'label' => __( 'List Layout', 'revolution-for-elementor' ),
            'tab'   => Controls_Manager::TAB_LAYOUT,
        ] );
        $this->add_control( 'show_label', [
            'label'        => __( 'Show Label', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'show_empty_item', [
            'label'        => __( 'Show Empty Items', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'Whether or not to show items which have no content. Deactivate this if you use dynamic content (e. g. from custom fields) and want items without content to disappear.', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'show_separator', [
            'label'        => __( 'Show Separator', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'item_element', [
            'label'       => __( 'Item HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ],
            'default'     => 'div',
            'description' => __( 'The HTML element in which to wrap the items.', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'label_element', [
            'label'       => __( 'Label HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ],
            'default'     => 'span',
            'description' => __( 'The HTML element in which to wrap the label.', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'separator_element', [
            'label'       => __( 'Separator HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ],
            'default'     => 'div',
            'description' => __( 'The HTML element in which to wrap the separator.', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'content_element', [
            'label'       => __( 'Content HTML Tag', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ],
            'default'     => 'span',
            'description' => __( 'The HTML element in which to wrap the content. Not applied if content is a WYSIWYG field.', 'revolution-for-elementor' ),
        ] );
        $this->end_controls_section();
    }
    
    public function add_style_tab_controls()
    {
        $this->start_controls_section( 'section_style_text_style', [
            'label' => __( 'Text Style', 'revolution-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'heading_general', [
            'label'     => __( 'General', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_responsive_control( 'align', [
            'label'       => __( 'Alignment', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::CHOOSE,
            'options'     => [
            'left'    => [
            'title' => __( 'Left', 'revolution-for-elementor' ),
            'icon'  => 'fa fa-align-left',
        ],
            'center'  => [
            'title' => __( 'Center', 'revolution-for-elementor' ),
            'icon'  => 'fa fa-align-center',
        ],
            'right'   => [
            'title' => __( 'Right', 'revolution-for-elementor' ),
            'icon'  => 'fa fa-align-right',
        ],
            'justify' => [
            'title' => __( 'Justified', 'revolution-for-elementor' ),
            'icon'  => 'fa fa-align-justify',
        ],
        ],
            'description' => __( 'How to align the content of each item. Has no effect if using the flex item style (CSS flexbox).', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'text_color', [
            'label'     => __( 'Text Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}}' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name' => 'typography',
        ] );
        $this->add_control( 'label_options_title', [
            'label'     => __( 'Label', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'label_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-label' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'selector' => '{{WRAPPER}} .rfe-advanced-list-item-label',
        ] );
        $this->add_control( 'content_options_title', [
            'label'     => __( 'Content', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'content_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-content' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .rfe-advanced-list-item-content',
        ] );
        $this->add_control( 'link_options_title', [
            'label'     => __( 'Link', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'link_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'link_typography',
            'selector' => '{{WRAPPER}} a',
        ] );
        $this->add_control( 'link_hover_options_title', [
            'label'     => __( 'Link (Hover)', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'link_hover_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'link_hover_typography',
            'selector' => '{{WRAPPER}} a:hover',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_separator', [
            'label' => __( 'Separator', 'revolution-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'separator_flex_grow', [
            'label'        => __( 'Flexible Separator', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => '1',
            'default'      => '1',
            'selectors'    => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'flex-grow: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'separator_inline_block', [
            'label'        => __( 'Inline Block', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => 'yes',
        ] );
        $this->add_control( 'separator_width', [
            'label'     => __( 'Width', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 500,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'width: {{SIZE}}{{UNIT}};',
        ],
            'default'   => [
            'size' => '',
        ],
        ] );
        $this->add_control( 'separator_spacing', [
            'label'     => __( 'Spacing', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 40,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'separator_style', [
            'label'       => __( 'Style', 'revolution-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
            'solid'  => __( 'Solid', 'revolution-for-elementor' ),
            'dotted' => __( 'Dotted', 'revolution-for-elementor' ),
            'dashed' => __( 'Dashed', 'revolution-for-elementor' ),
            'double' => __( 'Double', 'revolution-for-elementor' ),
            'none'   => __( 'None', 'revolution-for-elementor' ),
        ],
            'default'     => 'dotted',
            'render_type' => 'template',
            'selectors'   => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'border-bottom-style: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'separator_weight', [
            'label'     => __( 'Weight', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 10,
        ],
        ],
            'condition' => [
            'separator_style!' => 'none',
        ],
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
        ],
            'default'   => [
            'size' => 2,
        ],
        ] );
        $this->add_control( 'separator_color', [
            'label'     => __( 'Color', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .rfe-advanced-list-item-separator' => 'border-bottom-color: {{VALUE}};',
        ],
            'condition' => [
            'separator_style!' => 'none',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_item_style', [
            'label' => __( 'Item Style', 'revolution-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'row_gap', [
            'label'      => __( 'Rows Gap', 'revolution-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'range'      => [
            'px' => [
            'max' => 50,
        ],
            'em' => [
            'max'  => 5,
            'step' => 0.1,
        ],
        ],
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .rfe-advanced-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
            'default'    => [
            'size' => 20,
        ],
        ] );
        $this->add_control( 'item_flex', [
            'label'        => __( 'Item Flex', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'When activated, use flexbox display for the items. This can be used to achieve a similar look to the price list module (display label and content next to each other, even if using block element tags).', 'revolution-for-elementor' ),
        ] );
        $this->add_control( 'item_label_flex_grow', [
            'label'        => __( 'Prevent Label Shrinking', 'revolution-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'revolution-for-elementor' ),
            'label_on'     => __( 'Yes', 'revolution-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [
            'item_flex' => 'yes',
        ],
        ] );
        $this->add_control( 'item_flex_align_items', [
            'label'     => __( 'Align Items', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'baseline'   => 'Baseline',
            'center'     => 'Center',
            'flex-start' => 'Flex Start',
            'flex-end'   => 'Flex End',
            'stretch'    => 'Stretch',
        ],
            'condition' => [
            'item_flex' => 'yes',
        ],
            'default'   => 'baseline',
        ] );
        $this->add_control( 'item_flex_justify_content', [
            'label'     => __( 'Justify Content', 'revolution-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'space-between',
            'options'   => [
            'flex-start'    => 'Flex Start',
            'flex-end'      => 'Flex End',
            'center'        => 'Center',
            'space-around'  => 'Space Around',
            'space-between' => 'Space Between',
            'space-evenly'  => 'Space Evenly',
        ],
            'condition' => [
            'item_flex' => 'yes',
        ],
        ] );
        $this->end_controls_section();
    }
    
    public function get_script_depends()
    {
        // return ['jt_elementor_typewriter_js'];
        return [];
    }
    
    protected function render( $instance = array() )
    {
        //Get the items
        // $instance = $this->get_settings();
        $instance = $this->get_settings_for_display();
        echo  '<div class="rfe-advanced-list">' ;
        //Loop each item in the advanced_list field
        foreach ( $instance['advanced_list'] as $index => $item ) {
            //Content which will be output for this item
            $item_content = '';
            //Unique item id which will also be used to generate attributes for the current list item
            $item_id = 'rfe-advanced-list-item-' . $item['_id'];
            //Add classes for this list item
            $this->add_render_attribute( $item_id, 'class', $item_id );
            $this->add_render_attribute( $item_id, 'class', 'elementor-repeater-item-' . $item['_id'] );
            $this->add_render_attribute( $item_id, 'class', 'rfe-advanced-list-item' );
            $this->add_render_attribute( $item_id, 'class', 'rfe-advanced-list-item-' . $index );
            /**
             * Get layout options for the current item
             */
            $show_label = $instance['show_label'];
            $show_empty_item = $instance['show_empty_item'];
            $show_separator = $instance['show_separator'];
            $item_element = $instance['item_element'];
            $label_element = $instance['label_element'];
            $separator_element = $instance['separator_element'];
            $content_element = $instance['content_element'];
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_show_label'] ) {
                $show_label = $item['item_show_label'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_show_empty_item'] ) {
                $show_empty_item = $item['item_show_empty_item'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_show_separator'] ) {
                $show_separator = $item['item_show_separator'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_item_element'] ) {
                $item_element = $item['item_item_element'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_label_element'] ) {
                $label_element = $item['item_label_element'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_separator_element'] ) {
                $separator_element = $item['item_separator_element'];
            }
            if ( 'yes' == $item['item_custom_layout'] && 'default' !== $item['item_content_element'] ) {
                $content_element = $item['item_content_element'];
            }
            /**
             * Get style options for the current item
             */
            $align = $instance['align'];
            $separator_inline_block = $instance['separator_inline_block'];
            $item_flex = $instance['item_flex'];
            $separator_spacing = $instance['separator_spacing'];
            $item_label_flex_grow = $instance['item_label_flex_grow'];
            $item_flex_align_items = $instance['item_flex_align_items'];
            $item_flex_justify_content = $instance['item_flex_justify_content'];
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_align'] ) {
                $align = $item['item_align'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_separator_inline_block'] ) {
                $separator_inline_block = $item['item_separator_inline_block'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_item_flex'] ) {
                $item_flex = $item['item_item_flex'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_separator_spacing'] ) {
                $separator_spacing = $item['item_separator_spacing'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_item_label_flex_grow'] ) {
                $item_label_flex_grow = $item['item_item_label_flex_grow'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_item_flex_align_items'] ) {
                $item_flex_align_items = $item['item_item_flex_align_items'];
            }
            if ( 'yes' == $item['item_custom_style'] && 'default' !== $item['item_item_flex_justify_content'] ) {
                $item_flex_justify_content = $item['item_item_flex_justify_content'];
            }
            //Align item content
            if ( '' !== $align ) {
                $this->add_render_attribute( $item_id, 'style', "text-align: {$align};" );
            }
            //Add inline editable label
            
            if ( 'yes' === $show_label ) {
                $label_key = $this->get_repeater_setting_key( 'label', 'advanced_list', $index );
                $this->add_inline_editing_attributes( $label_key );
                $this->add_render_attribute( $label_key, 'class', 'rfe-advanced-list-item-label' );
                if ( 'yes' === $item_flex && 'yes' === $item_label_flex_grow ) {
                    $this->add_render_attribute( $label_key, 'style', 'flex-shrink: 0;' );
                }
                $item_content .= sprintf(
                    '<%1$s %2$s>%3$s</%1$s>',
                    $label_element,
                    $this->get_render_attribute_string( $label_key ),
                    $item['label']
                );
            }
            
            
            if ( 'yes' === $item_flex ) {
                $this->add_render_attribute( $item_id, 'style', 'display: flex;' );
                $this->add_render_attribute( $item_id, 'style', "justify-content: {$item_flex_justify_content};" );
                $this->add_render_attribute( $item_id, 'style', "align-items: {$item_flex_align_items};" );
            }
            
            
            if ( 'yes' === $show_separator ) {
                $separator_key = $this->get_repeater_setting_key( 'separator', 'advanced_list', $index );
                $this->add_render_attribute( $separator_key, 'class', 'rfe-advanced-list-item-separator' );
                //Add margin auto to separator if center aligned and not inline displayed (otherwise empty div does not center)
                if ( 'center' === $align && 'yes' !== $separator_inline_block && 'yes' !== $item_flex ) {
                    $this->add_render_attribute( $separator_key, 'style', 'margin-left: auto; margin-right: auto;' );
                }
                //Display separator inline-block if necessary
                if ( 'yes' === $separator_inline_block ) {
                    $this->add_render_attribute( $separator_key, 'style', 'display: inline-block;' );
                }
                $item_content .= sprintf( '<%1$s %2$s></%1$s>', $separator_element, $this->get_render_attribute_string( $separator_key ) );
            }
            
            //Output the content of each item
            $field_type = $item['field_type'];
            
            if ( 'wysiwyg' === $field_type ) {
                $content = $this->parse_text_editor( $item['wysiwyg'] );
                if ( 'yes' !== $show_empty_item && ('' === $content || !$content) ) {
                    continue;
                }
                $wysiwyg_key = $this->get_repeater_setting_key( 'wysiwyg', 'advanced_list', $index );
                $this->add_inline_editing_attributes( $wysiwyg_key, 'advanced' );
                $this->add_render_attribute( $wysiwyg_key, 'class', 'rfe-advanced-list-item-content' );
                $item_content .= '<div ' . $this->get_render_attribute_string( $wysiwyg_key ) . '>';
                $item_content .= $content;
                $item_content .= '</div>';
            }
            
            
            if ( 'text' === $field_type ) {
                $content = $item['text'];
                if ( 'yes' !== $show_empty_item && ('' === $content || !$content) ) {
                    continue;
                }
                $text_key = $this->get_repeater_setting_key( 'text', 'advanced_list', $index );
                $this->add_inline_editing_attributes( $text_key );
                $this->add_render_attribute( $text_key, 'class', 'rfe-advanced-list-item-content' );
                $content = $this->encapsulate_content_in_link( $content, $item, $index );
                $item_content .= sprintf(
                    '<%1$s %2$s>%3$s</%1$s>',
                    $content_element,
                    $this->get_render_attribute_string( $text_key ),
                    $content
                );
            }
            
            
            if ( 'image' === $field_type ) {
                $content = $item['image'];
                if ( 'yes' !== $show_empty_item && ('' === $item['image']['id'] || !$item['image']['id']) && ('' === $item['image']['url'] || !$item['image']['url']) ) {
                    continue;
                }
                $image_key = $this->get_repeater_setting_key( 'image', 'advanced_list', $index );
                $this->add_render_attribute( $image_key, 'class', 'rfe-advanced-list-item-content' );
                $size = $item['image_size'];
                $image_sizes = get_intermediate_image_sizes();
                $image_sizes[] = 'full';
                $image_class = " attachment-{$size} size-{$size}";
                $image_attr = [
                    'class' => trim( $image_class ),
                ];
                
                if ( $item['image']['id'] && '' !== $item['image']['id'] ) {
                    $image = wp_get_attachment_image(
                        $item['image']['id'],
                        $size,
                        false,
                        $image_attr
                    );
                } else {
                    
                    if ( $item['image']['url'] && '' !== $item['image']['url'] ) {
                        $image = sprintf( '<img src="%1$s" />', $item['image']['url'] );
                    } else {
                        $image = '';
                    }
                
                }
                
                $content = $this->encapsulate_content_in_link( $content, $item, $index );
                $item_content .= sprintf(
                    '<%1$s %2$s>%3$s</%1$s>',
                    $content_element,
                    $this->get_render_attribute_string( $image_key ),
                    $image
                );
            }
            
            
            if ( 'number' === $field_type ) {
                $content = $item['number'];
                if ( 'yes' !== $show_empty_item && ('' === $content || !$content) ) {
                    continue;
                }
                $number_key = $this->get_repeater_setting_key( 'number', 'advanced_list', $index );
                $this->add_render_attribute( $number_key, 'class', 'rfe-advanced-list-item-content' );
                $number = $content;
                $number_thousands_separator = $item['number_thousands_separator'];
                $number_decimal_separator = $item['number_decimal_separator'];
                $number_max_fraction = $item['number_max_fraction'];
                $number_min_fraction = $item['number_min_fraction'];
                $number_prefix = $item['number_prefix'];
                $number_suffix = $item['number_suffix'];
                $formatted_number = rfe_format_number(
                    $number,
                    $number_thousands_separator,
                    $number_decimal_separator,
                    $number_min_fraction,
                    $number_max_fraction
                );
                $content = $number_prefix . $formatted_number . $number_suffix;
                $content = $this->encapsulate_content_in_link( $content, $item, $index );
                $item_content .= sprintf(
                    '<%1$s %2$s>%3$s</%1$s>',
                    $content_element,
                    $this->get_render_attribute_string( $number_key ),
                    $content
                );
            }
            
            // $item_content .= '</div>';
            //Output the list item with its attributes
            echo  sprintf(
                '<%1$s %2$s>%3$s</%1$s>',
                $item_element,
                $this->get_render_attribute_string( $item_id ),
                $item_content
            ) ;
        }
        echo  '</div>' ;
    }
    
    public function encapsulate_content_in_link( $content, $item, $index )
    {
        $link_key = $this->get_repeater_setting_key( 'link', 'advanced_list', $index );
        
        if ( !empty($item['link']['url']) ) {
            $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );
            if ( $item['link']['is_external'] ) {
                $this->add_render_attribute( $link_key, 'target', '_blank' );
            }
            if ( !empty($item['link']['nofollow']) ) {
                $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
            }
            $content = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), $content );
        }
        
        return $content;
    }
    
    /**
     * Get all image sizes.
     *
     * Retrieve available image sizes with data like `width`, `height` and `crop`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array An array of available image sizes.
     */
    public static function get_all_image_sizes()
    {
        global  $_wp_additional_image_sizes ;
        $default_image_sizes = [
            'thumbnail',
            'medium',
            'medium_large',
            'large'
        ];
        $image_sizes = [];
        foreach ( $default_image_sizes as $size ) {
            $image_sizes[$size] = [
                'width'  => (int) get_option( $size . '_size_w' ),
                'height' => (int) get_option( $size . '_size_h' ),
                'crop'   => (bool) get_option( $size . '_crop' ),
            ];
        }
        if ( $_wp_additional_image_sizes ) {
            $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
        }
        /** This filter is documented in wp-admin/includes/media.php */
        $wp_image_sizes = apply_filters( 'image_size_names_choose', $image_sizes );
        $image_sizes = [];
        foreach ( $wp_image_sizes as $size_key => $size_attributes ) {
            $control_title = ucwords( str_replace( '_', ' ', $size_key ) );
            if ( is_array( $size_attributes ) ) {
                $control_title .= sprintf( ' - %d x %d', $size_attributes['width'], $size_attributes['height'] );
            }
            $image_sizes[$size_key] = $control_title;
        }
        $image_sizes['full'] = _x( 'Full', 'Image Size Control', 'elementor' );
        return $image_sizes;
    }

}