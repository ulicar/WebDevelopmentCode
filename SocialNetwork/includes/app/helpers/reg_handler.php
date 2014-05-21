<?php

/*
 *  Predefinirani podaci
 */
//session_start();
//efine('BAZA', "users.txt");
define('BAZA','C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\files\users.txt');
define('HOMEPAGE', "http://localhost/Testiranja/DZ2/index.php");

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
function registerUser($username, $password, $ime= NULL, $prezime = NULL, $email = NULL, $url = NULL) {
    $data = array(
        'username' => $username,
        'password' => sha1($password)
    );
    /*,
        'first_name' => $ime,
        'last_name' => $prezime,
        'email' => $email,
        'website' => $url,
    );
    */
    if(!userExists($username)){
        $txt_file = unserialize(file_get_contents(BAZA));
        if(is_array($txt_file)){
            $txt_file[$username] = $data;
        } else {
            $txt_file = array($username => $data);
        }
        file_put_contents(BAZA, serialize($txt_file));
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
    
    if(userExists($username) and isLoggedIn($username)){
        unset($_SESSION["username"]);
        redirect(HOMEPAGE);
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
    
    $txt_file = unserialize(file_get_contents(BAZA));
    if(is_array($txt_file) and array_key_exists($username, $txt_file)){   
            return true;
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
    
    $txt_file = unserialize(file_get_contents(BAZA));
    if(is_array($txt_file) and array_key_exists($username, $txt_file) and
            $txt_file[$username]["password"] === sha1($password)){
            return true;
        }
    return false;
}
/** Dohvalaća ime prijavljenog korisnika
 * @return string Ime prijavljenog korisnika
 */
function whoIsLoggedIn() {
    $user = NULL;
    if (array_key_exists("username", $_SESSION)){
        $user = $_SESSION["username"];
    }
    return $user;
}

/**
 * Funkcija prosljeđuje korisnika na drugu loakaciju
 * 
 * @param string $location    
 */
function redirect($location){
    header("Location:" . $location);
    die();
}