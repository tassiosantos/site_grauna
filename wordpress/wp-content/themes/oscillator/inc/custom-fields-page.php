<?php
	add_action( 'admin_init', 'oscillator_cpt_page_add_metaboxes' );
	add_action( 'save_post', 'oscillator_cpt_page_update_meta' );

	function oscillator_cpt_page_add_metaboxes() {
		add_meta_box( 'oscillator-tpl-artist-listing-meta', __( 'Artist Listing Options', 'oscillator' ), 'oscillator_add_page_artist_listing_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'oscillator-tpl-discography-listing-meta', __( 'Discography Listing Options', 'oscillator' ), 'oscillator_add_page_discography_listing_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'oscillator-tpl-gallery-listing-meta', __( 'Gallery Listing Options', 'oscillator' ), 'oscillator_add_page_gallery_listing_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'oscillator-tpl-video-listing-meta', __( 'Video Listing Options', 'oscillator' ), 'oscillator_add_page_video_listing_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'oscillator-tpl-event-listing-meta', __( 'Event Listing Options', 'oscillator' ), 'oscillator_add_page_event_listing_meta_box', 'page', 'normal', 'high' );
	}

	function oscillator_cpt_page_update_meta( $post_id ) {

		if ( ! oscillator_can_save_meta( 'page' ) ) {
			return;
		}

		update_post_meta( $post_id, 'oscillator_artist_listing_base_category', intval( $_POST['oscillator_artist_listing_base_category'] ) );
		update_post_meta( $post_id, 'oscillator_artist_listing_columns', intval( $_POST['oscillator_artist_listing_columns'] ) );
		update_post_meta( $post_id, 'oscillator_artist_listing_masonry', oscillator_sanitize_checkbox_ref( $_POST['oscillator_artist_masonry'] ) );
		update_post_meta( $post_id, 'oscillator_artist_listing_isotope', oscillator_sanitize_checkbox_ref( $_POST['oscillator_artist_listing_isotope'] ) );
		update_post_meta( $post_id, 'oscillator_artist_listing_posts_per_page', intval( $_POST['oscillator_artist_listing_posts_per_page'] ) );

		update_post_meta( $post_id, 'oscillator_discography_listing_base_category', intval( $_POST['oscillator_discography_listing_base_category'] ) );
		update_post_meta( $post_id, 'oscillator_discography_listing_columns', intval( $_POST['oscillator_discography_listing_columns'] ) );
		update_post_meta( $post_id, 'oscillator_discography_listing_masonry', oscillator_sanitize_checkbox_ref( $_POST['oscillator_discography_masonry'] ) );
		update_post_meta( $post_id, 'oscillator_discography_listing_isotope', oscillator_sanitize_checkbox_ref( $_POST['oscillator_discography_listing_isotope'] ) );
		update_post_meta( $post_id, 'oscillator_discography_listing_posts_per_page', intval( $_POST['oscillator_discography_listing_posts_per_page'] ) );

		update_post_meta( $post_id, 'oscillator_gallery_listing_base_category', intval( $_POST['oscillator_gallery_listing_base_category'] ) );
		update_post_meta( $post_id, 'oscillator_gallery_listing_columns', intval( $_POST['oscillator_gallery_listing_columns'] ) );
		update_post_meta( $post_id, 'oscillator_gallery_listing_masonry', oscillator_sanitize_checkbox_ref( $_POST['oscillator_gallery_masonry'] ) );
		update_post_meta( $post_id, 'oscillator_gallery_listing_isotope', oscillator_sanitize_checkbox_ref( $_POST['oscillator_gallery_listing_isotope'] ) );
		update_post_meta( $post_id, 'oscillator_gallery_listing_posts_per_page', intval( $_POST['oscillator_gallery_listing_posts_per_page'] ) );

		update_post_meta( $post_id, 'oscillator_video_listing_base_category', intval( $_POST['oscillator_video_listing_base_category'] ) );
		update_post_meta( $post_id, 'oscillator_video_listing_columns', intval( $_POST['oscillator_video_listing_columns'] ) );
		update_post_meta( $post_id, 'oscillator_video_listing_masonry', oscillator_sanitize_checkbox_ref( $_POST['oscillator_video_masonry'] ) );
		update_post_meta( $post_id, 'oscillator_video_listing_isotope', oscillator_sanitize_checkbox_ref( $_POST['oscillator_video_listing_isotope'] ) );
		update_post_meta( $post_id, 'oscillator_video_listing_posts_per_page', intval( $_POST['oscillator_video_listing_posts_per_page'] ) );

		update_post_meta( $post_id, 'oscillator_event_listing_base_category', intval( $_POST['oscillator_event_listing_base_category'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_sidebar', oscillator_sanitize_checkbox_ref( $_POST['oscillator_event_listing_sidebar'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_upcoming', oscillator_sanitize_checkbox_ref( $_POST['oscillator_event_listing_upcoming'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_past', oscillator_sanitize_checkbox_ref( $_POST['oscillator_event_listing_past'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_upcoming_title', sanitize_text_field( $_POST['oscillator_event_listing_upcoming_title'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_past_title', sanitize_text_field( $_POST['oscillator_event_listing_past_title'] ) );
		update_post_meta( $post_id, 'oscillator_event_listing_posts_per_page', intval( $_POST['oscillator_event_listing_posts_per_page'] ) );
	}

function oscillator_add_page_artist_listing_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_guide( __( "Select a base category. Only items from the selected category will be displayed. If you don't select one (i.e. empty) items from all categories will be shown.", 'oscillator' ) );
			?><p><label for="oscillator_artist_base_category"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label> <?php
			$category = get_post_meta( $object->ID, 'oscillator_artist_listing_base_category', true );
			wp_dropdown_categories( array(
				'selected'          => $category,
				'id'                => 'oscillator_artist_listing_base_category',
				'name'              => 'oscillator_artist_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'oscillator_artist_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i );
			}
			oscillator_metabox_dropdown( 'oscillator_artist_listing_columns', $options, __( 'Listing columns:', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_artist_masonry', 1, __( 'Masonry effect.', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_artist_listing_isotope', 1, __( 'Isotope effect (ignores <em>Items per page</em> setting).', 'oscillator' ) );
			oscillator_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'oscillator' ), get_option( 'posts_per_page' ) ) );
			oscillator_metabox_input( 'oscillator_artist_listing_posts_per_page', __( 'Items per page:', 'oscillator' ), array( 'input_type' => 'number' ) );
		oscillator_metabox_close_tab();
	?></div><?php

	oscillator_bind_metabox_to_page_template( 'oscillator-tpl-artist-listing-meta', 'template-listing-artist.php', 'oscillator_tpl_artist_listing_metabox' );
}

function oscillator_add_page_discography_listing_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_guide( __( "Select a base category. Only items from the selected category will be displayed. If you don't select one (i.e. empty) items from all categories will be shown.", 'oscillator' ) );
			?><p><label for="oscillator_discography_base_category"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label> <?php
			$category = get_post_meta( $object->ID, 'oscillator_discography_listing_base_category', true );
			wp_dropdown_categories( array(
				'selected'          => $category,
				'id'                => 'oscillator_discography_listing_base_category',
				'name'              => 'oscillator_discography_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'oscillator_discography_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i );
			}
			oscillator_metabox_dropdown( 'oscillator_discography_listing_columns', $options, __( 'Listing columns:', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_discography_masonry', 1, __( 'Masonry effect.', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_discography_listing_isotope', 1, __( 'Isotope effect (ignores <em>Items per page</em> setting).', 'oscillator' ) );
			oscillator_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'oscillator' ), get_option( 'posts_per_page' ) ) );
			oscillator_metabox_input( 'oscillator_discography_listing_posts_per_page', __( 'Items per page:', 'oscillator' ), array( 'input_type' => 'number' ) );
		oscillator_metabox_close_tab();
	?></div><?php

	oscillator_bind_metabox_to_page_template( 'oscillator-tpl-discography-listing-meta', 'template-listing-discography.php', 'oscillator_tpl_discography_listing_metabox' );
}

function oscillator_add_page_gallery_listing_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_guide( __( "Select a base category. Only items from the selected category will be displayed. If you don't select one (i.e. empty) items from all categories will be shown.", 'oscillator' ) );
			?><p><label for="oscillator_gallery_base_category"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label> <?php
			$category = get_post_meta( $object->ID, 'oscillator_gallery_listing_base_category', true );
			wp_dropdown_categories( array(
				'selected'          => $category,
				'id'                => 'oscillator_gallery_listing_base_category',
				'name'              => 'oscillator_gallery_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'oscillator_gallery_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i );
			}
			oscillator_metabox_dropdown( 'oscillator_gallery_listing_columns', $options, __( 'Listing columns:', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_gallery_masonry', 1, __( 'Masonry effect.', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_gallery_listing_isotope', 1, __( 'Isotope effect (ignores <em>Items per page</em> setting).', 'oscillator' ) );
			oscillator_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'oscillator' ), get_option( 'posts_per_page' ) ) );
			oscillator_metabox_input( 'oscillator_gallery_listing_posts_per_page', __( 'Items per page:', 'oscillator' ), array( 'input_type' => 'number' ) );
		oscillator_metabox_close_tab();
	?></div><?php

	oscillator_bind_metabox_to_page_template( 'oscillator-tpl-gallery-listing-meta', 'template-listing-gallery.php', 'oscillator_tpl_gallery_listing_metabox' );
}

function oscillator_add_page_video_listing_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_guide( __( "Select a base category. Only items from the selected category will be displayed. If you don't select one (i.e. empty) items from all categories will be shown.", 'oscillator' ) );
			?><p><label for="oscillator_video_base_category"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label> <?php
			$category = get_post_meta( $object->ID, 'oscillator_video_listing_base_category', true );
			wp_dropdown_categories( array(
				'selected'          => $category,
				'id'                => 'oscillator_video_listing_base_category',
				'name'              => 'oscillator_video_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'oscillator_video_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			$options = array();
			for ( $i = 2; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i );
			}
			oscillator_metabox_dropdown( 'oscillator_video_listing_columns', $options, __( 'Listing columns:', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_video_masonry', 1, __( 'Masonry effect.', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_video_listing_isotope', 1, __( 'Isotope effect (ignores <em>Items per page</em> setting).', 'oscillator' ) );
			oscillator_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'oscillator' ), get_option( 'posts_per_page' ) ) );
			oscillator_metabox_input( 'oscillator_video_listing_posts_per_page', __( 'Items per page:', 'oscillator' ), array( 'input_type' => 'number' ) );
		oscillator_metabox_close_tab();
	?></div><?php

	oscillator_bind_metabox_to_page_template( 'oscillator-tpl-video-listing-meta', 'template-listing-video.php', 'oscillator_tpl_video_listing_metabox' );
}

function oscillator_add_page_event_listing_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_guide( array(
				__( "Select a base category. Only items from the selected category will be displayed. If you don't select one (i.e. empty) items from all categories will be shown.", 'oscillator' ),
				__( 'Please note that this value affects upcoming and past events, as well as recurrent events.', 'oscillator' ),
			) );
			?><p class="ci-field-group"><label for="oscillator_event_base_category"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label> <?php
			$category = get_post_meta( $object->ID, 'oscillator_event_listing_base_category', true );
			wp_dropdown_categories( array(
				'selected'          => $category,
				'id'                => 'oscillator_event_listing_base_category',
				'name'              => 'oscillator_event_listing_base_category',
				'show_option_none'  => ' ',
				'option_none_value' => 0,
				'taxonomy'          => 'oscillator_event_category',
				'hierarchical'      => 1,
				'show_count'        => 1,
				'hide_empty'        => 0
			) );
			?></p><?php

			oscillator_metabox_checkbox( 'oscillator_event_listing_sidebar', 1, __( 'Show sidebar widgets.', 'oscillator' ), array( 'default' => 1 ) );
			oscillator_metabox_checkbox( 'oscillator_event_listing_upcoming', 1, __( 'Show upcoming events.', 'oscillator' ), array( 'default' => 1 ) );
			oscillator_metabox_input( 'oscillator_event_listing_upcoming_title', __( 'Upcoming events title:', 'oscillator' ), array( 'default' => __( 'Upcoming Events', 'oscillator' ) ) );
			oscillator_metabox_checkbox( 'oscillator_event_listing_past', 1, __( 'Show past events.', 'oscillator' ), array( 'default' => 1 ) );
			oscillator_metabox_input( 'oscillator_event_listing_past_title', __( 'Past events title:', 'oscillator' ), array( 'default' => __( 'Past Events', 'oscillator' ) ) );

			oscillator_metabox_guide( array(
				sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'oscillator' ), get_option( 'posts_per_page' ) ),
				__( 'Please note that this value affects upcoming and past events <strong>independently</strong>, and it does not affect recurrent events. For example, if you set it to <code>3</code>, all recurrent, 3 upcoming and 3 past events will be shown.', 'oscillator' ),
			) );
			oscillator_metabox_input( 'oscillator_event_listing_posts_per_page', __( 'Items per page:', 'oscillator' ) );
		oscillator_metabox_close_tab();
	?></div><?php

	oscillator_bind_metabox_to_page_template( 'oscillator-tpl-event-listing-meta', 'template-listing-event.php', 'oscillator_tpl_event_listing_metabox' );
}
