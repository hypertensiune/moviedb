let w = 0;

function hamburger_menu() {
    if (w == 1) {
        w = 0;
        $("#s1").removeClass("s1");
        $("#s2").removeClass("s2");
        $("#s3").removeClass("s3");
        $("#slider-menu").css('width', '0%');
        
    }
    else {
        w = 1;
        $("#s1").addClass("s1");
        $("#s2").addClass("s2");
        $("#s3").addClass("s3");

        $("#slider-menu").css('width', '70%');
    }
}