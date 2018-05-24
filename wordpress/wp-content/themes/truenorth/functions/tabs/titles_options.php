<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_titles_options', 70);
	if( !function_exists('ci_add_tab_titles_options') ):
		function ci_add_tab_titles_options($tabs)
		{
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Section titles', 'ci_theme');
			return $tabs;
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	$ci_defaults['title_blog']   = _x( 'From the blog', 'section title', 'ci_theme' );
	$ci_defaults['title_search'] = _x( 'Search Results', 'section title', 'ci_theme' );
	$ci_defaults['title_404']    = _x( 'Not Found!', 'section title', 'ci_theme' );

	$ci_defaults['related_portfolios_enable'] = 'on';
	$ci_defaults['related_portfolios_text']   = __( 'Related Projects', 'ci_theme' );

?>
<?php else: ?>

	<fieldset class="set">
		<legend><?php _e( 'Section titles', 'ci_theme' ); ?></legend>

		<p class="guide"><?php _e( 'Set the title for various sections of your website. These titles appear on automatically generated pages.', 'ci_theme' ); ?></p>
		<?php
			ci_panel_input( 'title_blog', __( 'Blog section title:', 'ci_theme' ) );
			ci_panel_input( 'title_search', __( 'Search page section title:', 'ci_theme' ) );
			ci_panel_input( 'title_404', __( 'Not Found (404) page section title:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Related Projects', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e( 'You can show / hide the related projects section that appear beneath portfolio items.', 'ci_theme' ); ?></p>
		<fieldset class="mb10">
			<?php
				ci_panel_checkbox( 'related_portfolios_enable', 'on', __( 'Show related projects.', 'ci_theme' ) );
				ci_panel_input( 'related_portfolios_text', __( 'Related projects title:', 'ci_theme' ) );
			?>
		</fieldset>
	</fieldset>

<?php endif; ?>