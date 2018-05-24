<?php
add_action( 'wp_head', 'oscillator_customizer_css' );
if ( ! function_exists( 'oscillator_customizer_css' ) ):
function oscillator_customizer_css() {
    ?><style type="text/css"><?php

		//
		// Global
		//
		if ( get_theme_mod( 'site_bg_color' ) ) {
			?>
			body {
				background-color: <?php echo get_theme_mod( 'site_bg_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_primary_color' ) ) {
			$secondary_color = get_theme_mod( 'site_secondary_color' );
			$secondary_color = ! empty ( $secondary_color ) ? $secondary_color : '#F3890B';
			?>

			a,
			.item-timer .count b,
			.list-item-no,
			.list-item-title,
			.entry-title a:hover,
			.ci-soundplayer-controls a,
			.ci-soundplayer-controls a:hover,
			.ci-soundplayer-controls a:focus {
				color: <?php echo get_theme_mod( 'site_primary_color' ); ?>
			}

			.comment-reply-link,
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button,
			.btn-white:hover,
			.btn-transparent:hover,
			.item:hover .btn,
			.list-item:before,
			.ci-soundplayer-met .progress-bar,
			.section-title:after ,
			.page-title:after {
				background-color: <?php echo get_theme_mod( 'site_primary_color' ); ?>;
				background-image: -webkit-linear-gradient(left, <?php echo get_theme_mod( 'site_primary_color' ); ?>, <?php echo $secondary_color; ?>);
				background-image: linear-gradient(to right, <?php echo get_theme_mod( 'site_primary_color' ); ?>, <?php echo $secondary_color; ?>);
			}

			.comment-reply-link:before,
			.btn:before,
			input[type="button"]:before,
			input[type="submit"]:before,
			input[type="reset"]:before,
			button:before,
			.navigation > li ul a:hover,
			.navigation > li ul .sfHover > a,
			.ci-slider .ci-control-paging li a.ci-active,
			.ci-soundplayer-play,
			.widget-title:after,
			.hero-player {
				background-color: <?php echo get_theme_mod( 'site_primary_color' ); ?>
			}

			.home-slider + .hero-player,
			.hero-video + .hero-player {
				background: rgba(255,255,255,0.1);
			}

			.ci-slider .ci-control-paging li a.ci-active,
			.item:hover .btn {
				border-color: <?php echo get_theme_mod( 'site_primary_color' ); ?>
			}

			.navigation > li > a:hover,
			.navigation > li.sfHover > a,
			.navigation > li.sfHover > a:active,
			.navigation > li.current_page_item > a,
			.navigation > li.current-menu-item > a,
			.navigation > li.current-menu-ancestor > a,
			.navigation > li.current-menu-parent > a,
			.navigation > li.current > a {
				border-bottom-color: <?php echo get_theme_mod( 'site_primary_color' ); ?>
			}
			<?php
		}

		if ( get_theme_mod( 'site_secondary_color' ) ) {
			$primary_color = get_theme_mod( 'site_primary_color' );
			$primary_color = ! empty ( $primary_color ) ? $primary_color : '#f3430c'
			?>
				a:hover {
					color: <?php echo get_theme_mod( 'site_secondary_color' ); ?>
				}

				.comment-reply-link,
				.btn,
				input[type="button"],
				input[type="submit"],
				input[type="reset"],
				button,
				.btn-white:hover,
				.btn-transparent:hover,
				.item:hover .btn,
				.list-item:before,
				.ci-soundplayer-met .progress-bar,
				.section-title:after ,
				.page-title:after {
					background-image: -webkit-linear-gradient(left, <?php echo $primary_color; ?>, <?php echo get_theme_mod( 'site_secondary_color' ); ?>);
					background-image: linear-gradient(to right, <?php echo $primary_color; ?>, <?php echo get_theme_mod( 'site_secondary_color' ); ?>);
				}
			<?php
		}

		if ( get_theme_mod( 'site_text_color' ) ) {
			?>
			body,
			blockquote cite,
			.btn-white,
			.btn-transparent,
			.list-item:hover .btn,
			.list-item.sm2_container_playing .btn,
			.list-item.sm2_container_playing .list-item-title,
			.list-item:hover .list-item-title,
			.list-item.sm2_container_playing .list-item-title,
			.list-item.sm2_container_playing .list-item-title a,
			.list-item:hover .list-item-title a,
			.list-item-title:hover,
			.entry-title a,
			.form-allowed-tags,
			.comment-notes,
			.widget .instagram-pics li a, {
				color: <?php echo get_theme_mod( 'site_text_color' ); ?>;
			}

			@media ( min-width: 992px ) {
				.sidebar {
					.list-item-no {
						color: <?php echo get_theme_mod( 'site_text_color' ); ?>;
					}
				}
			}
			<?php
		}

		if ( get_theme_mod( 'site_border_color' ) ) {
			?>

			input,
			textarea,
			.btn-transparent,
			.item a,
			.item-timer .count,
			#paging a,
			#paging > span,
			.widget select,
			input:hover,
			textarea:hover,
			input:focus,
			textarea:focus {
				border-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.item-meta,
			.list-item:first-child {
				border-top-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.item-meta th,
			.item-meta td,
			.list-item,
			.widget ul li a,
			.widget ul li {
				border-bottom-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.item-meta th,
			.item-meta td {
				border-left-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.item-meta td {
				border-right-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			<?php
		}

		//
		// Header
		//
		$header_color = false;
		$header_image = false;
		if( is_page_template( 'template-frontpage.php' ) ) {
			$header_color = get_theme_mod( 'header_front_color', 'rgba( 243, 67, 12, 0.6 )' );
		} else {
			$header_color = get_theme_mod( 'header_color', 'rgba( 243, 67, 12, 1 )' );
			$header_image = get_header_image();
		}

		if( ! empty( $header_color ) || ! empty( $header_image ) ) {
			?>
			.header {
				<?php if ( ! empty( $header_color ) ) : ?>
					background-color: <?php echo $header_color; ?>;
				<?php endif; ?>
				<?php if ( ! empty( $header_image ) ) : ?>
					background-image: url('<?php echo esc_url_raw( $header_image ); ?>');
				<?php endif; ?>
			}
			<?php
		}


		//
		// Logo
		//
		if( get_theme_mod( 'logo_padding_top' ) || get_theme_mod( 'logo_padding_top' ) ) {
			?>
			.site-logo img {
				<?php if( get_theme_mod( 'logo_padding_top' ) ): ?>
					padding-top: <?php echo intval( get_theme_mod( 'logo_padding_top' ) ); ?>px;
				<?php endif; ?>
				<?php if( get_theme_mod( 'logo_padding_bottom' ) ): ?>
					padding-bottom: <?php echo intval( get_theme_mod( 'logo_padding_bottom' ) ); ?>px;
				<?php endif; ?>
			}
			<?php
		}


		if( get_theme_mod( 'custom_css' ) ) {
			echo get_theme_mod( 'custom_css' );
		}

	?></style><?php
}
endif;
