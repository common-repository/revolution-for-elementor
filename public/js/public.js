var isAdminBar = false,
    isEditMode = false;

(function ($) {
    'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    var getElementSettings = function ($element) {
        var elementSettings = {},
            modelCID = $element.data('model-cid');

        if (isEditMode && modelCID) {
            var settings = elementorFrontend.config.elements.data[modelCID],
                settingsKeys = elementorFrontend.config.elements.keys[settings.attributes.widgetType || settings.attributes.elType];

            jQuery.each(settings.getActiveControls(), function (controlKey) {
                if (-1 !== settingsKeys.indexOf(controlKey)) {
                    elementSettings[controlKey] = settings.attributes[controlKey];
                }
            });
        } else {
            elementSettings = $element.data('settings') || {};
        }

        return elementSettings;
    };

    var FlexColumnsFrontEndHandler = function ($scope, $) {
        var elementSettings = getElementSettings($scope);

        if ('yes' !== elementSettings.flex_columns_flexbox_enabled) {
            return;
        }

        console.log("Flex enabled", elementSettings);
        

        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('display', 'flex');
        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('flex-direction', elementSettings.flex_columns_flex_direction);
        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('align-items', elementSettings.flex_columns_align_items);
        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('justify-content', elementSettings.flex_columns_justify_content);
        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('align-content', elementSettings.flex_columns_align_content);
        $scope.children('.elementor-column-wrap').children('.elementor-widget-wrap').css('flex-wrap', elementSettings.flex_columns_flex_wrap);

    }

    var ParticlesFrontEndHandler = function ($scope, $) {
        var elementSettings = getElementSettings($scope);

        // Detach every time

        // Exit if particles are not enabled
        if ('yes' !== elementSettings.particles_enabled) {
            return;
        }

        //Get ID 
        var id = '';
        if (!$scope.attr("id")) {
            id = 'p' + $scope.data('id');
            $scope.attr('id', id);
        } else {
            id = $scope.attr('id');
        }

        var template_url = object_name.template_url;
        var config_url = '';
        switch (elementSettings.particles_style) {
            case 'default':
                config_url = template_url + "assets/particlesjs-default.json";
                break;
            case 'nasa':
                config_url = template_url + "assets/particlesjs-nasa.json";
                break;
            case 'bubble':
                config_url = template_url + "assets/particlesjs-bubble.json";
                break;
            case 'snow':
                config_url = template_url + "assets/particlesjs-snow.json";
                break;
        }

        
/* Premium Code Stripped by Freemius */

            $.getJSON(config_url, function (data) {

                if (elementSettings.particles_color) {
                    data.particles.color.value = elementSettings.particles_color
                }

                if (elementSettings.particles_link_color) {
                    data.particles.line_linked.color = elementSettings.particles_link_color
                }

                particlesJS(id, data);

            });
            
/* Premium Code Stripped by Freemius */


        $scope.children('div').each(function () {
            $(this).css('z-index', '10');
        });

        $scope.children('canvas').each(function () {
            $(this).css('z-index', '1');
        });
    }

    $(window).on('elementor/frontend/init', function () {

        if (elementorFrontend.isEditMode()) {
            isEditMode = true;
        }

        if ($('body').is('.admin-bar')) {
            isAdminBar = true;
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/section', ParticlesFrontEndHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/column', FlexColumnsFrontEndHandler);
    });

})(jQuery);
