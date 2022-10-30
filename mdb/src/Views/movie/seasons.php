<?php

    $title = $MOVIE['name'];
    $date = $MOVIE['first_air_date'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasons</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/seasons.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</head>
<body>
    <?php include 'src/Views/header.php'; ?>

    <div id="movie-top">
        <div id="wrapper">
            <img id="poster-img" src="https://image.tmdb.org/t/p/w58_and_h87_face/<?=$MOVIE['poster_path']; ?>" crossorigin="anonymous" width="58" height="87">
            <span id="movie-details">
                <span style="display: block;">
                    <a id="title"><?=$title?></a>
                    <span id="year">(<?=substr($date, 0, 4); ?>)</span>
                </span>
                <a id="back"><i class="fa-solid fa-arrow-left"></i>&ensp;Back to main</a>
            </span>
        </div>
        <script>
            $("#back, #title").click(() => {
                let url = window.location.href;
                window.location.href = url.slice(0, url.lastIndexOf('/'));
            });
        </script>
        <script src="../../js/get_average_color.js"></script>
    </div>

    <div id="seasons-holder">
        <div id="seasons-wrapper">
            <?php
                $SEASONS = $MOVIE['seasons'];
                foreach($SEASONS as $season){
                    $poster = $season['poster_path'];
                    $air_date = date('F j, Y', strtotime($season['air_date']));
                    $ep = $season['episode_count'];
                    $overview = $season['overview'];
                    $name = $season['name'];
                    echo <<<HTML
                        <div class="season-card">
                            <div class="wrapper">
                                <div class="image">
                                    <a href="/mdb/tv/<?=$movie_id?>/seasons">
                                        <img src="https://image.tmdb.org/t/p/w130_and_h195_bestv2$poster">
                                    </a>
                                </div>
                                <div class="details">
                                    <a href="/mdb/tv/<?=$movie_id?>/seasons"><h2>$name</h2></a>
                                    <span>$air_date | $ep Episodes</span>
                                    <p>$overview</p>
                                </div>
                            </div>
                        </div>
                    HTML;
                }
            ?>
        </div>
    </div>

    <?php include "src/Views/footer.html"; ?>
</body>
</html>