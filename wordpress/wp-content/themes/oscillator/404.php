<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-title"><?php echo esc_html( get_theme_mod( 'title_404', __( 'Page not found (404)', 'oscillator' ) ) ); ?></h2>

		<div class="row">
			<div class="col-md-8 col-xs-12">
				<article class="entry">
					<div class="entry-content">
						<p><?php esc_html_e( 'The page you were looking for can not be found! Perhaps try searching?', 'oscillator' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>
			</div>

			<div class="col-md-4 col-xs-12">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>