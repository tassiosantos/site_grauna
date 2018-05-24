<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_color_options', 20);
	if( !function_exists('ci_add_tab_color_options') ):
		function ci_add_tab_color_options($tabs)
		{
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Appearance Options', 'ci_theme');
			return $tabs;
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	load_panel_snippet( 'custom_background' );

	$ci_defaults['blog_layout'] = 'sidebar';

	$ci_defaults['default_header_bg']    = ''; // Holds the URL of the image file to use as header background
	$ci_defaults['default_header_color'] = '#CCCCCC'; // Holds the color to use as header background

?>
<?php else: ?>

	<fieldset class="set">
		<legend><?php _e( 'Blog Layout', 'ci_theme' ); ?></legend>

		<p class="guide"><?php _e( 'Select the default layout of your blog and blog-related pages (e.g. single posts).', 'ci_theme' ); ?></p>
		<?php
			$options = array(
				'sidebar'   => __( 'With Sidebar', 'ci_theme' ),
				'fullwidth' => __( 'Full width - No Sidebar', 'ci_theme' ),
			);
			ci_panel_dropdown( 'blog_layout', $options, __( 'Blog Layout:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Header Display', 'ci_theme' ); ?></legend>

		<p class="guide">
			<?php
				$image_sizes = ci_get_image_sizes();
				$size = $image_sizes['ci_header']['width'] . 'x' . $image_sizes['ci_header']['height'];
				_e( 'Upload or select an image to be used as the default header background on your header. This will be displayed across your website.', 'ci_theme' );
				echo sprintf( __( 'For best results, use a high resolution image, at least %s pixels in size.', 'ci_theme' ), $size );
				_e( 'You may additionally set a background color (useful for having solid backgrounds or transparent images).', 'ci_theme' );
			?>
		</p>
		<?php
			ci_panel_upload_image( 'default_header_bg', __( 'Upload an image:', 'ci_theme' ) );
			ci_panel_input( 'default_header_color', __( 'Color:', 'ci_theme' ), array( 'input_class' => 'colorpckr' ) );
		?>
	</fieldset>

	<?php load_panel_snippet( 'custom_background' ); ?>

<?php endif; ?>