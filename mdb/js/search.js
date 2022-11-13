let currentPage = url.searchParams.get('page') || 1;

$(() => {

    $(`#search-results-right > div:not(#${filter}-results)`).each(function () {
        $(this).css("display", "none");
    });
    $(`#filter-${filter}`).addClass("selected");

    $(`.page-btn.${currentPage}`).css("text-decoration", "underline").css("pointer-events", "none");

    if (currentPage > 1)
        changePage(currentPage);
});

function filterResults(event) {
    filter = event.id.substr(7);

    url.searchParams.set('filter', filter);
    url.searchParams.set('page', 1);
    window.history.pushState(null, '', url.toString());

    $("#search-results-right div.search-results-list").each(function () {
        $(this).css("display", "none");
    });

    $(`#${filter}-results`).css("display", "flex");

    $("#filter-options div").each(function () {
        $(this).removeClass("selected");
    });

    $(event).addClass("selected");
}

function changePageHandler(event) {
    let page = 0;
    if (event.id == "previous-btn")
        page = parseInt(currentPage) - 1;
    else if (event.id == "next-btn")
        page = parseInt(currentPage) + 1;
    else
        page = $(event).attr('class').split(' ')[1];

    $(event).css("text-decoration", "underline");

    changePage(page);
}

function changePage(page) {
    url.searchParams.set('page', page);
    window.history.pushState(null, '', url.toString());
    
    $.ajax({
        type: 'GET',
        url: req_url,
        data: { page: page, filter: filter, query: url.searchParams.get("query") },
        success: function (res) {
            $(`#${filter}-results`).html(res);
            $(`.page-btn.${page}`).css("text-decoration", "underline").css("pointer-events", "none");
            currentPage = page;
        }
    });
}