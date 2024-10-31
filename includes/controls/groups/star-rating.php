<?php
namespace RevolutionForElementor\Controls\Groups;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Group Control Tooltip
 *
 * @since 1.8.0
 */
class Group_Control_Star_Rating extends Group_Control_Base {

	protected static $fields;

	/**
	 * @since 1.8.0
	 * @access public
	 */
	public static function get_type() {
		return 'rfe-star-rating';
	}

	/**
	 * @since 1.8.0
	 * @access protected
	 */
	protected function init_fields() {
		$controls = [];
	
        $controls['rating'] =
            [
                'label' => __('Rating', 'revolution-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'min' => 0,
                'step' => 0.5,
                'default' => 3,
            ];


        $controls['max_rating'] = [
            'label' => __('Max Rating', 'revolution-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => [
                'active' => true,
            ],
            'step' => 1,
            'default' => 5,            
        ];

        
        $controls['show_rating_numbers'] = [
            'label' => __('Show Rating Numbers', 'revolution-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'revolution-for-elementor'),
            'label_on' => __('Yes', 'revolution-for-elementor'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => __('Whether or not to show numbers next to the stars.', 'revolution-for-elementor'),
        ];
        

        $controls['number_rating_separator'] = [
            'label' => __('Rating Separator', 'revolution-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'default' => '/',
        ];

        $controls['number_thousands_separator'] = [
            'label' => __('Thousands Separator', 'revolution-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'default' => ',',
        ];

        $controls['number_decimal_separator'] = [
            'label' => __('Decimal Separator', 'revolution-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'default' => '.',
        ];
        
        $controls['number_min_fraction'] = [
            'label' => __('Min Fraction Digits', 'revolution-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'min' => 0,
            'step' => 1,
            'default' => 0,
        ];

        $controls['number_max_fraction'] = [
            'label' => __('Max Fraction Digits', 'revolution-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'min' => 0,
            'step' => 1,
            'default' => 100,
        ];

        $controls['rating_numbers_position'] = [
            'label' => __('Numbers Position', 'revolution-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'before',
            'options' => [
                'left' => [
                    'title' => __('Before', 'revolution-for-elementor'),
                    'icon' 		=> 'fa fa-chevron-left',
                ],
                'right' => [
                    'title' => __('After', 'revolution-for-elementor'),
                    'icon' 		=> 'fa fa-chevron-right',
                ],
                'up' => [
                    'title' => __('Above', 'revolution-for-elementor'),
                    'icon' 		=> 'fa fa-chevron-up',
                ],
                'down' => [
                    'title' => __('Below', 'revolution-for-elementor'),
                    'icon' 		=> 'fa fa-chevron-down',
                ],
            ],
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
        ];


        $controls['number_spacing'] = [
            'label' 		=> __('Number Spacing', 'revolution-for-elementor'),
            'type' 			=> Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
            'selectors' => [
                '{{WRAPPER}} .rfe-star-rating-wrapper span' => 'margin: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .rfe-star-rating-wrapper'      => 'margin: -{{SIZE}}{{UNIT}};',
            ],
        ];

        $controls['star_color'] = [
            'label' => __('Star Color', 'revolution-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rfe-star-rating-stars' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
        ];

        $controls['number_color'] = [
            'label' => __('Number Color', 'revolution-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rfe-star-rating-numbers' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'show_rating_numbers' => ['yes'],
            ],
        ];

		return $controls;
	}

	/**
	 * @since 1.8.0
	 * @access protected
	 */
	protected function get_default_options() {
		return [
			'popover' => false,
		];
    }
    
    public static function render($prefix, $settings){
        $rating = $settings[$prefix . '_rating'];
        $rating = rfe_format_number($rating, '', '.', 0, 100);
        $rating = round($rating, 1, PHP_ROUND_HALF_EVEN);

        $max_rating = $settings[$prefix . '_max_rating'];
        $max_rating = rfe_format_number($max_rating, '', '.', 0, 100);
        $max_rating = round($max_rating, 1, PHP_ROUND_HALF_EVEN);

        if ($rating > $max_rating) {
            $rating = $max_rating;
        }

        
        //Create star rating
        $star_rating = '';
        for($i = 1; $i <= $max_rating; $i++) {

            if($rating >= $i) {
                $star_rating .= '<i class="fa fa-star"></i>';
            } else if (round($rating, 0, PHP_ROUND_HALF_UP) == $i){
                $star_rating .= '<i class="fa fa-star-half-o"></i>';
            } else {
                $star_rating .= '<i class="fa fa-star-o"></i>';
            }
        }

        $star_rating = sprintf(
            '<span class="rfe-star-rating-stars">%1$s</span>',
            $star_rating
        );


        //Add rating numbers if necessary
        $number_position_class = '';
        if('yes' === $settings[$prefix . '_show_rating_numbers']) {

            $number_rating_separator    = $settings[$prefix . '_number_rating_separator'];
            $number_thousands_separator = $settings[$prefix . '_number_thousands_separator'];
            $number_decimal_separator   = $settings[$prefix . '_number_decimal_separator'];
            $number_max_fraction        = $settings[$prefix . '_number_max_fraction'];
            $number_min_fraction        = $settings[$prefix . '_number_min_fraction'];


            $star_rating .= sprintf(
                '<span class="rfe-star-rating-numbers">%1$s%2$s%3$s</span>',
                rfe_format_number($rating, $number_thousands_separator, $number_decimal_separator, $number_min_fraction, $number_max_fraction),
                $number_rating_separator,
                rfe_format_number($max_rating, $number_thousands_separator, $number_decimal_separator, $number_min_fraction, $number_max_fraction)
            );
            
            switch($settings[$prefix . '_rating_numbers_position']){
                case 'left':
                $number_position_class = ' class="rfe-star-rating-number-left"';
                break;
                case 'right':
                $number_position_class = ' class="rfe-star-rating-number-right"';
                break;
                case 'up':
                $number_position_class = ' class="rfe-star-rating-number-up"';
                break;
                case 'down':
                $number_position_class = ' class="rfe-star-rating-number-down"';
                break;
            }

        }
// print_r($settings);

        return sprintf(
            '<div class="rfe-star-rating-wrapper">
                <div%2$s>%1$s</div>
             </div>',
            $star_rating,
            $number_position_class
        );
        
    }
}
