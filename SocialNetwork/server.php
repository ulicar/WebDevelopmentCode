<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getAllUsers() {
    if (isset($_GET) and isset($_GET["names"]) and $_GET["names"] == "all"){
        $users = "";
        $text = unserialize(file_get_contents('includes/files/users.txt'));
        if(is_array($text)){
            $users = implode("<br>", array_keys($text));            
        }
        return $users;
    }
}

echo getAllUsers();