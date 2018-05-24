jQuery.noConflict();
jQuery(document).ready(function () {
    jQuery(function () {
        var widths = jQuery('#wrapper').width();
        jQuery('.footer').footerReveal({width: widths});
    });

    var windowh = jQuery(window).width();
    if (windowh == '1263') {
        var wids = jQuery('#wrapper').width();
        jQuery(".footer").css("width", wids);
    } else if (windowh == '985') {
        var widths = jQuery('#wrapper').width();
        var fullwidth = (widths - 1);
        jQuery(".footer").css("width", fullwidth);
    } else {
        var wid = jQuery('#wrapper').width();
        jQuery(".footer").css("width", wid);
    }
});