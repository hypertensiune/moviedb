<?php

use function PHPSTORM_META\type;

    function echoList($data){
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
            <div class="card">
                <a href=$href><img src="https://www.themoviedb.org/t/p/w220_and_h330_face/$poster"></a>
                <a href=$href>$title</a>
                <p>$release_date</p>
            </div>
        HTML;
    }

    function getData($data){
        $RES = array();
        $i = 0;
        foreach($data as $d){
            if(!empty($d)){
                if($d[0] == 'm'){
                    $RES[$i] = Movie::getDetails(substr($d, 1));
                    $RES[$i]['media_type'] = "movie";
                }
                else if($d[0] == 't'){
                    $RES[$i] = TV::getDetails(substr($d, 1));
                    $RES[$i]['media_type'] = "tv";
                }
                $i++;
            }
        }
        return $RES;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/user.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</head>
<body>
    
    <?php include 'src/Views/header.php'; ?>

    <?php

        require "src/Classes/DB.php";

        $db = new DB();

        $favorites = $db->getList("favorites", $_SESSION['username'])['list'];
        $bookmarks = $db->getList("bookmark", $_SESSION['username'])['list'];

        $favorites = explode('/', $favorites);
        $bookmarks = explode('/', $bookmarks);

        $FAVORITES = getData($favorites);
        $BOOKMARKS = getData($bookmarks);
        
    ?>

    <div id="lists-container">
        <div id="lists-wrapper">
            <div style="display: flex; justify-content: flex-start;">
                <h2>Your lists</h2>
                <div class="selector">
                    <a class="active">Favorites</a>
                    <a>Bookmark</a>
                </div>
            </div>
            <div class="results">
                <?php
                    foreach($FAVORITES as $favorite){
                        if($favorite['media_type'] == "movie")
                            Movie::echoCards($favorite['title'], $favorite['release_date'], $favorite['poster_path'], $favorite['id']);
                        else
                            TV::echoCards($favorite['name'], $favorite['first_air_date'], $favorite['poster_path'], $favorite['id']);    
                    }
                ?>
            </div>
            <div class="results hidden">
                <?php
                    foreach($BOOKMARKS as $bookmark){
                        if($bookmark['media_type'] == "movie")
                            Movie::echoCards($bookmark['title'], $bookmark['release_date'], $bookmark['poster_path'], $bookmark['id']);
                        else
                            TV::echoCards($bookmark['name'], $bookmark['first_air_date'], $bookmark['poster_path'], $bookmark['id']);    
                    }
                ?>
            </div>
        </div>
    </div>
    <script>
        $(".selector a").click(function(){
            $(".selector a").removeClass("active");
            $(this).addClass("active");
            $("div.results").toggleClass("hidden");
        });
    </script>
    
    <?php include 'src/Views/footer.html'; ?>
</body>
</html>