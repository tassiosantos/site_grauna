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

						<?php
							$event_venue    = get_post_meta( get_queried_object_id(), 'oscillator_event_venue', true );
							$event_location = get_post_meta( get_queried_object_id(), 'oscillator_event_location', true );
							$event_fields   = get_post_meta( get_queried_object_id(), 'oscillator_event_fields', true );

							$event_recurrent  = get_post_meta( get_the_ID(), 'oscillator_event_recurrent', true );
							$event_recurrence = get_post_meta( get_the_ID(), 'oscillator_event_recurrence', true );
							$event_date       = get_post_meta( get_queried_object_id(), 'oscillator_event_date', true );
							$event_time       = get_post_meta( get_queried_object_id(), 'oscillator_event_time', true );
							$event_dt         = strtotime( $event_date . ' ' . $event_time );
							$now_dt           = current_time( 'timestamp' );
						?>

						<?php if ( ! $event_recurrent && $event_dt !== false ): ?>
							<?php
								$diff_dt  = $event_dt - $now_dt;
								$diff_tmp = $diff_dt;

								$diff_day  = 0;
								$diff_hour = 0;
								$diff_min  = 0;
								$diff_sec  = 0;

								$diff_day = intval( floor( $diff_tmp / ( 60 * 60 * 24 ) ) );
								if ( $diff_day > 0 ) {
									$diff_tmp = $diff_tmp % ( 60 * 60 * 24 );
								}

								$diff_hour = intval( floor( $diff_tmp / ( 60 * 60 ) ) );
								if ( $diff_hour > 0 ) {
									$diff_tmp = $diff_tmp % ( 60 * 60 );
								}

								$diff_min = intval( floor( $diff_tmp / 60 ) );
								if ( $diff_min > 0 ) {
									$diff_tmp = $diff_tmp % 60;
								}

								$diff_sec = $diff_tmp;
							?>
							<?php if ( $event_dt >= $now_dt ): ?>
								<div class="item-timer">
									<div class="count">
										<?php
											/* translators: %d: number of days */
											echo strip_tags( sprintf( __( '<b>%d</b><span>Days</span>', 'oscillator' ), $diff_day ), '<b><span>' );
										?>
									</div>
									<div class="count">
										<?php
											/* translators: %d: number of hours */
											echo strip_tags( sprintf( __( '<b>%d</b><span>Hours</span>', 'oscillator' ), $diff_hour ), '<b><span>' );
										?>
									</div>
									<div class="count">
										<?php
											/* translators: %d: number of minutes */
											echo strip_tags( sprintf( __( '<b>%d</b><span>Minutes</span>', 'oscillator' ), $diff_min ), '<b><span>' );
										?>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<table class="item-meta">
							<tbody>
								<?php if ( $event_recurrent ): ?>
									<?php if ( ! empty( $event_recurrence ) ): ?>
										<tr>
											<th><?php echo esc_html_x( 'Date', 'event date', 'oscillator' ); ?></th>
											<td><?php echo strip_tags( $event_recurrence ); ?></td>
										</tr>
									<?php endif; ?>
								<?php else: ?>
									<?php if ( ! empty( $event_date ) ): ?>
										<tr>
											<th><?php echo esc_html_x( 'Date', 'event date', 'oscillator' ); ?></th>
											<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), $event_dt ) ); ?></td>
										</tr>
									<?php endif; ?>

									<?php if ( ! empty( $event_time ) ): ?>
										<tr>
											<th><?php echo esc_html_x( 'Time', 'event time', 'oscillator' ); ?></th>
											<td><?php echo esc_html( date_i18n( get_option( 'time_format' ), $event_dt ) ); ?></td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( ! empty( $event_location ) ): ?>
									<tr>
										<th><?php echo esc_html_x( 'Location', 'event location', 'oscillator' ); ?></th>
										<td><?php echo esc_html( $event_location ); ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( ! empty( $event_venue ) ): ?>
									<tr>
										<th><?php echo esc_html_x( 'Venue', 'event venue', 'oscillator' ); ?></th>
										<td><?php echo esc_html( $event_venue ); ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( ! empty( $event_fields ) ): ?>
									<?php foreach ( $event_fields as $field ): ?>
										<tr>
											<th><?php echo $field['title']; ?></th>
											<td><?php echo make_clickable( $field['description'] ); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

								<?php if ( $event_recurrent || $event_dt !== false ): ?>
									<?php
										if ( $event_dt >= $now_dt ) {
											$button_text = get_post_meta( get_queried_object_id(), 'oscillator_event_upcoming_button', true );
											$button_url  = get_post_meta( get_queried_object_id(), 'oscillator_event_upcoming_url', true );
										} else {
											$button_text = get_post_meta( get_queried_object_id(), 'oscillator_event_past_button', true );
											$button_url  = get_post_meta( get_queried_object_id(), 'oscillator_event_past_url', true );
										}
									?>
									<?php if ( ! empty( $button_text ) ): ?>
										<tr>
											<th></th>
											<td class="action">
												<?php if ( ! empty( $button_url ) ): ?>
													<a class="btn" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
												<?php else: ?>
													<span class="btn btn-inactive"><?php echo esc_html( $button_text ); ?></span>
												<?php endif; ?>
											</td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</aside>

					<?php dynamic_sidebar( 'event' ); ?>
				</div>
			</div>
			<div class="col-md-8 col-xs-12 col-md-pull-4">
				<?php while ( have_posts() ): the_post(); ?>
					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<?php
							$map_lon  = get_post_meta( get_the_ID(), 'oscillator_event_lon', true );
							$map_lat  = get_post_meta( get_the_ID(), 'oscillator_event_lat', true );
							$map_zoom = get_post_meta( get_the_ID(), 'oscillator_event_zoom', true );
						?>
						<?php if ( ! empty( $map_lat ) && ! empty( $map_lon ) ): ?>
							<div id="event_map" class="ci-map" data-lat="<?php echo esc_attr( $map_lat ); ?>" data-lng="<?php echo esc_attr( $map_lon ); ?>" data-zoom="<?php echo esc_attr( $map_zoom ); ?>" data-tooltip-txt="<?php echo esc_attr( $event_venue ); ?>" title="<?php the_title_attribute(); ?>"></div>
						<?php endif; ?>

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