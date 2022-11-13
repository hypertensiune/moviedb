<?php
    $RESULTS = $RES['results'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>

    <link rel="stylesheet" href="<?=$GLOBALS['apppath']?>css/global.css">
    <link rel="stylesheet" href="<?=$GLOBALS['apppath']?>css/header.css">
    <link rel="stylesheet" href="<?=$GLOBALS['apppath']?>css/movie.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</head>
<body>
    
    <?php include 'src/Views/header.php'; ?>

    <div id="content">
         <div id="wrapper">
            <div id="content-left">
                <div id="search-filter">
                    <div id="search-header">
                        <h1>Filter</h1>
                    </div>
                    <div id="filter-options">
                        <div id="filter-popular"><a href="./<?=$TYPE?>?filter=popular">Popular</a></div>
                        <div id="filter-top-rated"><a href="./<?=$TYPE?>?filter=top-rated">Top Rated</a></div>
                        <?php if($TYPE == "movie"): ?>
                            <div id="filter-upcoming"><a href="./<?=$TYPE?>?filter=upcoming">Upcoming</a></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div id="content-right">
                <div class="results 1">
                    <?php
                        foreach($RESULTS as $result){
                            if($TYPE == "movie")
                                Movie::echoCards($result['title'], $result['release_date'], $result['poster_path'], $result['id']);
                            else if($TYPE == "tv")
                                TV::echoCards($result['name'], $result['first_air_date'], $result['poster_path'], $result['id']);    
                        }
                    ?>
                </div>
                <div class="load-more">
                    <a id="load-more-btn" onclick="loadMore(); $(this).parent().hide()">Load More</a>
                </div>
            </div>
         </div>
    </div>

    <?php include 'src/Views/footer.php'; ?>

    <script>
        let maxPageNo = <?=$RES['total_pages']?>;
        let req_url = "<?=$GLOBALS['apppath']?>" + "<?=$TYPE?>" + "/load_more";
    </script>

    <script src="<?=$GLOBALS['apppath']?>js/movie.js"></script>
</body>
</html>