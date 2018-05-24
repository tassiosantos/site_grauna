jQuery(document).ready(function($) {

	if ( $.isFunction( $.fn.datepicker ) ) {
		var ciDatePicker = $( '.postbox .datepicker' );

		ciDatePicker.each( function() {
			$( this ).datepicker( {
				dateFormat: 'yy-mm-dd'
			} );
		} );
	}

	if ( $.isFunction( $.fn.timepicker ) ) {
		var ciTimePicker = $( '.postbox .timepicker' );

		ciTimePicker.each( function() {
			$( this ).timepicker( {
				ampm: false,
				timeFormat: 'HH:mm',
				stepMinute: 5
			} );
		} );
	}

	//
	// Events
	//
	var isEnabled = $( '#oscillator_event_recurrent' ).prop( 'checked' );
	var datetime = $( '#oscillator_event_datetime_container' );
	var recurrence = $( '#oscillator_event_recurrent_container' );

	if ( isEnabled ) {
		datetime.hide();
		recurrence.show();
	} else {
		datetime.show();
		recurrence.hide();
	}

	$( '#oscillator_event_recurrent' ).click( function() {
		var datetime = $( '#oscillator_event_datetime_container' );
		var recurrence = $( '#oscillator_event_recurrent_container' );
		if ( $( this ).prop( 'checked' ) ) {
			datetime.hide();
			recurrence.show();
		} else {
			datetime.show();
			recurrence.hide();
		}
	} );


	//
	// Discography tracks (repeating fields)
	//
	$( '.repeating-tracks .tracks' ).sortable( {
		update: renumberTracks
	} );


	// Repeating fields
	oscillator_repeating_sortable_init();

	var $body = $( 'body' );

	$body.on( 'click', '.repeating-tracks .ci-repeating-add-field', function( e ) {
		"use strict";
		renumberTracks();
		e.preventDefault();
	} );


	$body.on( 'click', '.repeating-tracks .ci-repeating-remove-field', function( e ) {
		"use strict";
		var field = $( this ).parents( '.post-field' );
		field.remove();
		renumberTracks();
		e.preventDefault();
	} );


	function renumberTracks() {
		var $i = 1;
		var $tbody = $( "table.tracks" ).find( "tbody:not(.field-prototype)" );

		$tbody.each( function() {
			$( this ).find( ".track-num" ).text( $i );
			$i++;
		} );
	}

});
