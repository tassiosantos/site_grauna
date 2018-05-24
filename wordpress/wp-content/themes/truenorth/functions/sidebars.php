<?php
add_action( 'widgets_init', 'ci_widgets_init' );
if ( !function_exists('ci_widgets_init') ) :
function ci_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'ci_theme' ),
		'id'            => 'blog',
		'description'   => __('This is the main sidebar.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'ci_theme' ),
		'id'            => 'page',
		'description'   => __( 'Widgets placed in this sidebar will appear in the static pages. If empty, blog widgets will be shown instead.', 'ci_theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Homepage', 'widget area', 'ci_theme' ),
		'id'            => 'home',
		'description'   => __( 'Widget area of the homepage.', 'ci_theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>'
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer', 'widget area', 'ci_theme' ),
		'id'            => 'footer',
		'description'   => __( 'Widget area on the footer.', 'ci_theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

}
endif;
