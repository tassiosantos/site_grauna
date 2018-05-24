<?php
	$has_video = false;
	$files     = array(
		'mp4'  => get_theme_mod( 'home_video_mp4' ),
		'webm' => get_theme_mod( 'home_video_webm' ),
		'ogg'  => get_theme_mod( 'home_video_ogg' ),
	);

	foreach ( $files as $type => $url ) {
		if ( ! empty( $url ) ) {
			$has_video = true;
		}
	}
?>
<?php if ( $has_video ): ?>
	<div class="hero-video">
		<video autoplay="" loop="" muted="">
			<?php foreach ( $files as $type => $url ): ?>
				<?php if ( ! empty( $url ) ): ?>
					<source src="<?php echo esc_url( $url ); ?>" type="video/<?php echo esc_attr( $type ); ?>">
				<?php endif; ?>
			<?php endforeach; ?>
		</video>
	</div>
<?php endif; ?>