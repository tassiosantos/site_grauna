<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-title"><?php single_post_title(); ?></h2>

		<div class="row">
			<div class="col-md-4 col-xs-12 col-md-push-8">
				<div class="sidebar">
					<aside class="entry-aside">
						<?php if ( has_post_thumbnail( get_queried_object_id() ) ): ?>
							<div class="item">
								<a class="ci-lightbox" href="<?php echo esc_url( oscillator_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
									<?php echo get_the_post_thumbnail( get_queried_object_id(), 'oscillator_tall' ); ?>
								</a>
								<span class="btn btn-round btn-white btn-transparent"><i class="fa fa-search-plus"></i></span>
							</div>
						<?php endif; ?>

						<table class="item-meta">
							<tbody>
								<?php
									$release_date       = get_post_meta( get_queried_object_id(), 'oscillator_discography_date', true );
									$label              = get_post_meta( get_queried_object_id(), 'oscillator_discography_label', true );
									$cat_no             = get_post_meta( get_queried_object_id(), 'oscillator_discography_cat_no', true );
									$discography_fields = get_post_meta( get_queried_object_id(), 'oscillator_discography_fields', true );
								?>
								<?php if ( ! empty( $release_date ) ): ?>
									<tr>
										<th><?php esc_html_e( 'Release Date', 'oscillator' ); ?></th>
										<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $release_date ) ); ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( ! empty( $label ) ): ?>
									<tr>
										<th><?php esc_html_e( 'Record Label', 'oscillator' ); ?></th>
										<td><?php echo $label; ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( ! empty( $cat_no ) ): ?>
									<tr>
										<th><?php esc_html_e( 'Catalog Number', 'oscillator' ); ?></th>
										<td><?php echo $cat_no; ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( ! empty( $discography_fields ) ): ?>
									<?php foreach( $discography_fields as $field ): ?>
										<tr>
											<th><?php echo $field['title']; ?></th>
											<td><?php echo make_clickable( $field['description'] ); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

							</tbody>
						</table>
					</aside>

					<?php dynamic_sidebar( 'discography' ); ?>
				</div>
			</div>
			<div class="col-md-8 col-xs-12 col-md-pull-4">
				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>