<?php
add_action( 'init', 'oscillator_create_artist' );

function oscillator_create_artist() {
	$labels = array(
		'name'               => _x( 'Artists', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Artist', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Artists', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Artist', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Artist', 'oscillator' ),
		'edit_item'          => __( 'Edit Artist', 'oscillator' ),
		'new_item'           => __( 'New Artist', 'oscillator' ),
		'view_item'          => __( 'View Artist', 'oscillator' ),
		'search_items'       => __( 'Search Artists', 'oscillator' ),
		'not_found'          => __( 'No Artists found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Artists found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Artist:', 'oscillator' ),
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Artist', 'post type singular name', 'oscillator' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'artists-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'artist', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-admin-users'
	);

	register_post_type( 'oscillator_artist' , $args );

	$labels = array(
		'name'              => _x( 'Artist Categories', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Artist Category', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Artist Categories', 'oscillator' ),
		'all_items'         => __( 'All Artist Categories', 'oscillator' ),
		'parent_item'       => __( 'Parent Artist Category', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Artist Category:', 'oscillator' ),
		'edit_item'         => __( 'Edit Artist Category', 'oscillator' ),
		'update_item'       => __( 'Update Artist Category', 'oscillator' ),
		'add_new_item'      => __( 'Add New Artist Category', 'oscillator' ),
		'new_item_name'     => __( 'New Artist Category Name', 'oscillator' ),
		'menu_name'         => __( 'Categories', 'oscillator' ),
		'view_item'         => __( 'View Artist Category', 'oscillator' ),
		'popular_items'     => __( 'Popular Artist Categories', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_artist_category', array( 'oscillator_artist' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'artist-category', 'taxonomy slug', 'oscillator' ) ),
	) );

}


add_action( 'load-post.php', 'oscillator_artist_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_artist_meta_boxes_setup' );
function oscillator_artist_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_artist_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_artist_save_meta', 10, 2 );
}

function oscillator_artist_add_meta_boxes() {
	add_meta_box( 'oscillator-artist-box', esc_html__( 'Artist Settings', 'oscillator' ), 'oscillator_artist_score_meta_box', 'oscillator_artist', 'normal', 'high' );
}

function oscillator_artist_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_artist' );

	?><div class="ci-cf-wrap"><?php

	oscillator_metabox_open_tab( esc_html__( 'Information', 'oscillator' ) );
		oscillator_metabox_guide( array(
			__( 'You may include as many rows of information as you want. Press <em>Add Field</em> to add a new row. Press <em>Remove me</em> to delete a specific row. You can rearrange rows by drag and drop. You may leave empty the title or the description, but not both.', 'oscillator' ),
			__( 'Allowed tags in description: a (href, class), span (class), i (class), b, em, strong. E.g.: <code>&lt;a href="#" class="btn">Button text&lt;/a></code>', 'oscillator' ),
		), array( 'type' => 'p' ) );
		?>
		<fieldset class="ci-repeating-fields">
			<div class="inner">
				<?php
					$fields = get_post_meta( $object->ID, 'oscillator_artist_fields', true );

					if ( ! empty( $fields ) ) {
						foreach ( $fields as $field ) {
							?>
							<div class="post-field">
								<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_artist_fields_repeatable_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
								<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_artist_fields_repeatable_description[]" value="<?php echo esc_attr( $field['description'] ); ?>" class="widefat" /></label>
								<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
							</div>
							<?php
						}
					}
					?>
					<div class="post-field field-prototype" style="display: none;">
						<label><?php esc_html_e( 'Title:', 'oscillator' ); ?> <input type="text" name="oscillator_artist_fields_repeatable_title[]" value="" class="widefat" /></label>
						<label><?php esc_html_e( 'Description:', 'oscillator' ); ?> <input type="text" name="oscillator_artist_fields_repeatable_description[]" value="" class="widefat" /></label>
						<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
					</div>
			</div>
			<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Field', 'oscillator' ); ?></a>
		</fieldset>
		<?php
	oscillator_metabox_close_tab();
	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_artist_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_artist' ) ) {
		return;
	}

	update_post_meta( $post_id, 'oscillator_artist_fields', oscillator_sanitize_artist_fields_repeating( $_POST ) );
}


function oscillator_sanitize_artist_fields_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles       = $POST_array['oscillator_artist_fields_repeatable_title'];
	$descriptions = $POST_array['oscillator_artist_fields_repeatable_description'];

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
