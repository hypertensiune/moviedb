<?php

    require_once 'src/Classes/Router.php';
    require_once 'src/Classes/Api.php';

    $router = new Router();

    $rgx_movie = "~\/movie$~";
    $rgx_movie_load_more = "~\/movie\/load_more$~";
    $rgx_movie_id = "~\/movie\/[0-9]+$~";
    $rgx_movie_iframe = "~\/movie\/[0-9]+\/get_iframe~";
    $rgx_movie_cast = "~\/movie\/[0-9]+\/cast$~";
    $rgx_movie_reviews = "~\/movie\/[0-9]+\/reviews$~";

    $rgx_tv = "~\/tv$~";
    $rgx_tv_load_more = "~\/tv\/load_more$~";
    $rgx_tv_id = "~\/tv\/[0-9]+$~";
    $rgx_tv_iframe = "~\/tv\/[0-9]+\/get_iframe~";
    $rgx_tv_cast = "~\/tv\/[0-9]+\/cast$~";
    $rgx_tv_reviews = "~\/tv\/[0-9]+\/reviews$~";
    $rgx_tv_seasons = "~\/tv\/[0-9]+\/seasons$~";
    $rgx_person = "~\/person\/[0-9]+$~";

    $rgx_user = "~\/u\/[A-Za-z0-9]+$~";
    $rgx_user_controller = "~\/u\/[A-Za-z0-9]+\/[a-z]+$~";

    session_start();

    function check(...$p){
        foreach($p as $v){
            if($v == null || (array_key_exists("success", $v) && !$v['success']))
                return false;
        }
        return true;
    }

    $router->get("/mdb/", function(){
        $TRENDING_TODAY = getTrending("day");
        $TRENDING_WEEK = getTrending("week");

        $POPULAR_MOVIES = Movie::getPopular();
        $POPULAR_TV = TV::getPopular();

        require "src/Views/home.php";
    });

    $router->get("/mdb/login", function(){
        require "src/Views/account/login.php";
    });

    $router->get("/mdb/logout", function(){
        unset($_SESSION['username']);
        header("Location: /mdb/");
        die();
    });

    $router->get("/mdb/register", function(){
        require "src/Views/account/register.php";
    });

    $router->get($rgx_user, function(){
        if(isset($_SESSION['username']))
            require "src/Views/account/user.php";
        else{
            require "src/Views/error.php";
        }
    }, true);

    $router->post($rgx_user_controller, function(){
        if(isset($_SESSION['username']))
            require "src/Controllers/user.php";
        else{
            require "src/Views/error.php";
        }
    }, true);


    $router->post("/mdb/login_register_controller", function(){
        require "src/Controllers/login_register_controller.php";
    });

    // ====================== SEARCH ================

    $router->get("/mdb/search", function(){
        if(!isset($_GET['query']) || $_GET['query'] == ""){
            require "src/Views/error.php";
            die();
        }

        $query = $_GET['query'];

        $SEARCH_MOVIES = Search::getMovies($query);
        $SEARCH_TV = Search::getTV($query);
        $SEARCH_PEOPLE = Search::getPeople($query);

        $filter = "movie";
        if($SEARCH_TV['total_results'] > $SEARCH_MOVIES['total_results'])
            $filter = "tv";
        if($SEARCH_PEOPLE['total_results'] > $SEARCH_TV['total_results'])
            $filter = "person";

        require "src/Views/search.php";
    });

    $router->get("/mdb/search/get_page", function(){
        if($_GET['filter'] == "movie")
            $RES = Search::getMovies($_GET['query'], $_GET['page']);        
        else if($_GET['filter'] == "tv")
            $RES = Search::getTV($_GET['query'], $_GET['page']);
        else if($_GET['filter'] == "person")
            $RES = Search::getPeople($_GET['query'], $_GET['page']);        

        Search::echoSearchResults($RES, $_GET['filter']);
    });


    // ================== MOVIE =====================

    $router->get($rgx_movie, function(){
        if(!isset($_GET['filter'])){
            $_GET['filter'] = "popular";
        }

        if($_GET['filter'] == "popular")
            $RES = Movie::getPopular();
        else if($_GET['filter'] == "upcoming")
            $RES = Movie::getUpcoming();
        else if($_GET['filter'] == "top-rated")
            $RES = Movie::getTopRated();

        $TYPE = "movie";

        require "src/Views/movie/movie.php";
    }, true);

    $router->get($rgx_movie_load_more, function(){
        if(!isset($_GET['filter']) || !isset($_GET['page'])){
            require 'src/Views/error.php';
            die();
        }

        if($_GET['filter'] == "popular")
            $RES = Movie::getPopular();
        else if($_GET['filter'] == "upcoming")
            $RES = Movie::getUpcoming();
        else if($_GET['filter'] == "top-rated")
            $RES = Movie::getTopRated();

        Movie::echoCardsAll($RES['results']);

    }, true);

    $router->get($rgx_movie_id, function(){

        $movie_id = basename($_SERVER['REQUEST_URI']);

        $MOVIE = Movie::getDetails($movie_id);
        $MOVIE_CAST_CREW = Movie::getCredits($movie_id);
        $MOVIE_RECOMMENDATIONS = Movie::getRecommendations($movie_id);
        $MOVIE_KEYWORDS = Movie::getKeywords($movie_id);
        $MOVIE_REVIEWS = Movie::getReviews($movie_id);
        $MOVIE_EIDS = Movie::getExternalIDs($movie_id);

        if(!check($MOVIE, $MOVIE_CAST_CREW, $MOVIE_RECOMMENDATIONS, $MOVIE_KEYWORDS, $MOVIE_REVIEWS)){
            require 'src/Views/error.php';
            die();
        }

        $MOVIE_RECOMMENDATIONS = $MOVIE_RECOMMENDATIONS['results'];
        $MOVIE_KEYWORDS = $MOVIE_KEYWORDS['keywords'];
        $MOVIE_REVIEWS = $MOVIE_REVIEWS['results'];

        $_SESSION['TYPE'] = "MOVIE";
        $_SESSION['id'] = $movie_id;
        $_SESSION['MOVIE'] = $MOVIE;
        $_SESSION['MOVIE_CAST_CREW'] = $MOVIE_CAST_CREW;
        $_SESSION['MOVIE_RECOMMENDATIONS'] = $MOVIE_RECOMMENDATIONS;
        $_SESSION['MOVIE_KEYWORDS'] = $MOVIE_KEYWORDS;
        $_SESSION['MOVIE_REVIEWS'] = $MOVIE_REVIEWS;
        
        require "src/Views/movie/movie_detailed.php";

    }, true);

    $router->get($rgx_movie_cast, function(){
        
        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/cast")));

        if(!isset($_SESSION['id']) || $_SESSION['TYPE'] != "MOVIE"){
            $MOVIE = Movie::getDetails($movie_id);
            $MOVIE_CAST_CREW = Movie::getCredits($movie_id);
        }
        else{
            $MOVIE = $_SESSION['MOVIE'];
            $MOVIE_CAST_CREW = $_SESSION['MOVIE_CAST_CREW'];

            if(!check($MOVIE, $MOVIE_CAST_CREW)){
                require 'src/Views/error.php';
                die();
            }
        }

        include "src/Views/movie/cast.php";

    }, true);

    $router->get($rgx_movie_reviews, function(){

        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/reviews")));

        if(!isset($_SESSION['id']) || $_SESSION['TYPE'] != "MOVIE"){
            $MOVIE_REVIEWS = Movie::getReviews($movie_id)['results'];
            $MOVIE = Movie::getDetails($movie_id);
        }
        else{
            $MOVIE_REVIEWS = $_SESSION['MOVIE_REVIEWS'];
            $MOVIE = $_SESSION['MOVIE'];

            if(!check($MOVIE, $MOVIE_REVIEWS)){
                require 'src/Views/error.php';
                die();
            }
        }

        include "src/Views/movie/reviews.php";

    }, true);

    $router->get($rgx_movie_iframe, function(){
        
        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/get_iframe")));

        $TYPE = "MOVIE";

        include "src/Views/movie/iframe.php";

    }, true);




    // ================== TV =====================

    $router->get($rgx_tv, function(){
        if(!isset($_GET['filter'])){
            $_GET['filter'] = "popular";
        }

        if($_GET['filter'] == "popular")
            $RES = TV::getPopular();
        else if($_GET['filter'] == "upcoming")
            $RES = TV::getUpcoming();
        else if($_GET['filter'] == "top-rated")
            $RES = TV::getTopRated();

        $TYPE = "tv";

        require "src/Views/movie/movie.php";
    }, true);

    $router->get($rgx_tv_load_more, function(){
        if(!isset($_GET['filter']) || !isset($_GET['page'])){
            require 'src/Views/error.php';
            die();
        }

        if($_GET['filter'] == "popular")
            $RES = TV::getPopular();
        else if($_GET['filter'] == "upcoming")
            $RES = TV::getUpcoming();
        else if($_GET['filter'] == "top-rated")
            $RES = TV::getTopRated();

        TV::echoCardsAll($RES['results']);

    }, true);

    $router->get($rgx_tv_id, function(){

        $movie_id = basename($_SERVER['REQUEST_URI']);

        $MOVIE = TV::getDetails($movie_id);
        $MOVIE_CAST_CREW = TV::getCredits($movie_id);
        $MOVIE_RECOMMENDATIONS = TV::getRecommendations($movie_id);
        $MOVIE_KEYWORDS = TV::getKeywords($movie_id);
        $MOVIE_REVIEWS = TV::getReviews($movie_id);
        $MOVIE_EIDS = TV::getExternalIDs($movie_id);

        if(!check($MOVIE, $MOVIE_CAST_CREW, $MOVIE_RECOMMENDATIONS, $MOVIE_KEYWORDS, $MOVIE_REVIEWS)){
            require 'src/Views/error.php';
            die();
        }

        $MOVIE_RECOMMENDATIONS = $MOVIE_RECOMMENDATIONS['results'];
        $MOVIE_KEYWORDS = $MOVIE_KEYWORDS['results'];
        $MOVIE_REVIEWS = $MOVIE_REVIEWS['results'];

        $_SESSION['TYPE'] = "TV";
        $_SESSION['id'] = $movie_id;
        $_SESSION['MOVIE'] = $MOVIE;
        $_SESSION['MOVIE_CAST_CREW'] = $MOVIE_CAST_CREW;
        $_SESSION['MOVIE_RECOMMENDATIONS'] = $MOVIE_RECOMMENDATIONS;
        $_SESSION['MOVIE_KEYWORDS'] = $MOVIE_KEYWORDS;
        $_SESSION['MOVIE_REVIEWS'] = $MOVIE_REVIEWS;

        include "src/Views/movie/movie_detailed.php";

    }, true);

    $router->get($rgx_tv_cast, function(){

        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/cast")));

        if(!isset($_SESSION['id']) || $_SESSION['TYPE'] != "TV"){
            $MOVIE = TV::getDetails($movie_id);
            $MOVIE_CAST_CREW = TV::getCredits($movie_id);
        }
        else{
            $MOVIE = $_SESSION['MOVIE'];
            $MOVIE_CAST_CREW = $_SESSION['MOVIE_CAST_CREW'];

            if(!check($MOVIE, $MOVIE_CAST_CREW)){
                require 'src/Views/error.php';
                die();
            }
        }

        include "src/Views/movie/cast.php";

    }, true); 

    $router->get($rgx_tv_reviews, function(){

        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/reviews")));

        if(!isset($_SESSION['id']) || $_SESSION['TYPE'] != "TV"){
            $MOVIE_REVIEWS = TV::getReviews($movie_id)['results'];
            $MOVIE = TV::getDetails($movie_id);
        }
        else{
            $MOVIE_REVIEWS = $_SESSION['MOVIE_REVIEWS'];
            $MOVIE = $_SESSION['MOVIE'];

            if(!check($MOVIE, $MOVIE_REVIEWS)){
                require 'src/Views/error.php';
                die();
            }
        }

        include "src/Views/movie/reviews.php";

    }, true);

    $router->get($rgx_tv_seasons, function(){
        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/seasons")));

        if(!isset($_SESSION['id']) || $_SESSION['TYPE'] != "TV"){
            $MOVIE = TV::getDetails($movie_id);
        }
        else{
            $MOVIE = $_SESSION['MOVIE'];

            if(!check($MOVIE)){
                require 'src/Views/error.php';
                die();
            }
        }

        include "src/Views/movie/seasons.php";
    }, true);

    $router->get($rgx_tv_iframe, function(){
        
        $movie_id = basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/get_iframe")));
        
        $TYPE = "TV";

        include "src/Views/movie/iframe.php";

    }, true);




    // ================== PERSON =====================

    $router->get($rgx_person, function(){

        $person_id = basename($_SERVER['REQUEST_URI']);

        $PERSON = Person::getDetails($person_id);
        $PERSON_CREDITS = Person::getCredits($person_id);
        $PERSON_EIDS = Person::getExternalIDs($person_id);

        if(!check($PERSON, $PERSON_CREDITS)){
            require 'src/Views/error.php';
            die();
        }

        require 'src/Views/person.php';

    }, true);

    $router->run();

?>