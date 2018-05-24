<?php
//
// Portfolio Post Type related functions.
//
add_action( 'init', 'ci_create_cpt_portfolio' );
add_action( 'admin_init', 'ci_add_cpt_portfolio_meta' );
add_action( 'save_post', 'ci_update_cpt_portfolio_meta' );

if ( ! function_exists( 'ci_create_cpt_portfolio' ) ) :
function ci_create_cpt_portfolio() {
	$labels = array(
		'name'               => _x( 'Portfolio', 'post type general name', 'ci_theme' ),
		'singular_name'      => _x( 'Portfolio Item', 'post type singular name', 'ci_theme' ),
		'add_new'            => __( 'Add New', 'ci_theme' ),
		'add_new_item'       => __( 'Add New Portfolio Item', 'ci_theme' ),
		'edit_item'          => __( 'Edit Portfolio Item', 'ci_theme' ),
		'new_item'           => __( 'New Portfolio Item', 'ci_theme' ),
		'view_item'          => __( 'View Portfolio Item', 'ci_theme' ),
		'search_items'       => __( 'Search Portfolio Items', 'ci_theme' ),
		'not_found'          => __( 'No Portfolio Items found', 'ci_theme' ),
		'not_found_in_trash' => __( 'No Portfolio Items found in the trash', 'ci_theme' ),
		'parent_item_colon'  => __( 'Parent Portfolio Item:', 'ci_theme' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => __( 'Portfolio Item', 'ci_theme' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => _x( 'portfolio-archive', 'post type archive slug', 'ci_theme' ),
		'rewrite'         => array( 'slug' => _x( 'portfolio', 'post type slug', 'ci_theme' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon'       => 'dashicons-portfolio'
	);

	register_post_type( 'cpt_portfolio' , $args );
}
endif;

if ( ! function_exists( 'ci_add_cpt_portfolio_meta' ) ) :
function ci_add_cpt_portfolio_meta() {
	add_meta_box( 'ci_cpt_portfolio_meta', __( 'Portfolio Details', 'ci_theme' ), 'ci_add_cpt_portfolio_meta_box', 'cpt_portfolio', 'normal', 'high' );
	add_meta_box( 'ci-header-bg-box', __( 'Header background', 'ci_theme' ), 'ci_add_cpt_header_bg_meta_box', 'cpt_portfolio', 'normal', 'high' );
}
endif;

if ( ! function_exists( 'ci_update_cpt_portfolio_meta' ) ):
function ci_update_cpt_portfolio_meta( $post_id )	{
	if ( ! ci_can_save_meta( 'cpt_portfolio' ) ) return;

	update_post_meta( $post_id, 'header_image', esc_url_raw( $_POST['header_image'] ) );
	update_post_meta( $post_id, 'header_image_id', intval( $_POST['header_image_id'] ) );

	update_post_meta( $post_id, 'portfolio_template', in_array( $_POST['portfolio_template'], array( 'list', 'slideshow' ) ) ? $_POST['portfolio_template'] : 'slideshow' );
	update_post_meta( $post_id, 'portfolio_details', ci_theme_sanitize_portfolio_details_repeating( $_POST ) );
	update_post_meta( $post_id, 'portfolio_video_url', esc_url_raw( $_POST['portfolio_video_url'] ) );

	ci_metabox_gallery_save( $_POST );
}
endif;

if ( ! function_exists( 'ci_add_cpt_portfolio_meta_box' ) ) :
function ci_add_cpt_portfolio_meta_box( $object, $box ) {
	ci_prepare_metabox( 'cpt_portfolio' );


	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( __( 'Information', 'ci_theme' ) );
			ci_metabox_guide( array(
				__( 'There are various ways that your portfolio can be displayed.', 'ci_theme' ),
				__( 'You should assign a <em>Featured Image</em> that will be used as the cover image of this portfolio item throughout your website. It will also be displayed as the main image when this portfolio item is being viewd.', 'ci_theme' ),
				__( 'Adding a gallery with the <em>Image Slideshow</em> template, will <strong>hide</strong> the featured image in the single portfolio view, and the slideshow will be shown in its place.', 'ci_theme' ),
				__( 'Adding a gallery with the <em>Image List</em> template, will <strong>hide</strong> the featured image in the single portfolio view, and the image list will be displayed before the main content.', 'ci_theme' ),
				__( 'Adding a video will <strong>hide</strong> the featured image in the single portfolio view, and the slideshow will be shown in its place.', 'ci_theme' ),
				__( 'Adding a video while also having a gallery with the <em>Image Slideshow</em> template, will show the video in the feature image position, and the slideshow will be displayed before the main content.', 'ci_theme' ),
			) );
		ci_metabox_close_tab();

		ci_metabox_open_tab( __( 'Gallery', 'ci_theme' ) );
			ci_metabox_guide( __('You can display your image gallery in two different layouts: 1) Image List (one image after the other) or 2) Image Slideshow.', 'ci_theme') );
			$opts = array(
				'slideshow' => __( 'Image Slideshow', 'ci_theme' ),
				'list'      => __( 'Image List', 'ci_theme' ),
			);
			ci_metabox_dropdown( 'portfolio_template', $opts, __( 'Gallery Layout:', 'ci_theme' ) );

			ci_metabox_guide( __( "You can create a gallery for your portfolio item by pressing the <em>Add Images</em> button below. You should also set a featured image that will be used as this portfolio item's cover.", 'ci_theme' ) );
			ci_metabox_gallery();
		ci_metabox_close_tab();

		ci_metabox_open_tab( __( 'Details', 'ci_theme' ) );
			ci_metabox_guide( __( 'Select <em>Add Field</em> as many times as you want to create a list of info details. You can delete a row by clicking on its <em><span class="dashicons dashicons-no"><span class="screen-reader-text">Remove Me</span></span></em> icon next to it. You may also click and drag the fields to re-arrange them.', 'ci_theme' ) );
			?>
			<fieldset class="ci-repeating-fields">
				<div class="inner">
					<?php
						$fields = get_post_meta( $object->ID, 'portfolio_details', true );
						if ( ! empty( $fields ) ) {
							foreach ( $fields as $field ) {
								?>
								<div class="post-field">
									<label><?php _e( 'Title:', 'ci_theme' ); ?> <input type="text" name="ci_repeatable_detail_title[]" value="<?php echo esc_attr( $field['title'] ); ?>" class="widefat" /></label>
									<label><?php _e( 'Description:', 'ci_theme' ); ?> <input type="text" name="ci_repeatable_detail_description[]" value="<?php echo esc_attr( $field['description'] ); ?>" class="widefat" /></label>
									<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php _e( 'Remove me', 'ci_theme' ); ?></a></p>
								</div>
								<?php
							}
						}
					?>
					<div class="post-field field-prototype" style="display: none;">
						<label><?php _e( 'Title:', 'ci_theme' ); ?> <input type="text" name="ci_repeatable_detail_title[]" value="" class="widefat" /></label>
						<label><?php _e( 'Description:', 'ci_theme' ); ?> <input type="text" name="ci_repeatable_detail_description[]" value="" class="widefat" /></label>
						<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php _e( 'Remove me', 'ci_theme' ); ?></a></p>
					</div>
				</div>
				<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php _e('Add Field', 'ci_theme'); ?></a>
			</fieldset>
			<?php
		ci_metabox_close_tab();

		ci_metabox_open_tab( __( 'Video', 'ci_theme' ) );
			ci_metabox_guide( sprintf( __( 'Just paste the URL of your video here. <a href="%s">WordPress supports a wide range of video services.</a>', 'ci_theme' ), 'https://codex.wordpress.org/Embeds' ) );
			ci_metabox_input( 'portfolio_video_url', __( 'Video url:', 'ci_theme' ), array( 'esc_func' => 'esc_url' ) );
		ci_metabox_close_tab();
	?></div><?php
}
endif;

if ( ! function_exists( 'ci_theme_sanitize_portfolio_details_repeating' ) ) :
function ci_theme_sanitize_portfolio_details_repeating( $POST_array ) {
	if ( empty( $POST_array ) || !is_array( $POST_array ) ) {
		return false;
	}

	$titles       = $POST_array['ci_repeatable_detail_title'];
	$descriptions = $POST_array['ci_repeatable_detail_description'];

	$count = max( count( $titles ), count( $descriptions ) );

	$new_fields = array();

	$records_count = 0;
	for ( $i = 0; $i < $count; $i++ ) {
		if ( empty( $titles[ $i ] ) && empty( $descriptions[ $i ] ) ) {
			continue;
		}

		$new_fields[ $records_count ]['title']       = sanitize_text_field( $titles[ $i ] );
		$new_fields[ $records_count ]['description'] = wp_kses( $descriptions[ $i ], wp_kses_allowed_html( 'post' ) );
		$records_count++;
	}
	return $new_fields;
}
endif;
