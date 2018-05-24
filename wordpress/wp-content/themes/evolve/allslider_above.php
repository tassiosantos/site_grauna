<?php
/*
 *
 * Template: allslider.php
 *
 */
?>
<div class="sliderblock">
    <?php
    global $evl_options, $evl_frontpage_slider_status;
    $evl_frontpage_slider = array();
        if ( isset($evl_options['evl_front_elements_header_area']['enabled']) )
            $evl_frontpage_slider = $evl_options['evl_front_elements_header_area']['enabled'];

        if ($evl_frontpage_slider):
                foreach ($evl_frontpage_slider as $sliderkey => $sliderval) {
                        if ($sliderkey == 'bootstrap_slider') {
                                fp_bootstrap_slider();
                                $evl_frontpage_slider_status['bootstrap'] = false;
                        } elseif ($sliderkey == 'parallax_slider') {
                                fp_parallax_slider();
                                $evl_frontpage_slider_status['parallax'] = false;
                        } elseif ($sliderkey == 'posts_slider') {
                                fp_post_slider();
                                $evl_frontpage_slider_status['posts'] = false;
                        } elseif ($sliderkey == 'header') {
                                break;
                        }
                }
        endif;
    ?>
</div><!--/.sliderblock-->
