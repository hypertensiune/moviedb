<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>
<body>

    <?php include 'src/Views/header.html'; ?>

    <div id="search-results-container">
        <div id="search-results-wrapper">
            <div id="search-results-left">
                <div id="search-filter">
                    <div id="search-header">
                        <h1>Search Results</h1>
                    </div>
                    <div id="filter-options">
                        <div id="filter-movie" onclick="filterResults(this)">Movies     <?=$SEARCH_MOVIES['total_results']?></div>
                        <div id="filter-tv" onclick="filterResults(this)">TV Shows      <?=$SEARCH_TV['total_results']?></div>
                        <div id="filter-person" onclick="filterResults(this)">People    <?=$SEARCH_PEOPLE['total_results']?></div>
                    </div>
                </div>
            </div>
            <div id="search-results-right">
                <div id="movie-results" class="search-results-list">
                    <?php
                        Search::echoSearchResults($SEARCH_MOVIES, "movie");
                    ?>
                </div>
                <div id="tv-results" class="search-results-list">
                    <?php
                        Search::echoSearchResults($SEARCH_TV, "tv");
                    ?>
                </div>
                <div id="person-results" class="search-results-list">
                    <?php
                        Search::echoSearchResults($SEARCH_PEOPLE, "person");
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'src/Views/footer.html'; ?>

    <script>
        let filter = url.searchParams.get('filter') || <?=json_encode($filter)?>;
    </script>

    <script src="./js/search.js"></script>
</body>
</html>