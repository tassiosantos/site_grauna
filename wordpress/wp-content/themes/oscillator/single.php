<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-title"><?php echo esc_html( get_theme_mod( 'title_blog', __( 'From the Blog', 'oscillator' ) ) ); ?></h2>

		<div class="row">
			<div class="col-md-8 col-xs-12">
				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<h1 class="entry-title"><?php the_title(); ?></h1>

						<div class="entry-meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							&bull;
							<?php the_category( ', ' ); ?>
							&bull;
							<a href="<?php echo esc_url( get_comments_link() ); ?>"><?php comments_number(); ?></a>
						</div>

						<?php if ( has_post_thumbnail() ): ?>
							<figure class="entry-thumb">
								<a class="ci-lightbox" href="<?php echo esc_url( oscillator_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
									<?php the_post_thumbnail(); ?>
								</a>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>

						<?php comments_template(); ?>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="col-md-4 col-xs-12">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>