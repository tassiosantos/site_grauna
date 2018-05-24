<?php
add_action( 'init', 'oscillator_create_discography' );

function oscillator_create_discography() {
	$labels = array(
		'name'               => _x( 'Discography', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Discography Item', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Discography', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Discography Item', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Discography Item', 'oscillator' ),
		'edit_item'          => __( 'Edit Discography Item', 'oscillator' ),
		'new_item'           => __( 'New Discography Item', 'oscillator' ),
		'view_item'          => __( 'View Discography Item', 'oscillator' ),
		'search_items'       => __( 'Search Discography Items', 'oscillator' ),
		'not_found'          => __( 'No Discography Items found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Discography Items found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Discography Item:', 'oscillator' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Discography Item', 'post type singular name', 'oscillator' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'discography-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'discography', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-format-audio'
	);

	register_post_type( 'oscillator_disco' , $args );

	$labels = array(
		'name'              => _x( 'Discography Sections', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Discography Section', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Discography Sections', 'oscillator' ),
		'all_items'         => __( 'All Discography Sections', 'oscillator' ),
		'parent_item'       => __( 'Parent Discography Section', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Discography Section:', 'oscillator' ),
		'edit_item'         => __( 'Edit Discography Section', 'oscillator' ),
		'update_item'       => __( 'Update Discography Section', 'oscillator' ),
		'add_new_item'      => __( 'Add New Discography Section', 'oscillator' ),
		'new_item_name'     => __( 'New Discography Section Name', 'oscillator' ),
		'menu_name'         => __( 'Discography Sections', 'oscillator' ),
		'view_item'         => __( 'View Discography Section', 'oscillator' ),
		'popular_items'     => __( 'Popular Discography Sections', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_discography_category', array( 'oscillator_disco' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'section', 'taxonomy slug', 'oscillator' ) ),
	) );

}

add_action( 'load-post.php', 'oscillator_discography_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_discography_meta_boxes_setup' );
function oscillator_discography_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_discography_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_discography_save_meta', 10, 2 );
}

function oscillator_discography_add_meta_boxes() {
	add_meta_box( 'oscillator-discography-box', esc_html__( 'Discography Settings', 'oscillator' ), 'oscillator_discography_score_meta_box', 'oscillator_disco', 'normal', 'high' );
}

function oscillator_discography_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_disco' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( esc_html__( 'Details', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_discography_date', __( 'Release Date:', 'oscillator' ), array( 'input_class' => 'datepicker widefat' ) );
			oscillator_metabox_input( 'oscillator_discography_label', __( 'Record Label:', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_discography_cat_no', __( 'Catalog Number:', 'oscillator' ) );
		oscillator_metabox_close_tab();

		oscillator_metabox_open_tab( esc_html__( 'Tracks', 'oscillator' ) );
			oscillator_metabox_guide( __( 'You may add the tracks of your release, along with related information such as a Download URL, Buy URL and lyrics. Press the <em>Add Track</em> button to add a new track, and individually the <em>Remove me</em> button to delete a track. You can also use a SoundCloud URL in place of the Play URL.', 'oscillator' ) );
			?>
			<div class="ci-repeating-fields repeating-tracks">
				<table class="tracks inner">
					<thead>
					 <tr>
						 <th class="tracks-no"><?php echo esc_html_x( '#', 'number sign', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Title', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Subtitle', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Artist', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Buy URL', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Play URL', 'oscillator' ); ?></th>
						 <th><?php esc_html_e( 'Download URL', 'oscillator' ); ?></th>
						 <th class="tracks-action"></th>
					 </tr>
					</thead>
						<?php
							$fields = get_post_meta( $object->ID, 'oscillator_discography_tracks', true );

							if ( ! empty( $fields ) ) {
								$i = 0;
								foreach ( $fields as $field ) {
									$i++;
									?>
									<tbody class="track-group post-field">
										<tr>
											<td class="tracks-no" rowspan="2"><span class="dashicons dashicons-sort"></span><?php echo esc_html_x( '#', 'track number', 'oscillator' ); ?><span class="track-num"><?php echo esc_html( $i ); ?></span></td>
											<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_title[]" placeholder="<?php esc_attr_e( 'Title', 'oscillator' ); ?>" value="<?php echo esc_attr( $field['title'] ); ?>" /></td>
											<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_subtitle[]" placeholder="<?php esc_attr_e( 'Subtitle', 'oscillator' ); ?>" value="<?php echo esc_attr( $field['subtitle'] ); ?>" /></td>
											<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_artist[]" placeholder="<?php esc_attr_e( 'Artist', 'oscillator' ); ?>" value="<?php echo esc_attr( $field['artist'] ); ?>" /></td>
											<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_buy_url[]" placeholder="<?php esc_attr_e( 'Buy URL', 'oscillator' ); ?>" value="<?php echo esc_url( $field['buy_url'] ); ?>" /></td>
											<td class="tracks-field"><div class="wp-media-buttons"><input type="text" name="oscillator_discography_tracks_repeatable_play_url[]" placeholder="<?php esc_attr_e( 'Play URL', 'oscillator' ); ?>" value="<?php echo esc_url( $field['play_url'] ); ?>" class="ci-uploaded-url with-button" /><a href="#" class="ci-media-button ci-upload-track button add_media" data-type="audio"><span class="wp-media-buttons-icon"></span></a></div></td>
											<td class="tracks-field"><div class="wp-media-buttons"><input type="text" name="oscillator_discography_tracks_repeatable_download_url[]" placeholder="<?php esc_attr_e( 'Download URL', 'oscillator' ); ?>" value="<?php echo esc_url( $field['download_url'] ); ?>" class="ci-uploaded-url with-button" /><a href="#" class="ci-media-button ci-upload-track button add_media" data-type="audio"><span class="wp-media-buttons-icon"></span></a></div></td>
											<td class="tracks-action"><a href="#" class="ci-repeating-remove-field"><span class="dashicons dashicons-no"></span></a></td>
										</tr>
										<tr>
											<td class="tracks-field" colspan="8"><textarea placeholder="<?php esc_attr_e( 'Song Lyrics', 'oscillator' ); ?>" name="oscillator_discography_tracks_repeatable_lyrics[]"><?php echo esc_textarea( $field['lyrics'] ); ?></textarea></td>
										</tr>
									</tbody>
									<?php
								}
							}
						?>
						<tbody class="track-group post-field field-prototype" style="display: none;"">
							<tr>
								<td class="tracks-no" rowspan="2"><span class="dashicons dashicons-sort"></span><?php echo esc_html_x( '#', 'track number', 'oscillator' ); ?><span class="track-num"></span></td>
								<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_title[]" placeholder="<?php esc_attr_e( 'Title', 'oscillator' ); ?>" value="" /></td>
								<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_subtitle[]" placeholder="<?php esc_attr_e( 'Subtitle', 'oscillator' ); ?>" value="" /></td>
								<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_artist[]" placeholder="<?php esc_attr_e( 'Artist', 'oscillator' ); ?>" value="" /></td>
								<td class="tracks-field"><input type="text" name="oscillator_discography_tracks_repeatable_buy_url[]" placeholder="<?php esc_attr_e( 'Buy URL', 'oscillator' ); ?>" value="" /></td>
								<td class="tracks-field"><div class="wp-media-buttons"><input type="text" name="oscillator_discography_tracks_repeatable_play_url[]" placeholder="<?php esc_attr_e( 'Play URL', 'oscillator' ); ?>" value="" class="ci-uploaded-url with-button" /><a href="#" class="ci-media-button ci-upload-track button add_media" data-type="audio"><span class="wp-media-buttons-icon"></span></a></div></td>
								<td class="tracks-field"><div class="wp-media-buttons"><input type="text" name="oscillator_discography_tracks_repeatable_download_url[]" placeholder="<?php esc_attr_e( 'Download URL', 'oscillator' ); ?>" value="" class="ci-uploaded-url with-button" /><a href="#" class="ci-media-button ci-upload-track button add_media" data-type="audio"><span class="wp-media-buttons-icon"></span></a></div></td>
								<td class="tracks-action"><a href="#" class="ci-repeating-remove-field"><span class="dashicons dashicons-no"></span></a></td>
							</tr>
							<tr>
								<td class="tracks-field" colspan="8"><textarea placeholder="<?php esc_attr_e( 'Song Lyrics', 'oscillator' ); ?>" name="oscillator_discography_tracks_repeatable_lyrics[]"></textarea></td>
							</tr>
						</tbody>
				</table>
				<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Track', 'oscillator' ); ?></a>
			</div>
			<?php
			oscillator_metabox_guide( array(
				__( 'To display the track listing in your content, you need to use the <code>[tracklisting]</code> shortcode at the desired position.', 'oscillator' ),
				__( 'The <code>[tracklisting]</code> shortcode, by default will display the tracks of the current discography item. You may also display the track listing of any discography item in any other post/page or widget (that supports shortcodes) by passing the <code>ID</code> or <code>slug</code> parameter to the shortcode. E.g. <code>[tracklisting id="25"]</code> or <code>[tracklisting slug="the-division-bell"]</code>', 'oscillator' ),
				__( 'You can also selectively display tracks, by passing their track number (counting from 1), separated by a comma, like this <code>[tracklisting tracks="2,5,8"]</code> and can limit the total number of tracks displayed like <code>[tracklisting limit="3"]</code>', 'oscillator' ),
				__( 'Of course, you can mix and match the parameters, so the following is totally valid: <code>[tracklisting slug="the-division-bell" tracks="2,5,8" limit="2"]</code>', 'oscillator' ),
				__( "You may also add a SoundCloud track by copying the track's URL (the one given by it's <em>Share</em> button) and pasting it into the Play URL field.", 'oscillator' ),
			) );
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
						$fields = get_post_meta( $object->ID, 'oscillator_discography_fields', true );

						if ( ! empty( $fields ) ) {
							foreach ( $fields as $field ) {
								?>
								<div class="post-field">
									<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_discography_fields_repeatable_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
									<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_discography_fields_repeatable_description[]" value="<?php echo esc_attr( $field['description'] ); ?>" class="widefat" /></label>
									<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
								</div>
								<?php
							}
						}
						?>
						<div class="post-field field-prototype" style="display: none;">
							<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_discography_fields_repeatable_title[]" value="" class="widefat" /></label>
							<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_discography_fields_repeatable_description[]" value="" class="widefat" /></label>
							<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
						</div>
				</div>
				<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Field', 'oscillator' ); ?></a>
			</fieldset>
			<?php
		oscillator_metabox_close_tab();

	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_discography_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_disco' ) ) {
		return;
	}

	update_post_meta( $post_id, 'oscillator_discography_date', sanitize_text_field( $_POST['oscillator_discography_date'] ) );
	update_post_meta( $post_id, 'oscillator_discography_label', sanitize_text_field( $_POST['oscillator_discography_label'] ) );
	update_post_meta( $post_id, 'oscillator_discography_cat_no', sanitize_text_field( $_POST['oscillator_discography_cat_no'] ) );

	update_post_meta( $post_id, 'oscillator_discography_tracks', oscillator_sanitize_discography_tracks_repeating( $_POST ) );
	update_post_meta( $post_id, 'oscillator_discography_fields', oscillator_sanitize_discography_fields_repeating( $_POST ) );
}

function oscillator_sanitize_discography_tracks_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return array();
	}

	$titles        = $POST_array['oscillator_discography_tracks_repeatable_title'];
	$subtitles     = $POST_array['oscillator_discography_tracks_repeatable_subtitle'];
	$artists       = $POST_array['oscillator_discography_tracks_repeatable_artist'];
	$buy_urls      = $POST_array['oscillator_discography_tracks_repeatable_buy_url'];
	$download_urls = $POST_array['oscillator_discography_tracks_repeatable_download_url'];
	$play_urls     = $POST_array['oscillator_discography_tracks_repeatable_play_url'];
	$lyrics        = $POST_array['oscillator_discography_tracks_repeatable_lyrics'];

	$count = max(
		count( $titles ),
		count( $subtitles ),
		count( $artists ),
		count( $buy_urls ),
		count( $download_urls ),
		count( $play_urls ),
		count( $lyrics )
	);

	$new_fields = array();

	$records_count = 0;

	for ( $i = 0; $i < $count; $i++ ) {
		if ( empty( $titles[$i] )
			&& empty( $subtitles[$i] )
			&& empty( $artists[$i] )
			&& empty( $buy_urls[$i] )
			&& empty( $download_urls[$i] )
			&& empty( $play_urls[$i] )
			&& empty( $lyrics[$i] )
		) {
			continue;
		}

		$new_fields[ $records_count ]['title']        = sanitize_text_field( $titles[ $i ] );
		$new_fields[ $records_count ]['subtitle']     = sanitize_text_field( $subtitles[ $i ] );
		$new_fields[ $records_count ]['artist']       = sanitize_text_field( $artists[ $i ] );
		$new_fields[ $records_count ]['buy_url']      = esc_url_raw( $buy_urls[ $i ] );
		$new_fields[ $records_count ]['download_url'] = esc_url_raw( $download_urls[ $i ] );
		$new_fields[ $records_count ]['play_url']     = esc_url_raw( $play_urls[ $i ] );
		$new_fields[ $records_count ]['lyrics']       = wp_kses_post( $lyrics[ $i ] );

		$records_count++;
	}
	return $new_fields;
}

function oscillator_sanitize_discography_fields_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles       = $POST_array['oscillator_discography_fields_repeatable_title'];
	$descriptions = $POST_array['oscillator_discography_fields_repeatable_description'];

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
