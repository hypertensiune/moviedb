let url = new URL(window.location);
let filter = url.searchParams.get('filter');
let currentPage = 1;

window.addEventListener('resize', () => {
    let w = parseInt($(".image img").css("width"));
    let pw = parseInt($("#results").css("width"));

    $(".image img").each(function(){
        $(this).css("height", (w / 0.66667) + 'px');
    });
});

window.addEventListener('scroll', function(){
    if(currentPage > 1 && currentPage < maxPageNo && Math.ceil($(window).scrollTop()) == $(document).height() - $(window).height()){
        loadMore();
    }
});

$(() => {
    $(`#filter-${filter}`).addClass("selected");
});

function loadMore(){
    $.ajax({
        type: 'GET',
        url: req_url,
        data: { page: currentPage + 1, filter: filter},
        success: function (res) {
            currentPage++;
            $("#content-right").append("<div class='results " + currentPage + "'>" + res + "</div>");                    
        }
    });
}