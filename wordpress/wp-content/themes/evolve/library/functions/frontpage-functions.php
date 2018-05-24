<?php

/* Front Page Content Boxes */
function evolve_content_boxes() {
    $evolve_content_boxes = evolve_get_option('evl_content_boxes', '1');
    if ($evolve_content_boxes == "1") {
        global $evl_options;
        
        $evolve_content_box1_enable = evolve_get_option('evl_content_box1_enable', '1');
        if ($evolve_content_box1_enable === false) {
            $evolve_content_box1_enable = '';
        }
        $evolve_content_box2_enable = evolve_get_option('evl_content_box2_enable', '1');
        if ($evolve_content_box2_enable === false) {
            $evolve_content_box2_enable = '';
        }
        $evolve_content_box3_enable = evolve_get_option('evl_content_box3_enable', '1');
        if ($evolve_content_box3_enable === false) {
            $evolve_content_box3_enable = '';
        }
        $evolve_content_box4_enable = evolve_get_option('evl_content_box4_enable', '1');
        if ($evolve_content_box4_enable === false) {
            $evolve_content_box4_enable = '';
        }

        $evolve_content_boxes_section_padding_top         = $evl_options['evl_content_boxes_section_padding']['padding-top'];
        $evolve_content_boxes_section_padding_bottom      = $evl_options['evl_content_boxes_section_padding']['padding-bottom'];
        $evolve_content_boxes_section_padding_left        = $evl_options['evl_content_boxes_section_padding']['padding-left'];
        $evolve_content_boxes_section_padding_right       = $evl_options['evl_content_boxes_section_padding']['padding-right'];
        $evolve_content_boxes_section_back_color          = evolve_get_option( 'evl_content_boxes_section_back_color', '' );
        $evolve_content_boxes_section_image_src           = evolve_get_option('evl_content_boxes_section_background_image');
        $evolve_content_boxes_section_image               = evolve_get_option('evl_content_boxes_section_image', 'cover');
        $evolve_content_boxes_section_background_repeat   = evolve_get_option('evl_content_boxes_section_image_background_repeat', 'no-repeat');
        $evolve_content_boxes_section_background_position = evolve_get_option('evl_content_boxes_section_image_background_position', 'center top');

        //html_attr
        $html_class = 't4p-fullwidth fullwidth-box hentry';
        $html_style = '';

        if( $evolve_content_boxes_section_back_color ) {
                $html_style .= sprintf( 'background-color:%s;', $evolve_content_boxes_section_back_color );
        }

        if( $evolve_content_boxes_section_image_src ) {
                $html_style .= sprintf( 'background-image: url(%s);', $evolve_content_boxes_section_image_src );
        }

        if( $evolve_content_boxes_section_image ) {
                $html_style .= sprintf( 'background-size:%s;', $evolve_content_boxes_section_image );
                $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_content_boxes_section_image );
                $html_style .= sprintf( '-moz-background-size:%s;', $evolve_content_boxes_section_image );
                $html_style .= sprintf( '-o-background-size:%s;', $evolve_content_boxes_section_image );
        }

        if( $evolve_content_boxes_section_background_position ) {
                $html_style .= sprintf( 'background-position:%s;', $evolve_content_boxes_section_background_position );
        }

        if( $evolve_content_boxes_section_background_repeat ) {
                $html_style .= sprintf( 'background-repeat:%s;', $evolve_content_boxes_section_background_repeat );
        }

        if( $evolve_content_boxes_section_padding_top ) {
                $html_style .= sprintf( 'padding-top:%s;', $evolve_content_boxes_section_padding_top );
        }

        if( $evolve_content_boxes_section_padding_bottom ) {
                $html_style .= sprintf( 'padding-bottom:%s;', $evolve_content_boxes_section_padding_bottom );
        }

        if( $evolve_content_boxes_section_padding_left ) {
                $html_style .= sprintf( 'padding-left:%s;', $evolve_content_boxes_section_padding_left );
        }

        if( $evolve_content_boxes_section_padding_right ) {
                $html_style .= sprintf( 'padding-right:%s;', $evolve_content_boxes_section_padding_right );
        }

        echo "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";

        $evolve_content_box_section_title = evolve_get_option('evl_content_boxes_title', 'evolve comes with amazing features which will blow your mind');
        if ($evolve_content_box_section_title == false) {
            $evolve_content_box_section_title = '';
        } else {
            $evolve_content_box_section_title = '<h2 class="content_box_section_title section_title">'.evolve_get_option('evl_content_boxes_title', 'evolve comes with amazing features which will blow your mind').'</h2>';
        }

        echo "<div class='home-content-boxes'><div class='row'>".$evolve_content_box_section_title;

        $evolve_content_box1_title = evolve_get_option('evl_content_box1_title', 'Flat & Beautiful');
        if ($evolve_content_box1_title === false) {
            $evolve_content_box1_title = '';
        }
        $evolve_content_box1_desc = evolve_get_option('evl_content_box1_desc', 'Clean modern theme with smooth and pixel perfect design focused on details');
        if ($evolve_content_box1_desc === false) {
            $evolve_content_box1_desc = '';
        }
        $evolve_content_box1_button = evolve_get_option('evl_content_box1_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>');
        if ($evolve_content_box1_button === false) {
            $evolve_content_box1_button = '';
        }
        $evolve_content_box1_icon = evolve_get_option('evl_content_box1_icon', 'fa-cube');
        if ($evolve_content_box1_icon === false) {
            $evolve_content_box1_icon = '';
        }

        /**
         * Count how many boxes are enabled on frontpage
         * Apply proper responsivity class
         *
         * @since 3.1.5
         */
        $BoxCount = 0; // Box Counter

        if ($evolve_content_box1_enable == true) {
            $BoxCount ++;
        }
        if ($evolve_content_box2_enable == true) {
            $BoxCount ++;
        }
        if ($evolve_content_box3_enable == true) {
            $BoxCount ++;
        }
        if ($evolve_content_box4_enable == true) {
            $BoxCount ++;
        }

        switch ($BoxCount):
            case $BoxCount == 1:
                $BoxClass = 'col-md-12';
                break;

            case $BoxCount == 2:
                $BoxClass = 'col-md-6';
                break;

            case $BoxCount == 3:
                $BoxClass = 'col-md-4';
                break;

            case $BoxCount == 4:
                $BoxClass = 'col-md-3';
                break;

            default:
                $BoxClass = 'col-md-3';
        endswitch;

        if ($evolve_content_box1_enable == true) {

            echo "<div class='col-sm-12 $BoxClass content-box content-box-1'>";

            echo "<i class='fa " . $evolve_content_box1_icon . "'></i>";

            echo "<h2>" . esc_attr($evolve_content_box1_title) . "</h2>";

            echo "<p>" . do_shortcode($evolve_content_box1_desc) . "</p>";

            echo "<div class='cntbox_btn sbtn1'>" . do_shortcode($evolve_content_box1_button) . "</div>";

            echo "</div>";
        }

        $evolve_content_box2_title = evolve_get_option('evl_content_box2_title', 'Easy Customizable');
        if ($evolve_content_box2_title === false) {
            $evolve_content_box2_title = '';
        }
        $evolve_content_box2_desc = evolve_get_option('evl_content_box2_desc', 'Over a hundred theme options ready to make your website unique');
        if ($evolve_content_box2_desc === false) {
            $evolve_content_box2_desc = '';
        }
        $evolve_content_box2_button = evolve_get_option('evl_content_box2_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>');
        if ($evolve_content_box2_button === false) {
            $evolve_content_box2_button = '';
        }
        $evolve_content_box2_icon = evolve_get_option('evl_content_box2_icon', 'fa-circle-o-notch');
        if ($evolve_content_box2_icon === false) {
            $evolve_content_box2_icon = '';
        }

        if ($evolve_content_box2_enable == true) {

            echo "<div class='col-sm-12 $BoxClass content-box content-box-2'>";

            echo "<i class='fa " . $evolve_content_box2_icon . "'></i>";

            echo "<h2>" . esc_attr($evolve_content_box2_title) . "</h2>";

            echo "<p>" . do_shortcode($evolve_content_box2_desc) . "</p>";

            echo "<div class='cntbox_btn sbtn2'>" . do_shortcode($evolve_content_box2_button) . "</div>";

            echo "</div>";
        }


        $evolve_content_box3_title = evolve_get_option('evl_content_box3_title', 'WooCommerce Ready');
        if ($evolve_content_box3_title === false) {
            $evolve_content_box3_title = '';
        }
        $evolve_content_box3_desc = evolve_get_option('evl_content_box3_desc', 'Start selling your products within few minutes using the WooCommerce feature');
        if ($evolve_content_box3_desc === false) {
            $evolve_content_box3_desc = '';
        }
        $evolve_content_box3_button = evolve_get_option('evl_content_box3_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>');
        if ($evolve_content_box3_button === false) {
            $evolve_content_box3_button = '';
        }
        $evolve_content_box3_icon = evolve_get_option('evl_content_box3_icon', 'fa-shopping-basket');
        if ($evolve_content_box3_icon === false) {
            $evolve_content_box3_icon = '';
        }

        if ($evolve_content_box3_enable == true) {

            echo "<div class='col-sm-12 $BoxClass content-box content-box-3'>";

            echo "<i class='fa " . $evolve_content_box3_icon . "'></i>";

            echo "<h2>" . esc_attr($evolve_content_box3_title) . "</h2>";

            echo "<p>" . do_shortcode($evolve_content_box3_desc) . "</p>";

            echo "<div class='cntbox_btn sbtn3'>" . do_shortcode($evolve_content_box3_button) . "</div>";

            echo "</div>";
        }

        $evolve_content_box4_title = evolve_get_option('evl_content_box4_title', 'Prebuilt Demos');
        if ($evolve_content_box4_title === false) {
            $evolve_content_box4_title = '';
        }
        $evolve_content_box4_desc = evolve_get_option('evl_content_box4_desc', 'Drag & Drop front page builder with many demos just perfect to start your new project');
        if ($evolve_content_box4_desc === false) {
            $evolve_content_box4_desc = '';
        }
        $evolve_content_box4_button = evolve_get_option('evl_content_box4_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>');
        if ($evolve_content_box4_button === false) {
            $evolve_content_box4_button = '';
        }
        $evolve_content_box4_icon = evolve_get_option('evl_content_box4_icon', 'fa-object-ungroup');
        if ($evolve_content_box4_icon === false) {
            $evolve_content_box4_icon = '';
        }

        if ($evolve_content_box4_enable == true) {

            echo "<div class='col-sm-12 $BoxClass content-box content-box-4'>";

            echo "<i class='fa " . $evolve_content_box4_icon . "'></i>";

            echo "<h2>" . esc_attr($evolve_content_box4_title) . "</h2>";

            echo "<p>" . do_shortcode($evolve_content_box4_desc) . "</p>";

            echo "<div class='cntbox_btn sbtn4'>" . do_shortcode($evolve_content_box4_button) . "</div>";

            echo "</div>";
        }
        echo "</div></div><div class='clearfix'></div></div></div>";
    }
}

/* Front Page Testimonials */
function evolve_testimonials() {
    global $evl_options;
    $testimonials_counter = 1;

    $backgroundcolor = $evl_options["evl_fp_testimonials_bg_color"];
    $textcolor = $evl_options["evl_fp_testimonials_text_color"];
    $evolve_testimonials_section_back_color             = evolve_get_option( 'evl_testimonials_section_back_color', '' );
    $evolve_testimonials_section_image_src              = evolve_get_option('evl_testimonials_section_background_image');
    $evolve_testimonials_section_image                  = evolve_get_option('evl_testimonials_section_image', 'cover');
    $evolve_testimonials_section_background_position    = evolve_get_option('evl_testimonials_section_image_background_position', 'center top');
    $evolve_testimonials_section_background_repeat      = evolve_get_option('evl_testimonials_section_image_background_repeat', 'no-repeat');
    $evolve_testimonials_section_padding_top            = $evl_options['evl_testimonials_section_padding']['padding-top'];
    $evolve_testimonials_section_padding_bottom         = $evl_options['evl_testimonials_section_padding']['padding-bottom'];
    $evolve_testimonials_section_padding_left           = $evl_options['evl_testimonials_section_padding']['padding-left'];
    $evolve_testimonials_section_padding_right          = $evl_options['evl_testimonials_section_padding']['padding-right'];

    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_testimonials_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_testimonials_section_back_color );
    }

    if( $evolve_testimonials_section_image_src ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_testimonials_section_image_src );
    }

    if( $evolve_testimonials_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_testimonials_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_testimonials_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_testimonials_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_testimonials_section_image );
    }

    if( $evolve_testimonials_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_testimonials_section_background_position );
    }

    if( $evolve_testimonials_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_testimonials_section_background_repeat );
    }

    if( $evolve_testimonials_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_testimonials_section_padding_top );
    }

    if( $evolve_testimonials_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_testimonials_section_padding_bottom );
    }

    if( $evolve_testimonials_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_testimonials_section_padding_left );
    }

    if( $evolve_testimonials_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_testimonials_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";

    $styles = "<style type='text/css'>
    .t4p-testimonials.t4p-testimonials-{$testimonials_counter} .author:after{border-top-color:{$backgroundcolor} !important;}
    .t4p-testimonials.t4p-testimonials-{$testimonials_counter}  blockquote { background-color:{$backgroundcolor}; color:{$textcolor}; }
    </style>
    ";

    $evolve_testimonials_section_title = evolve_get_option('evl_testimonials_title', 'Why people love our themes');
    if ($evolve_testimonials_section_title == false) {
        $evolve_testimonials_section_title = '';
    } else {
        $evolve_testimonials_section_title = '<h2 class="testimonials_section_title section_title">'.evolve_get_option('evl_testimonials_title', 'Why people love our themes').'</h2>';
    }

    $html .= "<div class='t4p-testimonials t4p-testimonials-$testimonials_counter'>$styles".$evolve_testimonials_section_title."<div class='reviews'>";

    for ($i = 1; $i <= 2; $i ++) {
        $enabled = $evl_options["evl_fp_testimonial{$i}"];
        if ($enabled == 1) {
            $name  = $evl_options["evl_fp_testimonial{$i}_name"];
            $avatar = 'image';
            $image = $evl_options["evl_fp_testimonial{$i}_avatar"]['url'];
            $company = '';
            $link = '';
            $target = '';
            $content = $evl_options["evl_fp_testimonial{$i}_content"];
            
            $sub_htmls = array();
            
            $inner_content = $testimonials_thumbnail = $pic = $alt = '';
            if( $name ) {

                if( $avatar == 'image' && 
                        $image 
                ) {

                        $attr['class'] = 'testimonial-image';
                        $attr['src'] = $image;
                        $attr['alt'] = $alt;

                        $image_id = evolve_get_attachment_id_from_url( $image );
                        if( $image_id ) {
                                $alt = get_post_field( 'post_excerpt', $image_id );
                        }

                        $pic = "<img class='testimonial-image' src='$image' alt='$alt' />";

                }

                if( $avatar == 'image' && 
                        ! $image 
                ) {
                        $avatar = 'none';
                }

                if( $avatar != 'none' ) {
                        $testimonials_thumbnail = "<span class='testimonials-shortcode-thumbnail'>$pic</span>";
                }

                $inner_content .= "<div class='author'>$testimonials_thumbnail<span class='company-name'><strong>$name</strong>";

                if( $company ) {

                        if( ! empty( $link ) && 
                                $link 
                        ) {

                                $inner_content .= ", <a href='$link' target='$target'><span>$company</span></a>";

                        } else {

                                $inner_content .= "<span>$company</span>";

                        }

                }

                $inner_content .= '</span></div>';
            }

            if( $avatar == 'none' ) {
               $review_class = 'no-avatar';
            } else {
                $review_class = $avatar;
            }

            $html .= "<div class='$review_class' ><blockquote><q>".do_shortcode( $content )."</q></blockquote>$inner_content</div>";
        }
    }

    $html .= "</div></div></div></div>";

    echo $html;

    $testimonials_counter++;
}

function evolve_get_attachment_id_from_url( $attachment_url = '' ) {
        global $wpdb;
        $attachment_id = false;

        if ( $attachment_url == '' ) {
                return;
        }

        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

                // If this is the URL of an auto-generated thumbnail, get the URL of the original image
                $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

                // Remove the upload path base directory from the attachment URL
                $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

                // Run a custom database query to get the attachment ID from the modified attachment URL
                $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
        }
        return $attachment_id;
}

/* Front Page Counter Circle */
function evolve_counter_circle() {
    global $evl_options;

    $evolve_counter_circle_section_padding_top          = $evl_options['evl_counter_circle_section_padding']['padding-top'];
    $evolve_counter_circle_section_padding_bottom       = $evl_options['evl_counter_circle_section_padding']['padding-bottom'];
    $evolve_counter_circle_section_padding_left         = $evl_options['evl_counter_circle_section_padding']['padding-left'];
    $evolve_counter_circle_section_padding_right        = $evl_options['evl_counter_circle_section_padding']['padding-right'];
    $evolve_counter_circle_section_back_color           = evolve_get_option( 'evl_counter_circle_section_back_color', '' );
    $evolve_counter_circle_section_image_src            = evolve_get_option('evl_counter_circle_section_background_image');
    $evolve_counter_circle_section_image                = evolve_get_option('evl_counter_circle_section_image', 'cover');
    $evolve_counter_circle_section_background_repeat    = evolve_get_option('evl_counter_circle_section_image_background_repeat', 'no-repeat');
    $evolve_counter_circle_section_background_position  = evolve_get_option('evl_counter_circle_section_image_background_position', 'center top');
    
    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_counter_circle_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_counter_circle_section_back_color );
    }

    if ( isset($evolve_counter_circle_section_image_src['url']) && $evolve_counter_circle_section_image_src['url'] ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_counter_circle_section_image_src['url'] );
    }

    if( $evolve_counter_circle_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_counter_circle_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_counter_circle_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_counter_circle_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_counter_circle_section_image );
    }

    if( $evolve_counter_circle_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_counter_circle_section_background_position );
    }

    if( $evolve_counter_circle_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_counter_circle_section_background_repeat );
    }

    if( $evolve_counter_circle_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_counter_circle_section_padding_top );
    }

    if( $evolve_counter_circle_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_counter_circle_section_padding_bottom );
    }

    if( $evolve_counter_circle_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_counter_circle_section_padding_left );
    }

    if( $evolve_counter_circle_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_counter_circle_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";

    $evolve_counter_circle_section_title = evolve_get_option('evl_counter_circle_title', 'Cooperation with many great brands is our mission');
    if ($evolve_counter_circle_section_title == false) {
        $evolve_counter_circle_section_title = '';
    } else {
        $evolve_counter_circle_section_title = '<h2 class="counter_circle_section_title section_title">'.evolve_get_option('evl_counter_circle_title', 'Cooperation with many great brands is our mission').'</h2>';
    }

    $html   .=   "<div class='t4p-counters-circle counters-circle'>".$evolve_counter_circle_section_title;

    for ($i = 1; $i <= 3; $i ++) {
        $enabled = $evl_options["evl_fp_counter_circle{$i}"];
        if ($enabled == 1) {
                        $description = '';
                        $title = $evl_options["evl_fp_counter_circle{$i}_text"];
                        $value = $evl_options["evl_fp_counter_circle{$i}_percentage"];
                        $filledcolor = $evl_options["evl_fp_counter_circle{$i}_filledcolor"];
                        $unfilledcolor = $evl_options["evl_fp_counter_circle{$i}_unfilledcolor"];
                        $size = '220';
                        $font_size = '30';
                        $icon = "<i class='fa {$evl_options["evl_fp_counter_circle{$i}_icon"]}'></i>";
                        $scales = 'no';
                        $countdown = 'no';
                        $speed = '1500';
                        $multiplicator = $size / 220;
                        $stroke_size = 11 * $multiplicator;
                        //$font_size = 50 * $multiplicator;
                        $content_line_height = $size+($size*25/100);

                        $circle_title = "<span class='t4p-counters-circle-text' style='line-height: {$size}px; font-size: {$font_size}px;'>{$icon}".$title."</span>";
                        $description = "<span class='t4p-counters-circle-info' style='line-height: {$content_line_height}px;'>{$description}</span>";
                        $data_percent = $value;
                        $data_countdown = ( $countdown == 'no' ) ? '' : 1 ;
                        $data_filledcolor = $filledcolor;
                        $data_unfilledcolor = $unfilledcolor;
                        $data_scale = ( $scales == 'no' ) ? '' : 1 ;
                        $data_size = $size;
                        $data_speed = $speed;
                        $data_strokesize = $stroke_size;

                        $child_wrapper_style = sprintf( 'height:%spx;width:%spx;line-height:%spx;', $size, $size, $size );

                        $output = "<div data-percent='{$data_percent}' data-countdown='{$data_countdown}' data-filledcolor='{$data_filledcolor}' data-unfilledcolor='{$data_unfilledcolor}' data-scale='{$data_scale}' data-size='{$data_size}' data-speed='{$data_speed}' data-strokesize='{$data_strokesize}' class='t4p-counter-circle counter-circle counter-circle-content' style='{$child_wrapper_style}'>{$circle_title}{$description}</div>";

                        $html .= "<div class='counter-circle-wrapper' style='{$child_wrapper_style}'>{$output}</div>";

        }
    }

    $html .= "</div></div></div>";

    echo $html;
}

/* Front Page Google Map */
function evolve_google_map() {
    global $evl_options;

    $address  = $evl_options["evl_fp_googlemap_address"];
    $gmap_alignment = 'center';
    $map_style  = 'default';
    $type = $evl_options["evl_fp_googlemap_type"];
    $width = $evl_options["evl_fp_googlemap_width"];
    $height = $evl_options["evl_fp_googlemap_height"];
    $zoom = $evl_options["evl_fp_googlemap_zoom_level"];
    $scrollwheel = $evl_options["evl_fp_googlemap_scrollwheel"];
    $scale = $evl_options["evl_fp_googlemap_scale"];
    $zoom_pancontrol = $evl_options["evl_fp_googlemap_zoomcontrol"];
    $popup = 'yes';

    $evolve_googlemap_section_padding_top          = $evl_options['evl_googlemap_section_padding']['padding-top'];
    $evolve_googlemap_section_padding_bottom       = $evl_options['evl_googlemap_section_padding']['padding-bottom'];
    $evolve_googlemap_section_padding_left         = $evl_options['evl_googlemap_section_padding']['padding-left'];
    $evolve_googlemap_section_padding_right        = $evl_options['evl_googlemap_section_padding']['padding-right'];
    $evolve_googlemap_section_back_color           = evolve_get_option( 'evl_googlemap_section_back_color', '' );
    $evolve_googlemap_section_image_src            = evolve_get_option('evl_googlemap_section_background_image');
    $evolve_googlemap_section_image                = evolve_get_option('evl_googlemap_section_image', 'cover');
    $evolve_googlemap_section_background_repeat    = evolve_get_option('evl_googlemap_section_image_background_repeat', 'no-repeat');
    $evolve_googlemap_section_background_position  = evolve_get_option('evl_googlemap_section_image_background_position', 'center top');

    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_googlemap_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_googlemap_section_back_color );
    }

    if ( isset($evolve_googlemap_section_image_src['url']) && $evolve_googlemap_section_image_src['url'] ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_googlemap_section_image_src['url'] );
    }

    if( $evolve_googlemap_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_googlemap_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_googlemap_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_googlemap_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_googlemap_section_image );
    }

    if( $evolve_googlemap_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_googlemap_section_background_position );
    }

    if( $evolve_googlemap_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_googlemap_section_background_repeat );
    }

    if( $evolve_googlemap_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_googlemap_section_padding_top );
    }

    if( $evolve_googlemap_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_googlemap_section_padding_bottom );
    }

    if( $evolve_googlemap_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_googlemap_section_padding_left );
    }

    if( $evolve_googlemap_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_googlemap_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";
    
    $evolve_googlemap_section_title = evolve_get_option('evl_googlemap_title', 'Our Contact Place');
    if ($evolve_googlemap_section_title == false) {
        $evolve_googlemap_section_title = '';
    } else {
        $evolve_googlemap_section_title = '<h2 class="googlemap_section_title section_title">'.evolve_get_option('evl_googlemap_title', 'Our Contact Place').'</h2>';
    }

    $html   .=   "<div class='t4p-googlemap'>".$evolve_googlemap_section_title;

    if ( $gmap_alignment === 'right' ) {
            $alignment = 'float: right';
    } else if ( $gmap_alignment === 'center' ) {
            $alignment = 'margin: 0 auto; display: block;';
    } else if ( $gmap_alignment === 'left' ) {
            $alignment = 'float: left';
    }

    if( $address ) {
            $addresses = explode( '|', $address );

            if( $addresses ) {
                    $address = $addresses;
            }

            $num_of_addresses = count( $addresses );

            $infobox_content = $address;

            wp_print_scripts( 'google-maps-api' );
            wp_print_scripts( 'google-maps-infobox' );

            foreach( $address as $add ) {
                    $coordinates[] = get_coordinates( $add );
            }

            if( ! is_array( $coordinates ) ) {
                    return;
            }

            $map_id = uniqid( 't4p_map_' ); // generate a unique ID for this map

            ob_start(); ?>
            <script type="text/javascript">
                    var map_<?php echo $map_id; ?>;
                    var markers = [];
                    var counter = 0;
                    function t4p_run_map_<?php echo $map_id ; ?>() {
                            var location = new google.maps.LatLng(<?php echo $coordinates[0]['lat']; ?>, <?php echo $coordinates[0]['lng']; ?>);
                            var map_options = {
                                    zoom: <?php echo $zoom; ?>,
                                    center: location,
                                    mapTypeId: google.maps.MapTypeId.<?php echo strtoupper($type); ?>,
                                    scrollwheel: <?php echo ($scrollwheel == 'yes') ? 'true' : 'false'; ?>,
                                    scaleControl: <?php echo ($scale == 'yes') ? 'true' : 'false'; ?>,
                                    panControl: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>,
                                    zoomControl: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>						
                            };
                            map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo esc_attr( $map_id ); ?>"), map_options);
                            <?php $i = 0; ?>
                            <?php foreach( $coordinates as $key => $coordinate ): ?>

                                    var content_string = "<div class='info-window'><?php echo $infobox_content[$key]; ?></div>";

                                    map_<?php echo $map_id ; ?>_args = {
                                            position: new google.maps.LatLng("<?php echo $coordinate['lat']; ?>", "<?php echo $coordinate['lng']; ?>"),
                                            map: map_<?php echo $map_id ; ?>
                                    };

                                    <?php $i++; ?>

                                    markers[counter] = new google.maps.Marker(map_<?php echo $map_id ; ?>_args);

                                    markers[counter]['infowindow'] = new google.maps.InfoWindow({
                                            content: content_string
                                    });					

                                    <?php if( $popup == 'yes' ) { ?>
                                            markers[counter]['infowindow'].show = true;
                                            markers[counter]['infowindow'].open(map_<?php echo $map_id ; ?>, markers[counter]);
                                    <?php } ?>						

                                    google.maps.event.addListener(markers[counter], 'click', function() {
                                            if(this['infowindow'].show) {
                                                    this['infowindow'].close(map_<?php echo $map_id ; ?>, this);
                                                    this['infowindow'].show = false;
                                            } else {
                                                    this['infowindow'].open(map_<?php echo $map_id ; ?>, this);
                                                    this['infowindow'].show = true;
                                            }
                                    });

                                    counter++;
                            <?php endforeach; ?>

                    }

                    google.maps.event.addDomListener(window, 'load', t4p_run_map_<?php echo $map_id ; ?>);

            </script>
            <style scoped >
                .t4p-google-map {
                    <?php echo sprintf('height:%s;width:%s;%s',  $height, $width, $alignment ); ?>
                }
            </style>
            <?php
            //html_attr
            $class = 'shortcode-map t4p-google-map';
            $id = $map_id;

            $html .= ob_get_clean() . "<div class='$class' id='$id' ></div>";
    }

    $html .= "</div></div></div>";

    echo $html;
}

function get_coordinates( $address, $force_refresh = false ) {

    $address_hash = md5( $address );

    $coordinates = get_transient( $address_hash );

    if ( $force_refresh || $coordinates === false ) {

        $args       = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
        $url        = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
        $response   = wp_remote_get( $url );

        if( is_wp_error( $response ) )
                return;

        $data = wp_remote_retrieve_body( $response );

        if( is_wp_error( $data ) )
                return;

                if ( $response['response']['code'] == 200 ) {

                        $data = json_decode( $data );

                        if ( $data->status === 'OK' ) {

                                $coordinates = $data->results[0]->geometry->location;

                                $cache_value['lat'] 	= $coordinates->lat;
                                $cache_value['lng'] 	= $coordinates->lng;
                                $cache_value['address'] = (string) $data->results[0]->formatted_address;

                                // cache coordinates for 3 months
                                set_transient($address_hash, $cache_value, 3600*24*30*3);
                                $data = $cache_value;

                        } elseif ( $data->status === 'ZERO_RESULTS' ) {
                                return __( 'No location found for the entered address.', 'evolve' );
                        } elseif( $data->status === 'INVALID_REQUEST' ) {
                                return __( 'Invalid request. Did you enter an address?', 'evolve' );
                        } else {
                                return __( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'evolve' );
                        }

                } else {
                        return __( 'Unable to contact Google API service.', 'evolve' );
                }

    } else {
       // return cached results
       $data = $coordinates;
    }

    return $data;

}

/* Front Page Custom Content */
function evolve_custom_content() {
    global $evl_options;

    $content = $evl_options["evl_fp_custom_content_editor"];

    $evolve_custom_content_section_padding_top          = $evl_options['evl_custom_content_section_padding']['padding-top'];
    $evolve_custom_content_section_padding_bottom       = $evl_options['evl_custom_content_section_padding']['padding-bottom'];
    $evolve_custom_content_section_padding_left         = $evl_options['evl_custom_content_section_padding']['padding-left'];
    $evolve_custom_content_section_padding_right        = $evl_options['evl_custom_content_section_padding']['padding-right'];
    $evolve_custom_content_section_back_color           = evolve_get_option( 'evl_custom_content_section_back_color', '' );
    $evolve_custom_content_section_image_src            = evolve_get_option('evl_custom_content_section_background_image');
    $evolve_custom_content_section_image                = evolve_get_option('evl_custom_content_section_image', 'cover');
    $evolve_custom_content_section_background_repeat    = evolve_get_option('evl_custom_content_section_image_background_repeat', 'no-repeat');
    $evolve_custom_content_section_background_position  = evolve_get_option('evl_custom_content_section_image_background_position', 'center top');

    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_custom_content_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_custom_content_section_back_color );
    }

    if ( isset($evolve_custom_content_section_image_src['url']) && $evolve_custom_content_section_image_src['url'] ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_custom_content_section_image_src['url'] );
    }

    if( $evolve_custom_content_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_custom_content_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_custom_content_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_custom_content_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_custom_content_section_image );
    }

    if( $evolve_custom_content_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_custom_content_section_background_position );
    }

    if( $evolve_custom_content_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_custom_content_section_background_repeat );
    }

    if( $evolve_custom_content_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_custom_content_section_padding_top );
    }

    if( $evolve_custom_content_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_custom_content_section_padding_bottom );
    }

    if( $evolve_custom_content_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_custom_content_section_padding_left );
    }

    if( $evolve_custom_content_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_custom_content_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";
    
    $evolve_custom_content_section_title = evolve_get_option('evl_custom_content_title', 'Your Custom Content Here');
    if ($evolve_custom_content_section_title == false) {
        $evolve_custom_content_section_title = '';
    } else {
        $evolve_custom_content_section_title = '<h2 class="custom_content_section_title section_title">'.evolve_get_option('evl_custom_content_title', 'Your Custom Content Here').'</h2>';
    }

    $html  .= "<div class='t4p-text' >".$evolve_custom_content_section_title;

    $html .= $content;

    $html .= "</div></div></div>";

    echo $html;
}

/* Front Page WooCommerce Product */
function evolve_woocommerce_products() {
    global $evl_options;

    $product_cat = $evl_options["evl_fp_woo_product"];
    $product_number = $evl_options["evl_fp_woo_product_number"];

    $evolve_woo_product_section_padding_top          = $evl_options['evl_woo_product_section_padding']['padding-top'];
    $evolve_woo_product_section_padding_bottom       = $evl_options['evl_woo_product_section_padding']['padding-bottom'];
    $evolve_woo_product_section_padding_left         = $evl_options['evl_woo_product_section_padding']['padding-left'];
    $evolve_woo_product_section_padding_right        = $evl_options['evl_woo_product_section_padding']['padding-right'];
    $evolve_woo_product_section_back_color           = evolve_get_option( 'evl_woo_product_section_back_color', '' );
    $evolve_woo_product_section_image_src            = evolve_get_option('evl_woo_product_section_background_image');
    $evolve_woo_product_section_image                = evolve_get_option('evl_woo_product_section_image', 'cover');
    $evolve_woo_product_section_background_repeat    = evolve_get_option('evl_woo_product_section_image_background_repeat', 'no-repeat');
    $evolve_woo_product_section_background_position  = evolve_get_option('evl_woo_product_section_image_background_position', 'center top');

    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_woo_product_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_woo_product_section_back_color );
    }

    if ( isset($evolve_woo_product_section_image_src['url']) && $evolve_woo_product_section_image_src['url'] ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_woo_product_section_image_src['url'] );
    }

    if( $evolve_woo_product_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_woo_product_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_woo_product_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_woo_product_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_woo_product_section_image );
    }

    if( $evolve_woo_product_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_woo_product_section_background_position );
    }

    if( $evolve_woo_product_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_woo_product_section_background_repeat );
    }

    if( $evolve_woo_product_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_woo_product_section_padding_top );
    }

    if( $evolve_woo_product_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_woo_product_section_padding_bottom );
    }

    if( $evolve_woo_product_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_woo_product_section_padding_left );
    }

    if( $evolve_woo_product_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_woo_product_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";
    
    $evolve_woo_product_section_title = evolve_get_option('evl_woo_product_title', 'New Arrival Product');
    if ($evolve_woo_product_section_title == false) {
        $evolve_woo_product_section_title = '';
    } else {
        $evolve_woo_product_section_title = '<h2 class="woo_product_section_title section_title">'.evolve_get_option('evl_woo_product_title', 'New Arrival Product').'</h2>';
    }

    $html  .= "<div class='t4p-woo-product' >".$evolve_woo_product_section_title;

    if ($product_cat) {
        $html .= do_shortcode( '[product_category category="'.$product_cat.'"  per_page="'. $product_number .'" orderby="title" order="asc"]' );
    } else {
        $html .= do_shortcode( '[products limit="'. $product_number .'" columns="4" category="" cat_operator="AND"]' );
    }

    $html .= "</div></div></div>";

    echo $html;
}

/* Front Page Blog Content */
function evolve_blog_posts() {
    global $evl_options;

    $layout = $evl_options["evl_fp_blog_layout"];
    $number_posts = ( ! $evl_options["evl_fp_blog_number_posts"] ) ? '-1' : $evl_options["evl_fp_blog_number_posts"];
    $cat_slug = ( !isset($evl_options["evl_fp_blog_cat_slug"]) ) ? '' : $evl_options["evl_fp_blog_cat_slug"];
    $exclude_cats = ( !isset($evl_options["evl_fp_blog_exclude_cats"]) ) ? '' : $evl_options["evl_fp_blog_exclude_cats"];
    $show_title = $evl_options["evl_fp_blog_show_title"];
    $title_link = $evl_options["evl_fp_blog_title_link"];
    $thumbnail = $evl_options["evl_fp_blog_thumbnail"];
    $excerpt = $evl_options["evl_fp_blog_excerpt"];
    $excerpt_length = $evl_options["evl_fp_blog_excerpt_length"];
    $meta_all = $evl_options["evl_fp_blog_meta_all"];
    $meta_author = $evl_options["evl_fp_blog_meta_author"];
    $meta_categories = $evl_options["evl_fp_blog_meta_categories"];
    $meta_comments = $evl_options["evl_fp_blog_meta_comments"];
    $meta_date = $evl_options["evl_fp_blog_meta_date"];
    $meta_link = $evl_options["evl_fp_blog_meta_link"];
    $meta_tags = $evl_options["evl_fp_blog_meta_tags"];
    $paging = $evl_options["evl_fp_blog_paging"];
    $scrolling = $evl_options["evl_fp_blog_scrolling"];
    $blog_grid_columns = $evl_options["evl_fp_blog_blog_grid_columns"];
    $strip_html = $evl_options["evl_fp_blog_strip_html"];
    
    $evolve_blog_section_padding_top          = $evl_options['evl_blog_section_padding']['padding-top'];
    $evolve_blog_section_padding_bottom       = $evl_options['evl_blog_section_padding']['padding-bottom'];
    $evolve_blog_section_padding_left         = $evl_options['evl_blog_section_padding']['padding-left'];
    $evolve_blog_section_padding_right        = $evl_options['evl_blog_section_padding']['padding-right'];
    $evolve_blog_section_back_color           = evolve_get_option( 'evl_blog_section_back_color', '' );
    $evolve_blog_section_image_src            = evolve_get_option('evl_blog_section_background_image');
    $evolve_blog_section_image                = evolve_get_option('evl_blog_section_image', 'cover');
    $evolve_blog_section_background_repeat    = evolve_get_option('evl_blog_section_image_background_repeat', 'no-repeat');
    $evolve_blog_section_background_position  = evolve_get_option('evl_blog_section_image_background_position', 'center top');

    //html_attr
    $html_class = 't4p-fullwidth fullwidth-box hentry';
    $html_style = '';

    if( $evolve_blog_section_back_color ) {
            $html_style .= sprintf( 'background-color:%s;', $evolve_blog_section_back_color );
    }

    if ( isset($evolve_blog_section_image_src['url']) && $evolve_blog_section_image_src['url'] ) {
            $html_style .= sprintf( 'background-image: url(%s);', $evolve_blog_section_image_src['url'] );
    }

    if( $evolve_blog_section_image ) {
            $html_style .= sprintf( 'background-size:%s;', $evolve_blog_section_image );
            $html_style .= sprintf( '-webkit-background-size:%s;', $evolve_blog_section_image );
            $html_style .= sprintf( '-moz-background-size:%s;', $evolve_blog_section_image );
            $html_style .= sprintf( '-o-background-size:%s;', $evolve_blog_section_image );
    }

    if( $evolve_blog_section_background_position ) {
            $html_style .= sprintf( 'background-position:%s;', $evolve_blog_section_background_position );
    }

    if( $evolve_blog_section_background_repeat ) {
            $html_style .= sprintf( 'background-repeat:%s;', $evolve_blog_section_background_repeat );
    }

    if( $evolve_blog_section_padding_top ) {
            $html_style .= sprintf( 'padding-top:%s;', $evolve_blog_section_padding_top );
    }

    if( $evolve_blog_section_padding_bottom ) {
            $html_style .= sprintf( 'padding-bottom:%s;', $evolve_blog_section_padding_bottom );
    }

    if( $evolve_blog_section_padding_left ) {
            $html_style .= sprintf( 'padding-left:%s;', $evolve_blog_section_padding_left );
    }

    if( $evolve_blog_section_padding_right ) {
            $html_style .= sprintf( 'padding-right:%s;', $evolve_blog_section_padding_right );
    }

    $html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>";
    
    $evolve_fp_blog_section_title = evolve_get_option('evl_blog_section_title', 'Read New Story Here');
    if ($evolve_fp_blog_section_title == false) {
        $evolve_fp_blog_section_title = '';
    } else {
        $evolve_fp_blog_section_title = '<h2 class="fp_blog_section_title section_title">'.evolve_get_option('evl_blog_section_title', 'Read New Story Here').'</h2>';
    }

    $html  .= "<div class='t4p-fp-blog' >".$evolve_fp_blog_section_title;

            if ( is_front_page() || is_home() ) {
                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : ( ( get_query_var('page') ) ? get_query_var('page') : 1 );
            }

            // convert all attributes to correct values for WP query		
            if ($number_posts) {
                $posts_per_page = $number_posts;
            }

            $nopaging = '';
            if ($posts_per_page == -1) {
                $nopaging = true;
            }

            ( $excerpt == "yes" ) ? ( $excerpt = true ) : ( $excerpt = false );
            ( $meta_all == "yes" ) ? ( $meta_all = true ) : ( $meta_all = false );
            ( $meta_author == "yes" ) ? ( $meta_author = true ) : ( $meta_author = false );
            ( $meta_categories == "yes" ) ? ( $meta_categories = true ) : ( $meta_categories = false );
            ( $meta_comments == "yes" ) ? ( $meta_comments = true) : ( $meta_comments = false );
            ( $meta_date == "yes" ) ? ( $meta_date = true ) : ( $meta_date = false );
            ( $meta_link == "yes" ) ? ( $meta_link = true ) : ( $meta_link = false );
            ( $meta_tags == "yes" ) ? ( $meta_tags = true ) : ( $meta_tags = false );
            ( $paging == "yes" ) ? ( $paging = true ) : ( $paging = false );
            ( $scrolling == "infinite" ) ? ( $paging = true ) : ( $paging = $paging );
            ( $strip_html == "yes" ) ? ( $strip_html = true ) : ( $strip_html = false );
            ( $thumbnail == "yes" ) ? ( $thumbnail = true ) : ( $thumbnail = false );
            ( $show_title == "yes" ) ? ( $show_title = true ) : ( $show_title = false );
            ( $title_link == "yes" ) ? ( $title_link = true ) : ( $title_link = false );

            //check for cats to exclude; needs to be checked via exclude_cats param and '-' prefixed cats on cats param
            //exclution via exclude_cats param 
            $cats_to_exclude = $exclude_cats;
            $cats_id_to_exclude = $category__not_in = array();
            if ($cats_to_exclude) {
                foreach ($cats_to_exclude as $cat_to_exclude) {
                    $id_obj = get_category_by_slug($cat_to_exclude);
                    if ($id_obj) {
                        $cats_id_to_exclude[] = $id_obj->term_id;
                    }
                }
                if ($cats_id_to_exclude) {
                    $category__not_in = $cats_id_to_exclude;
                }
            }

            //setting up cats to be used and exclution using '-' prefix on cats param; transform slugs to ids
            $cat_ids = '';
            $categories = $cat_slug;
            if ( isset($categories) && $categories ) {
                foreach ($categories as $category) {

                    $id_obj = get_category_by_slug($category);

                    if ($id_obj) {
                        if (strpos($category, '-') === 0) {
                            $cat_ids .= '-' . $id_obj->cat_ID . ',';
                        } else {
                            $cat_ids .= $id_obj->cat_ID . ',';
                        }
                    }
                }
            }
            $cat = substr($cat_ids, 0, -1);

            $args = array(
                    'paged' => $paged,
                    'nopaging' => $nopaging,
                    'posts_per_page' => $posts_per_page,
                    'category__not_in' => $category__not_in,
                    'cat' => $cat,
                    'excerpt' => $excerpt,
                    'meta_all' => $meta_all,
                    'meta_author' => $meta_author,
                    'meta_categories' => $meta_categories,
                    'meta_comments' => $meta_comments,
                    'meta_date' => $meta_date,
                    'meta_link' => $meta_link,
                    'meta_tags' => $meta_tags,
                    'paging' => $paging,
                    'scrolling' => $scrolling,
                    'strip_html' => $strip_html,
                    'thumbnail' => $thumbnail,
                    'show_title' => $show_title,
                    'title_link' => $title_link
            );

            $t4p_query = new WP_Query($args);

            $query = $t4p_query;

            //blog-shortcode-attr
            $blog_layout = $layout;
            $attr_class = sprintf('t4p-blog-shortcode t4p-blog-%s t4p-blog-%s', $blog_layout, $scrolling);
            $html .= "<div class='$attr_class'>";

            //blog-shortcode-posts-container
            $post_container_class = sprintf('t4p-posts-container posts-container-%s', $scrolling);
            if ($layout == 'grid') {
                $post_container_class .= sprintf(' grid-layout grid-layout-%s', $blog_grid_columns);
            }
            $html .= "<div class='$post_container_class'>";

            ob_start();
            wrap_loop_open();
            $wrap_loop_open = ob_get_contents();
            ob_get_clean();

            $html .= $wrap_loop_open;

            //do the loop
            if ($t4p_query->have_posts()) : while ($t4p_query->have_posts()) : $t4p_query->the_post();

                    $post_id = get_the_ID();

                    ob_start();
                        before_loop($post_id);
                        $before_loop_action = ob_get_contents();
                    ob_get_clean();

                    $html .= $before_loop_action;

                    $html .= "<div class='post-content-wrapper'>";

                    $header = array(
                        'title_link' => true,
                    );

                    ob_start();
                        loop_header($header);

                        loop_content();
                        page_links();

                        loop_footer();

                        after_loop();
                        $loop_actions = ob_get_contents();
                    ob_get_clean();

                    $html .= $loop_actions;

                    $html .= '</div>';

                endwhile;
            else:
            endif;

                    wp_reset_query();

            ob_start();
            wrap_loop_close();

            $wrap_loop_close_action = ob_get_contents();
            ob_get_clean();

            $html .= $wrap_loop_close_action;

            $html .= '</div>';

            if ($paging == 'yes') {
                ob_start();
                t4p_pagination($query->max_num_pages, $range = 2, $query);
                $pagination = ob_get_contents();
                ob_get_clean();

                $html .= $pagination;
            }

            $html .= '</div>';

    $html .= "</div></div></div>";

    echo $html;
}

function wrap_loop_open() {
    $wrapper = '';

    echo $wrapper;
}

function wrap_loop_close() {
    global $evl_options;

    $wrapper = '';

    if ( $evl_options['evl_fp_blog_layout'] == 'grid' ) {
        $wrapper .= '<div class="t4p-clearfix"></div>';
    }

    echo $wrapper;
}

function before_loop($post_id) {
    global $evl_options;
    $post_count = 1;

    //loop_attr
    $defaults = array(
        'post_id' => '',
        'post_count' => '',
    );

    $args['post_id'] = $post_id;
    $args['post_count'] = $post_count;

    $args = wp_parse_args($args, $defaults);

    $post_id = $args['post_id'];

    $post_count = $args['post_count'];

    $loop_attr_id = 'post-' . $post_id;

    $extra_classes = array();

    if ($evl_options['evl_fp_blog_layout'] == 'large') {
        $extra_classes[] = 'blog-large';
    }

    if ($evl_options['evl_fp_blog_layout'] == 'grid') {

        $column_width = 12 / $evl_options['evl_fp_blog_blog_grid_columns'];

        $extra_classes[] = 'blog-grid';
        $extra_classes[] = sprintf('col-lg-%s col-md-%s col-sm-%s', $column_width, $column_width, $column_width);
    }

    $post_class = get_post_class($extra_classes, $post_id);

    if ($post_class && is_array($post_class)) {

        $classes = implode(' ', get_post_class($extra_classes, $post_id));
        $loop_attr_class = $classes;
    }

    $loop_attr_itemtype = '';
    $loop_attr_itemprop = '';
    if (current_theme_supports('t4p-schema')) {
        $loop_attr_itemtype = 'http://schema.org/BlogPosting';
        $loop_attr_itemprop = 'blogPost';
    }

    $formatted_class = '';
    if (has_post_format(array(
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video'
                ), '')) {
    $formatted_class = ' formatted-post';
    }

    echo "<div id='$loop_attr_id' class='$loop_attr_class $formatted_class' itemtype='$loop_attr_itemtype' itemprop='$loop_attr_itemprop'> \n";
}

function before_loop_timeline($args) {
    global $evl_options;
    $post_count = 1;

    //loop_attr
    $defaults = array(
        'post_id' => '',
        'post_count' => '',
    );

    $args['post_id'] = $post_id;
    $args['post_count'] = $post_count;

    $args = wp_parse_args($args, $defaults);

    $post_id = $args['post_id'];

    $post_count = $args['post_count'];

    $loop_attr_id = 'post-' . $post_id;

    $extra_classes = array();

    if ($evl_options['evl_fp_blog_layout'] == 'large') {
        $extra_classes[] = 'blog-large';
    }

    if ($evl_options['evl_fp_blog_layout'] == 'grid') {

        $column_width = 12 / $evl_options['evl_fp_blog_blog_grid_columns'];

        $extra_classes[] = 'blog-grid';
        $extra_classes[] = sprintf('col-lg-%s col-md-%s col-sm-%s', $column_width, $column_width, $column_width);
    }

    $post_class = get_post_class($extra_classes, $post_id);

    if ($post_class && is_array($post_class)) {

        $classes = implode(' ', get_post_class($extra_classes, $post_id));
        $loop_attr_class = $classes;
    }

    $loop_attr_itemtype = '';
    $loop_attr_itemprop = '';
    if (current_theme_supports('t4p-schema')) {
        $loop_attr_itemtype = 'http://schema.org/BlogPosting';
        $loop_attr_itemprop = 'blogPost';
    }

    echo "<div id='$loop_attr_id' class='$loop_attr_class' itemtype='$loop_attr_itemtype' itemprop='$loop_attr_itemprop'> \n";

}

function after_loop() {
    echo '</div>' . "\n";
}

function get_slideshow() {
    global $smof_data, $theme_prefix;
    $post_id = get_the_ID();

    $html = '';

    $slideshow = array(
        'images' => get_post_thumbnails(get_the_ID(), $smof_data['posts_slideshow_number'])
    );

    if (get_post_meta($post_id, $theme_prefix.'video', true)) {
        $slideshow['video'] = get_post_meta($post_id, $theme_prefix.'video', true);
    }

        ob_start();
        if ($smof_data['legacy_posts_slideshow']) {
            include(locate_template('legacy-slideshow-blog-shortcode.php', false));
        } else {
            include(locate_template('new-slideshow-blog-shortcode.php', false));
        }
        $post_slideshow_action = ob_get_contents();
        ob_get_clean();

        $html .= $post_slideshow_action;

    return $html;
}

function get_post_thumbnails($post_id, $count = '') {
    global $smof_data;

    $attachment_ids = array();

    if (get_post_thumbnail_id($post_id)) {
        $attachment_ids[] = get_post_thumbnail_id($post_id);
    }

    if ($smof_data['posts_slideshow']) {
        $i = 2;
        while ($i <= $smof_data['posts_slideshow_number']) {

            if (kd_mfi_get_featured_image_id('featured-image-' . $i, 'post')) {
                $attachment_ids[] = kd_mfi_get_featured_image_id('featured-image-' . $i, 'post');
            }

            $i++;
        }
    }

    if (isset($count) && $count >= 1) {
        $attachment_ids = array_slice($attachment_ids, 0, $count);
    }

    return $attachment_ids;
}

function loop_header($header) {
    global $evl_options;
    $defaults = array(
        'title_link' => false,
    );

    $args = wp_parse_args($header, $defaults);

    $pre_title_content = '';
    $meta_data = '';
    $content_sep = '';
    $link = '';

    if ($evl_options['evl_fp_blog_thumbnail'] == 'yes') {
        $pre_title_content = get_slideshow();
    }
    
    if ($evl_options['evl_fp_blog_layout'] == 'large') {
        ob_start();
        entry_meta_alternate();
        $meta_data = ob_get_contents();
        ob_get_clean();
    }

    if ($evl_options['evl_fp_blog_layout'] == 'grid') {
        if ((!$evl_options['evl_fp_blog_meta_all'] == 'yes' && $evl_options['evl_fp_blog_excerpt_length'] == '0' ) ||
                (!$evl_options['evl_fp_blog_meta_author'] == 'yes' && !$evl_options['evl_fp_blog_meta_date'] == 'yes' && !$evl_options['evl_fp_blog_meta_categories'] == 'yes' && !$evl_options['evl_fp_blog_meta_tags'] == 'yes' && !$evl_options['evl_fp_blog_meta_comments'] == 'yes' && !$evl_options['evl_fp_blog_meta_link'] == 'yes' && $evl_options['evl_fp_blog_excerpt_length'] == '0' )
        ) {
            $content_sep = "<div class='no-content-sep'></div>";
        } else {
            $content_sep = "<div class='content-sep'></div>";
        }

        if ($evl_options['evl_fp_blog_meta_all'] == 'yes') {
            ob_start();
            entry_meta_grid_timeline();
            $meta_data = ob_get_contents();
            ob_get_clean();
        }
    }

    $pre_title_content .= "<div class='post-content-container'>";

    if ($evl_options['evl_fp_blog_show_title'] == 'yes') {
        if ($evl_options['evl_fp_blog_title_link'] == 'yes') {
            $link = sprintf('<a href="%s">%s</a>', get_permalink(), get_the_title());
        } else {
            $link = get_the_title();
        }
    }

    $itemprop = '';
    if (current_theme_supports('t4p-schema')) {
        $itemprop = 'headline';
    }
    $html = "{$pre_title_content}<h2 class='entry-title' itemprop='$itemprop'>{$link}</h2>{$meta_data}{$content_sep}";

    echo $html;
}

function loop_footer() {
    global $evl_options;
    
    if ($evl_options['evl_fp_blog_meta_all'] == 'yes' && $evl_options['evl_fp_blog_layout'] == 'large') {
       entry_meta_default();
    }

    if ($evl_options['evl_fp_blog_meta_all'] == 'yes' && $evl_options['evl_fp_blog_layout'] == 'grid') {
        echo read_more();
        echo grid_timeline_comments();
        echo '<div class="t4p-clearfix"></div>';
    }

    echo '</div>';
    echo '<div class="t4p-clearfix"></div>';
}

function date_and_format() {
    global $smof_data;

    $inner_content = "<div class='date-and-formats'>";
    $inner_content .= "<div class='date-box updated'>";

    $inner_content .= sprintf('<span class="date">%s</span>', get_the_time($smof_data['alternate_date_format_day']));
    $inner_content .= sprintf('<span class="month-year">%s</span>', get_the_time($smof_data['alternate_date_format_month_year']));

    switch (get_post_format()) {
        case 'gallery':
            $format_class = 'camera-retro';
            break;
        case 'link':
            $format_class = 'link';
            break;
        case 'image':
            $format_class = 'picture-o';
            break;
        case 'quote':
            $format_class = 'quote-left';
            break;
        case 'video':
            $format_class = 'youtube-play';
            break;
        case 'audio':
            $format_class = 'headphones';
            break;
        case 'chat':
            $format_class = 'comments-o';
            break;
        default:
            $format_class = 'pencil';
            break;
    }

    $inner_content .= "</div><div class='format-box'><i class=t4p-icon-$format_class></i></div></div>";

    echo $inner_content;
}

function timeline_date($date_params) {
    global $smof_data;

    $defaults = array(
        'prev_post_month' => null,
        'post_month' => 'null'
    );

    $args = wp_parse_args($date_params, $defaults);
    $inner_content = '';

    if ($args['prev_post_month'] != $args['post_month']) {
        $inner_content = sprintf('<div class="timeline-date hidden-div"><h3 class="timeline-title" style="font-size:13px !important; padding: 0px 5px;">%s</h3></div>', get_the_date($smof_data['timeline_date_format']));
    }

    echo $inner_content;
}

function entry_meta_default() {
    global $evl_options;

    $inner_content = '';
    $inner_content .= read_more();

    if ($evl_options['evl_fp_blog_layout'] == 'large') {
        if ($evl_options['evl_fp_blog_meta_categories'] == 'yes') {

            $categories = get_the_category();
            $no_of_categories = count($categories);
            $separator = ', ';
            $output = ' ';
            $count = 1;

            foreach ($categories as $category) {

                $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'evolve'), $category->name)) . '">' . $category->cat_name . '</a>';

                if ($count < $no_of_categories) {
                    $output .= $separator;
                }

                $count++;
            }

            $inner_content .= sprintf('<span class="entry-categories">%s</span><span class="meta-separator">|</span>', $output);
        }
        if ($evl_options['evl_fp_blog_meta_tags'] == 'yes') {
            $inner_content .= sprintf('%s<span class="meta-separator">|</span>', post_meta_tags());
        }
    }

    //blog-shortcode-entry-meta    
    if ($evl_options['evl_fp_blog_layout'] == 'grid' ) {
        $blog_shortcode_entry_meta = 'entry-meta-single';
    } else {
        $blog_shortcode_entry_meta = 'entry-meta';
    }
    $entry_meta = "<div class='t4p-clearfix'></div><div class='$blog_shortcode_entry_meta'>{$inner_content}</div>";

    echo $entry_meta;
}

function entry_meta_alternate() {
    global $evl_options;
    $inner_content = post_meta_data(true);

    //blog-shortcode-entry-meta
    if ($evl_options['evl_fp_blog_layout'] == 'grid') {
        $blog_shortcode_entry_meta = 'entry-meta-single';
    } else {
        $blog_shortcode_entry_meta = 'entry-meta';
    }
    $entry_meta = "<div class='$blog_shortcode_entry_meta'>$inner_content</div>";

    echo $entry_meta;
}

function entry_meta_grid_timeline() {
    global $evl_options;
    $inner_content = post_meta_data(false);

    //blog-shortcode-entry-meta    
    if ($evl_options['evl_fp_blog_layout'] == 'grid') {
        $blog_shortcode_entry_meta = 'entry-meta-single';
    } else {
        $blog_shortcode_entry_meta = 'entry-meta';
    }
    $entry_meta = "<div class='$blog_shortcode_entry_meta'>$inner_content</div>";

    echo $entry_meta;
}

function post_meta_data($return_all_meta = false) {
    global $evl_options, $smof_data;

    $inner_content = "<p class='entry-meta-details'>";

        $meta_time = get_the_modified_time('c');

        //meta_date_attr
        $meta_date_class = 'published';
        $meta_date_datetime = '';
        if (current_theme_supports('t4p-schema')) {
            $meta_date_datetime = get_the_time('c');
        }

        $meta_date = get_the_time(get_option( 'date_format' ));

        //blog-shortcode-meta-author
        $meta_author_class = 'entry-author fn';
        $meta_author_itemprop = '';
        $meta_author_itemscope = '';
        $meta_author_itemtype = '';
        if (current_theme_supports('t4p-schema')) {
            $meta_author_itemprop = 'author';
            $meta_author_itemscope = 'itemscope';
            $meta_author_itemtype = 'http://schema.org/Person';
        }

        //meta_author_link_attr       
        $meta_author_link_href = get_author_posts_url(get_the_author_meta('ID'));
        $meta_author_link_itemprop = '';
        $meta_author_link_rel = '';
        if (current_theme_supports('t4p-schema')) {
            $meta_author_link_itemprop = 'url';
            $meta_author_link_rel = 'author';
        }

        $meta_author = get_the_author_meta('display_name');

        if ($evl_options['evl_fp_blog_meta_date'] == 'yes') {
            $inner_content .= "<span class='entry-time'><span class='updated' style='display:none;'>$meta_time</span><time class='$meta_date_class'>$meta_date</time></span><span class='meta-separator'>|</span>";
        }

        if ($evl_options['evl_fp_blog_meta_author'] == 'yes') {
            $inner_content .= "<span class='$meta_author_class' itemprop='$meta_author_itemprop' itemscope='$meta_author_itemscope' itemtype='$meta_author_itemtype'>" . __('Written By', 'evolve') . " <a href='$meta_author_link_href' itemprop='$meta_author_link_itemprop' rel='$meta_author_link_rel'>$meta_author</a>" . "</span><span class='meta-separator'>|</span>";
        }

        if ($evl_options['evl_fp_blog_layout'] != 'grid' && $evl_options['evl_fp_blog_layout'] != 'timeline') {
            if ($evl_options['evl_fp_blog_meta_comments'] == 'yes') {

                    ob_start();
                    comments_popup_link(__('0 Comments', 'evolve'), __('1 Comment', 'evolve'), __('% Comments', 'evolve'));
                    $comments = ob_get_contents();
                    ob_get_clean();

                    $inner_content .= sprintf('<span class="entry-comments">%s</span><span class="meta-separator">|</span>', $comments);
            }
        }

    $inner_content .= '</p>';

    return $inner_content;
}

function grid_timeline_comments() {
    global $evl_options;
    if ($evl_options['evl_fp_blog_meta_comments'] == 'yes') {

        $comments_icon = "<i class='t4p-icon-comment'></i>&nbsp";
        ob_start();
        comments_popup_link($comments_icon . __('0', 'evolve'), $comments_icon . __('1', 'evolve'), $comments_icon . __('%', 'evolve'));
        $comments = ob_get_contents();
        ob_get_clean();

        $inner_content = sprintf('<span class="comment-number">%s</span>', $comments);

        return $inner_content;
    }
}

function post_meta_tags() {
    global $evl_options;

    if( has_tag() ) {
            $inner_content = '';			
            if ($evl_options['evl_fp_blog_meta_tags'] == 'yes') {
                    ob_start();
                    echo ' ';
                    the_tags('');
                    $tags = ob_get_contents();
                    ob_get_clean();
                    $inner_content = sprintf('<span class="meta-tags">%s</span>', $tags);
            }
            return $inner_content;
    }
}

function read_more() {
    global $evl_options;
    if ($evl_options['evl_fp_blog_meta_link'] == 'yes') {
        $inner_content = '';

            $inner_content .= "<p class='entry-read-more'>";
            $btn_text = __('Read More', 'evolve');
            $link = get_permalink();
            $inner_content .= "<a class='read-more btn t4p-button-default' href='$link'>$btn_text</a>";
            $inner_content .= '</p>';

        return $inner_content;
    }
}

function loop_content() {
    global $evl_options;
    // get the post content according to the chosen kind of delivery
    if ($evl_options['evl_fp_blog_excerpt'] == 'yes') {
        $content = t4p_content($evl_options['evl_fp_blog_excerpt_length'], $evl_options['evl_fp_blog_strip_html']);
    } else {
        $content = get_the_content();
        //$content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
    }

    echo $content;
}

function page_links() {
    wp_link_pages(array('before' => '<div id="page-links"><p>' . __('<strong>Pages:</strong>', 'evolve'), 'after' => '</p></div>'));
}

if( ! function_exists('t4p_content') ) {
	function t4p_content($limit, $strip_html) {
		global $smof_data, $more;

		$content = '';

		if(!$limit && $limit != 0) {
			$limit = 285;
		}

		$limit = (int) $limit;

		$test_strip_html = $strip_html;

		if($strip_html == "true" || $strip_html == true) {
			$test_strip_html = true;
		} else {
			$test_strip_html = false;
		}
		
		$custom_excerpt = false;

		$post = get_post(get_the_ID());

		$pos = strpos($post->post_content, '<!--more-->');

		if($smof_data['link_read_more']) {
			$readmore = ' <a href="'.get_permalink( get_the_ID() ).'">&#91;...&#93;</a>';
		} else {
			$readmore = ' &#91;...&#93;';
		}

		if($smof_data['disable_excerpts']) {
			$readmore = '';
		}

		if($test_strip_html) {
			$more = 0;
			$raw_content = strip_tags( get_the_content( $readmore ) );
			
			if( $post->post_excerpt ||
				$pos !== false
			) {
				$more = 0;
				if( ! $pos ) {
					$raw_content = strip_tags( rtrim( get_the_excerpt(), '[&hellip;]' ) . $readmore );
				}
				$custom_excerpt = true;
			}
		} else {
			$raw_content = get_the_content( $readmore );
			if( $post->post_excerpt ) {
				$more = 0;
				$raw_content = rtrim( get_the_excerpt(), '[&hellip;]' ) . $readmore;
				$custom_excerpt = true;
			}
		}

		if($raw_content && $custom_excerpt == false) {
			$pattern = get_shortcode_regex();
			$content = $raw_content;

			if( $smof_data['excerpt_base'] == 'Characters' ) {
				$content = mb_substr($content, 0, $limit);
				if($limit != 0 && !$smof_data['disable_excerpts']) {
					$content .= $readmore;
				}
			} else {
				$content = explode(' ', $content, $limit);
				if(count($content)>=$limit) {
					array_pop($content);
					if($smof_data['disable_excerpts']) {
						$content = implode(" ",$content);
					} else {
						$content = implode(" ",$content);
					if($limit != 0) {
							if($smof_data['link_read_more']) {
								$content .= $readmore;
							} else {
								$content .= $readmore;
							}
						}
					}
				} else {
					$content = implode(" ",$content);
				}
			}

			if( $limit != 0 ) {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
			}

			$content = '<div class="excerpt-container">'.do_shortcode($content).'</div>';

			return $content;
		}

		if($custom_excerpt == true) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback("/$pattern/s", 't4p_process_tag', $raw_content);		
			if($test_strip_html == true) {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$content = '<div class="excerpt-container">'.do_shortcode($content).'</div>';
			} else {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
			}
		}

		if( has_excerpt() ) {
			$content = do_shortcode( get_the_excerpt() );
			$content = '<p>' . $content . '</p>';
		}

		return $content;
	}
}

/* Front Page Bootstrap Slider */
function fp_bootstrap_slider() {
    // Bootstrap Slider
    $evolve_bootstrap_on = evolve_get_option('evl_bootstrap_slider_support', '1');
    if ( ($evolve_bootstrap_on == "1" && is_front_page()) || ($evolve_bootstrap_on == "1" && is_home()) ):
	$evolve_bootstrap_slider = evolve_get_option('evl_bootstrap_slider_support', '1');
		if ($evolve_bootstrap_slider == "1"):
			evolve_bootstrap();
        endif;		
    endif;
}

/* Front Page Parallax Slider */
function fp_parallax_slider() {
    // Parallax Slider
    $evolve_parallax_on = evolve_get_option('evl_parallax_slider_support', '1');
    if ( ($evolve_parallax_on == "1" && is_front_page()) || ($evolve_parallax_on == "1" && is_home()) ):
        $evolve_parallax_slider = evolve_get_option('evl_parallax_slider_support', '1');
        if ($evolve_parallax_slider == "1"):
            evolve_parallax();
        endif;
    endif;
}

/* Front Page Posts Slider */
function fp_post_slider() {
    // Posts Slider
    $evolve_post_on = evolve_get_option('evl_carousel_slider', '1');
    if ( ($evolve_post_on == "1" && is_front_page()) || ($evolve_post_on == "1" && is_home()) ):
        $evolve_carousel_slider = evolve_get_option('evl_carousel_slider', '1');
        if ($evolve_carousel_slider == "1"):
            evolve_posts_slider();
        endif;
    endif;
}
