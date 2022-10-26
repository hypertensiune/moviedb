<?php
    function echoReview($author_name, $author_img, $date, $content, $i, $full = false){
        echo <<<HTML
            <div class="review-card $i">
                <div class="review-header">
                    <a><img style='border-radius: 50%;' width=64 height=64 src=$author_img></img></a>
                    <div style="width: 100%; margin-left: 20px;">
                        <a style='font-size: 21px; font-weight: 700;'>A review by $author_name</a>
                        <div style='font-size: 14px; font-weight: 500;'>Written by $author_name on $date</div>
                    </div>    
                </div>
                <div class='review-content'>
        HTML;

        if($full || strlen($content) <= 600){
            echo nl2br($content);
        }
        else{
            echo nl2br(substr($content, 0, 600)) . "..." . "<a onclick=readTheRest($i) style='text-decoration: underline; cursor: pointer;'>read the rest</a>";
        }
        
        echo "</div></div>";
    }

    function getReviewDetails($review){
        $author_img = $review['author_details']['avatar_path'];
        if(strstr($author_img, "https"))
            $author_img = substr($author_img, 1);
        else
            $author_img = "https://image.tmdb.org/t/p/w64_and_h64_face" . $author_img;

        $author_name = $review['author'];
        $date = substr($review['created_at'], 0, 10);
        $content = $review['content'];

        return [$author_name, $author_img, $date, $content];
    }

    $title = array_key_exists("title", $MOVIE) ? $MOVIE['title'] : $MOVIE['name'];
    $date = array_key_exists("release_date", $MOVIE) ? $MOVIE['release_date'] : $MOVIE['first_air_date'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/reviews.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</head>

<body>

    <?php 
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $rd = getReviewDetails($MOVIE_REVIEWS[$id]);
        
            echo '<div id="readFullReview">';
            echoReview($rd[0], $rd[1], $rd[2], $rd[3], "full", true);
            echo '</div>'; 
        }

    ?>

    <?php include 'src/Views/header.html'; ?>

    <div id="movie-top">
        <div id="wrapper">
            <img id="poster-img" src="https://image.tmdb.org/t/p/w58_and_h87_face/<?=$MOVIE['poster_path']; ?>" crossorigin="anonymous" width="58" height="87">
            <span id="movie-details">
                <span style="display: block;">
                    <a id="title"><?=$title; ?></a>
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

    <div id="reviews-holder">
        <div id="reviews-wrapper">
            <?php
                $k = 0;
                foreach($MOVIE_REVIEWS as $review){
                    $rd = getReviewDetails($review);

                    echoReview($rd[0], $rd[1], $rd[2], $rd[3], $k);
                    $k++;
                }

            ?>
        </div>
    </div>

    <?php include 'src/Views/footer.html'; ?>

    <script>
        let urlParams = new URLSearchParams(window.location.search);

        function readTheRest(id){
            urlParams.set('id', id);
            window.location.search = urlParams;
        }

        $(".full").on('click', function(){
            urlParams.delete('id');
            window.location.search = urlParams;
        });

        $(() => {
            if(urlParams.has('id')){
                $("body").css("overflow", "hidden");
                //$(".review-card").css("pointer-events", "none");
            }
        });
    </script>

</body>

</html>