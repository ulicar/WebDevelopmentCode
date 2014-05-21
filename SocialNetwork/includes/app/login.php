<?php
session_start();
require_once 'helpers/reg_handler.php';
require_once 'helpers/strings.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($_REQUEST === $_POST and array_key_exists("user", $_POST) and 
        array_key_exists("pass", $_POST)){
    if(logIn(clean($_POST["user"]),clean($_POST["pass"])) === True){
        header("Location: http://localhost/Testiranja/DZ2/profile.php?user=" . 
        clean($_POST["user"]));
    }  else {
        echo "Login FAILED! User doesn't exist";
    }
    
}