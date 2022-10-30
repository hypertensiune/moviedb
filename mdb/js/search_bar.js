let search_bar_status = "closed";
$("#search-bar-btn").on('click', function(){
    if(search_bar_status == "closed"){
        $(this).children("i").removeClass("fa-magnifying-glass");
        $(this).children("i").addClass("fa-xmark");
        $("#search-form input[type=text]").focus();
        $("#header-search-bar").addClass("opened");
        search_bar_status = "opened";
    }
    else{
        $(this).children("i").removeClass("fa-xmark");
        $(this).children("i").addClass("fa-magnifying-glass");
        $("#header-search-bar").removeClass("opened");
        search_bar_status = "closed";
    }
});