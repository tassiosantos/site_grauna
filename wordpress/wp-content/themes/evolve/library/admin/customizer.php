<?php
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function evolve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '#logo a, #sticky-logo a',
		'render_callback' => 'evolve_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '#tagline',
		'render_callback' => 'evolve_customize_partial_blogdescription',
	) );

        $wp_customize->selective_refresh->add_partial( 'evl_content_box1_title', array(
		'selector' => '.content-box-1 h2',
		'render_callback' => 'evl_content_box1_title',
	) );
       
        
        $wp_customize->selective_refresh->add_partial( 'evl_content_box1_icon_color', array(
		'selector' => '.content-box-1 i',
		'render_callback' => 'evl_content_box1_icon_color',
	) );
        
                
      
}
add_action( 'customize_register', 'evolve_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since evolve 3.8.2
 * @see evolve_customize_register()
 *
 * @return void
 */

function evl_content_box1_title() {
   return get_theme_mod( 'evl_content_box1_title' );
}

function evl_content_box1_icon_color() {
   	$evl_content_box1_icon_color = get_theme_mod( 'evl_content_box1_icon_color' );
	if ( ! empty( $evl_content_box1_icon_color ) ) {
                echo 	'<style>';
                echo    '.content-box-1 i {color:'.  $evl_content_box1_icon_color. ';}';
                echo    '</style>';
	}
}

function evolve_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since evolve 3.8.2
 * @see evolve_customize_register()
 *
 * @return void
 */
function evolve_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Selective Refresh for Widgets.
 */
add_theme_support( 'customize-selective-refresh-widgets' );

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function evolve_customize_preview_js() {
        wp_enqueue_script( 'evolvecustomizepreview', get_template_directory_uri() . '/assets/js/evolve-customize-preview.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'evolve_customize_preview_js' );