<div class="item">
	<a href="<?php the_permalink(); ?>">
		<div class="item-info">
			<p class="item-title"><?php the_title(); ?></p>

			<?php $location = get_post_meta( get_the_ID(), 'oscillator_gallery_location', true ); ?>
			<?php if ( ! empty( $location ) ): ?>
				<p class="item-subtitle"><?php echo esc_html( $location ); ?></p>
			<?php endif; ?>
		</div>
		<?php the_post_thumbnail( 'oscillator_square' ); ?>

		<span class="btn btn-white btn-transparent btn-round">
			<i class="fa fa-search-plus"></i><span class="screen-reader-text"><?php esc_html_e( 'View Gallery', 'oscillator' ); ?></span>
		</span>
	</a>
</div>
