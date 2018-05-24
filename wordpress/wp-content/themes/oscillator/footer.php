	<?php if ( ! is_page_template( 'template-frontpage.php' ) ): ?>
			</div>
		</main>
	<?php endif; ?>

	<footer class="footer">
		<?php if ( is_active_sidebar( 'footer' ) ): ?>
			<div class="footer-sections">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
		<?php endif; ?>

		<div class="footer-info">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-5">
						<p>
							<?php echo get_theme_mod( 'footer_text', implode( ' &ndash; ', array(
								get_bloginfo( 'name' ),
								get_bloginfo( 'description' )
							) ) ); ?>
						</p>
					</div>

					<div class="col-md-7">
						<?php wp_nav_menu( array(
							'theme_location' => 'footer_menu',
							'container'      => '',
							'menu_id'        => '',
							'menu_class'     => 'nav-footer',
							'depth'          => 1,
						) ); ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
