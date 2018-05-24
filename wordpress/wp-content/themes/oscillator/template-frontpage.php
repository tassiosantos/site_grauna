<?php
/*
 * Template Name: Homepage Template
 */
?>
<?php get_header(); ?>



<?php get_template_part( 'part', 'player' ); ?>

<?php
/*
 * Edição para funciona com o Elementor
 */
?>
<?php the_content(); ?>
<?php wp_link_pages(); ?>
<?php
/*
 * Fim da edição
 */
?>

<?php
	if ( get_theme_mod( 'home_video_show' ) ) {
		get_template_part( 'part', 'video' );
	} elseif ( get_theme_mod( 'home_slider_show', 1 ) ) {
		get_template_part( 'part', 'slider' );
	}
?>


<main class="main home-sections">
	<?php dynamic_sidebar( 'frontpage' ); ?>
</main>

<?php get_footer(); ?>