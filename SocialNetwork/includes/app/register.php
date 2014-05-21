<?php

require_once 'helpers/reg_handler.php';
require_once 'helpers/strings.php';
require_once 'helpers/profile_handler.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($_REQUEST === $_POST and array_key_exists("user", $_POST) and 
        array_key_exists("pass", $_POST)){
    
    if(registerUser($_POST["user"], $_POST["pass"]) === TRUE){
        createEntry(clean($_POST["user"]), PRIJATELJI);
        createEntry(clean($_POST["user"]), IMGS);
        header("Location: http://localhost/Testiranja/DZ2/index.php");
    }else{
        echo "Reqister Failed! User already exists";
    }
} else {
    echo "Send POST request with USERNAME and PASSWORD!";    
}
