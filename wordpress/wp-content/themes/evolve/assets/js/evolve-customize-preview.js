/**
 * File customize-preview.js.
 *
 * Instantly live-update customizer settings in the preview for improved user experience.
 */

(function( $ ) {

        wp.customize( 'evl_content_box2_title', function( value ) {
		value.bind( function( newval ) {
			$( '.content-box-2 h2' ).text( newval );
		});
	});

        //Update site title color in real time...
	wp.customize( 'evl_content_box2_icon_color', function( value ) {
		value.bind( function( newval ) {
			$('.content-box-2 i').css('color', newval );
		} );
	} );

} )( jQuery );
