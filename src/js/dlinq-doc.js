// Add your JS customizations here
console.log('loadedddddd')

// smooth scroll
// handle links with @href started with '#' only
jQuery(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    console.log('click')
    var id = jQuery(this).attr('href');

    // target element
    var $id = jQuery(id);
    if ($id.length === 0) {
        return;
    }

    // opted to leave it so that links could be shared more intuitively 
   // e.preventDefault();

    // top position relative to the document
    var pos = $id.offset().top-50;

    // animated top scrolling
    jQuery('body, html').animate({scrollTop: pos});
});