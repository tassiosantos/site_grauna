<div class="sidebar">
	<?php
		if ( is_singular( 'oscillator_video' ) ) {
			dynamic_sidebar( 'video' );
		} elseif ( is_singular( 'oscillator_event' ) || is_page_template( 'template-listing-event.php' ) ) {
			dynamic_sidebar( 'event' );
		} elseif ( is_page() ) {
			if ( is_active_sidebar( 'page' ) ) {
				dynamic_sidebar( 'page' );
			} else {
				dynamic_sidebar( 'blog' );
			}
		} else {
			dynamic_sidebar( 'blog' );
		}
	?>
</div><!-- /sidebar -->
