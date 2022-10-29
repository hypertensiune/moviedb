<?php

    function echoResult($data){
        if($data['media_type'] == "movie"){
            $title = $data['title'];
            $release_date = date('F j, Y', strtotime($data['release_date']));
            $poster = $data['poster_path'];
            $href = "/mdb/movie/" . $data['id'];
        }
        else if($data['media_type'] == "tv"){
            $title = $data['name'];
            $release_date = date('F j, Y', strtotime($data['first_air_date']));
            $poster = $data['poster_path'];
            $href = "/mdb/tv/" . $data['id'];
        }
        echo <<<HTML
            <li class="card">
                <a href=$href><img src="https://www.themoviedb.org/t/p/w220_and_h330_face/$poster"></a>
                <a href=$href>$title</a>
                <p>$release_date</p>
            </li>
        HTML;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Database</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>
<body>
    <?php include 'src/Views/header.php'; ?>

    <div id="welcome-content">
        <div id="welcome-wrapper">
            <div id="welcome-center">
                <div id="title">
                    <h2 style="font-weight: 700; font-size: 3em;">Welcome</h2>
                    <h3 style="font-weight: 600; font-size: 2em;">Millions of movies, TV shows and people to discover. Explore Now</h3>
                </div>  
                <div id="search-bar">
                    <form method="GET" action="./search">
                        <input type="text" placeholder="Search for a movie, tv show, person..." name="query">
                        <input type="submit" value="Search">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="more-content">
        <div id="more-wrapper">
            <div id="popular" class="should-fade is-fading" style="margin-bottom: 30px;">
                <div id="popular-header">
                    <h2>What's Popular</h2>
                    <div class="selector">
                        <a class="active">Movies</a>
                        <a>TV</a>
                    </div>
                </div>
                <ol id="popular-movies" class="results-list selected">
                    <?php
                        foreach($POPULAR_MOVIES['results'] as $movie){
                            $movie['media_type'] = "movie";
                            echoResult($movie);    
                        }
                    ?>
                </ol>
                <ol id="popular-tv" class="results-list">
                    <?php
                        foreach($POPULAR_TV['results'] as $tv){
                            $tv['media_type'] = "tv";
                            echoResult($tv);    
                        }
                    ?>
                </ol>
            </div>
            <script>
                $("#popular .selector a").click(function(){
                    $("#popular .selector a").removeClass("active");
                    $(this).addClass("active");
                    $("#popular ol.results-list").toggleClass("selected");
                });

                $("#popular ol.results-list").scroll(function(){
                    if($(this).scrollLeft() > 6){
                        $("#popular").removeClass("is-fading").addClass("is-hidden");
                    }else{
                        $("#popular").removeClass("is-hidden").addClass("is-fading");
                    }
                });
            </script>
            <div id="trending" class="should-fade is-fading">
                <div id="trending-header">
                    <h2>Trending</h2>
                    <div class="selector">
                        <a class="active">Today</a>
                        <a>This week</a>
                    </div>
                </div>
                <ol id="trending-today" class="results-list selected">
                    <?php
                        foreach($TRENDING_TODAY['results'] as $trending){
                            if($trending['media_type'] != "person")
                                echoResult($trending);    
                        }
                    ?>
                    
                </ol>
                <ol id="trending-week" class="results-list">
                    <?php
                        foreach($TRENDING_WEEK['results'] as $trending){
                            if($trending['media_type'] != "person")
                                echoResult($trending);    
                        }
                    ?>
                </ol>
            </div>
            <script>
                $("#trending .selector a").click(function(){
                    $("#trending .selector a").removeClass("active");
                    $(this).addClass("active");
                    $("#trending ol.results-list").toggleClass("selected");
                });

                $("#trending ol.results-list").scroll(function(){
                    if($(this).scrollLeft() > 6){
                        $("#trending").removeClass("is-fading").addClass("is-hidden");
                    }else{
                        $("#trending").removeClass("is-hidden").addClass("is-fading");
                    }
                });
            </script>
        </div>
    </div>
    <script>
        window.addEventListener('resize', function(){
            if(window.innerWidth <= 560)
                $("#search-bar input[type=text]").attr('placeholder', 'Search...');
            else
                $("#search-bar input[type=text]").attr('placeholder', 'Search for a movie, tv show, person...');
        });
    </script>

    <?php include "src/Views/footer.html"; ?>
</body>
</html>
