<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-title"><?php echo esc_html( get_theme_mod( 'title_search', __( 'Search results', 'oscillator' ) ) ); ?></h2>

		<div class="row">
			<div class="col-md-8 col-xs-12">

				<?php
					global $wp_query;

					$found = $wp_query->found_posts;
					$none  = esc_html__( 'No results found. Please broaden your terms and search again.', 'oscillator' );
					$one   = esc_html__( 'Just one result found. We either nailed it, or you might want to broaden your terms and search again.', 'oscillator' );
					$many  = esc_html( sprintf( _n( '%d result found.', '%d results found.', $found, 'oscillator' ), $found ) );
				?>
				<article class="entry">
					<div class="entry-content">
						<p><?php oscillator_e_inflect( $found, $none, $one, $many ); ?></p>
						<?php if ( $found < 2 ) {
							get_search_form();
						} ?>
					</div>
				</article>

				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

						<?php if ( get_post_type() == 'post' ): ?>
							<div class="entry-meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								&bull;
								<?php the_category( ', ' ); ?>
								&bull;
								<a href="<?php echo esc_url( get_comments_link() ); ?>"><?php comments_number(); ?></a>
							</div>
						<?php endif; ?>

						<?php if ( has_post_thumbnail() ): ?>
							<figure class="entry-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>
								</a>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>

						<a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'oscillator' ); ?></a>
					</article>
				<?php endwhile; ?>

				<?php oscillator_pagination(); ?>
			</div>

			<div class="col-md-4 col-xs-12">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>