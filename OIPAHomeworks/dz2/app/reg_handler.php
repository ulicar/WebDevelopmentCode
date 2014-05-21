<?php

/*
 *  Predefinirani podaci
 */
//session_start();
define('BAZA', "data/users.txt");


/** 
 * Funkcija za registraciju korisnika i spremanje podataka u bazu korisnika.
 * 
 * @param string $username Korisničko ime novog korisnika
 * @param string $password Lozinka novog korisnika
 * @param string $ime      Ime korisnika
 * @param string $email    Adresa elektronske pošte
 * @param string $url      Adresa Web sjedišta
 * @return boolean true ako novi korisnik registiran uspješno
 */
function registerUser($username, $password, $ime, $prezime, $email, $url = NULL) {
    
    $data = array(
        'username' => $username,
        'password' => sha1($password),
        'first_name' => $ime,
        'last_name' => $prezime,
        'email' => $email,
        'website' => $url,
    );
    
    if(!userExists($username)){
            $file = fopen(BAZA, "a+");
            fprintf($file, "%s\n", serialize($data));
            fclose($file);
            return true;
    }
    return false;
}


/** 
 * Funkcija za prijavljivanje korisnika pretraživanjem baze korisnika (.txt)
 * 
 * @param string $username Korisničko ime
 * @param string $password Lozinka
 * @return boolean true ako korisnik prijavljen uspješno 
 */ 
function logIn($username,$password){
    if(userExists($username) && passwordMatch($username, $password)){
        $_SESSION["username"] = $username;
        //var_dump($_SESSION);
        return true;
    }
    return false;
}


/** 
 * Funkcija za odjavu korisnika
 * 
 * @param string $username Korisničko ime
 * @return boolean ako korisnik uspješno odjavljen
 */
function logOut($username) {
    
    if(userExists($username) && isLoggedIn($username)){
        unset($_SESSION["username"]);
        return true;
    }
    return false;
}


/**
 * Funkcija za provjeru je li korisnik trenuno prijavljen na sustav
 * 
 * @param string $username Korisničko ime
 * @return boolean true ako korisnik trenutno prijavljen na sustav
 */
function isLoggedIn($username) {
    if (userExists($username) && isset($_SESSION["username"]) &&
            $_SESSION["username"] === $username){
        return true;
    }
    return false;
}

/**
 * Funkcija pretražuje BAZU po korisničkom imenu.
 * 
 * @param string $username Korisničko ime
 * @return boolean vraća True ukoliko pronađen korisnik
 */
function userExists($username){
    
    $txt_file = explode("\n",file_get_contents(BAZA));
         
    foreach ($txt_file as $user) {
        $user_s = unserialize($user);
        if($user_s && $user_s["username"] === $username ){
               return true;
        }
    }
    return false;
}

/**
 * Funkcija za provjeru ispravnosti lozinke korisnika.
 * 
 * @param string $username Korisničko ime
 * @param string $password Lozinka
 * @return boolean True ako postoji i korisnik i lozinka ispravna
 */
function passwordMatch($username, $password){
    
     $txt_file = explode("\n",file_get_contents(BAZA));
    foreach ($txt_file as $user) {
        $user_s = unserialize($user);
        //var_dump($user_s["username"], $username);
        //var_dump($user_s["password"], $password);
        //echo "NEW";
        if($user_s && $user_s["username"] === $username 
                   && $user_s["password"] === sha1($password)){
            echo "OcK";
            return true;
        }
    }
    return false;
}


/**
 * Funkcija prosljeđuje korisnika na drugu loakaciju
 * 
 * @param string $location    
 */
function redirect ($location){
    header($location);
    die();
}