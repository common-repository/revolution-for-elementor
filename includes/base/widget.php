<?php

namespace RevolutionForElementor\Base;

use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

abstract class Revolution_Widget extends Widget_Base
{

    /**
     * Wether or not we are in edit mode
     *
     * Used for the add_helper_render_attribute method which needs to
     * add attributes only in edit mode
     *
     * @access protected
     *
     * @var bool
     */
    protected $_is_edit_mode = false;

    /**
     * Widget base constructor.
     *
     * Initializing the widget base class.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array       $data Widget data. Default is an empty array.
     * @param array|null  $args Optional. Widget default arguments. Default is null.
     */
    public function __construct($data = [], $args = null)
    {

        parent::__construct($data, $args);

        // Set edit mode
        $this->_is_edit_mode = \Elementor\Plugin::instance()->editor->is_edit_mode();
    }

    /**
     * Method for adding editor helper attributes
     *
     * Adds attributes that enable a display of a label for a specific html element
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function add_helper_render_attribute($key, $name = '')
    {

        if (!$this->_is_edit_mode) {
            return;
        }

        $this->add_render_attribute($key, [
            'data-rfe-helper' => $name,
            'class' => 'rfe-editor-helper',
        ]);
    }

    /**
     * Method for setting widget dependency on Elementor Pro plugin
     *
     * When returning true it doesn't allow the widget to be registered
     *
     * @access public
     * @since 1.0.0
     * @return bool
     */
    public static function requires_elementor_pro()
    {
        return false;
    }

}
