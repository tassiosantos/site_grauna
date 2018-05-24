<?php
add_action( 'customize_register', 'oscillator_customize_register', 100 );
/**
 * Registers all theme-related options to the Customizer.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function oscillator_customize_register( $wpc ) {

	$wpc->add_section( 'header', array(
		'title'       => esc_html_x( 'Header Options', 'customizer section title', 'oscillator' ),
		'priority'    => 1
	) );

	$wpc->get_panel( 'nav_menus' )->priority = 2;

	$wpc->add_section( 'layout', array(
		'title'    => esc_html_x( 'Layout Options', 'customizer section title', 'oscillator' ),
		'priority' => 20
	) );

	$wpc->add_section( 'homepage', array(
		'title'    => esc_html_x( 'Front Page', 'customizer section title', 'oscillator' ),
		'priority' => 25
	) );

	$wpc->get_section( 'colors' )->title    = esc_html__( 'Content Colors', 'oscillator' );
	$wpc->get_section( 'colors' )->priority = 40;

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'widgets' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	//$wpc->get_panel( 'widgets' )->priority = 55;
	$panel_widgets = (object) $wpc->get_panel( 'widgets' );
	$panel_widgets->priority = 55;


	$wpc->add_section( 'footer', array(
		'title'       => _x( 'Footer Options', 'customizer section title', 'oscillator' ),
		'priority'    => 100
	) );

	$wpc->get_section( 'static_front_page' )->priority = 110;

	$wpc->add_section( 'titles', array(
		'title'       => esc_html_x( 'Titles', 'customizer section title', 'oscillator' ),
		'priority'    => 120
	) );

	$wpc->add_section( 'other', array(
		'title'       => esc_html_x( 'Other', 'customizer section title', 'oscillator' ),
		'description' => esc_html__( 'Other options affecting the whole site.', 'oscillator' ),
		'priority'    => 130
	) );



	//
	// Group options by registering the setting first, and the control right after.
	//

	//
	// Layout
	//
	$wpc->add_setting( 'excerpt_length', array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
	) );
	$wpc->add_control( 'excerpt_length', array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'step' => 1,
		),
		'section'     => 'layout',
		'label'       => esc_html__( 'Automatically generated excerpt length (in words)', 'oscillator' ),
	) );

	$wpc->add_setting( 'pagination_method', array(
		'default'           => 'numbers',
		'sanitize_callback' => 'oscillator_sanitize_pagination_method',
	) );
	$wpc->add_control( 'pagination_method', array(
		'type'    => 'select',
		'section' => 'layout',
		'label'   => esc_html__( 'Pagination method', 'oscillator' ),
		'choices' => array(
			'numbers' => esc_html_x( 'Numbered links', 'pagination method', 'oscillator' ),
			'text'    => esc_html_x( '"Previous - Next" links', 'pagination method', 'oscillator' ),
		),
	) );



	//
	// Header
	//
	$wpc->add_setting( 'header_tagline', array(
		'default'           => 1,
		'sanitize_callback' => 'oscillator_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_tagline', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => esc_html__( 'Show tagline.', 'oscillator' ),
	) );

	$wpc->add_setting( 'header_sticky', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_sticky', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => esc_html__( 'Sticky header.', 'oscillator' ),
	) );



	//
	// Homepage
	//
	$wpc->add_setting( '_home_video_text', array(
		'default' => '',
	) );
	$wpc->add_control( new Oscillator_Customize_Static_Text_Control( $wpc, '_home_video_text', array(
		'section'     => 'homepage',
		'label'       => esc_html__( 'Home Video', 'oscillator' ),
		'description' => array(
			esc_html__( 'You can have a video appearing in your home page, by simply providing a URL to the video, depending on its format. You should convert your video to all available formats for maximum browser compatibility.', 'oscillator' ),
		),
	) ) );

	$wpc->add_setting( 'home_video_show', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_checkbox',
	) );
	$wpc->add_control( 'home_video_show', array(
		'type'    => 'checkbox',
		'section' => 'homepage',
		'label'   => esc_html__( 'Show home video.', 'oscillator' ),
	) );

	$wpc->add_setting( 'home_video_mp4', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'home_video_mp4', array(
		'type'    => 'url',
		'section' => 'homepage',
		'label'       => esc_html__( 'MP4 video URL', 'oscillator' ),
	) );

	$wpc->add_setting( 'home_video_webm', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'home_video_webm', array(
		'type'    => 'url',
		'section' => 'homepage',
		'label'       => esc_html__( 'WebM video URL', 'oscillator' ),
	) );

	$wpc->add_setting( 'home_video_ogg', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'home_video_ogg', array(
		'type'    => 'url',
		'section' => 'homepage',
		'label'       => esc_html__( 'OGG video URL', 'oscillator' ),
	) );


	$wpc->add_control( new Oscillator_Customize_Flexslider_Control( $wpc, 'home_slider', array(
		'section'     => 'homepage',
		'label'       => esc_html__( 'Home Slider', 'oscillator' ),
		'description' => esc_html__( 'Fine-tune the homepage slider.', 'oscillator' ),
	), array(
		'taxonomy' => 'oscillator_slide_category',
	) ) );

	$wpc->add_setting( 'player_post_id', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_intval_or_empty',
	) );
	$wpc->add_control( new Oscillator_Customize_Dropdown_Posts_Control( $wpc, 'player_post_id', array(
		'section'     => 'homepage',
		'label'       => esc_html__( 'Home Player Tracklisting', 'oscillator' ),
		'description' => esc_html__( 'Select the discography from which you want the tracks to appear on the front page player.', 'oscillator' ),
	), array(
		'post_type' => 'oscillator_disco',
	) ) );

	$wpc->add_setting( 'player_stream', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'player_stream', array(
		'type'    => 'url',
		'section' => 'homepage',
		'label'       => esc_html__( 'Home Player Stream URL', 'oscillator' ),
		'description' => esc_html__( 'Your home player can also play SHOUTcast / Icecast streams. Enter the stream URL here. Please note that if you enter a stream URL, the above selected discography tracklisting will be ignored.', 'oscillator' ),
	) );

	$wpc->add_setting( 'player_stream_name', array(
		'default'           => esc_html__( 'Streaming audio', 'oscillator' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'player_stream_name', array(
		'type'    => 'text',
		'section' => 'homepage',
		'label'       => esc_html__( 'Home Player Stream name', 'oscillator' ),
	) );


	//
	// Global colors
	//
	$wpc->add_setting( 'color_scheme', array(
		'default'           => 'default.css',
		'sanitize_callback' => 'oscillator_sanitize_color_scheme',
	) );
	$wpc->add_control( 'color_scheme', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Color scheme', 'oscillator' ),
		'type'    => 'select',
		'choices' => oscillator_get_color_schemes(),
	) );
	
	$wpc->add_setting( 'site_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_bg_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Background color', 'oscillator' ),
	) ) );

	$wpc->add_setting( 'site_primary_color', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_primary_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Primary color', 'oscillator' ),
	) ) );

	$wpc->add_setting( 'site_secondary_color', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_secondary_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Secondary color', 'oscillator' ),
	) ) );

	$wpc->add_setting( 'site_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Text color', 'oscillator' ),
	) ) );

	$wpc->add_setting( 'site_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_border_color', array(
		'section' => 'colors',
		'label'   => __( 'Border Color', 'oscillator' ),
	) ) );


	//
	// Titles
	//
	$wpc->add_setting( 'title_blog', array(
		'default'           => esc_html__( 'From the Blog', 'oscillator' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'title_blog', array(
		'type'    => 'text',
		'section' => 'titles',
		'label'   => esc_html__( 'Blog title', 'oscillator' ),
	) );

	$wpc->add_setting( 'title_search', array(
		'default'           => esc_html__( 'Search results', 'oscillator' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'title_search', array(
		'type'    => 'text',
		'section' => 'titles',
		'label'   => esc_html__( 'Search title', 'oscillator' ),
	) );

	$wpc->add_setting( 'title_404', array(
		'default'           => esc_html__( 'Page not found (404)', 'oscillator' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'title_404', array(
		'type'    => 'text',
		'section' => 'titles',
		'label'   => esc_html__( '404 (not found) title', 'oscillator' ),
	) );


	//
	// Other
	//
	$wpc->add_setting( 'custom_css', array(
		'default'              => '',
		'sanitize_callback'    => 'wp_strip_all_tags',
		'sanitize_js_callback' => 'wp_strip_all_tags',
	) );
	$wpc->add_control( 'custom_css', array(
		'type'    => 'textarea',
		'section' => 'other',
		'label'   => esc_html__( 'Custom CSS', 'oscillator' ),
	) );

	$wpc->add_setting( 'google_maps_api_enable', array(
		'default'           => 1,
		'sanitize_callback' => 'oscillator_sanitize_checkbox',
	) );
	$wpc->add_control( 'google_maps_api_enable', array(
		'type'        => 'checkbox',
		'section'     => 'other',
		'label'       => esc_html__( 'Enable Google Maps API.', 'oscillator' ),
		'description' => esc_html__( 'The Google Maps API must only be loaded once in each page. Since many plugins may try to load it as well, you might want to disable it from the theme to avoid potential errors.', 'oscillator' ),
	) );

	$wpc->add_setting( 'google_maps_api_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'google_maps_api_key', array(
		'type'        => 'text',
		'section'     => 'other',
		'label'       => esc_html__( 'Google Maps API key', 'oscillator' ),
		'description' => sprintf( __( 'While your maps can be displayed without an API key, if you get a lot of visits to your site (more than 25,000 per day currently), the maps might stop working. In that case, you need to issue a key from <a href="%s">Google Accounts</a>', 'oscillator' ), 'https://code.google.com/apis/console/' ),
	) );


	//
	// Custom Header
	//
	$wpc->add_setting( 'header_color', array(
		'default'           => 'rgba( 243, 67, 12, 1 )',
		'sanitize_callback' => 'oscillator_sanitize_rgba_color',
	) );
	$wpc->add_control( new Customize_Alpha_Color_Control( $wpc, 'header_color', array(
		'label'        => esc_html__( 'Header Color', 'oscillator' ),
		'description'  => esc_html__( 'Select a color for your header. This will not be visible if you set a header image, unless the image itself has transparent areas.', 'oscillator' ),
		'section'      => 'header_image',
		'show_opacity' => true,
	) ) );

	$wpc->add_setting( 'header_front_color', array(
		'default'           => 'rgba( 243, 67, 12, 0.6 )',
		'sanitize_callback' => 'oscillator_sanitize_rgba_color',
	) );
	$wpc->add_control( new Customize_Alpha_Color_Control( $wpc, 'header_front_color', array(
		'label'        => esc_html__( 'Header Color (front page)', 'oscillator' ),
		'description'  => esc_html__( 'On the front page, the header overlaps the featured slider / video, so only a color can be set. For best results, adjust the color transparency accordingly.', 'oscillator' ),
		'section'      => 'header_image',
		'show_opacity' => true,
	) ) );


	//
	// Footer
	//
	$wpc->add_setting( 'footer_text', array(
		'default'           => implode( ' &ndash; ', array( get_bloginfo( 'name' ), get_bloginfo( 'description' ) ) ),
		'sanitize_callback' => 'oscillator_sanitize_footer_text',
	) );
	$wpc->add_control( 'footer_text', array(
		'type'        => 'text',
		'section'     => 'footer',
		'label'       => esc_html__( 'Footer text', 'oscillator' ),
		'description' => esc_html__( 'Allowed tags: a (href|class), img (src|class), span (class), i (class), b, em, strong.', 'oscillator' ),
	) );

	if ( class_exists( 'null_instagram_widget' ) ) {
		$wpc->add_setting( 'instagram_auto', array(
			'default'           => 1,
			'sanitize_callback' => 'oscillator_sanitize_checkbox',
		) );
		$wpc->add_control( 'instagram_auto', array(
			'type'    => 'checkbox',
			'section' => 'footer',
			'label'   => esc_html__( 'WP Instagram: Slideshow', 'oscillator' ),
		) );

		$wpc->add_setting( 'instagram_speed', array(
			'default'           => 300,
			'sanitize_callback' => 'oscillator_sanitize_intval_or_empty',
		) );
		$wpc->add_control( 'instagram_speed', array(
			'type'    => 'number',
			'section' => 'footer',
			'label'   => esc_html__( 'WP Instagram: Slideshow Speed', 'oscillator' ),
		) );
	}



	//
	// site_tagline Section
	//
	$wpc->add_setting( 'logo', array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'logo', array(
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Logo', 'oscillator' ),
		'description' => esc_html__( 'If an image is selected, it will replace the default textual logo (site name) on the header.', 'oscillator' ),
	) ) );

	$wpc->add_setting( 'logo_padding_top', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_top', array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => esc_html__( 'Logo top padding', 'oscillator' ),
	) );

	$wpc->add_setting( 'logo_padding_bottom', array(
		'default'           => '',
		'sanitize_callback' => 'oscillator_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_bottom', array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => esc_html__( 'Logo bottom padding', 'oscillator' ),
	) );

}


add_action( 'customize_register', 'oscillator_customize_register_custom_controls', 9 );
/**
 * Registers custom Customizer controls.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function oscillator_customize_register_custom_controls( $wpc ) {
	require get_template_directory() . '/inc/customizer-controls/flexslider.php';
	require get_template_directory() . '/inc/customizer-controls/dropdown-posts.php';
	require get_template_directory() . '/inc/customizer-controls/static-text.php';

	require get_template_directory() . '/inc/customizer-controls/alpha-color-picker/alpha-color-picker.php';
}