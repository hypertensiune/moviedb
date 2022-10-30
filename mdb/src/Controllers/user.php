<?php

    require_once "src/Classes/Router.php";
    require_once "src/Classes/DB.php";

    $router = new Router();
    $db = new DB();

    $rgx_bookmark = "~\/u\/[A-Za-z0-9]+\/bookmark$~";
    $rgx_favorites = "~\/u\/[A-Za-z0-9]+\/favorites$~";

    $router->post($rgx_bookmark, function() use ($db){
        if($_POST['add'] === "true")
            $db->addToList($_POST['type'] . $_POST['id'], "bookmark", $_SESSION['username']);
        else
            $db->removeFromList($_POST['type'] . $_POST['id'], "bookmark", $_SESSION['username']);
    }, true);

    $router->post($rgx_favorites, function() use ($db){
        if($_POST['add'] === "true")
            $db->addToList($_POST['type'] . $_POST['id'], "favorites", $_SESSION['username']);
        else
            $db->removeFromList($_POST['type'] . $_POST['id'], "favorites", $_SESSION['username']);
    }, true);

    $router->run();
?>