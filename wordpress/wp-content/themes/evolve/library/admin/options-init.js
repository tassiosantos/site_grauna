/* For Front/Home Page Demo Image Hover Overlay */
jQuery(document).ready(function ($) {

    var numberofdemo = $( '#evl_options-evl_frontpage_prebuilt_demo ul' ).children().length;
    for (i = 1; i <= numberofdemo; i++) {
            if ( ! $( '#evl_options-evl_frontpage_prebuilt_demo' ).hasClass( 'fp_demo_overlay' ) ) {
                    var fp_demoname = $( '#evl_frontpage_prebuilt_demo_'+i ).val();
                    $( '.evl_frontpage_prebuilt_demo_'+i ).append( '<div class=fp_demooverlay><div class=fp_demoname>'+fp_demoname+'</div></div>' );
                    $( '#evl_options-evl_frontpage_prebuilt_demo' ).addClass( 'demohover' )
            }
    }

    $( '#evl_options-evl_frontpage_prebuilt_demo ul li .redux-image-select' ).on({
        mouseenter: function (event) {
                var className  = $(this).children().attr('id');
                $( '.'+className+' .fp_demooverlay' ).addClass( 'hover_opacity' );
        },
        mouseleave: function (event) {
                var className  = $(this).children().attr('id');
                $( '.'+className+' .fp_demooverlay' ).removeClass( 'hover_opacity' );
        }
    });

    $( '.fp_demooverlay' ).on( 'click', function() {
            $(this).parent().find('img').click();
    });

});