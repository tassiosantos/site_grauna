<?php get_header(); ?>


<?php while( have_posts() ): the_post(); ?>

	<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
		<?php
			$gal       = ci_featgal_get_attachments( get_the_ID() );
			$details   = get_post_meta( get_the_ID(), 'portfolio_details', true );
			$template  = get_post_meta( get_the_ID(), 'portfolio_template', true );
			$video_url = get_post_meta( get_the_ID(), 'portfolio_video_url', true );
		?>
<!-- se existir video -->
		<?php if( ! empty( $video_url ) ): ?>
<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<figure class="entry-featured">
					<?php echo wp_oembed_get( esc_url_raw( $video_url ) ); ?>
				</figure>

<!-- conteudo do template inicio -->
		<div class="entry-content group">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
		</div><!-- /.entry-content -->
<!-- conteudo do template fim -->
			</div><!-- /.col-md-10 .col-md-offset-1 -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
		
<!-- se nao existir video -->
		
		<?php elseif( $gal->have_posts() && 'slideshow' == $template ): ?>
			<main class="main">
				<div class="container">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
		
			<figure class="entry-featured">
				<div class="ci-slider portfolio-slider loading">
					<ul class="slides">
						<?php while( $gal->have_posts() ): $gal->the_post(); ?>
							<?php $img_info = wp_prepare_attachment_for_js( get_the_ID() ); ?>
							<li>
								<a class="ci-lightbox" href="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $img_info['caption'] ); ?>">
									<img src="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $img_info['alt'] ); ?>" />
								</a>
							</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
			</figure>
							
			</div><!-- /.col-md-10 .col-md-offset-1 -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
							
<!-- Se nao existir video -->
		<?php elseif( has_post_thumbnail() ): ?>
<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
		
			<figure class="entry-featured">
				<a href="<?php echo ci_get_featured_image_src( 'large' ); ?>" class="ci-lightbox">
					<?php the_post_thumbnail(); ?>
				</a>
			</figure>
		
			</div><!-- /.col-md-10 .col-md-offset-1 -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
		<?php endif; ?>
<!-- coluna a partir da qual entra as imagens -->
<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">		
		<div class="row">

			<div class="col-md-9">

<!-- inicio das imagens se galeria -->						
				<?php if( $gal->have_posts() && 'list' == $template ): ?>
					<figure class="entry-thumb entry-portfolio-images">
						<?php while( $gal->have_posts() ): $gal->the_post(); ?>
							<?php $img_info = wp_prepare_attachment_for_js( get_the_ID() ); ?>
							<a class="ci-lightbox" href="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $img_info['caption'] ); ?>">
								<img src="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $img_info['alt'] ); ?>" />
							</a>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</figure>
				
		
<!-- inicio das imagens se slideshow -->								
				

				<?php elseif( ! empty( $video_url ) && $gal->have_posts() && 'slideshow' == $template ): ?>
				<figure class="entry-featured">
						<div class="ci-slider portfolio-slider loading">
							<ul class="slides">
								<?php while( $gal->have_posts() ): $gal->the_post(); ?>
									<?php $img_info = wp_prepare_attachment_for_js( get_the_ID() ); ?>
									<li>
										<a class="ci-lightbox" href="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'large' ) ); ?>" title="<?php echo esc_attr( $img_info['caption'] ); ?>">
											<img src="<?php echo esc_url( ci_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $img_info['alt'] ); ?>" />
										</a>
									</li>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</ul>
						</div>
					</figure>

				<?php endif; ?>


			</div><!-- /.col-md-9 -->

		</div><!-- /.row -->
			</div><!-- /.col-md-10 .col-md-offset-1 -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
	</article><!-- /.entry -->
<!-- ?php get_template_part( 'inc_related', get_post_type() ); ? -->

<?php endwhile; ?>
				
					
<?php get_footer(); ?>
