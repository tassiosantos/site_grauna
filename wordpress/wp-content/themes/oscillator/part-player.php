<?php
	$player_postid = get_theme_mod( 'player_post_id' );
	$tracklisting  = get_post_meta( $player_postid, 'oscillator_discography_tracks', true );

	if ( empty( $tracklisting ) || ! is_array( $tracklisting ) || count( $tracklisting ) < 1 ) {
		$tracklisting = false;
	}

	$player_stream = get_theme_mod( 'player_stream' );
	$player_name   = get_theme_mod( 'player_stream_name', esc_html__( 'Streaming audio', 'oscillator' ) );
	$player_class  = ! empty( $player_stream ) ? 'ci-streaming' : '';
?>
<?php if ( ! empty( $tracklisting ) || ! empty( $player_stream ) ): ?>
	<div class="hero-player">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="ci-soundplayer <?php echo esc_attr( $player_class ); ?>">
						<div class="ci-soundplayer-controls">
							<a class="ci-soundplayer-prev" href="#"><i class="fa fa-step-backward"></i></a>
							<a class="ci-soundplayer-play" href="#"><i class="fa fa-play"></i></a>
							<a class="ci-soundplayer-next" href="#"><i class="fa fa-step-forward"></i></a>
						</div>

						<div class="ci-soundplayer-meta">
							<span class="track-title"></span>

							<div class="track-bar">
								<div class="progress-bar"></div>
								<div class="load-bar"></div>
							</div>
							<span class="track-position">00:00</span>
						</div>

						<ol class="ci-soundplayer-tracklist">
							<?php if ( ! empty( $player_stream ) ): ?>
								<li>
									<a class="inline-exclude" href="<?php echo esc_url( $player_stream ); ?>"><?php echo esc_html( $player_name ); ?></a>
								</li>
							<?php else: ?>
								<?php
									$track_no = 1;
									foreach ( $tracklisting as $track ) {
										echo sprintf( '<li><a class="inline-exclude" href="%s">%s. %s%s</a></li>',
											esc_url( $track['play_url'] ),
											$track_no,
											esc_html( $track['title'] ),
											empty( $track['subtitle'] ) ? '' : ' - ' . $track['subtitle']
										);
										$track_no ++;
									}
								?>
							<?php endif; ?>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>