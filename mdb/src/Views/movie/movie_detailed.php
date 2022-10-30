<?php

    /** @var array $MOVIE */

    $MOVIE_CAST = $MOVIE_CAST_CREW['cast'];
    $MOVIE_CREW = $MOVIE_CAST_CREW['crew'];

    $is_bookmarked = false;
    $is_favorited = false;

    global $languages;

    $TYPE = $_SESSION['TYPE'];

    if($TYPE == "MOVIE"){
        $title = $MOVIE['title'];
        $date = $MOVIE["release_date"]; 
        $runtime = $MOVIE["runtime"];
    }
    else{
        $title = $MOVIE['name'];
        $date = $MOVIE["first_air_date"]; 
        $runtime = $MOVIE["episode_run_time"][0];
        $last_season = $MOVIE['number_of_seasons'];
        $n = $MOVIE['seasons'][0]['name'] == "Specials" ? $last_season : $last_season - 1;
        $last_season_ep = $MOVIE['seasons'][$n]['episode_count'];
        $last_season_date = substr($MOVIE['seasons'][$n]['air_date'], 0, 4);
        $last_season_overview = $MOVIE['seasons'][$n]['overview'];
        $last_seaons_poster = $MOVIE['seasons'][$n]['poster_path'];
    }

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];

        require "src/Classes/DB.php";

        $db = new DB();

        $favorites = $db->getList("favorites", $_SESSION['username'])['list'];
        $bookmarks = $db->getList("bookmark", $_SESSION['username'])['list'];

        $favorites = explode('/', $favorites);
        $bookmarks = explode('/', $bookmarks);

        foreach($bookmarks as $bookmark){
            if($movie_id == substr($bookmark, 1) && strtolower($TYPE)[0] == $bookmark[0])
                $is_bookmarked = true;
        }

        foreach($favorites as $favorite){
            if($movie_id == substr($favorite, 1) && strtolower($TYPE)[0] == $favorite[0])
                $is_favorited = true;
        }
    }
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title><?= $title; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/movie_detailed.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>

<body style="padding: 0; margin: 0;">

    <?php include 'src/Views/header.php'; ?>

    <div id="movie-container">
        <div id="backdrop" style="background-image: url('https://image.tmdb.org/t/p/w1920_and_h800_multi_faces<?=$MOVIE['backdrop_path']; ?>');">
            <div id="overlay"></div>
        </div>
        <div id="wrapper">
            <div id="movie-left">
                <img id="poster-img" src="https://image.tmdb.org/t/p/original<?=$MOVIE['poster_path']; ?>" crossorigin="anonymous">
                <script async id="onload" src="../js/get_average_color.js"></script>
            </div>
            <div id="movie-right">
                <div id="movie-right-container">
                    <div id="r1">
                        <a id="title"><?=$title; ?></a>
                        <a id="release_year">(<?=substr($date, 0, 4); ?>)</a>
                    </div>
                    <div id="r2">
                        <span id="date">
                            <?php
                                $date = strrev($date);
                                $tok = strtok($date, '-');
                                for ($i = 0; $i < 3; $i++) {
                                    echo strrev($tok);
                                    if ($i < 2)
                                        echo '/';
                                    $tok = strtok('-');
                                }
                            ?>
                        </span>
                        <span class="dot"></span>
                        <span id="genres">
                            <?php
                                for ($i = 0; $i < count($MOVIE['genres']); $i++) {
                                    echo $MOVIE['genres'][$i]['name'];
                                    if ($i < count($MOVIE['genres']) - 1)
                                        echo ', ';
                                }
                            ?>
                        </span>
                        <span class="dot"></span>
                        <span id="runtime">
                            <?=floor($runtime / 60) . "h " . $runtime % 60 . 'm'; ?>
                        </span>
                    </div>
                    <div id="r3">
                        <div id="r3-left" style="display: inline-flex;">
                            <div class="user-score" style="background: conic-gradient(#21d07a 288deg, darkslategray 0deg);">
                                <span id="user-score-n"><?=floor($MOVIE['vote_average'] * 10); ?></span>
                            </div>
                            <div id="user-score-tag">User score</div>
                        </div>
                        <div id="actions">
                            <div id="favorites-btn" class="circle" <?php if($is_favorited) echo "style='color: red;'" ?>><i class="fa-solid fa-heart"></i></div>
                            <div id="bookmark-btn" class="circle" <?php if($is_bookmarked) echo "style='color: red;'" ?>><i class="fa-solid fa-bookmark"></i></div>
                        </div>
                        <div id="r3-right" style="display: inline-flex">
                            <i style="margin-right: 5px; font-size: 16px;" class="fa-solid fa-play"></i>
                            <a id="play-trailer" onclick=play_trailer() style="margin-top: -2px;">Play trailer</a>
                        </div>
                    </div>
                    <div id="r4">
                        <p style="font-size: 17.6px; font-style: italic; font-weight: 400; opacity: 0.7; margin: 0;"><?= $MOVIE['tagline']; ?></p>
                        <h3 style="font-size: 21px; margin: 10px 0px 8px">Overview</h3>
                        <p style="font-size: 16px; margin: 0; max-width: 962px;"><?= $MOVIE['overview']; ?></p>
                    </div>
                    <?php 
                        if(array_key_exists('title', $MOVIE)){
                            echo '<div id="r5">';
                            echo '<ol class="olist" style="margin: 30px 0 0 -10px;">';
                            $crew = array();
                            foreach ($MOVIE_CREW as $crew_member) {
                                if ($crew_member['job'] == 'Director' || $crew_member['job'] == 'Writer') {
                                    if (!array_key_exists($crew_member['name'], $crew))
                                        $crew[$crew_member['name']] = $crew_member['job'];
                                    else
                                        $crew[$crew_member['name']] .= ", " . $crew_member['job'];
                                }
                            }

                            foreach ($crew as $key => $value) {
                                echo '<li style="margin-right: 10px;">';
                                echo '<p class="cast-name">' . $key . '</p>';
                                echo '<p class="character">' . $value . '</p>';
                                echo '</li>';
                            }
                            echo "</ol></div>";
                        } 
                    ?>
                </div>
            </div>
        </div>
        <script>
            function setMovieContainerHeight() {
                if (window.innerWidth <= 880) {
                    let ml = $("#movie-left").css("height");
                    ml = parseInt(ml.substring(0, ml.length - 2));
                    let mr1 = $("#movie-right-container").css("height");
                    let mr2 = $("#movie-right").css("height");
                    mr1 = parseInt(mr1.substring(0, mr1.length - 2));
                    mr2 = parseInt(mr2.substring(0, mr2.length - 2));
                    let mr = Math.max(mr1, mr2);
                    $("#movie-container").css("height", `${ml + mr + 40}px`);
                } else {
                    $("#movie-container").css("height", "572px");
                }
            }

            window.addEventListener('load', () => {
                setMovieContainerHeight();
            });

            window.addEventListener('resize', () => {
                setMovieContainerHeight();
            });
        </script>
    </div>

    <div id="movie-content">
        <div id="content-wrapper">
            <div id="content-left">
                <div id="cast-scroller" class="should-fade is-fading">
                    <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Top billed cast</h3>
                    <ol id="cast-list" class="olist">
                        <?php
                            for ($i = 0; $i < 9 && $i < count($MOVIE_CAST); $i++) {
                                echo '<li class="cast-card">';
                                echo '<a href="../person/' . $MOVIE_CAST[$i]['id'] . '"><img src="https://image.tmdb.org/t/p/w138_and_h175_face' . $MOVIE_CAST[$i]["profile_path"] . '"></img></a>';
                                echo '<p class="cast-name">' . $MOVIE_CAST[$i]['name'] . '</p>';
                                if(array_key_exists("character", $MOVIE_CAST[$i]))
                                    echo '<p class="character">' . $MOVIE_CAST[$i]["character"] . '</p>';
                                else
                                    echo '<p class="character">' . $MOVIE_CAST[$i]["roles"][0]["character"] . '</p>';
                                echo '</li>';
                            }
                        ?>

                        <li class="cast-view-more">
                            <p style="margin-top: 115px;"><a style="color: black; text-decoration: none;" href="./<?= $movie_id; ?>/cast">View more</a><i class="fa-solid fa-arrow-right"></i></p>
                        </li>
                    </ol>
                    <script>
                        $("#cast-list").scroll(function() {
                            if ($("#cast-list").scrollLeft() > 6) {
                                $("#cast-scroller").removeClass("is-fading").addClass("is-hidden");
                            } else {
                                $("#cast-scroller").addClass("is-fading").removeClass("is-hidden");
                            }
                        });

                        document.addEventListener('load', changeCastPhoto());

                        window.addEventListener('resize', () => {
                            changeCastPhoto();
                        });

                        function changeCastPhoto() {
                            if (window.innerWidth <= 880) {
                                $(".cast-card img").each(function() {
                                    let src = $(this).attr("src");
                                    src = src.replace("138", "120");
                                    src = src.replace("175", "133");
                                    $(this).attr("src", src);
                                });
                            } else {
                                $(".cast-card img").each(function() {
                                    let src = $(this).attr("src");
                                    src = src.replace("120", "138");
                                    src = src.replace("133", "175");
                                    $(this).attr("src", src);
                                });
                            }
                        }
                    </script>
                    <a class="more" href="./<?=$movie_id; ?>/cast">Full Cast & Crew</a>
                </div>
                
                <?php if($TYPE == "TV"): ?>
                    <div id="seasons">
                    <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Current Season</h3>
                    <div class="season-card">
                        <div class="wrapper">
                            <div class="image">
                                <a href="/mdb/tv/<?=$movie_id?>/seasons">
                                    <img src="https://image.tmdb.org/t/p/w130_and_h195_bestv2/<?=$last_seaons_poster?>">
                                </a>
                            </div>
                            <div class="details">
                                <a href="/mdb/tv/<?=$movie_id?>/seasons"><h2>Season <?=$last_season?></h2></a>
                                <span><?=$last_season_date?> | <?=$last_season_ep?> Episodes</span>
                                <p><?=$last_season_overview?></p>
                            </div>
                        </div>
                    </div>
                    <a class="more" href="/mdb/tv/<?=$movie_id?>/seasons">View All Seasons</a>
                    </div>  
                <?php endif ?>

                <?php if(count($MOVIE_REVIEWS) > 0): ?>
                    <div id="reviews">
                        <?php $index = rand(0, count($MOVIE_REVIEWS) - 1); ?>
                        <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Reviews</h3>
                        <div id="review-holder">
                            <div style="display: flex; align-items: center; align-content: center;">
                                <a>
                                    <img style="border-radius: 50%;" width=64 height=64 src=<?php
                                                                                            $avatar_path = $MOVIE_REVIEWS[$index]['author_details']['avatar_path'];
                                                                                            if (strstr($avatar_path, "https"))
                                                                                                echo '"' . substr($avatar_path, 1) . '"';
                                                                                            else
                                                                                                echo "https://image.tmdb.org/t/p/w64_and_h64_face$avatar_path";
                                                                                            ?>>
                                    </img>
                                </a>
                                <div style="width: 100%; margin-left: 20px;">
                                    <a style="font-size: 21px; font-weight: 700;">A review by <?= $MOVIE_REVIEWS[$index]['author']; ?></a>
                                    <div style="font-size: 14px; font-weight: 500;">Written by <?= $MOVIE_REVIEWS[$index]['author'] . " on " . substr($MOVIE_REVIEWS[$index]['created_at'], 0, 10); ?></div>
                                </div>
                            </div>
                            <div id="review-content">
                                <?php
                                    $content = $MOVIE_REVIEWS[$index]['content'];

                                    if (strlen($content) > 600) {
                                        echo nl2br(substr($content, 0, 600)) . '...';
                                        echo "<a href='./$movie_id/reviews?id=$index' style='text-decoration: underline;'>read the rest</a>";
                                    } else {
                                        echo nl2br($content);
                                    }
                                ?>
                            </div>
                        </div>
                        <a class="more" href="./<?= $movie_id; ?>/reviews">Read All Reviews</a>
                    </div>
                <?php endif ?>

                <div id="recommendations" class="should-fade is-fading">
                    <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Recommendations</h3>
                    <ol id="recommendations-list" class="olist">
                        <?php

                        foreach ($MOVIE_RECOMMENDATIONS as $recommendation) {
                            $r_title = array_key_exists("original_title", $recommendation) ? $recommendation['original_title'] : $recommendation['name'];
                            echo '<li class="movie-card">';
                            echo '<a href="./' . $recommendation['id'] . '"><img src="https://image.tmdb.org/t/p/w250_and_h141_face/' . $recommendation['backdrop_path'] . '"></img></a>';
                            echo '<span style="float: left;">' . $r_title . '</span>';
                            echo '<span style="float: right;">' . floor($recommendation['vote_average'] * 10) . '%</span>';
                        }

                        ?>

                    </ol>
                    <script>
                        $("#recommendations-list").scroll(function() {
                            if ($("#recommendations-list").scrollLeft() > 6) {
                                $("#recommendations").removeClass("is-fading").addClass("is-hidden");
                            } else {
                                $("#recommendations").addClass("is-fading").removeClass("is-hidden");
                            }
                        });
                    </script>
                </div>
            </div>
            <div id="content-right" class="should-fade is-fading">
                <div>
                    <span id="external-links">
                        <a <?php if($MOVIE_EIDS['facebook_id']) echo "href='https://www.facebook.com/" . $MOVIE_EIDS['facebook_id'] . "'" ?>><i class="fa-brands fa-square-facebook"></i></a>
                        <a <?php if($MOVIE_EIDS['twitter_id']) echo "href='https://twitter.com/" . $MOVIE_EIDS['twitter_id'] . "'" ?>><i class="fa-brands fa-twitter"></i></a>
                        <a <?php if($MOVIE_EIDS['instagram_id']) echo "href='https://www.instagram.com/" . $MOVIE_EIDS['instagram_id'] . "'" ?>><i class="fa-brands fa-instagram"></i></a>
                        <span class="line"></span>
                        <a href="<?= $MOVIE['homepage'] ?>"><i class="fa-solid fa-link"></i></a>
                    </span>
                    <p><strong>Status</strong><br><?= $MOVIE['status']; ?></p>
                    <p><strong>Original Language</strong><br><?= $languages[$MOVIE['original_language']]; ?></p>
                    <?php if(array_key_exists("budget", $MOVIE)): ?>
                        <p><strong>Budget</strong><br><?= '$' . number_format($MOVIE['budget'], 2); ?></p>
                        <p><strong>Revenue</strong><br><?= '$' . number_format($MOVIE['revenue'], 2); ?></p>
                    <?php else: ?>
                        <p><strong>Original Name</strong><br><?=$MOVIE['original_name']; ?></p>
                    <?php endif ?>
                </div>
                <div style="margin-top: 50px;">
                    <h4 style="font-size: 18px; margin-bottom: 10px;">Keywords</h4>
                    <ul id="keywords-list">
                        <?php
                            foreach ($MOVIE_KEYWORDS as $keyword) {
                                echo "<li><a>{$keyword['name']}</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include 'src/Views/footer.html'; ?>

    <?php if(isset($_SESSION['username'])): ?>
        <script>
            let type = <?=json_encode($TYPE)?>.substring(0, 1).toLowerCase();
            let id = <?=json_encode($movie_id)?>;
            let username = <?=json_encode($username)?>;

            let is_bookmarked = <?=json_encode($is_bookmarked)?>;
            let is_favorited = <?=json_encode($is_favorited)?>;

            $("#bookmark-btn").on('click', function(){
                $.ajax({
                    type: "POST",
                    url: `../u/${username}/bookmark`,
                    data: {id: id, type: type, add: !is_bookmarked},
                    success: function(res){
                        console.log(res);
                    }
                });
                if(is_bookmarked)
                    $(this).css("color", "white");
                else
                    $(this).css("color", "red");
                is_bookmarked = !is_bookmarked;
            });
            $("#favorites-btn").on('click', function(){
                $.ajax({
                    type: "POST",
                    url: `../u/${username}/favorites`,
                    data: {id: id, type: type, add: !is_favorited},
                    success: function(res){
                        console.log(res);
                    }
                });
                if(is_favorited)
                    $(this).css("color", "white");
                else
                    $(this).css("color", "red");
                is_favorited = !is_favorited;
            });
        </script>
    <?php endif ?>

    <script>
        function luminance(r, g, b) {
            let a = [r, g, b].map(v => {
                v /= 255;
                return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
            });
            return a[0] * 0.2126 + a[1] * 0.7125 + a[2] * 0.722;
        }

        function contrast(rgb1, rgb2) {
            let lum1 = luminance(rgb1[0], rgb1[1], rgb1[2]);
            let lum2 = luminance(rgb2[0], rgb2[1], rgb2[2]);
            let brightest = Math.max(lum1, lum2);
            let darkest = Math.min(lum1, lum2);
            return (brightest + 0.05) / (darkest + 0.05);
        }
    </script>

    <script id="change_date_runtime">
        $(() => {
            let original = $("#date").text();
            let state = 1;

            if (window.innerWidth < 880) {
                change_date_runtime(1);
            }

            window.addEventListener('resize', () => {
                if (state && window.innerWidth < 880) {
                    change_date_runtime(1);
                    state = 0;
                }
                if (!state && window.innerWidth >= 880) {
                    change_date_runtime(0, original);
                    state = 1;
                }
            });
        });

        function change_date_runtime(change, original) {
            if (change) {
                $("#date").append(" " + $("#runtime").text());
                $("#runtime").css("display", "none");
            } else {
                $("#date").empty();
                $("#date").append(original);
                $("#runtime").css("display", "unset");
            }
        }
    </script>

    <script id="trailer">
        function play_trailer() {
            $.ajax({
                type: 'GET',
                url: './<?=$movie_id?>/get_iframe',
                success: function(res) {
                    $("body").append(res);
                    let w = $("#trailer_iframe_container").css('width');
                    $("#trailer_iframe").css('height', w.slice(0, -2) / 1.77777778);
                }
            });
        }

        function close_trailer() {
            $("body").children("div").last().remove();
            $("body").children("div").last().remove();
        }
    </script>

</body>

</html>