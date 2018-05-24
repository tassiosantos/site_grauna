<?php
	$event_venue    = get_post_meta( get_the_ID(), 'oscillator_event_venue', true );
	$event_location = get_post_meta( get_the_ID(), 'oscillator_event_location', true );
	$event_fields   = get_post_meta( get_the_ID(), 'oscillator_event_fields', true );

	$event_recurrent  = get_post_meta( get_the_ID(), 'oscillator_event_recurrent', true );
	$event_recurrence = get_post_meta( get_the_ID(), 'oscillator_event_recurrence', true );
	$event_date       = get_post_meta( get_the_ID(), 'oscillator_event_date', true );
	$event_time       = get_post_meta( get_the_ID(), 'oscillator_event_time', true );
	$event_dt         = strtotime( $event_date . ' ' . $event_time );
	$now_dt           = current_time( 'timestamp' );
?>
<li class="list-item">
	<div class="list-item-intro">
		<?php if ( $event_recurrent ): ?>
			<p class="list-item-group">
				<?php echo $event_recurrence; ?>
			</p>
		<?php elseif ( $event_dt !== false ): ?>
			<span class="list-item-no"><?php echo esc_html( date_i18n( 'd', $event_dt ) ); ?></span>

			<p class="list-item-group">
				<?php echo esc_html( date_i18n( 'M', $event_dt ) ); ?>
				<b><?php echo esc_html( date_i18n( 'Y', $event_dt ) ); ?></b>
			</p>
		<?php endif; ?>
	</div>

	<div class="list-item-info">
		<p class="list-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

		<p class="list-item-group">
			<?php echo esc_html( $event_venue ); ?>
			<b><?php echo esc_html( $event_location ); ?></b>
		</p>
	</div>


	<?php if ( $event_recurrent || $event_dt !== false ): ?>
		<?php
			if ( $event_recurrent || $event_dt >= $now_dt ) {
				$button_text = get_post_meta( get_the_ID(), 'oscillator_event_upcoming_button', true );
				$button_url  = get_post_meta( get_the_ID(), 'oscillator_event_upcoming_url', true );
			} else {
				$button_text = get_post_meta( get_the_ID(), 'oscillator_event_past_button', true );
				$button_url  = get_post_meta( get_the_ID(), 'oscillator_event_past_url', true );
			}
		?>
		<?php if ( ! empty( $button_text ) ): ?>
			<div class="list-item-extra">
				<?php if( ! empty( $button_url ) ): ?>
					<a class="btn" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
				<?php else: ?>
					<span class="btn btn-inactive"><?php echo esc_html( $button_text ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</li>
