<?php
//
// Include all custom post types here (one custom post type per file)
//
add_action('after_setup_theme', 'ci_load_custom_post_type_files');
if( !function_exists('ci_load_custom_post_type_files') ):
function ci_load_custom_post_type_files()
{
	$cpt_files = apply_filters('load_custom_post_type_files', array(
		'functions/post_types/portfolio',
		'functions/post_types/page',
		'functions/post_types/post',
	));
	foreach($cpt_files as $cpt_file) get_template_part($cpt_file);
}
endif;


add_action( 'init', 'ci_tax_create_taxonomies');
if( !function_exists('ci_tax_create_taxonomies') ):
function ci_tax_create_taxonomies() {
	//
	// Create all taxonomies here.
	//
	$labels = array(
		'name'              => _x( 'Portfolio Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Portfolio Categories', 'ci_theme' ),
		'all_items'         => __( 'All Portfolio Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'ci_theme' ),
		'update_item'       => __( 'Update Portfolio Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Portfolio Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Portfolio Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Portfolio Categories', 'ci_theme' ),
	);
	register_taxonomy( 'portfolio_category', array( 'cpt_portfolio' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'portfolio-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

}
endif;

add_action('admin_enqueue_scripts', 'ci_load_post_scripts');
if( !function_exists('ci_load_post_scripts') ):
function ci_load_post_scripts($hook)
{
	//
	// Add here all scripts and styles, to load on all admin pages.
	//
	
	
	if('post.php' == $hook or 'post-new.php' == $hook)
	{
		//
		// Add here all scripts and styles, specific to post edit screens.
		//
		wp_enqueue_media();
		ci_enqueue_media_manager_scripts();
		wp_enqueue_style( 'ci-post-edit-screens' );
		wp_enqueue_script( 'ci-post-edit-screens' );

	}
}
endif;

add_filter('request', 'ci_feed_request');
if( !function_exists('ci_feed_request') ):
function ci_feed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type'])){

		$qv['post_type'] = array();
		$qv['post_type'] = get_post_types($args = array(
	  		'public'   => true,
	  		'_builtin' => false
		));
		$qv['post_type'][] = 'post';
	}
	return $qv;
}
endif;
