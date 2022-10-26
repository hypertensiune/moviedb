<?php

    class Person{
        public static $API_BASE_URL = "https://api.themoviedb.org/3/person/";
        public static $API_KEY = "d5da50d38ab038fd755da73db3a0f1df";

        public static function getDetails($person_id){
            $curl = curl_init(self::$API_BASE_URL . $person_id . "?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }

        public static function getCredits($person_id){
            $curl = curl_init(self::$API_BASE_URL . $person_id . "/combined_credits?api_key=" . self::$API_KEY);
            $res = EXEC_CURL($curl);

            return json_decode($res, true);
        }
    }

?>