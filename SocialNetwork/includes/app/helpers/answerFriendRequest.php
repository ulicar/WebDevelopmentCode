<?php
require_once 'profile_handler.php';
var_dump($_POST);
require_once 'profile_handler.php';
if ($_REQUEST === $_POST and clean($_POST["answer"]) === "accept"){
    acceptFriendRequest(clean($_POST["user"]), clean($_POST["friend"]));    
} 
else if ($_REQUEST === $_POST and clean($_POST["answer"]) === "decline"){
    removeFriendRequest(clean($_POST["user"]), clean($_POST["friend"]));
}
header("Location: http://localhost/Testiranja/DZ2/profile.php");
?>