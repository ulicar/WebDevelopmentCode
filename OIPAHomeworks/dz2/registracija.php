<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'validate/validate.php';
require_once 'app/reg_handler.php';

var_dump($_POST);
if ($_POST){
    $data = $_POST;
    $rules = array(
            'username' => 'required|max_length[15]',
            'password' => 'required|min_length[8]',
            'ime' => '',
            'prezime' => '',
            'email'   => '', //isEmail
            'url'    => '' //isUrl
        );
        if (!validate($data, $rules)) {
            if(registerUser($data["username"], $data["password"],
                    $data["ime"], $data["prezime"], $data["email"], $data["url"])){
                echo "Registiran!";
                echo "<a href=\"index.php\"> Povratak </a>";
                
            }
        }
}