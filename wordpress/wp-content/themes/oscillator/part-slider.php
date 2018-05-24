<?php
	$q    = false;
	$args = array(
		'post_type' => 'oscillator_slide',
	);

	if ( get_theme_mod( 'home_slider_term' ) ) {
		$args = array_merge( $args, array(
			'tax_query' => array(
				array(
					'taxonomy' => 'oscillator_slide_category',
					'terms'    => get_theme_mod( 'home_slider_term' )
				),
			),
		) );
	}

	if ( $args !== false ) {
		$q = new WP_Query( $args );
	}

	$attributes = sprintf( 'data-slideshow="%s" data-animation="%s" data-direction="%s" data-slideshowspeed="%s" data-animationspeed="%s"',
		esc_attr( get_theme_mod( 'home_slider_slideshow', 1 ) ),
		esc_attr( get_theme_mod( 'home_slider_animation', 'fade' ) ),
		esc_attr( get_theme_mod( 'home_slider_direction', 'horizontal' ) ),
		esc_attr( get_theme_mod( 'home_slider_slideshowSpeed', 3000 ) ),
		esc_attr( get_theme_mod( 'home_slider_animationSpeed', 600 ) )
	);
?>
<?php if ( $args !== false && $q !== false && $q->have_posts() ): ?>
	<div class="home-slider ci-slider loading" <?php echo $attributes; ?>>
		<ul class="slides">
			<?php while ( $q->have_posts() ): $q->the_post(); ?>
				<?php
					$button_text = get_post_meta( get_the_ID(), 'oscillator_slide_button_text', true );
					$button_url  = get_post_meta( get_the_ID(), 'oscillator_slide_button_url', true );
					$subtext1    = get_post_meta( get_the_ID(), 'oscillator_slide_subtext_1', true );
					$subtext2    = get_post_meta( get_the_ID(), 'oscillator_slide_subtext_2', true );
					$rotated     = get_post_meta( get_the_ID(), 'oscillator_slide_rotated', true );
					$rotated     = $rotated == 1 ? 'slide-rotated' : '';
				?>
				<li style="background-image: url(<?php echo esc_url( oscillator_get_image_src( get_post_thumbnail_id(), 'oscillator_slider' ) ); ?>);">
					<div class="slide-content <?php echo esc_attr( $rotated ); ?>">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<div class="slide-sup">
										<?php if ( ! empty( $subtext2 ) ): ?>
											<p class="slide-date"><?php echo esc_html( $subtext2 ); ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $subtext1 ) ): ?>
											<p class="slide-location"><?php echo esc_html( $subtext1 ); ?></p>
										<?php endif; ?>
									</div>

									<p class="slide-title"><?php the_title(); ?></p>

									<?php if ( ! empty( $button_url ) ): ?>
										<a class="btn" href="<?php echo esc_url( $button_url ); ?>">
											<?php if ( ! empty( $button_text ) ) {
												echo esc_html( $button_text );
											} else {
												esc_html_e( 'Learn more', 'oscillator' );
											} ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php endif; ?>
