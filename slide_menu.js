$(document).ready(function() {
    $(".slide_menu").hide();
    $(".user-img").click(function(){
        $(".slide_menu").css('visibility', 'visible');
        $(".slide_menu").slideToggle("fast");
    });
        
});