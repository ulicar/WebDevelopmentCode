<?php
require_once 'profile_handler.php';

if($_REQUEST === $_POST and isset($_POST["user"]) and isset($_POST["picture"])){
    
    likePicture( clean($_POST["user"]), clean($_POST["picture"]));
    header("Location: http://localhost/Testiranja/DZ2/profile.php");
 }
