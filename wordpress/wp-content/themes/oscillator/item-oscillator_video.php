<div class="item">
	<a href="<?php the_permalink(); ?>">
		<div class="item-info">
			<p class="item-title"><?php the_title(); ?></p>
		</div>
		<?php the_post_thumbnail( 'oscillator_square' ); ?>

		<span class="btn btn-white btn-transparent btn-round">
			<i class="fa fa-play"></i><span class="screen-reader-text"><?php esc_html_e( 'View Video', 'oscillator' ); ?></span>
		</span>
	</a>
</div>
