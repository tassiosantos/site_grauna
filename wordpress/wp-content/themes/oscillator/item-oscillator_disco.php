<div class="item">
	<a href="<?php the_permalink(); ?>">
		<div class="item-info">
			<p class="item-title"><?php the_title(); ?></p>

			<?php $release_date = get_post_meta( get_the_ID(), 'oscillator_discography_date', true ); ?>
			<?php if ( ! empty( $release_date ) ): ?>
				<p class="item-subtitle"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $release_date ) ); ?></p>
			<?php endif; ?>
		</div>
		<?php the_post_thumbnail( 'oscillator_square' ); ?>

		<span class="btn btn-white btn-transparent"><?php esc_html_e( 'Learn More', 'oscillator' ); ?></span>
	</a>
</div>
