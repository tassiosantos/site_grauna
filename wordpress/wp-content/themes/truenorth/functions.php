<?php
	get_template_part('panel/constants');

	load_theme_textdomain( 'ci_theme', get_template_directory() . '/lang' );

	// This is the main options array. Can be accessed as a global in order to reduce function calls.
	$ci = get_option(THEME_OPTIONS);
	$ci_defaults = array();

	// The $content_width needs to be before the inclusion of the rest of the files, as it is used inside of some of them.
	if ( ! isset( $content_width ) ) $content_width = 705;

	//
	// Let's bootstrap the theme.
	//
	get_template_part('panel/bootstrap');

	//
	// Let WordPress manage the title.
	//
	add_theme_support( 'title-tag' );

	//
	// Use HTML5 on galleries
	//
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	//
	// Define our various image sizes.
	// Notice: Changing the values below requires running a thumbnail regeneration
	// plugin such as "Regenerate Thumbnails" (http://wordpress.org/plugins/regenerate-thumbnails/)
	// in order for the new dimensions to take effect.
	//
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 945, 680, true );
	add_image_size( 'ci_header', 2000, 500, true );
	add_image_size( 'ci_full_height', 945 );


	// Enable the automatic video thumbnails.
	add_filter( 'ci_automatic_video_thumbnail_field', 'ci_theme_add_auto_thumb_video_field' );
	if ( !function_exists( 'ci_theme_add_auto_thumb_video_field' ) ):
	function ci_theme_add_auto_thumb_video_field( $field ) {
		return 'portfolio_video_url';
	}
	endif;


	function ci_theme_get_columns_classes( $columns ) {
		switch ( $columns ) {
			case 1:
				$classes = 'col-md-12';
				break;
			case 4:
				$classes = 'col-md-3';
				break;
			case 3:
				$classes = 'col-md-4';
				break;
			case 2:
			default:
				$classes = 'col-md-6';
				break;
		}

		return $classes;
	}


	function ci_add_cpt_header_bg_meta_box( $post ) {
		ci_prepare_metabox( get_post_type( $post ) );

		$image_sizes = ci_get_image_sizes();
		$size = $image_sizes['ci_header']['width'] . 'x' . $image_sizes['ci_header']['height'];

		?><div class="ci-cf-wrap"><?php
			ci_metabox_open_tab( '' );
				ci_metabox_guide( array(
					__( 'You can replace the default header image if you want, by uploading and / or selecting an already uploaded image. This applies to the current page only.', 'ci_theme' ),
					sprintf( __( 'For best results, use a high resolution image, at least %s pixels in size. Make sure you select the desired image size before pressing <em>Use this file</em>.', 'ci_theme' ), $size ),
				), array( 'type' => 'ul' ) );

				?>
				<p>
					<?php
						ci_metabox_input( 'header_image', '', array(
							'input_type'  => 'hidden',
							'esc_func'    => 'esc_url',
							'input_class' => 'uploaded',
							'before'      => '',
							'after'       => ''
						) );

						ci_metabox_input( 'header_image_id', '', array(
							'input_type'  => 'hidden',
							'input_class' => 'uploaded-id',
							'before'      => '',
							'after'       => ''
						) );
					?>
					<span class="selected_image" style="display: block;">
						<?php
							$image_url = ci_get_image_src( get_post_meta( $post->ID, 'header_image_id', true ), 'thumbnail' );
							if( !empty( $image_url ) ) {
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon"></a>', $image_url );
							}
						?>
					</span>
					<a href="#" class="button ci-upload"><?php _e( 'Upload / Select Image', 'ci_theme' ); ?></a>
				</p>
				<?php

			ci_metabox_close_tab();
		?></div><?php
	}


	function ci_theme_sanitize_checkbox( &$input ) {
		if ( $input == 1 ) {
			return 1;
		}

		return '';
	}


	add_action( 'wp_ajax_ci_theme_widget_get_selected_image_preview', 'ci_theme_widget_get_selected_image_preview' );
	function ci_theme_widget_get_selected_image_preview() {
		$image_id   = intval( $_POST['image_id'] );
		$image_size = 'thumbnail';

		if ( ! empty( $image_id ) ) {
			$image_url = ci_get_image_src( $image_id, $image_size );
			if ( ! empty( $image_url ) ) {
				echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon"></a>', $image_url );
			}
		}
		die;
	}
