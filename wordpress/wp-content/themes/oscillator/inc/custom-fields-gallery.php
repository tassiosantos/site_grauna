<?php
add_action( 'init', 'oscillator_create_gallery' );

function oscillator_create_gallery() {
	$labels = array(
		'name'               => _x( 'Galleries', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Gallery', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Galleries', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Gallery', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Gallery', 'oscillator' ),
		'edit_item'          => __( 'Edit Gallery', 'oscillator' ),
		'new_item'           => __( 'New Gallery', 'oscillator' ),
		'view_item'          => __( 'View Gallery', 'oscillator' ),
		'search_items'       => __( 'Search Galleries', 'oscillator' ),
		'not_found'          => __( 'No Galleries found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Galleries found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Gallery:', 'oscillator' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Gallery', 'post type singular name', 'oscillator' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'galleries-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'gallery', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-format-gallery'
	);

	register_post_type( 'oscillator_gallery' , $args );

	$labels = array(
		'name'              => _x( 'Gallery Categories', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Gallery Category', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Gallery Categories', 'oscillator' ),
		'all_items'         => __( 'All Gallery Categories', 'oscillator' ),
		'parent_item'       => __( 'Parent Gallery Category', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Gallery Category:', 'oscillator' ),
		'edit_item'         => __( 'Edit Gallery Category', 'oscillator' ),
		'update_item'       => __( 'Update Gallery Category', 'oscillator' ),
		'add_new_item'      => __( 'Add New Gallery Category', 'oscillator' ),
		'new_item_name'     => __( 'New Gallery Category Name', 'oscillator' ),
		'menu_name'         => __( 'Categories', 'oscillator' ),
		'view_item'         => __( 'View Gallery Category', 'oscillator' ),
		'popular_items'     => __( 'Popular Gallery Categories', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_gallery_category', array( 'oscillator_gallery' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'gallery-category', 'taxonomy slug', 'oscillator' ) ),
	) );

}

add_action( 'load-post.php', 'oscillator_gallery_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_gallery_meta_boxes_setup' );
function oscillator_gallery_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_gallery_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_gallery_save_meta', 10, 2 );
}

function oscillator_gallery_add_meta_boxes() {
	add_meta_box( 'oscillator-gallery-box', esc_html__( 'Gallery Settings', 'oscillator' ), 'oscillator_gallery_score_meta_box', 'oscillator_gallery', 'normal', 'high' );
}

function oscillator_gallery_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_gallery' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( false );
			oscillator_metabox_input( 'oscillator_gallery_location', __( 'Gallery Location. For example: Ibiza, Spain', 'oscillator' ) );
			$options = array();
			for ( $i = 2; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i );
			}
			oscillator_metabox_dropdown( 'oscillator_gallery_cols', $options, __( 'Number of columns to display this gallery in:', 'oscillator' ), array( 'default' => 3 ) );
			oscillator_metabox_checkbox( 'oscillator_gallery_caption', 1, __( 'Enable image captions.', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_gallery_masonry', 1, __( 'Masonry effect.', 'oscillator' ) );
			oscillator_metabox_guide( __( "You can create a featured gallery by pressing the <em>Add Images</em> button below. You should also set a featured image that will be used as this Gallery's cover.", 'oscillator' ) );
			oscillator_metabox_gallery();
		oscillator_metabox_close_tab();
	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_gallery_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_gallery' ) ) {
		return;
	}

	update_post_meta( $post->ID, 'oscillator_gallery_location', sanitize_text_field( $_POST['oscillator_gallery_location'] ) );
	update_post_meta( $post->ID, 'oscillator_gallery_cols', absint( $_POST['oscillator_gallery_cols'] ) );
	update_post_meta( $post->ID, 'oscillator_gallery_caption', oscillator_sanitize_checkbox_ref( $_POST['oscillator_gallery_caption'] ) );
	update_post_meta( $post->ID, 'oscillator_gallery_masonry', oscillator_sanitize_checkbox_ref( $_POST['oscillator_gallery_masonry'] ) );
	oscillator_metabox_gallery_save( $_POST );
}
