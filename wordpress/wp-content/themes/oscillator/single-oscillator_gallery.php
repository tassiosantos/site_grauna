<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">

		<?php while ( have_posts() ): the_post(); ?>
			<?php
				$location = get_post_meta( get_the_ID(), 'oscillator_gallery_location', true );
				$caption  = get_post_meta( get_the_ID(), 'oscillator_gallery_caption', true );
				$columns  = get_post_meta( get_the_ID(), 'oscillator_gallery_cols', true );
				$masonry  = get_post_meta( get_the_ID(), 'oscillator_gallery_masonry', true );
				$thumbs   = oscillator_featgal_get_attachments();

				$div_class  = '';
				$thumb_size = 'oscillator_square';

				if ( $masonry ) {
					$div_class  = 'list-masonry';
					$thumb_size = 'oscillator_tall';
				}
			?>

			<h2 class="page-title">
				<?php the_title(); ?>
				<?php
					if ( ! empty( $location ) ) {
						echo ' / ' . $location;
					}
				?>
			</h2>

			<?php if ( get_the_content() ) : ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $thumbs->have_posts() ): ?>
				<div class="row row-joined item-list <?php echo esc_attr( $div_class ); ?>">
					<?php while ( $thumbs->have_posts() ): $thumbs->the_post(); ?>
						<?php $img_info = wp_prepare_attachment_for_js( get_the_ID() ); ?>
						<div class="<?php echo esc_attr( oscillator_get_columns_classes( $columns ) ); ?>">
							<div class="item">
								<a class="ci-lightbox" href="<?php echo esc_url( oscillator_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $img_info['caption'] ); ?>">
									<?php if( $caption ): ?>
										<div class="item-info">
											<p class="item-title"><?php echo $img_info['caption']; ?></p>
										</div>
									<?php endif; ?>
									<img src="<?php echo esc_url( oscillator_get_image_src( get_the_ID(), $thumb_size ) ); ?>" alt="<?php echo esc_attr( $img_info['alt'] ); ?>"/>

									<span class="btn btn-white btn-transparent btn-round"><i class="fa fa-search-plus"></i></span>
								</a>
							</div>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>