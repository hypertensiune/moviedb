<?php

    class Search{
        public static $API_BASE_URL = "https://api.themoviedb.org/3/search/";
        public static $API_KEY = "";

        public static function getMovies($query, $page = 1){
            $query = urlencode($query);

            $curl = curl_init(self::$API_BASE_URL . "movie?api_key=" . self::$API_KEY . "&query=" . $query . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getTV($query, $page = 1){
            $query = urlencode($query);

            $curl = curl_init(self::$API_BASE_URL . "tv?api_key=" . self::$API_KEY . "&query=" . $query . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getPeople($query, $page = 1){
            $query = urlencode($query);

            $curl = curl_init(self::$API_BASE_URL . "person?api_key=" . self::$API_KEY . "&query=" . $query . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function echoSearchResults($data, $type){
            foreach($data['results'] as $d){

                $id = $d['id'];
            
                if($type == "movie"){
                    $title = $d['title'];
                    $release_date = $d['release_date'];
                    $poster_path = $d['poster_path'];
                    $overview = $d['overview'];
                }
                else if($type == "tv"){
                    $title = $d['name'];
                    $release_date = $d['first_air_date'];
                    $poster_path = $d['poster_path'];
                    $overview = $d['overview'];
                }
                else if($type == "person"){
                    $title = $d['name'];
                    $release_date = $d['known_for_department'];
                    $poster_path = $d['profile_path'];
                    $overview = "";
                    $k = 0;
                    foreach($d['known_for'] as $credit){
                        if(array_key_exists('original_title', $credit))
                            $overview .= $k == 0 ? $credit['original_title'] : ',  ' . $credit['original_title'];
                        else
                            $overview .= $k == 0 ? $credit['original_name'] : ',  ' . $credit['original_name'];
                        $k = 1;
                    }
                }

                self::echoSearchResultsHTML($id, $poster_path, $title, $release_date, $overview, $type);
            }

            if($data['total_pages'] > 1)
                self::echoPages($data['total_pages'], $data['page']);
        }

        public static function echoSearchResultsHTML($id, $poster_path, $title, $release_date, $overview, $type = "movie"){
            echo <<<HTML
                <div class="movie-card">
                    <div class="wrapper">
                        <div class="image">
                            <a href="./$type/$id">
                                <img src="https://image.tmdb.org/t/p/w94_and_h141_bestv2/$poster_path">
                            </a>
                        </div>
                        <div class="details">
                            <a href="./$type/$id"><h2>$title</h2></a>
                            <span>$release_date</span>
                            <p>$overview</p>
                        </div>
                    </div>
                </div>
            HTML;
        }

        public static function echoPages($n, $c){
            echo '<div class="pages-wrapper">';
            if($c > 1)
                echo "<span id='previous-btn' onclick='changePageHandler(this)'>Previous</span>"; 
            if($c > 4){
                echo "<span class='page-btn 1' onclick='changePageHandler(this)'>1</span>";
                echo "<span class='page-btn 2' onclick='changePageHandler(this)'>2</span>";
                echo "<span>...</span>";
                for($i = $c - 2; $i <= $c + 2 && $i <= $n; $i++){
                    echo "<span class='page-btn $i' onclick='changePageHandler(this)'>$i</span>";
                }
                
            }
            else{
                for($i = 1; $i <= 5 && $i <= $n; $i++){
                    echo "<span class='page-btn $i' onclick='changePageHandler(this)'>$i</span>";
                }
            }

            if($n > 6 && $c < $n - 2){
                echo "<span>...</span>";
                $n--;
                echo "<span class='page-btn $n' onclick='changePageHandler(this)'>$n</span>";
                $n++;
                echo "<span class='page-btn $n' onclick='changePageHandler(this)'>$n</span>";
            }
            
            if($c < $n)
                echo "<span id='next-btn' onclick='changePageHandler(this)'>Next</span>";
            echo '</div>';
        }
    }

?>