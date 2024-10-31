(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	$(document).ready(function (){

		var activetab = '';
	
		$('.rfe-settings__group').hide();
	
		if ( typeof( window.localStorage ) !== 'undefined' ) {
			
			activetab = window.localStorage.getItem("rfe-activetab");

		}
		
		if( window.location.hash ) {
	
			activetab = window.location.hash;

			if ( typeof( window.localStorage ) !== 'undefined' ) {

				window.localStorage.setItem( "rfe-activetab", activetab );
	
			}                
		} 
		
		if ( activetab != '' && $( activetab ).length ) {

			$(activetab).fadeIn();

		} else {

			$('.rfe-settings__group:first').fadeIn();

		}
	
		$('.rfe-settings__group .collapsed').each( function() {
	
			$(this).find('input:checked').parent().parent().parent().nextAll().each(
	
				function() {
	
					if ( $(this).hasClass('last') ) {
						$(this).removeClass('hidden');
						return false;
					}
	
					$(this).filter('.hidden').removeClass('hidden');
				}
	
			);

		});
	
		if ( activetab != '' && $( activetab + '-tab' ).length ) {

			$( activetab + '-tab' ).addClass('nav-tab-active');

		} else {

			$('.rfe-nav-tabs a:first').addClass('nav-tab-active');

		}
		
		$('.rfe-nav-tabs a').click( function( e ) {
	
			if ( $(this).is( '.rfe-nav-tabs__link' ) ) {
				return;
			}
	
			$('.rfe-nav-tabs a').removeClass('nav-tab-active');
	
			$(this).addClass('nav-tab-active').blur();
	
			var clicked_group = $(this).attr('href');
	
			if ( typeof( window.localStorage ) !== 'undefined' ) {
				
				window.localStorage.setItem("rfe-activetab", $(this).attr('href'));

			}
			
			$('.rfe-settings__group').hide();
			
			$(clicked_group).fadeIn();
			
			e.preventDefault();
		});
	
	});

})( jQuery );
