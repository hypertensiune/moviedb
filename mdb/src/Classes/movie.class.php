<?php 

    class Movie{
        public static $API_BASE_URL = "https://api.themoviedb.org/3/movie/";
        public static $API_KEY = "";

        public static function getPopular($page = 1){
            $curl = curl_init(self::$API_BASE_URL . "/popular" . "?api_key=" . self::$API_KEY . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getUpcoming($page = 1){
            $curl = curl_init(self::$API_BASE_URL . "/upcoming" . "?api_key=" . self::$API_KEY . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getTopRated($page = 1){
            $curl = curl_init(self::$API_BASE_URL . "/top_rated" . "?api_key=" . self::$API_KEY . "&page=" . $page);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getDetails($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getCredits($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/credits?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getIframe($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/videos?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getRecommendations($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/recommendations?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getKeywords($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/keywords?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getReviews($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/reviews?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getExternalIDs($movie_id){
            $curl = curl_init(self::$API_BASE_URL . $movie_id . "/external_ids?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function echoCardsAll($results){
            foreach($results as $result){
                self::echoCards($result['title'], $result['release_date'], $result['poster_path'], $result['id']);
            }
        }

        public static function echoCards($title, $release_date, $poster_path, $id){
            $release_date = date('F j, Y', strtotime($release_date));
            echo <<<HTML
                <div class="card">
                    <div class="image">
                        <a href="./movie/$id">
                            <img src="https://www.themoviedb.org/t/p/w220_and_h330_face/$poster_path"></img>
                        </a>
                    </div>
                    <div class="details">
                        <a href="./movie/$id">$title</a>
                        <p>$release_date</p>
                    </div>
                </div>
            HTML;
        }
    }

?>