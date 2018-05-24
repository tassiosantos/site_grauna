<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label for="s" class="screen-reader-text"><?php _e( 'Search for:', 'ci_theme' ); ?></label>
		<input type="text" placeholder="<?php esc_attr_e( 'Search', 'ci_theme' ); ?>" id="s" name="s" value="<?php echo esc_attr( get_search_query() != '' ? get_search_query() : '' ); ?>">
		<button class="searchsubmit" type="submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php _e( 'Search', 'ci_theme' ); ?></span></button>
	</div>
</form>