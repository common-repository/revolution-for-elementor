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

class Term_List extends Revolution_Widget
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
        return 'term-list';
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
        return __('Term List', 'revolution-for-elementor');
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
        return 'eicon-editor-list-ul';
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
        $post_type_names = [];

        $taxonomy_options = [];
        $taxonomies = get_taxonomies(['public' => true], 'objects');

        foreach ($taxonomies as $taxonomy) {

            //Skip our own taxonomy
            if ('rfe_taxonomy_related_category' === $taxonomy->name) {
                continue;
            }

            $taxonomy_name = $taxonomy->labels->name;
            $taxonomy_slug = $taxonomy->name;
            $taxonomy_post_types = [];

            $object_type = $taxonomy->object_type;

            foreach ($object_type as $post_type) {

                //Skip our own post type
                if ('rfe_taxonomy_related' === $post_type) {
                    continue;
                }

                $post_type_name = isset($post_type_names[$post_type]) ? $post_type_names[$post_type] : false;

                if (!$post_type_name) {
                    $post_type_name = get_post_type_object($post_type)->label;
                    $post_type_names[$post_type] = $post_type_name;
                }

                $taxonomy_post_types[] = $post_type_name;
            }

            $taxonomy_options[$taxonomy_slug] = sprintf(
                '%1$s (%2$s)',
                $taxonomy_name,
                implode(',', $taxonomy_post_types)
            );
        }

        $this->start_controls_section(
            'section_taxonomy',
            [
                'label' => __('Taxonomy', 'revolution-for-elementor'),
            ]
        );

        $this->add_control(
            'taxonomies',
            [
                'label' => __('Taxonomies', 'elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => $taxonomy_options,
            ]
        );

        $this->add_control('show_taxonomy_label', [
            'label' => __('Show Taxonomy Label', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
        ]);

        $this->add_control('taxonomy_label_element', [
            'label' => __('Label Element', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h5',
            'description' => __('The HTML element in which to wrap the label.', 'revolution-for-elementor'),
            'condition' => [
                'show_taxonomy_label' => ['yes'],
            ],
        ]);

        $this->add_control('show_emtpy_taxonomy', [
            'label' => __('Show Empty Taxonomy', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_terms',
            [
                'label' => __('Terms', 'revolution-for-elementor'),
            ]
        );

        $this->add_control('show_count', [
            'label' => __('Show Post Counts', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
        ]);

        $this->add_control('show_hierarchy', [
            'label' => __('Show Hierarchy', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
        ]);

        $this->add_control('show_empty', [
            'label' => __('Show Empty Terms', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
        ]);

        $this->add_control('style', [
            'label' => __('Style', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'list' => __('List', 'revolution-for-elementor'),
                'separator' => __('Separator', 'revolution-for-elementor'),
            ],
            'default' => 'list',
        ]);

        $this->add_control('separator', [
            'label' => __('Separator', 'revolution-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => ', ',
            'condition' => [
                'style' => ['separator'],
            ],
        ]);

        $this->add_control('orderby', [
            'label' => __('Order By', 'revolution-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'name' => __('Name', 'revolution-for-elementor'),
                'id' => __('ID', 'revolution-for-elementor'),
                'slug' => __('Slug', 'revolution-for-elementor'),
                'count' => __('Count', 'revolution-for-elementor'),
                'term_group' => __('Term Group', 'revolution-for-elementor'),
            ],
            'default' => 'name',
        ]);

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'revolution-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'asc',
                'options' => [
                    'asc' => [
                        'title' => __('Ascending', 'revolution-for-elementor'),
                        'icon' => 'fa fa-chevron-up',
                    ],
                    'desc' => [
                        'title' => __('Descending', 'revolution-for-elementor'),
                        'icon' => 'fa fa-chevron-down',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('List', 'elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'list_style',
            [
                'label' => __('List Style', 'revolution-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'disc',
                'options' => [
                    'none' => __('none', 'revolution-for-elementor'),
                    'disc' => __('disc', 'revolution-for-elementor'),
                    'circle' => __('circle', 'revolution-for-elementor'),
                    'square' => __('square', 'revolution-for-elementor'),
                    'initial' => __('initial', 'revolution-for-elementor'),
                    'inherit' => __('inherit', 'revolution-for-elementor'),
                    'armenian' => __('armenian', 'revolution-for-elementor'),
                    'cjk-ideographic' => __('cjk-ideographic', 'revolution-for-elementor'),
                    'decimal' => __('decimal', 'revolution-for-elementor'),
                    'decimal-leading-zero' => __('decimal-leading-zero', 'revolution-for-elementor'),
                    'georgian' => __('georgian', 'revolution-for-elementor'),
                    'hebrew' => __('hebrew', 'revolution-for-elementor'),
                    'hiragana' => __('hiragana', 'revolution-for-elementor'),
                    'hiragana-iroha' => __('hiragana-iroha', 'revolution-for-elementor'),
                    'katakana' => __('katakana', 'revolution-for-elementor'),
                    'katakana-iroha' => __('katakana-iroha', 'revolution-for-elementor'),
                    'lower-alpha' => __('lower-alpha', 'revolution-for-elementor'),
                    'upper-alpha' => __('upper-alpha', 'revolution-for-elementor'),
                    'lower-greek' => __('lower-greek', 'revolution-for-elementor'),
                    'upper-greek' => __('upper-greek', 'revolution-for-elementor'),
                    'lower-latin' => __('lower-latin', 'revolution-for-elementor'),
                    'upper-latin' => __('upper-latin', 'revolution-for-elementor'),
                    'lower-roman' => __('lower-roman', 'revolution-for-elementor'),
                    'upper-roman' => __('upper-roman', 'revolution-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} ul' => 'list-style-type: {{VALUE}};',
                    '{{WRAPPER}} ol' => 'list-style-type: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_margin',
            [
                'label' 		=> __( 'List Margin', 'elementor-extras' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', 'em', '%' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .elementor-widget-container > ul' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_padding',
            [
                'label' 		=> __( 'List Padding', 'elementor-extras' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', 'em', '%' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .elementor-widget-container > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                'label' => __('List Item Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('List Item Typography', 'elementor'),
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} li',
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
                'label' => __('Link Color', 'elementor'),
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

        $taxonomies = $settings['taxonomies'];
        $show_taxonomy_label = $settings['show_taxonomy_label'];
        $taxonomy_label_element = $settings['taxonomy_label_element'];
        $show_emtpy_taxonomy = $settings['show_emtpy_taxonomy'];

        $show_count = $settings['show_count'];
        $show_hierarchy = $settings['show_hierarchy'];
        $show_empty = $settings['show_empty'];
        $style = $settings['style'];
        $separator = $settings['separator'];
        $orderby = $settings['orderby'];
        $order = $settings['order'];

        foreach ($taxonomies as $taxonomy) {
            $taxonomy_object = get_taxonomy($taxonomy);

            $title = '';
            if ('yes' === $show_taxonomy_label) {
                $title = sprintf(
                    '<%1$s>%2$s</%1$s>',
                    $taxonomy_label_element,
                    $taxonomy_object->label
                );
            }

            $args = [
                'echo' => false,
                'taxonomy' => $taxonomy,
                'title_li' => '',
                'style' => $style,
                'separator' => $separator,
                'orderby' => $orderby,
                'order' => $order,
            ];

            $args['show_option_none'] = 'yes' === $show_emtpy_taxonomy ? sprintf(__('No %s', 'revolution-for-elementor'), $taxonomy_object->labels->name) : '';
            $args['hide_empty'] = 'yes' !== $show_empty;
            $args['hierarchical'] = 'yes' === $show_hierarchy;
            $args['show_count'] = 'yes' === $show_count;

            $list = wp_list_categories($args);

            if ('yes' !== $show_emtpy_taxonomy && (!$list || '' === $list)) {
                continue;
            }

            if ('separator' === $style) {
                $pos = strrpos($list, $separator);
                if ($pos !== false) {
                    $list = substr_replace($list, '', $pos, strlen($separator));
                }
            }

            if('yes' ===  $settings['remove_list_margin']){
                $this->add_render_attribute('term-list', 'style', 'margin: 0 !important;');
            }

            if('yes' ===  $settings['remove_list_padding']){
                $this->add_render_attribute('term-list', 'style', 'padding: 0 !important;');
            }
            

            echo sprintf(
                '%1$s
                 <ul %3$s>%2$s</ul>',
                $title,
                $list,
                $this->get_render_attribute_string('term-list')
            );
        }
    }
}
