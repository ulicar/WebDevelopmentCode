<?php
require_once 'profile_handler.php';

if($_REQUEST === $_POST and array_key_exists("user", $_POST) and 
        array_key_exists("friend", $_POST)){
    if(clean($_POST["user"]) !== clean($_POST["friend"])){     
        sendFriendRequest(clean($_POST["user"]), clean($_POST["friend"]));
        header('Location: http://localhost/Testiranja/DZ2/profile.php');   
    } else {
        echo "Cannot send requesto to yourself!";
    }
}
