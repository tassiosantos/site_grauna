<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package TA Music
 */
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<!-- go to top --> 
		<div class="container gototop">
			<a href="#top"><?php _e( 'Go To Top', 'ta-music' ); ?></a><i class="fa fa-chevron-up"></i>
		</div>

		<?php if ( is_active_sidebar ( 'footer-1' ) || is_active_sidebar ( 'footer-2' ) || is_active_sidebar ( 'footer-3' ) || is_active_sidebar ( 'footer-4' ) ) { ?>
		<!-- footer widgets -->
		<div class="container">
			<div class="row">
				<div class="footer-col col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
				<div class="footer-col col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
				<div class="footer-col col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
				<div class="footer-col col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>
			</div>
		</div><!-- end footer widgets -->
		<?php } ?>

		<div class="container bottom-footer">
			<div class="row">
				<!-- copyright notice -->
				<div class="col-md-6 copyright">
					<?php if ( ta_option( 'custom_copyright' ) != '') { echo ta_option( 'custom_copyright' ); } ?>
				</div><!-- .copyright -->

			</div><!-- .row -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>