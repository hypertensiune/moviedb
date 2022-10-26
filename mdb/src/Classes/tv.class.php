<?php

    class TV{
        public static $API_BASE_URL = "https://api.themoviedb.org/3/tv/";
        public static $API_KEY = "d5da50d38ab038fd755da73db3a0f1df";

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

        public static function getDetails($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getCredits($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "/aggregate_credits?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getIframe($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "/videos?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getRecommendations($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "/recommendations?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getKeywords($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "/keywords?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getReviews($tv_id){
            $curl = curl_init(self::$API_BASE_URL . $tv_id . "/reviews?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function echoCardsAll($results){
            foreach($results as $result){
                self::echoCards($result['name'], $result['first_air_date'], $result['poster_path'], $result['id']);
            }
        }

        public static function echoCards($title, $release_date, $poster_path, $id){
            echo <<<HTML
                <div class="card">
                    <div class="image">
                        <a href="./tv/$id">
                            <img src="https://www.themoviedb.org/t/p/w220_and_h330_face/$poster_path"></img>
                        </a>
                    </div>
                    <div class="details">
                        <a href="./tv/$id">$title</a>
                        <p>$release_date</p>
                    </div>
                </div>
            HTML;
        }
    }

?>