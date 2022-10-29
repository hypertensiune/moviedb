<?php
    $knwon_for = $PERSON_CREDITS['cast'];
    $credits = $PERSON_CREDITS['cast'];
    $production_credits = $PERSON_CREDITS['crew'];

    $aux = array();
    foreach($knwon_for as $credit){
        $aux[] = $credit['vote_count'];
    }

    array_multisort($aux, SORT_DESC, $knwon_for);

    $aux = array();
    foreach($credits as $credit){
        if(array_key_exists("release_date", $credit))
            $aux[] = $credit["release_date"];
        else
            $aux[] = $credit["first_air_date"];
    }

    array_multisort($aux, SORT_DESC, $credits);

    $aux = array();
    foreach($production_credits as $credit){
        if(array_key_exists("release_date", $credit))
            $aux[] = $credit["release_date"];
        else
            $aux[] = $credit["first_air_date"];
    }

    array_multisort($aux, SORT_DESC, $production_credits);

    function echoTable($data, $type){
        echo '<table class="full-credits-table">';

        $c = $type == "cast" ? "character" : "job";
        $s = $type == "cast" ? "as " : "...";
        $last_year = "";
        foreach($data as $element){
            $year = null;
            $name = null;
            if(array_key_exists("release_date", $element)){
                $year = substr($element["release_date"], 0, 4);
                $name = $element["title"];
                $path = "movie/";
            }
            else{
                $year = substr($element["first_air_date"], 0, 4);
                $name = $element["name"];   
                $path = "tv/";
            }

            if($year != $last_year){
                echo "</tbody><tbody>";
            }

            echo "<tr>";
            echo "<td class='year'>" . $year . "</td>";
            echo "<td class='separator'><i class='fa-regular fa-circle'></i></td>";
            echo "<td><a href='../" . $path . $element['id'] . "'>" . $name . "</a><span>" . $s . $element[$c] . "</span></td>";
            echo "</tr>";

            $last_year = $year;
        }

        echo '</table>';
    }

    function echoHeader($str){
        echo '<h3 style="font-size: 1.3em; margin: 0; font-weight: 600;">' .$str . '</h3>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$PERSON['name']?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/person.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>
<body>
    
    <?php include 'src/Views/header.php'; ?>

    <div id="container">
        <div id="wrapper">
            <div id="c1">
                <div id="img-holder">
                    <img id="img" src="https://www.themoviedb.org/t/p/w300_and_h450_bestv2/<?php echo $PERSON['profile_path']; ?>">
                </div>
                <h2 id="name-c1"><?php echo $PERSON['name']; ?></h2>
                <div id="facts">
                    <div id="social-media">
                        <a><i class="fa-brands fa-square-facebook"></i></a>
                        <a><i class="fa-brands fa-twitter"></i></a>
                        <a><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <div id="personal-info">
                        <p><strong>Known For</strong><br><?php echo $PERSON['known_for_department']; ?></p>
                        <p><strong>Known Credits</strong><br><?php echo count($PERSON_CREDITS['cast']); ?></p>
                        <p><strong>Gender</strong><br><?php if($PERSON['gender'] == 1) echo "Female"; else if($PERSON['gender'] == 2) echo "Male"; else echo "Not set"; ?></p>
                        <p><strong>Birthday</strong><br><?php echo $PERSON['birthday'] . " (" . date("Y") - substr($PERSON['birthday'], 0, 4) . " years old)"; ?></p>
                        <p><strong>Place of Birth</strong><br><?php echo $PERSON['place_of_birth']; ?></p>
                    </div>
                </div>
                <script>
                    window.addEventListener('load', () => {
                        if(window.innerWidth <= 660){
                            $("#img-holder").css("height", $("#img-holder").css("width"));
                        }
                    })
                    window.addEventListener('resize', () => {
                        if(window.innerWidth <= 660){
                            $("#img-holder").css("height", $("#img-holder").css("width"));
                        }
                        else{
                            $("#img-holder").css("height", "unset");
                        }
                    });
                </script>
            </div>
            <div id="c2">
                <h2 id="name-c2"><?php echo $PERSON['name']; ?></h2>
                <div id="biography-wrapper">
                    <h3 style="font-size: 1.3em; margin: 0 0 8px 0; font-weight: 600;">Biography</h3>
                    <div id="bio" class="should_fade">
                        <?php 
                            $bio = $PERSON['biography'];
                            $tok = strtok($bio, "\n\n");
                            while($tok !== false){
                                echo '<p>' . $tok . '</p>';
                                $tok = strtok("\n\n");
                            }
                        ?>
                    </div>
                    <div id="read-more">
                        <a onclick="showMore()">Read more <i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                    <script>
                        function showMore(){
                            $("#bio").css("max-height", "none");
                            $("#read-more").css("display", "none");
                        }
                    </script>
                </div>
                <div id="known-for-movies">
                    <h3 style="font-size: 1.3em; margin: 0; font-weight: 600;">Known For</h3>
                    <div id="known-for-wrapper" class="should-fade is-fading" style="position: relative;">
                        <ol id="known-for-list" class="olist">
                            <?php
                                $k = 0;
                                for($i = 0; $i < count($knwon_for) && $k < 10; $i++){
                                    if($knwon_for[$i]['media_type'] == "movie"){
                                        $t = $knwon_for[$i]['title'];
                                        $path = "movie/";
                                    }
                                    else{
                                        $t = $knwon_for[$i]['name'];
                                        $path = "tv/";
                                    }
                                    $k++;
                                    echo '<li class="movie-card">';
                                    echo '  <a href=../' . $path . $knwon_for[$i]['id'] . '><img src="https://www.themoviedb.org/t/p/w150_and_h225_bestv2/' . $knwon_for[$i]['poster_path'] . '" width="130" height="195"></a>';
                                    echo '  <a href=../' . $path . $knwon_for[$i]['id'] . '><p style="margin: 0; text-align: center;">' . $t . '</a></p>';
                                    echo '</li>';
                                }
                            ?>
                        </ol>
                    </div>
                    <script>
                        $("#known-for-list").scroll(function() {
                            if ($("#known-for-list").scrollLeft() > 6) {
                                $("#known-for-wrapper").removeClass("is-fading").addClass("is-hidden");
                            } else {
                                $("#known-for-wrapper").addClass("is-fading").removeClass("is-hidden");
                            }
                        });
                    </script>
                </div>
                <div id="full-credits">
                    <?php
                        if($PERSON['known_for_department'] == "Acting"){
                            echoHeader("Acting");
                            echoTable($credits, "cast");

                            echoHeader("Production");
                            echoTable($production_credits, "crew");
                        }
                        else{
                            $departments = array();
                            foreach($production_credits as $credit){
                                if(array_key_exists($credit["department"], $departments)){
                                    $departments[$credit["department"]]++;
                                }
                                else{
                                    $departments[$credit["department"]] = 1;
                                }
                            }

                            foreach($departments as $key => $value){
                                $department_credits = array();
                                foreach($production_credits as $credit){
                                    if($credit["department"] == $key){
                                        $department_credits[] = $credit;
                                    }
                                }
                                
                                echoHeader($key);
                                echoTable($department_credits, "crew");
                            }

                            echoHeader("Acting");
                            echoTable($credits, "cast");
                        }
    
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'src/Views/footer.html'; ?>

</body>
</html>