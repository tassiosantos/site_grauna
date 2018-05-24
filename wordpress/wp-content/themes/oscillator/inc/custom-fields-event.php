<?php
add_action( 'init', 'oscillator_create_event' );

function oscillator_create_event() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Event', 'oscillator' ),
		'edit_item'          => __( 'Edit Event', 'oscillator' ),
		'new_item'           => __( 'New Event', 'oscillator' ),
		'view_item'          => __( 'View Event', 'oscillator' ),
		'search_items'       => __( 'Search Events', 'oscillator' ),
		'not_found'          => __( 'No Events found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Events found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Event:', 'oscillator' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Event', 'post type singular name', 'oscillator' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'events-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'event', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-calendar'
	);

	register_post_type( 'oscillator_event' , $args );

	$labels = array(
		'name'              => _x( 'Event Categories', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Event Category', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Event Categories', 'oscillator' ),
		'all_items'         => __( 'All Event Categories', 'oscillator' ),
		'parent_item'       => __( 'Parent Event Category', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Event Category:', 'oscillator' ),
		'edit_item'         => __( 'Edit Event Category', 'oscillator' ),
		'update_item'       => __( 'Update Event Category', 'oscillator' ),
		'add_new_item'      => __( 'Add New Event Category', 'oscillator' ),
		'new_item_name'     => __( 'New Event Category Name', 'oscillator' ),
		'menu_name'         => __( 'Categories', 'oscillator' ),
		'view_item'         => __( 'View Event Category', 'oscillator' ),
		'popular_items'     => __( 'Popular Event Categories', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_event_category', array( 'oscillator_event' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'event-category', 'taxonomy slug', 'oscillator' ) ),
	) );

}

add_action( 'load-post.php', 'oscillator_event_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_event_meta_boxes_setup' );
function oscillator_event_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_event_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_event_save_meta', 10, 2 );
}

function oscillator_event_add_meta_boxes() {
	add_meta_box( 'oscillator-event-box', esc_html__( 'Event Settings', 'oscillator' ), 'oscillator_event_score_meta_box', 'oscillator_event', 'normal', 'high' );
}

function oscillator_event_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_event' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( esc_html__( 'Details', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_event_location', __( 'Event Location. For example: Ibiza, Spain', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_event_venue', __( 'Event Venue. For example: Ushuaia', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_event_recurrent', 1, __( 'Recurrent Event', 'oscillator' ) );
			?><div id="oscillator_event_recurrent_container"><?php
				oscillator_metabox_guide( sprintf( __( 'Enter the recurrence of the event. You may use <code>%1$s</code> to emphasise text. (e.g. <code>Every %1$sTuesday at 9pm%2$s</code>)', 'oscillator' ),
					esc_html( '<b>' ),
					esc_html( '</b>' )
				) );
				oscillator_metabox_input( 'oscillator_event_recurrence', __( 'Event Recurrence:', 'oscillator' ) );
			?></div><?php
			?><div id="oscillator_event_datetime_container"><?php
				oscillator_metabox_input( 'oscillator_event_date', __( 'Event Date. Use the Date Picker (Click inside the field).', 'oscillator' ), array( 'input_class' => 'datepicker widefat' ) );
				oscillator_metabox_input( 'oscillator_event_time', __( 'Event Time (e.g. <b>21:00</b>)', 'oscillator' ), array( 'input_class' => 'timepicker widefat' ) );
			?></div><?php
		oscillator_metabox_close_tab();

		oscillator_metabox_open_tab( esc_html__( 'Information', 'oscillator' ) );
			oscillator_metabox_guide( array(
				__( 'You may include as many rows of information as you want. Press <em>Add Field</em> to add a new row. Press <em>Remove me</em> to delete a specific row. You can rearrange rows by drag and drop. You may leave empty the title or the description, but not both.', 'oscillator' ),
				__( 'Allowed tags in description: a (href, class), span (class), i (class), b, em, strong. E.g.: <code>&lt;a href="#" class="btn">Button text&lt;/a></code>', 'oscillator' ),
			), array( 'type' => 'p' ) );
			?>
			<fieldset class="ci-repeating-fields">
				<div class="inner">
					<?php
						$fields = get_post_meta( $object->ID, 'oscillator_event_fields', true );

						if ( ! empty( $fields ) ) {
							foreach ( $fields as $field ) {
								?>
								<div class="post-field">
									<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_event_fields_repeatable_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
									<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_event_fields_repeatable_description[]" value="<?php echo esc_attr( $field['description'] ); ?>" class="widefat" /></label>
									<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
								</div>
								<?php
							}
						}
						?>
						<div class="post-field field-prototype" style="display: none;">
							<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_event_fields_repeatable_title[]" value="" class="widefat" /></label>
							<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_event_fields_repeatable_description[]" value="" class="widefat" /></label>
							<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
						</div>
				</div>
				<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Field', 'oscillator' ); ?></a>
			</fieldset>
			<?php
		oscillator_metabox_close_tab();

		oscillator_metabox_open_tab( esc_html__( 'Status', 'oscillator' ) );
			oscillator_metabox_guide( __( "In this section you can create two status buttons. The <em>Upcoming date</em> button will be the one displayed <strong>before</strong> the event's date, while the <em>Past date</em> button will be displayed <strong>after</strong> the event's date passes. This is useful so that you will not need to keep coming back editing the event, in situations like, providing a <em>Buy Tickets</em> button before the event and a <em>Watch Recorded</em> button afterwards. Leave a button's URL empty if you want it to be unclickable (e.g. when <strong>Canceled</strong>).", 'oscillator' ) );
			?><h4><?php esc_html_e( 'Upcoming date button', 'oscillator' ); ?></h4><?php
			oscillator_metabox_input( 'oscillator_event_upcoming_button', __( 'Button text (e.g. <em>Buy now</em>, <em>Watch live</em>, etc):', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_event_upcoming_url', esc_html__( 'Button URL:', 'oscillator' ), array( 'esc_func' => 'esc_url' ) );

			?><h4><?php esc_html_e( 'Past date button', 'oscillator' ); ?></h4><?php
			oscillator_metabox_input( 'oscillator_event_past_button', __( 'Button text (e.g. <em>Buy album</em>, <em>Watch recorded</em>, etc):', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_event_past_url', esc_html__( 'Button URL:', 'oscillator' ), array( 'esc_func' => 'esc_url' ) );
		oscillator_metabox_close_tab();


		oscillator_metabox_open_tab( esc_html__( 'Map', 'oscillator' ) );
			oscillator_metabox_guide( __( 'Enter a place or address and press <em>Search place/address</em>. Alternatively, you can drag the marker to the desired position, or double click on the map to set a new location.', 'oscillator' ) );
			?>
			<fieldset class="gllpLatlonPicker">
				<input type="text" class="gllpSearchField">
				<input type="button" class="button gllpSearchButton" value="<?php esc_attr_e( 'Search place/address', 'oscillator' ); ?>">
				<div class="gllpMap"><?php esc_html_e( 'Google Maps', 'oscillator' ); ?></div>
				<?php
					oscillator_metabox_input( 'oscillator_event_zoom', '', array(
						'input_type'  => 'hidden',
						'input_class' => 'gllpZoom',
						'default'     => '8'
					) );
					oscillator_metabox_input( 'oscillator_event_lat', __( 'Location Latitude.', 'oscillator' ), array(
						'input_class' => 'widefat gllpLatitude',
						'default'     => '36'
					) );
					oscillator_metabox_input( 'oscillator_event_lon', __( 'Location Longitude.', 'oscillator' ), array(
						'input_class' => 'widefat gllpLongitude',
						'default'     => '-120'
					) );
				?>
				<p><input type="button" class="button gllpUpdateButton" value="<?php esc_attr_e( 'Update map', 'oscillator' ); ?>"></p>
			</fieldset>
			<?php
		oscillator_metabox_close_tab();


	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_event_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_event' ) ) {
		return;
	}

	update_post_meta( $post_id, 'oscillator_event_recurrent', oscillator_sanitize_checkbox_ref( $_POST['oscillator_event_recurrent'] ) );
	update_post_meta( $post_id, 'oscillator_event_recurrence', strip_tags( $_POST['oscillator_event_recurrence'], '<b>' ) );

	if ( oscillator_sanitize_checkbox_ref( $_POST['oscillator_event_recurrent'] ) == 1 ) {
		// Since it's a recurring event, we need to delete date and time information, so
		// that it won't interfere with wp_query queries.
		delete_post_meta( $post_id, 'oscillator_event_date' );
		delete_post_meta( $post_id, 'oscillator_event_time' );
	} else {
		update_post_meta( $post_id, 'oscillator_event_date', sanitize_text_field( $_POST['oscillator_event_date'] ) );
		update_post_meta( $post_id, 'oscillator_event_time', sanitize_text_field( $_POST['oscillator_event_time'] ) );
	}

	update_post_meta( $post_id, 'oscillator_event_venue', sanitize_text_field( $_POST['oscillator_event_venue'] ) );
	update_post_meta( $post_id, 'oscillator_event_location', sanitize_text_field( $_POST['oscillator_event_location'] ) );

	update_post_meta( $post_id, 'oscillator_event_lon', sanitize_text_field( $_POST['oscillator_event_lon'] ) );
	update_post_meta( $post_id, 'oscillator_event_lat', sanitize_text_field( $_POST['oscillator_event_lat'] ) );
	update_post_meta( $post_id, 'oscillator_event_zoom', intval( $_POST['oscillator_event_zoom'] ) );

	update_post_meta( $post_id, 'oscillator_event_upcoming_button', sanitize_text_field( $_POST['oscillator_event_upcoming_button'] ) );
	update_post_meta( $post_id, 'oscillator_event_upcoming_url', esc_url_raw( $_POST['oscillator_event_upcoming_url'] ) );
	update_post_meta( $post_id, 'oscillator_event_past_button', sanitize_text_field( $_POST['oscillator_event_past_button'] ) );
	update_post_meta( $post_id, 'oscillator_event_past_url', esc_url_raw( $_POST['oscillator_event_past_url'] ) );

	update_post_meta( $post_id, 'oscillator_event_fields', oscillator_sanitize_event_fields_repeating( $_POST ) );
}

function oscillator_sanitize_event_fields_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles       = $POST_array['oscillator_event_fields_repeatable_title'];
	$descriptions = $POST_array['oscillator_event_fields_repeatable_description'];

	$count = max( count( $titles ), count( $descriptions ) );

	$new_fields = array();

	$records_count = 0;
	$allowed_html = array(
		'a'      => array(
			'href'  => array(),
			'class' => array(),
		),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'class' => array(),
		),
		'b'      => array(),
		'em'     => array(),
		'strong' => array(),
	);

	for ( $i = 0; $i < $count; $i++ ) {
		if ( empty( $titles[ $i ] ) && empty( $descriptions[ $i ] ) ) {
			continue;
		}

		$new_fields[ $records_count ]['title']       = sanitize_text_field( $titles[ $i ] );
		$new_fields[ $records_count ]['description'] = wp_kses( $descriptions[ $i ], $allowed_html );
		$records_count++;
	}
	return $new_fields;
}
