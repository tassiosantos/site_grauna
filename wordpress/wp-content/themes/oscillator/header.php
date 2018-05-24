<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="page">
	<div id="mobile-bar">
		<a class="menu-trigger" href="#mobilemenu"><i class="fa fa-bars"></i></a>

		<p class="mob-title"><?php bloginfo( 'name' ); ?></p>
	</div>

	<header class="header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<h1 class="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if ( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ): ?>
								<img
								     src="<?php echo esc_url( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>"
								     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
							<?php else: ?>
								<?php bloginfo( 'name' ); ?>
							<?php endif; ?>
						</a>
					</h1>

					<?php if ( get_theme_mod( 'header_tagline', 1 ) ): ?>
						<p class="site-tagline"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div>

				<div class="col-md-9">
					<nav class="nav">
						<?php wp_nav_menu( array(
							'theme_location' => 'main_menu',
							'container'      => '',
							'menu_id'        => '',
							'menu_class'     => 'navigation'
						) ); ?>
					</nav>

					<div id="mobilemenu"></div>
				</div>
			</div>
		</div>
	</header>

	<?php if ( ! is_page_template( 'template-frontpage.php' ) ): ?>
		<main class="main">
			<div class="container">
	<?php endif; ?>
