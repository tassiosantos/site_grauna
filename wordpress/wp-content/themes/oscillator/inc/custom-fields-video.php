<?php
add_action( 'init', 'oscillator_create_video' );

function oscillator_create_video() {
	$labels = array(
		'name'               => _x( 'Videos', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Video', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Videos', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Video', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Video', 'oscillator' ),
		'edit_item'          => __( 'Edit Video', 'oscillator' ),
		'new_item'           => __( 'New Video', 'oscillator' ),
		'view_item'          => __( 'View Video', 'oscillator' ),
		'search_items'       => __( 'Search Videos', 'oscillator' ),
		'not_found'          => __( 'No Videos found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Videos found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Video:', 'oscillator' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Video', 'post type singular name', 'oscillator' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'videos-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'video', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-format-video'
	);

	register_post_type( 'oscillator_video' , $args );

	$labels = array(
		'name'              => _x( 'Video Categories', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Video Category', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Video Categories', 'oscillator' ),
		'all_items'         => __( 'All Video Categories', 'oscillator' ),
		'parent_item'       => __( 'Parent Video Category', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Video Category:', 'oscillator' ),
		'edit_item'         => __( 'Edit Video Category', 'oscillator' ),
		'update_item'       => __( 'Update Video Category', 'oscillator' ),
		'add_new_item'      => __( 'Add New Video Category', 'oscillator' ),
		'new_item_name'     => __( 'New Video Category Name', 'oscillator' ),
		'menu_name'         => __( 'Categories', 'oscillator' ),
		'view_item'         => __( 'View Video Category', 'oscillator' ),
		'popular_items'     => __( 'Popular Video Categories', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_video_category', array( 'oscillator_video' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'video-category', 'taxonomy slug', 'oscillator' ) ),
	) );

}

add_action( 'load-post.php', 'oscillator_video_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_video_meta_boxes_setup' );
function oscillator_video_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_video_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_video_save_meta', 10, 2 );
}

function oscillator_video_add_meta_boxes() {
	add_meta_box( 'oscillator-video-box', esc_html__( 'Video Settings', 'oscillator' ), 'oscillator_video_score_meta_box', 'oscillator_video', 'normal', 'high' );
}

function oscillator_video_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_video' );

	?><div class="ci-cf-wrap"><?php
	oscillator_metabox_open_tab( esc_html__( 'Details', 'oscillator' ) );
			oscillator_metabox_guide( sprintf( __( 'In the following box, you can simply enter the URL of a supported website\'s video. It needs to start with <code>http://</code> or <code>https://</code> (E.g. <code>%1$s</code>). A list of supported websites can be <a href="%2$s">found here</a>.', 'oscillator' ), 'https://www.youtube.com/watch?v=4Z9WVZddH9w', 'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ) );
			oscillator_metabox_input( 'oscillator_video_url', __( 'Video URL:', 'oscillator' ), array( 'esc_func' => 'esc_url' ) );

			oscillator_metabox_input( 'oscillator_video_location', __( 'Video Location. For example: Ibiza, Spain', 'oscillator' ) );

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
					$fields = get_post_meta( $object->ID, 'oscillator_video_fields', true );

					if ( ! empty( $fields ) ) {
						foreach ( $fields as $field ) {
							?>
							<div class="post-field">
								<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_video_fields_repeatable_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
								<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_video_fields_repeatable_description[]" value="<?php echo esc_attr( $field['description'] ); ?>" class="widefat" /></label>
								<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
							</div>
							<?php
						}
					}
					?>
					<div class="post-field field-prototype" style="display: none;">
						<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_video_fields_repeatable_title[]" value="" class="widefat" /></label>
						<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_video_fields_repeatable_description[]" value="" class="widefat" /></label>
						<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
					</div>
			</div>
			<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Field', 'oscillator' ); ?></a>
		</fieldset>
		<?php
	oscillator_metabox_close_tab();
	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_video_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_video' ) ) {
		return;
	}

	update_post_meta( $post_id, 'oscillator_video_url', esc_url_raw( $_POST['oscillator_video_url'] ) );
	update_post_meta( $post->ID, 'oscillator_video_location', sanitize_text_field( $_POST['oscillator_video_location'] ) );

	update_post_meta( $post_id, 'oscillator_video_fields', oscillator_sanitize_video_fields_repeating( $_POST ) );
}


function oscillator_sanitize_video_fields_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles       = $POST_array['oscillator_video_fields_repeatable_title'];
	$descriptions = $POST_array['oscillator_video_fields_repeatable_description'];

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
