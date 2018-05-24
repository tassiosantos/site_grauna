<?php
/*
 * Template Name: Gallery Listing
 */
?>
<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">

		<?php while ( have_posts() ): the_post(); ?>
			<h2 class="page-title"><?php the_title(); ?></h2>

			<?php
				$cpt            = 'oscillator_gallery';
				$cpt_taxonomy   = 'oscillator_gallery_category';
				$base_category  = get_post_meta( get_the_ID(), 'oscillator_gallery_listing_base_category', true );
				$isotope        = get_post_meta( get_the_ID(), 'oscillator_gallery_listing_isotope', true );
				$columns        = get_post_meta( get_the_ID(), 'oscillator_gallery_listing_columns', true );
				$masonry        = get_post_meta( get_the_ID(), 'oscillator_gallery_listing_masonry', true );
				$posts_per_page = get_post_meta( get_the_ID(), 'oscillator_gallery_listing_posts_per_page', true );

				$args = array(
					'paged'     => oscillator_get_page_var(),
					'post_type' => $cpt,
				);

				$args_tax = array(
					'tax_query' => array(
						array(
							'taxonomy'         => $cpt_taxonomy,
							'field'            => 'id',
							'terms'            => intval( $base_category ),
							'include_children' => true
						)
					)
				);

				if ( $posts_per_page >= 1 ) {
					$args['posts_per_page'] = $posts_per_page;
				} elseif ( $posts_per_page <= - 1 ) {
					$args['posts_per_page'] = - 1;
				}

				$div_class = '';
				if ( $masonry ) {
					$div_class = 'list-masonry';
				}
				if ( $isotope ) {
					$args['posts_per_page'] = - 1;
					$div_class = 'list-masonry';
				}

				$q = new WP_Query( $args );

				if ( empty( $base_category ) || $base_category < 1 ) {
					$q = new WP_Query( $args );
				} else {
					$q = new WP_Query( array_merge( $args, $args_tax ) );
				}
			?>

			<?php if ( $isotope ): ?>
				<ul class="filters-nav group">
					<li><a href="#filter" class="selected btn btn-small" data-filter="*"><?php esc_html_e( 'All Items', 'oscillator' ); ?></a></li>
					<?php $cats = get_terms( $cpt_taxonomy, array( 'hide_empty' => 1 ) ); ?>
					<?php foreach ( $cats as $cat ): ?>
						<li><a href="#filter" class="btn btn-small btn-transparent" data-filter=".<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<div class="row row-joined item-list <?php echo esc_attr( $div_class ); ?>">
				<?php while ( $q->have_posts() ): $q->the_post(); ?>
					<?php $terms = implode( ' ', wp_list_pluck( wp_get_object_terms( get_the_ID(), $cpt_taxonomy ), 'slug' ) ); ?>
					<div class="<?php echo esc_attr( oscillator_get_columns_classes( $columns ) ); ?> <?php echo esc_attr( $terms ); ?>">
						<?php if( $masonry ) {
							get_template_part( 'item-tall', get_post_type() );
						} else {
							get_template_part( 'item', get_post_type() );
						} ?>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>

			<?php oscillator_pagination( array(), $q ); ?>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>