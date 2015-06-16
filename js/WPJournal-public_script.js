jQuery(document).ready(function(jQuery) {
    jQuery('img:not(.img-circle)').addClass("img-thumbnail").addClass(
        "img-responsive");
    jQuery(function() {
        jQuery('#titolo_wpjournal').quickfit({
            max: 78,
            min: 16,
            truncate: false
        });
        jQuery('.titolo_homepage').quickfit({
            max: 44,
            min: 18,
            truncate: false
        });
        jQuery('.titolo_main').quickfit({
            max: 56,
            min: 12,
            truncate: false
        });
        jQuery('.titolo_piccolo').quickfit({
            max: 24,
            min: 19,
            truncate: false
        });
        jQuery('#titolo_wpjournal_internal').quickfit({
            max: 32,
            min: 10,
            truncate: false
        });
        jQuery('.titolo_main_internal').quickfit({
            max: 72,
            min: 18,
            truncate: false
        });
    });
    jQuery(".wpjournal_menu-link").click(function() {
        jQuery("#wpjournal_menu").toggleClass("active");
        jQuery(".container").toggleClass("active");
    });
    jQuery('a').filter(function() {
        return jQuery(this).attr('href').match(
            /\.(jpg|png|gif)/i);
    }).addClass("lightboxxxx");
    jQuery(".lightboxxxx").colorbox({
        rel: 'lightboxxxx',
        width: "50%"
    });
});