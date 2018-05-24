<?php
require get_template_directory() . '/inc/downloads-handler.php';

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/sanitization.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/helpers-post-meta.php';
require get_template_directory() . '/inc/custom-fields-discography.php';
require get_template_directory() . '/inc/custom-fields-event.php';
require get_template_directory() . '/inc/custom-fields-artist.php';
require get_template_directory() . '/inc/custom-fields-gallery.php';
require get_template_directory() . '/inc/custom-fields-video.php';
require get_template_directory() . '/inc/custom-fields-slide.php';
require get_template_directory() . '/inc/custom-fields-page.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-styles.php';

add_action( 'after_setup_theme', 'oscillator_content_width', 0 );
function oscillator_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'oscillator_content_width', 750 );
}

add_action( 'after_setup_theme', 'oscillator_setup' );
if( !function_exists( 'oscillator_setup' ) ) :
function oscillator_setup() {

	if ( ! defined( 'CI_THEME_NAME' ) ) {
		define( 'CI_THEME_NAME', 'oscillator' );
	}
	if ( ! defined( 'CI_WHITELABEL' ) ) {
		// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
		define( 'CI_WHITELABEL', false );
	}

	load_theme_textdomain( 'oscillator', get_template_directory() . '/languages' );

	/*
	 * Theme supports.
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'custom-header', array(
		'default-image' => '',
		'width'         => 1920,
		'height'        => 100,
		'uploads'       => true,
		'header-text'   => false,
	) );

	/*
	 * Image sizes.
	 */
	set_post_thumbnail_size( 750, 420, true );
	add_image_size( 'oscillator_square', 650, 650, true );
	add_image_size( 'oscillator_tall', 750 );
	add_image_size( 'oscillator_slider', 1920, 1060, true );

	/*
	 * Navigation menus.
	 */
	register_nav_menus( array(
		'main_menu'   => esc_html__( 'Main Menu', 'oscillator' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'oscillator' ),
	) );

	// Automatic thumbnails for video posts.
	add_action( 'save_post', 'oscillator_save_video_thumbnail', 10, 1 );
	add_action( 'wp_insert_post', 'oscillator_save_video_thumbnail');
	add_filter( 'oscillator_automatic_video_thumbnail_field', 'oscillator_add_auto_thumb_video_field' );


	add_shortcode( 'tracklisting', 'oscillator_tracklisting_shortcode' );


	/*
	 * Default hooks
	 */
	// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
	add_action( 'admin_footer', 'oscillator_print_inline_js' );
	add_action( 'wp_footer', 'oscillator_print_inline_js' );

	// Handle the dismissible sample content notice.
	add_action( 'admin_notices', 'oscillator_admin_notice_sample_content' );
	add_action( 'wp_ajax_oscillator_dismiss_sample_content', 'oscillator_ajax_dismiss_sample_content' );

	// Wraps post counts in span.ci-count
	// Needed for the default widgets, however more appropriate filters don't exist.
	add_filter( 'get_archives_link', 'oscillator_wrap_archive_widget_post_counts_in_span', 10, 2 );
	add_filter( 'wp_list_categories', 'oscillator_wrap_category_widget_post_counts_in_span', 10, 2 );
}
endif;

add_action( 'wp_enqueue_scripts', 'oscillator_enqueue_scripts' );
function oscillator_enqueue_scripts() {

	/*
	 * Styles
	 */
	$theme = wp_get_theme();


	$font_url = '';
	/* translators: If there are characters in your language that are not supported by Montserrat and Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat and Lato fonts: on or off', 'oscillator' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Montserrat:400,700|Lato:400,700,400italic,700italic' ), '//fonts.googleapis.com/css' );
	}
	wp_register_style( 'oscillator-google-font', esc_url( $font_url ) );

	wp_register_style( 'oscillator-base', get_template_directory_uri() . '/css/base.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.5.0' );
	wp_register_style( 'mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), '5.2.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );
	wp_register_style( 'magnific', get_template_directory_uri() . '/css/magnific.css', array(), '1.0.0' );
	wp_register_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.5.7' );

	wp_register_style( 'oscillator-color-scheme', oscillator_get_color_scheme_path(), array(), $theme->get( 'Version' ) );

	wp_enqueue_style( 'oscillator-style', get_template_directory_uri() . '/style.css', array(
		'oscillator-google-font',
		'oscillator-base',
		'flexslider',
		'mmenu',
		'font-awesome',
		'magnific',
		'slick',
	), $theme->get( 'Version' ) );

	wp_enqueue_style( 'oscillator-color-scheme' );

	if( is_child_theme() ) {
		wp_enqueue_style( 'oscillator-style-child', get_stylesheet_directory_uri() . '/style.css', array(
			'oscillator-style',
		), $theme->get( 'Version' ) );
	}

	/*
	 * Scripts
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_register_script( 'oscillator-google-maps', oscillator_get_google_maps_api_url(), array(), null, false );

	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.8.3', false );
	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
	wp_register_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.2.0', true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '2.5.0', true );
	wp_register_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), '2.2.2', true );
	wp_register_script( 'soundmanager2', get_template_directory_uri() . '/js/soundmanager2.js', array( 'jquery' ), '2.97a.20140901', true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.5.7', true );
	wp_register_script( 'parallax', get_template_directory_uri() . '/js/parallax.min.js', array( 'jquery' ), '1.3.1', true );
	wp_register_script( 'soundmanager2-inlineplayer', get_template_directory_uri() . '/js/inlineplayer.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_register_script( 'oscillator-audioplayer', get_template_directory_uri() . '/js/ci_audioplayer.js', array( 'jquery' ), $theme->get( 'Version' ), true );


	/*
	 * Enqueue
	 */

	if( get_theme_mod( 'google_maps_api_enable', 1 ) ) {
		wp_enqueue_script( 'oscillator-google-maps' );
	}

	wp_enqueue_script( 'oscillator-front-scripts', get_template_directory_uri() . '/js/scripts.js', array(
		'jquery',
		'superfish',
		'mmenu',
		'flexslider',
		'fitVids',
		'magnific-popup',
		'isotope',
		'soundmanager2',
		'soundmanager2-inlineplayer',
		'oscillator-audioplayer',
		'slick',
		'parallax'
	), $theme->get( 'Version' ), true );


	$params['swfPath'] = get_template_directory_uri() . '/js/swf/';
	wp_localize_script( 'oscillator-front-scripts', 'ThemeOption', $params );

}

add_action( 'admin_enqueue_scripts', 'oscillator_admin_enqueue_scripts' );
function oscillator_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */
	wp_register_style( 'jquery-ui-style', get_template_directory_uri() . '/css/admin/jquery-ui.css', array(), '1.10.4' );
	wp_register_style( 'jquery-ui-timepicker-addon', get_template_directory_uri() . '/css/admin/jquery-ui-timepicker-addon.css', array( 'jquery-ui-style' ), '1.3' );
	wp_register_style( 'alpha-color-picker', get_template_directory_uri() . '/inc/customizer-controls/alpha-color-picker/alpha-color-picker.css', array(
		'wp-color-picker',
	), '1.0.0' );
	wp_register_style( 'oscillator-repeating-fields', get_template_directory_uri() . '/css/admin/repeating-fields.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'oscillator-widgets', get_template_directory_uri() . '/css/admin/widgets.css', array(
		'wp-color-picker',
		'oscillator-repeating-fields',
		'oscillator-post-meta'
	), $theme->get( 'Version' ) );
	wp_register_style( 'oscillator-post-edit', get_template_directory_uri() . '/css/admin/post-edit.css', array(
		'jquery-ui-style',
		'oscillator-repeating-fields',
	), $theme->get( 'Version' ) );


	/*
	 * Scripts
	 */
	wp_register_script( 'oscillator-google-maps', oscillator_get_google_maps_api_url(), array(), null, false );

	wp_register_script( 'jquery-ui-timepicker-addon', get_template_directory_uri() . '/js/admin/jquery-ui-timepicker-addon.js', array(
		'jquery-ui-slider',
		'jquery-ui-datepicker',
	), '1.3', true );
	wp_register_script( 'jquery-gmaps-latlon-picker', get_template_directory_uri() . '/js/admin/jquery-gmaps-latlon-picker.js', array(
		'jquery',
	), $theme->get( 'Version' ), true );
	wp_register_script( 'alpha-color-picker', get_template_directory_uri() . '/inc/customizer-controls/alpha-color-picker/alpha-color-picker.js', array(
		'jquery',
		'wp-color-picker',
	), '1.0.0', true );
	wp_register_script( 'oscillator-repeating-fields', get_template_directory_uri() . '/js/admin/repeating-fields.js', array(
		'jquery',
		'jquery-ui-sortable'
	), $theme->get( 'Version' ), true );
	wp_register_script( 'oscillator-post-edit', get_template_directory_uri() . '/js/admin/post-edit.js', array(
		'jquery',
		'jquery-ui-datepicker',
		'jquery-ui-timepicker-addon',
		'jquery-gmaps-latlon-picker',
		'oscillator-repeating-fields',
	), $theme->get( 'Version' ), true );

	wp_register_script( 'oscillator-widgets', get_template_directory_uri() . '/js/admin/widgets.js', array(
		'jquery',
		'wp-color-picker',
		'oscillator-repeating-fields',
		'oscillator-post-meta',
	), $theme->get( 'Version' ), true );

	$params = array(
		'no_posts_found' => esc_html__( 'No posts found.', 'oscillator' ),
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
	);
	wp_localize_script( 'oscillator-widgets', 'ThemeWidget', $params );


	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'oscillator-post-meta' );
		wp_enqueue_script( 'oscillator-post-meta' );

		if( get_theme_mod( 'google_maps_api_enable', 1 ) ) {
			wp_enqueue_script( 'oscillator-google-maps' );
		}

		wp_enqueue_style( 'oscillator-post-edit' );
		wp_enqueue_script( 'oscillator-post-edit' );
	}

	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'alpha-color-picker' );
		wp_enqueue_script( 'alpha-color-picker' );
		wp_enqueue_style( 'oscillator-widgets' );
		wp_enqueue_script( 'oscillator-widgets' );
	}

}


add_action( 'customize_controls_print_styles', 'oscillator_enqueue_customizer_styles' );
function oscillator_enqueue_customizer_styles() {
	$theme = wp_get_theme();

	wp_register_style( 'oscillator-customizer-styles', get_template_directory_uri() . '/css/admin/customizer-styles.css', array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'oscillator-customizer-styles' );
}


add_action( 'widgets_init', 'oscillator_widgets_init' );
function oscillator_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'oscillator' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'This is the main sidebar.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'oscillator' ),
		'id'            => 'page',
		'description'   => esc_html__( 'This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Artists', 'widget area', 'oscillator' ),
		'id'            => 'artist',
		'description'   => esc_html__( 'This sidebar appears on your artist pages.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Discography', 'widget area', 'oscillator' ),
		'id'            => 'discography',
		'description'   => esc_html__( 'This sidebar appears on your discography pages.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Events', 'widget area', 'oscillator' ),
		'id'            => 'event',
		'description'   => esc_html__( 'This sidebar appears on your event pages.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Videos', 'widget area', 'oscillator' ),
		'id'            => 'video',
		'description'   => esc_html__( 'This sidebar appears on your video pages.', 'oscillator' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Front page', 'widget area', 'oscillator' ),
		'id'            => 'frontpage',
		'description'   => esc_html__( 'This widget area appears on your widgetized front page template.', 'oscillator' ),
		'before_widget' => '<section id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="row"><div class="col-xs-12"><h2 class="section-title">',
		'after_title'   => '</h2></div></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer', 'widget area', 'oscillator' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'This widget area appears on your footer.', 'oscillator' ),
		'before_widget' => '<section id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="row"><div class="col-xs-12"><h2 class="section-title">',
		'after_title'   => '</h2></div></div>',
	) );
}

add_action( 'widgets_init', 'oscillator_load_widgets' );
function oscillator_load_widgets() {
	require get_template_directory() . '/inc/widgets/ci-items.php';
	require get_template_directory() . '/inc/widgets/ci-latest-post-type.php';
	require get_template_directory() . '/inc/widgets/ci-tracklisting.php';
	require get_template_directory() . '/inc/widgets/ci-events.php';
	require get_template_directory() . '/inc/widgets/ci-hero.php';
	require get_template_directory() . '/inc/widgets/ci-text.php';
}

add_filter( 'excerpt_length', 'oscillator_excerpt_length' );
function oscillator_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}


add_filter( 'wp_page_menu', 'oscillator_wp_page_menu', 10, 2 );
function oscillator_wp_page_menu( $menu, $args ) {
	preg_match( '#^<div class="(.*?)">(?:.*?)</div>$#', $menu, $matches );
	$menu = preg_replace( '#^<div class=".*?">#', '', $menu, 1 );
	$menu = preg_replace( '#</div>$#', '', $menu, 1 );
	$menu = preg_replace( '#^<ul>#', '<ul class="' . esc_attr( $args['menu_class'] ) . '">', $menu, 1 );
	return $menu;
}


function oscillator_get_fullwidth_sidebars() {
	return array(
		'frontpage',
		'footer',
	);
}


add_filter( 'the_content', 'oscillator_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'oscillator_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'oscillator_lightbox_rel' );
if ( ! function_exists( 'oscillator_lightbox_rel' ) ):
function oscillator_lightbox_rel( $content ) {
	global $post;
	$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = '<a$1href=$2$3.$4$5 data-lightbox="gal[' . $post->ID . ']"$6>$7</a>';
	$content     = preg_replace( $pattern, $replacement, $content );

	return $content;
}
endif;


add_filter( 'wp_link_pages_args', 'oscillator_wp_link_pages_args' );
function oscillator_wp_link_pages_args( $params ) {
	$params = array_merge( $params, array(
		'before' => '<p class="link-pages">' . __( 'Pages:', 'oscillator' ),
		'after'  => '</p>',
	) );

	return $params;
}


function oscillator_get_columns_classes( $columns ) {
	switch ( $columns ) {
		case 1:
			$classes = 'col-xs-12';
			break;
		case 2:
			$classes = 'col-sm-6 col-xs-12';
			break;
		case 4:
			$classes = 'col-md-3 col-sm-6 col-xs-12';
			break;
		case 3:
		default:
			$classes = 'col-md-4 col-sm-6 col-xs-12';
			break;
	}

	return $classes;
}


function oscillator_add_auto_thumb_video_field( $field ) {
	return 'oscillator_video_url';
}


function oscillator_get_google_maps_api_url() {
	$args = array();

	if ( get_theme_mod( 'google_maps_api_key' ) ) {
		$args['key'] = get_theme_mod( 'google_maps_api_key' );
	}

	return esc_url_raw( add_query_arg( $args, '//maps.googleapis.com/maps/api/js' ) );
}

function oscillator_tracklisting_shortcode( $params, $content = null ) {
	$params = shortcode_atts( array(
		'id'       => '',
		'slug'     => '',
		'limit'    => - 1,
		'tracks'   => '',
		'player'   => true,
		'lyrics'   => true,
		'buy'      => true,
		'download' => true,
	), $params, 'tracklisting' );

	$id       = $params['id'];
	$slug     = $params['slug'];
	$limit    = $params['limit'];
	$tracks   = $params['tracks'];
	$player   = $params['player'];
	$lyrics   = $params['lyrics'];
	$buy      = $params['buy'];
	$download = $params['download'];

	$show_player   = in_array( $player, array( '0', 0, 'false', false, 'hide', 'HIDE' ), true ) ? false : true;
	$show_lyrics   = in_array( $lyrics, array( '0', 0, 'false', false, 'hide', 'HIDE' ), true ) ? false : true;
	$show_buy      = in_array( $buy, array( '0', 0, 'false', false, 'hide', 'HIDE' ), true ) ? false : true;
	$show_download = in_array( $download, array( '0', 0, 'false', false, 'hide', 'HIDE' ), true ) ? false : true;

	$output = '';
	$tracks = empty( $tracks ) ? '' : explode( ',', $tracks );
	$post   = get_post();

	// By default, when the shortcode tries to get the tracklisting of any discography item, should be
	// restricted to only published discographies.
	// However, when the discography itself shows its own tracklisting, it should be allowed to do so,
	// no matter what its post status may be.
	$args = array(
		'post_type'      => 'oscillator_disco',
		'post_status'    => 'publish',
		'posts_per_page' => '1'
	);

	if ( empty( $id ) && empty( $slug ) ) {
		$args['p'] = $post->ID;

		// We are showing the current post's tracklisting (since we didn't get any parameters),
		// so we need to make sure we can retrieve it whatever its post status might be.
		$args['post_status'] = 'any';

	} elseif ( ! empty( $id ) && $id > 0 ) {
		$args['p'] = $id;

		// Check if the current post's ID matches what was passed.
		// If so, we need to make sure we can retrieve it whatever its post status might be.
		if ( $post->ID == $args['p'] ) {
			$args['post_status'] = 'any';
		}

	} elseif ( ! empty( $slug ) ) {
		$args['name'] = sanitize_title_with_dashes( $slug, '', 'save' );

		// Check if the current post's slug matches what was passed.
		// If so, we need to make sure we can retrieve it whatever its post status might be.
		if ( $post->post_name == $args['name'] ) {
			$args['post_status'] = 'any';
		}
	}

	$q = new WP_Query( $args );

	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();

			$post_id = get_the_ID();
			$fields  = get_post_meta( $post_id, 'oscillator_discography_tracks', true );

			ob_start();

			if ( ! empty( $fields ) ) {
				$track_num = 0; // Helps count songs even if skipped.
				$outputted = 0; // Helps count actually outputted songs. Used with 'limit' parameter.
				?>
				<ul class="list-array">
					<?php foreach( $fields as $field ): ?>
						<?php
							$track_num++;
							$track_id = $post_id . '_' . $track_num;

							if ( is_array( $tracks ) and ! in_array( $track_num, $tracks ) ) {
								continue;
							}

							preg_match('#^http[s|]://soundcloud\.com.*#', $field['play_url'], $soundcloud_url);
						?>

						<li class="list-item list-item-track">
							<div class="list-item-intro">
								<span class="list-item-no"><?php echo sprintf( '%02d', $track_num ); ?></span>
								<?php if( $show_player ): ?>
									<?php if ( ! empty( $soundcloud_url ) ): ?>
										<a class="sc-play sm2_link btn btn-round" href="<?php echo esc_url( $field['play_url'] ); ?>"><i class="fa fa-play"></i></a>
									<?php elseif( ! empty( $field['play_url'] ) ): ?>
										<a class="sm2_link btn btn-round" href="<?php echo esc_url( $field['play_url'] ); ?>"><i class="fa fa-play"></i></a>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<div class="list-item-info">
								<p class="list-item-title"><?php echo esc_html( $field['title'] ); ?></p>

								<p class="list-item-group">
									<?php echo esc_html( $field['subtitle'] ); ?>
									<?php if ( ! empty( $field['artist'] ) ): ?>
										<b><?php echo esc_html( $field['artist'] ); ?></b>
									<?php endif; ?>
								</p>
							</div>

							<div class="list-item-extra">
								<?php if ( $show_lyrics && ! empty( $field['lyrics'] ) ): ?>
									<a class="btn btn-lyrics" href="#lyrics_<?php echo esc_attr( $track_id ); ?>"><?php esc_html_e( 'Lyrics', 'oscillator' ); ?></a>
								<?php endif; ?>

								<?php if ( $show_buy && ! empty( $field['buy_url'] ) ): ?>
									<a class="btn btn-round" href="<?php echo esc_url( $field['buy_url'] ); ?>"><i class="fa fa-shopping-cart"></i></a>
								<?php endif; ?>

								<?php if ( $show_download && ! empty( $field['download_url'] ) ): ?>
									<a class="btn btn-round inline-exclude" href="<?php echo esc_url( add_query_arg( 'force_download', $field['download_url'] ) ); ?>"><i class="fa fa-download"></i></a>
								<?php endif; ?>
							</div>

							<?php if ( $show_lyrics && ! empty( $field['lyrics'] ) ): ?>
								<div id="lyrics_<?php echo esc_attr( $track_id ); ?>" class="lyrics-popup">
									<?php echo wpautop( $field['lyrics'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $soundcloud_url ) ): ?>
								<div id="track<?php echo $track_id; ?>" class="soundcloud-wrap">
									<?php echo wp_oembed_get( esc_url( $field['play_url'] ) ); ?>
								</div>
							<?php endif; ?>

						</li>

						<?php
							if ( $limit > 0 ) {
								$outputted ++;
								if ( $outputted >= $limit ) {
									break;
								}
							}
						?>
					<?php endforeach; ?>
				</ul>
				<?php
			}

			$output = ob_get_clean();
		}

		wp_reset_postdata();

	} else {
		$output = apply_filters( 'oscillator_tracklisting_shortcode_error_msg', esc_html__( 'Cannot show track listings from non-public, non-published posts.', 'oscillator' ) );
	}

	return $output;
}


if( ! function_exists( 'oscillator_get_color_schemes' ) ):
function oscillator_get_color_schemes() {
	return array(
		'default.css' => _x( 'Default', 'color scheme', 'oscillator' ),
		'blue.css'    => _x( 'Blue', 'color scheme', 'oscillator' ),
		'green.css'   => _x( 'Green', 'color scheme', 'oscillator' ),
		'pastel.css'  => _x( 'Pastel', 'color scheme', 'oscillator' ),
		'pink.css'    => _x( 'Pink', 'color scheme', 'oscillator' ),
		'red.css'     => _x( 'Red', 'color scheme', 'oscillator' ),
	);
}
endif;


//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_home_video_show', 'oscillator_handle_url_theme_mod_home_video_show' );
function oscillator_handle_url_theme_mod_home_video_show( $value ) {

	if ( ! empty( $_GET['home_video_show'] ) && $_GET['home_video_show'] == 1 ) {
		$value = 1;
	}
	return $value;
}


if( ! function_exists( 'oscillator_sanitize_color_scheme' ) ):
function oscillator_sanitize_color_scheme( $scheme ) {
	$schemes = array_keys( oscillator_get_color_schemes() );

	if( in_array( $scheme, $schemes ) ) {
		return $scheme;
	}

	return 'default.css';
}
endif;


if( ! function_exists( 'oscillator_get_color_scheme_path' ) ):
function oscillator_get_color_scheme_path() {
	$scheme = get_theme_mod( 'color_scheme', 'default.css' );
	if ( ! empty( $scheme ) ) {
		return get_template_directory_uri() . '/colors/' . $scheme;
	}

	return '';
}
endif;


add_filter( 'body_class', 'oscillator_add_sticky_body_class' );
if ( ! function_exists( 'oscillator_add_sticky_body_class' ) ) {
	function oscillator_add_sticky_body_class( $classes ) {
		if ( get_theme_mod( 'header_sticky' ) ) {
			$classes[] = 'header-sticky';
		} else {
			$classes[] = '';
		}

		return $classes;
	}
}

add_action( 'wpiw_before_widget', 'oscillator_wpiw_before_widget' );
function oscillator_wpiw_before_widget() {
	?><div data-auto="<?php echo esc_attr( get_theme_mod( 'instagram_auto', 1 ) ); ?>" data-speed="<?php echo esc_attr( get_theme_mod( 'instagram_speed', 300 ) ); ?>"><?php
}
add_action( 'wpiw_after_widget', 'oscillator_wpiw_after_widget' );
function oscillator_wpiw_after_widget() {
	?></div><?php
}


function oscillator_sanitize_footer_text( $text ) {
	$allowed_html = array(
		'a'      => array(
			'href'  => array(),
			'class' => array(),
		),
		'img'    => array(
			'src'   => array(),
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

	return wp_kses( $text, $allowed_html );
}

function oscillator_sanitize_rgba_color( $str, $return_hash = true, $return_fail = '' ) {
	if( $str === false || empty( $str ) || $str == 'false' ) {
		return $return_fail;
	}

	// Allow keywords and predefined colors
	if ( in_array( $str, array( 'transparent', 'initial', 'inherit', 'black', 'silver', 'gray', 'grey', 'white', 'maroon', 'red', 'purple', 'fuchsia', 'green', 'lime', 'olive', 'yellow', 'navy', 'blue', 'teal', 'aqua', 'orange', 'aliceblue', 'antiquewhite', 'aquamarine', 'azure', 'beige', 'bisque', 'blanchedalmond', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgrey', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkslategrey', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dimgrey', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'greenyellow', 'grey', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightslategrey', 'lightsteelblue', 'lightyellow', 'limegreen', 'linen', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'oldlace', 'olivedrab', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'skyblue', 'slateblue', 'slategray', 'slategrey', 'snow', 'springgreen', 'steelblue', 'tan', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'whitesmoke', 'yellowgreen', 'rebeccapurple' ) ) ) {
		return $str;
	}

	preg_match( '/rgba\(\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1}\.?\d*\%?)\s*\)/', $str, $rgba_matches );
	if( !empty( $rgba_matches ) && count($rgba_matches) == 5 ) {
		for( $i = 1; $i < 4; $i++ ) {
			if ( strpos( $rgba_matches[ $i ], '%' ) !== false ) {
				$rgba_matches[ $i ] = oscillator_sanitize_0_100_percent( $rgba_matches[ $i ] );
			} else {
				$rgba_matches[ $i ] = oscillator_sanitize_0_255( $rgba_matches[ $i ] );
			}
		}
		$rgba_matches[4] = oscillator_sanitize_0_1_opacity( $rgba_matches[ $i ] );
		return sprintf( 'rgba(%s, %s, %s, %s)', $rgba_matches[1], $rgba_matches[2], $rgba_matches[3], $rgba_matches[4] );
	}

	// Not a color function either. Let's see if it's a hex color.

	// Include the hash if not there.
	// The regex below depends on in.
	if ( substr( $str, 0, 1 ) != '#' ) {
		$str = '#' . $str;
	}

	preg_match( '/(#)([0-9a-fA-F]{6})/', $str, $matches );

	if ( count( $matches ) == 3 ) {
		if ( $return_hash ) {
			return $matches[1] . $matches[2];
		} else {
			return $matches[2];
		}
	}

	return $return_fail;
}

function oscillator_sanitize_0_100_percent( $val ) {
	$val = str_replace( '%', '', $val );
	if ( floatval( $val ) > 100 ) {
		$val = 100;
	} elseif ( floatval( $val ) < 0 ) {
		$val = 0;
	}

	return floatval( $val ) . '%';
}

function oscillator_sanitize_0_255( $val ) {
	if ( intval( $val ) > 255 ) {
		$val = 255;
	} elseif ( intval( $val ) < 0 ) {
		$val = 0;
	}

	return intval( $val );
}

function oscillator_sanitize_0_1_opacity( $val ) {
	if ( floatval( $val ) > 1 ) {
		$val = 1;
	} elseif ( floatval( $val ) < 0 ) {
		$val = 0;
	}

	return floatval( $val );
}
