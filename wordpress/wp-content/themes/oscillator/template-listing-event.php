<?php
/*
 * Template Name: Event Listing
 */
?>
<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">

		<h2 class="page-title"><?php single_post_title(); ?></h2>

		<div class="row">

			<?php
				$show_sidebar = get_post_meta( get_queried_object_id(), 'oscillator_event_listing_sidebar', true );
				// No matter what the post_meta says, if we don't have widgets, we don't show a sidebar.
				if ( ! is_active_sidebar( 'event' ) ) {
					$show_sidebar = false;
				}
			?>

			<?php while ( have_posts() ): the_post(); ?>
				<?php
					$cpt            = 'oscillator_event';
					$cpt_taxonomy   = 'oscillator_event_category';
					$base_category  = get_post_meta( get_the_ID(), 'oscillator_event_listing_base_category', true );
					$show_upcoming  = get_post_meta( get_the_ID(), 'oscillator_event_listing_upcoming', true );
					$show_past      = get_post_meta( get_the_ID(), 'oscillator_event_listing_past', true );
					$upcoming_title = get_post_meta( get_the_ID(), 'oscillator_event_listing_upcoming_title', true );
					$past_title     = get_post_meta( get_the_ID(), 'oscillator_event_listing_past_title', true );
					$posts_per_page = get_post_meta( get_the_ID(), 'oscillator_event_listing_posts_per_page', true );
				?>
				<div class="col-xs-12 <?php echo esc_attr( $show_sidebar ? 'col-md-9' : '' ); ?>">
					<?php if ( $show_upcoming ): ?>
						<?php
							$recurrent_params = array(
								'post_type'      => $cpt,
								'posts_per_page' => - 1,
								'meta_key'       => 'oscillator_event_recurrence',
								'orderby'        => 'meta_value',
								'order'          => 'ASC',
								'meta_query'     => array(
									array(
										'key'     => 'oscillator_event_recurrent',
										'value'   => 1,
										'compare' => '='
									)
								)
							);

							$date_params = array(
								'post_type'  => $cpt,
								'paged'      => oscillator_get_page_var(),
								'meta_query'     => array(
									'relation' => 'AND',
									'date_clause' => array(
										'key'     => 'oscillator_event_date',
										'value'   => date_i18n('Y-m-d'),
										'compare' => '>=',
										'type'    => 'DATE'
									),
									'time_clause' => array(
										'key'     => 'oscillator_event_time',
										'compare' => 'EXISTS',
										'type'    => 'TIME'
									),
								),
								'orderby'        => array(
									'date_clause' => 'ASC',
									'time_clause' => 'ASC',
								),
							);

							$args_tax = array(
								'tax_query' => array(
									array(
										'taxonomy'         => $cpt_taxonomy,
										'field'            => 'id',
										'terms'            => intval( $base_category ),
										'include_children' => true
									)
								)
							);

							if ( ! empty( $base_category ) && $base_category >= 1 ) {
								$recurrent_params = array_merge( $recurrent_params, $args_tax );
								$date_params      = array_merge( $date_params, $args_tax );
							}

							if ( $posts_per_page >= 1 ) {
								$date_params['posts_per_page'] = $posts_per_page;
							} elseif ( $posts_per_page <= - 1 ) {
								$date_params['posts_per_page'] = - 1;
							} else {
								$date_params['posts_per_page'] = get_option( 'posts_per_page' );
							}

							$future_events = oscillator_merge_wp_queries( $recurrent_params, $date_params );

							/*
							 * These are needed purely for the pagination of Upcoming events.
							 * Since $future_events is a merged query with posts_per_page = -1
							 * oscillator_pagination() gets confused, so this is needed to pass the correct values.
							 */
							$date_params['fields'] = 'ids';
							$dated_events = new WP_Query( $date_params );

						?>
						<div class="event-listing-wrap">
							<h3><?php echo esc_html( $upcoming_title ); ?></h3>
							<?php if ( $future_events->have_posts() ): ?>
								<ul class="list-array">
									<?php while ( $future_events->have_posts() ): $future_events->the_post(); ?>
										<?php get_template_part( 'item', get_post_type() ); ?>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</ul>
								<?php oscillator_pagination( array(), $dated_events ); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $show_past ): ?>
						<?php
							$past_events_args = array(
								'post_type'    => $cpt,
								'paged'        => oscillator_get_page_var(),
								'meta_key'     => 'oscillator_event_date',
								'meta_value'   => date_i18n( 'Y-m-d' ),
								'meta_compare' => '<',
								'orderby'      => 'meta_value',
								'order'        => 'DESC',
							);

							$args_tax = array(
								'tax_query' => array(
									array(
										'taxonomy'         => $cpt_taxonomy,
										'field'            => 'id',
										'terms'            => intval( $base_category ),
										'include_children' => true
									)
								)
							);

							if ( ! empty( $base_category ) && $base_category >= 1 ) {
								$past_events_args = array_merge( $past_events_args, $args_tax );
							}

							if ( $posts_per_page >= 1 ) {
								$past_events_args['posts_per_page'] = $posts_per_page;
							} elseif ( $posts_per_page <= - 1 ) {
								$past_events_args['posts_per_page'] = - 1;
							} else {
								$past_events_args['posts_per_page'] = get_option( 'posts_per_page' );
							}

							$past_events = new WP_Query( $past_events_args );
						?>
						<?php if ( $past_events->have_posts() ): ?>
							<div class="event-listing-wrap">
								<h3><?php echo esc_html( $past_title ); ?></h3>
									<ul class="list-array">
										<?php while ( $past_events->have_posts() ): $past_events->the_post(); ?>
											<?php get_template_part( 'item', get_post_type() ); ?>
										<?php endwhile; ?>
										<?php wp_reset_postdata(); ?>
									</ul>
									<?php oscillator_pagination( array(), $dated_events ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>

			<?php if ( $show_sidebar ): ?>
				<div class="col-md-3 col-xs-12">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>