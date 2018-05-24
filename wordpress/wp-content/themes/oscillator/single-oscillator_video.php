<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-title"><?php single_post_title(); ?></h2>

		<?php $video_url = get_post_meta( get_queried_object_id(), 'oscillator_video_url', true ); ?>

		<?php if ( ! empty( $video_url ) ): ?>
			<div class="video-wrap">
				<?php echo wp_oembed_get( $video_url ); ?>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-8 col-xs-12">
				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="col-md-4 col-xs-12">
				<?php
					$video_location  = get_post_meta( get_the_ID(), 'oscillator_video_location', true );
					$video_fields    = get_post_meta( get_the_ID(), "oscillator_video_fields", true );
				?>

				<table class="item-meta">
					<tbody>
						<?php if ( ! empty( $video_location ) ): ?>
							<tr>
								<th><?php _e( 'Location', 'oscillator' ); ?></th>
								<td><?php echo $video_location; ?></td>
							</tr>
						<?php endif; ?>

						<?php if ( ! empty( $video_fields ) ): ?>
							<?php foreach ( $video_fields as $field ): ?>
								<tr>
									<th><?php echo $field['title']; ?></th>
									<td><?php echo make_clickable( $field['description'] ); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>