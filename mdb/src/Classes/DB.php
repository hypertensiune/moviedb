<?php

    class DB{
        private $conn = null;

        public function __construct(){
            $ini = parse_ini_file("src/config.ini");

            $hostname = $ini['hostname'];
            $username = $ini['username'];
            $pass = $ini['password'];
            $db = $ini['database'];

            $this->conn = new mysqli($hostname, $username, $pass, $db);

            if($this->conn->connect_error){
                die("Connection failed");
            }
        }

        public function userExits($username){
            $username = $this->conn->real_escape_string($username);

            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->conn->stmt_init();

            if(!$stmt->prepare($sql)){
                exit();
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();

            $res = $stmt->get_result();

            if($r = $res->fetch_assoc()){
                return $r;
            }
            else{
                return false;
            }
        }

        public function addUser($username, $email, $pass){
            $username = $this->conn->real_escape_string($username);
            $email = $this->conn->real_escape_string($email);

            $sql = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->stmt_init();

            if(!$stmt->prepare($sql)){
                exit();
            }   

            $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

            $stmt->bind_param("sss", $username, $email, $pass_hashed);
            $stmt->execute();

            $sql = "CREATE TABLE $username (id INT AUTO_INCREMENT PRIMARY KEY, listname VARCHAR(50), list VARCHAR(1000))";
            $this->conn->query($sql);

            $sql = "INSERT INTO $username (listname, list) VALUES ('bookmark', ''), ('favorites', '')";
            $this->conn->query($sql);

        }

        public function addToList($id, $listname, $user){
            $sql = "SELECT * FROM $user WHERE listname = '$listname'";
            $res = $this->conn->query($sql);

            $res = $res->fetch_all(MYSQLI_ASSOC);

            $list = $res[0]['list'];
            $list_e = explode('/', $list);

            $repeats = false;
            foreach($list_e as $l){
                if($id == $l){
                    $repeats = true;
                }
            }

            if(!$repeats){
                $list .= $id . '/';
                $sql = "UPDATE $user SET list = '$list' WHERE listname = '$listname'";
                $res = $this->conn->query($sql);
            }
        }

        public function getList($listname, $user){
            $sql = "SELECT * FROM $user WHERE listname = '$listname'";
            $res = $this->conn->query($sql);

            $res = $res->fetch_assoc();

            return $res;
        }

        public function removeFromList($id, $listname, $user){
            $sql = "SELECT * FROM $user WHERE listname = '$listname'";
            $res = $this->conn->query($sql);

            $res = $res->fetch_all(MYSQLI_ASSOC);

            $list = $res[0]['list'];
            $list_e = explode('/', $list);

            array_splice($list_e, array_search($id, $list_e), 1);

            $list = "";
            foreach($list_e as $l){
                if(!empty($l))
                    $list .= $l . '/';
            }

            $sql = "UPDATE $user SET list = '$list' WHERE listname = '$listname'";
            $res = $this->conn->query($sql);
        }
    }

?>