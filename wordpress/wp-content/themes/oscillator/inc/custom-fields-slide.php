<?php
add_action( 'init', 'oscillator_create_slide' );

function oscillator_create_slide() {
	$labels = array(
		'name'               => _x( 'Slideshow', 'post type general name', 'oscillator' ),
		'singular_name'      => _x( 'Slide', 'post type singular name', 'oscillator' ),
		'menu_name'          => _x( 'Slideshow', 'admin menu', 'oscillator' ),
		'name_admin_bar'     => _x( 'Slideshow', 'add new on admin bar', 'oscillator' ),
		'add_new'            => __( 'Add New', 'oscillator' ),
		'add_new_item'       => __( 'Add New Slide', 'oscillator' ),
		'edit_item'          => __( 'Edit Slide', 'oscillator' ),
		'new_item'           => __( 'New Slide', 'oscillator' ),
		'view_item'          => __( 'View Slide', 'oscillator' ),
		'search_items'       => __( 'Search Slides', 'oscillator' ),
		'not_found'          => __( 'No Slides found', 'oscillator' ),
		'not_found_in_trash' => __( 'No Slides found in the trash', 'oscillator' ),
		'parent_item_colon'  => __( 'Parent Slide:', 'oscillator' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => _x( 'Slide', 'post type singular name', 'oscillator' ),
		'public'          => false,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
//		'has_archive'     => _x( 'slides-archive', 'post type archive slug', 'oscillator' ),
		'rewrite'         => array( 'slug' => _x( 'slide', 'post type slug', 'oscillator' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-image-flip-horizontal'
	);

	register_post_type( 'oscillator_slide' , $args );

	$labels = array(
		'name'              => _x( 'Slideshow Categories', 'taxonomy general name', 'oscillator' ),
		'singular_name'     => _x( 'Slideshow Category', 'taxonomy singular name', 'oscillator' ),
		'search_items'      => __( 'Search Slideshow Categories', 'oscillator' ),
		'all_items'         => __( 'All Slideshow Categories', 'oscillator' ),
		'parent_item'       => __( 'Parent Slideshow Category', 'oscillator' ),
		'parent_item_colon' => __( 'Parent Slideshow Category:', 'oscillator' ),
		'edit_item'         => __( 'Edit Slideshow Category', 'oscillator' ),
		'update_item'       => __( 'Update Slideshow Category', 'oscillator' ),
		'add_new_item'      => __( 'Add New Slideshow Category', 'oscillator' ),
		'new_item_name'     => __( 'New Slideshow Category Name', 'oscillator' ),
		'menu_name'         => __( 'Categories', 'oscillator' ),
		'view_item'         => __( 'View Slideshow Category', 'oscillator' ),
		'popular_items'     => __( 'Popular Slideshow Categories', 'oscillator' ),
	);
	register_taxonomy( 'oscillator_slide_category', array( 'oscillator_slide' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'slide-category', 'taxonomy slug', 'oscillator' ) ),
	) );

}

add_action( 'load-post.php', 'oscillator_slide_meta_boxes_setup' );
add_action( 'load-post-new.php', 'oscillator_slide_meta_boxes_setup' );
function oscillator_slide_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'oscillator_slide_add_meta_boxes' );
	add_action( 'save_post', 'oscillator_slide_save_meta', 10, 2 );
}

function oscillator_slide_add_meta_boxes() {
	add_meta_box( 'oscillator-slide-box', esc_html__( 'Slide Settings', 'oscillator' ), 'oscillator_slide_score_meta_box', 'oscillator_slide', 'normal', 'high' );
}

function oscillator_slide_score_meta_box( $object, $box ) {
	oscillator_prepare_metabox( 'oscillator_slide' );

	?><div class="ci-cf-wrap"><?php
		oscillator_metabox_open_tab( '' );
			oscillator_metabox_input( 'oscillator_slide_button_text', __( 'Button text:', 'oscillator' ), array( 'default' => esc_html__( 'Learn more', 'oscillator' ) ) );
			oscillator_metabox_input( 'oscillator_slide_button_url', __( 'Button URL. When someone clicks on this button, this is the link that they will be visiting. If you leave it empty, linking for this slide will be disabled.', 'oscillator' ), array( 'esc_func' => 'esc_url' ) );
			oscillator_metabox_input( 'oscillator_slide_subtext_1', __( 'Subtext 1 (appears above the title)', 'oscillator' ) );
			oscillator_metabox_input( 'oscillator_slide_subtext_2', __( 'Subtext 2 (appears above subtext 1)', 'oscillator' ) );
			oscillator_metabox_checkbox( 'oscillator_slide_rotated', 1, __( 'Rotated subtexts.', 'oscillator' ) );
		oscillator_metabox_close_tab();
	?></div><!-- /ci-cf-wrap --><?php

}

function oscillator_slide_save_meta( $post_id, $post ) {

	if ( ! oscillator_can_save_meta( 'oscillator_slide' ) ) {
		return;
	}

	update_post_meta( $post_id, 'oscillator_slide_button_text', sanitize_text_field( $_POST['oscillator_slide_button_text'] ) );
	update_post_meta( $post_id, 'oscillator_slide_button_url', esc_url_raw( $_POST['oscillator_slide_button_url'] ) );
	update_post_meta( $post_id, 'oscillator_slide_subtext_1', sanitize_text_field( $_POST['oscillator_slide_subtext_1'] ) );
	update_post_meta( $post_id, 'oscillator_slide_subtext_2', sanitize_text_field( $_POST['oscillator_slide_subtext_2'] ) );
	update_post_meta( $post_id, 'oscillator_slide_rotated', oscillator_sanitize_checkbox_ref( $_POST['oscillator_slide_rotated'] ) );
}
