<?php
/*
* Template Name: Fullwidth Page
*/
?>
<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<?php while ( have_posts() ): the_post(); ?>
			<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
				<h1 class="page-title"><?php the_title(); ?></h1>

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
</div>

<?php get_footer(); ?>
