<div class="item">
	<a href="<?php the_permalink(); ?>">
		<div class="item-info">
			<p class="item-title"><?php the_title(); ?></p>

			<p class="item-subtitle"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'oscillator_artist_category', '', ', ' ) ); ?></p>
		</div>
		<?php the_post_thumbnail( 'oscillator_square' ); ?>

		<span class="btn btn-white btn-transparent"><?php esc_html_e( 'Learn More', 'oscillator' ); ?></span>
	</a>
</div>
