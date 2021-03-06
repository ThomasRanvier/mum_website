/* --------------------------------- */
/* Navbar dropdown menus transitions */
/* --------------------------------- */
$(".dropdown").on("hide.bs.collapse", function() {
    $(this).find(".dropdown-menu").first().addClass("sliding")
});
$(".dropdown").on("hidden.bs.collapse", function() {
    $(this).find(".dropdown-menu").first().removeClass("sliding")
});
$(document).click(function() {
    $(".dropdown-menu.collapse.show").collapse("hide");
});

/* ----------------------- */
/* Share buttons on images */
/* ----------------------- */
var a2a_config = a2a_config || {};
a2a_config.overlays = a2a_config.overlays || [];
a2a_config.overlays.push({
    services: ['facebook', 'facebook_messenger', 'twitter', 'whatsapp', 'pinterest', 'tumblr', 'copy_link'],
    size: '25',
    style: 'horizontal',
    position: 'top left'
});

/* -------------------------- */
/* Slide on gallery carousels */
/* -------------------------- */
// Called once the modal is created
function carousel_touch_slide() {
    $('.carousel').on('touchstart', function(event){
        const xClick = event.originalEvent.touches[0].pageX;
        $(this).one('touchmove', function(event){
            const xMove = event.originalEvent.touches[0].pageX;
            const sensitivityInPx = 5;
            if( Math.floor(xClick - xMove) > sensitivityInPx ){
                $(".carousel-control-next").click();
            }
            else if( Math.floor(xClick - xMove) < -sensitivityInPx ){
                $(".carousel-control-prev").click();
            }
        });
        $(this).on('touchend', function(){
            $(this).off('touchmove');
        });
    });
}
$(document).keydown(function(e) {
    if (e.code === 37) {
        // Previous
        $(".carousel-control-prev").click();
        return false;
    }
    if (e.code === 39) {
        // Next
        $(".carousel-control-next").click();
        return false;
    }
});