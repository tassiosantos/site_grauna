<?php
/*
 *
 * Template: allslider.php
 *
 */
?>
<div class="sliderblock">
<?php
    $evolve_slider_page_id = '';
    if (!empty($post->ID)) {
        if (!is_home() && !is_front_page() && !is_archive()) {
            $evolve_slider_page_id = $post->ID;
        }
        if (!is_home() && is_front_page()) {
            $evolve_slider_page_id = $post->ID;
        }
    }
    if (is_home() && !is_front_page()) {
        $evolve_slider_page_id = get_option('page_for_posts');
    }

// Bootstrap Slider
    $evolve_bootstrap = evolve_get_option('evl_bootstrap_slider', '1');
    $evolve_bootstrap_on = evolve_get_option('evl_bootstrap_slider_support', '1');
    if ( (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'bootstrap' && $evolve_bootstrap_on == "1") || ($evolve_bootstrap == "1" && $evolve_bootstrap_on == "1") ):
        evolve_bootstrap();
    endif;

// Parallax Slider
    $evolve_parallax = evolve_get_option('evl_parallax_slider', '1');
    $evolve_parallax_on = evolve_get_option('evl_parallax_slider_support', '1');
    if ( (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'parallax' && $evolve_parallax_on == "1") || ($evolve_parallax == "1" && $evolve_parallax_on == "1") ):
        $evolve_parallax_slider = evolve_get_option('evl_parallax_slider_support', '1');
        if ($evolve_parallax_slider == "1"):
            evolve_parallax();
        endif;
    endif;

// Posts Slider
    $evolve_posts_slider = evolve_get_option('evl_posts_slider', '1');
    $evolve_post_on = evolve_get_option('evl_carousel_slider', '1');
    if ( (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'posts' && $evolve_post_on == "1") || ($evolve_posts_slider == "1" && $evolve_post_on == "1") ):
        $evolve_carousel_slider = evolve_get_option('evl_carousel_slider', '1');
        if ($evolve_carousel_slider == "1"):
            evolve_posts_slider();
        endif;
    endif;
?>
</div><!--/.sliderblock-->
