<?php
    if(array_key_exists("title", $MOVIE)){
        $title = $MOVIE['title'];
        $date = $MOVIE['release_date'];
    }
    else{
        $title = $MOVIE['name'];
        $date = $MOVIE['first_air_date'];
    }
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?> - Cast</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/cast.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>

<body>

    <?php include 'src/Views/header.html'; ?>

    <div id="movie-top">
        <div id="wrapper">
            <img id="poster-img" src="https://image.tmdb.org/t/p/w58_and_h87_face/<?php echo $MOVIE['poster_path']; ?>" crossorigin="anonymous" width="58" height="87">
            <span id="movie-details">
                <span style="display: block;">
                    <a id="title"><?=$title?></a>
                    <span id="year">(<?=substr($date, 0, 4)?>)</span>
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

    <div id="list-container">
        <div id="list-wrapper">
            <div>
                <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Cast <span style="font-weight: 400; opacity: 0.6;"><?php echo count($MOVIE_CAST_CREW['cast']); ?></span></h3>
                <ol class="people" id="cast">
                    <?php 
                        foreach($MOVIE_CAST_CREW['cast'] as $cast){
                            echo '<li>';
                            if($cast['profile_path']){
                                echo '<a href="/mdb/person/' . $cast['id'] . '"><img src="https://image.tmdb.org/t/p/w66_and_h66_face' . $cast['profile_path'] . '"></a>';
                            }
                            else{
                                echo '<a><img src="../../images/person.svg" width=66 height=66 style="background-color: lightgrey;"></a>';
                            }
                            echo '<div>';
                            echo '<div class="info">';
                            echo '<p><a>' . $cast['name'] . '</a></p>';
                            if(array_key_exists("character", $cast))
                                echo  '<p>' . $cast["character"] . '</p>';
                            else
                                echo '<p>' . $cast["roles"][0]["character"] . '</p>';
                            echo '</div></div></li>';
                        }
                    ?>
                </ol>
            </div>
            <div>
                <h3 style="font-size: 22.4px; margin: 0 0 25px; font-weight: 600;">Crew <span style="font-weight: 400; opacity: 0.6;"><?php echo count($MOVIE_CAST_CREW['crew']); ?></span></h3>
                <ol class="people" id="crew">
                    <?php 
                        foreach($MOVIE_CAST_CREW['crew'] as $crew){
                            echo '<li>';
                            if($crew['profile_path']){
                                echo '<a href="/mdb/person/' . $crew['id'] . '"><img src="https://image.tmdb.org/t/p/w66_and_h66_face' . $crew['profile_path'] . '"></a>';
                            }
                            else{
                                echo '<a><img src="../../images/person.svg" width=66 height=66 style="background-color: lightgrey;"></a>';
                            }
                            echo '<div>';
                            echo '<div class="info">';
                            echo '<p><a>' . $crew['name'] . '</a></p>';
                            if(array_key_exists("job", $crew))
                                echo  '<p>' . $crew["job"] . '</p>';
                            else
                                echo '<p>' . $crew["jobs"][0]["job"] . '</p>';
                            echo '</div></div></li>';
                        }
                    ?>
                </ol>
            </div>
        </div>
    </div>

    <?php include 'src/Views/footer.html'; ?>

</body>

</html>