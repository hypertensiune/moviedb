<?php

    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['action'])){
        header('HTTP/1.0 403 Forbidden');
        die();
    }

    require "src/Classes/DB.php";

    $db = new DB();

    $username = $_POST['username'];
    $pass = $_POST['password'];

    $res = $db->userExits($username);

    if($_POST['action'] == "login"){
        if(!$res)
            echo false;
        else{
            if(password_verify($pass, $res['password'])){
                $_SESSION['username'] = $username;
                echo "u/" . $username;
            }
            else{
                echo false;
            }
        }
    }
    else if($_POST['action'] == "register"){
        if($res || !isset($_POST['email']))
            echo false;
        else if(!$db->userExits($username)){
            $db->addUser($username, $_POST['email'], $pass);
            echo true;
        }
        else
            echo false;
    }
    
?>