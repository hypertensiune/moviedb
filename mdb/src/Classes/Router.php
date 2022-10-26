<?php

    class Router{

        private $handlers;

        function __construct() {}
        
        public function get(string $path, $handler, bool $rgx = false){
            $this->handlers['GET' . $path] = [
                'path' => $path,
                'method' => 'GET',
                'handler' => $handler,
                'rgx' => $rgx
            ];
        }

        public function post(string $path, $handler, bool $rgx = false){
            $this->handlers['POST' . $path] = [
                'path' => $path,
                'method' => 'POST',
                'handler' => $handler,
                'rgx' => $rgx
            ];
        }

        public function run(){
            $uri = parse_url($_SERVER['REQUEST_URI']);
            $path = $uri['path'];
            $method = $_SERVER['REQUEST_METHOD'];
            
            $cb = null;
            foreach($this->handlers as $handler){
                if(!$handler['rgx']){
                    if($handler['path'] == $path && $handler['method'] == $method){
                        $cb = $handler['handler'];
                    }
                }
                else{
                    if(preg_match($handler['path'], $path) && $handler['method'] == $method){
                        $cb = $handler['handler'];
                    }
                }
            }

            if(!$cb){
                http_response_code(404);
                include 'src/Views/error.php';
                exit();
            }

            call_user_func_array($cb, [array_merge($_GET, $_POST)]);
        }
    }

?>