<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'arrays.php';
require_once 'strings.php';
require_once 'C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\app\helpers\reg_handler.php'; //only for userExists()
define('PRIJATELJI', 'C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\files\BazaKorisnika');
define('LIKES','C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\files\likes.txt');
define('OBAVIJESTI','C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\files\obavijesti.txt');
define('IMGS', 'C:\Users\Josip\Documents\NetBeansProjects\Testiranja\DZ2\includes\files\imgs.txt');

/** Dohvaća korisnikove prijatelje
 * 
 * @param string $user Registiran i prijavljen korisnik
 * @return array Prijatelji korisnika
 */
function getAllFriends($user) {
    $friends = array();
    $all = unserialize(file_get_contents(PRIJATELJI));
    if(is_array($all) and array_key_exists($user, $all)){
        $friends = $all[$user]; 
    }
    return $friends;
}

/** Ispisuje sve komentare za sliku
 * @param string $picutureName Naziv fotografije bez ekstenzije
 * @return None None
 */
function showComments($pictureName) {
    // pročitaj iz comments.txt ua sliku komentare
    echo 'Heloooooo<br>'; 
    echo "katastrogafaf\n dadad \ndsada";
}

/** Dohvaća lokaciju slike na poslužitelju
 * @param string $pictureName Naziv slike bez ekstenzije, prepostaljen JPG
 * @return string relativna lokacija slike na poslužitelju
 */
function getPictureLoction($pictureName) {
    return 'includes/files/img/' . $pictureName . ".jpg";
}

/** Ispisuje sliku određene veličine
 * @param string $pictureName Ime slike bez ekstenzije
 */
function showPicture($pictureName) {
    $height = 250;
    $width  = 350;
    echo '<img src="' . getPictureLoction($pictureName) .'" height="' . $height 
            . '" width="' . $width . '" >';
}

/** Ispisi profilnu slike korisnika
 * @param string $user Registrian i prijavljen korisnik
 * @link echoes picture
 */
function showProfilePicture($user){
    $arr = getPictureNames($user);
    if(empty($arr)){
        showPicture("bigX");
    } else {
        showPicture(array_pop($arr));    
    }
    
}

/** Dohvaća sva imena slika nekog  korisnika
 *  array($user => array("$img1, $img2")) 
 * 
 * @param string $user Korisnik
 * @return array Nazivi slika bez ekstenzije
 */
function getPictureNames($user) {
    $pictureNames = array();
    $db = unserialize(file_get_contents(IMGS));
    if(isset($db[$user])){
        $pictureNames = $db[$user];
    }
    return $pictureNames;
}
/** Prikaz tablice. Ispisuje sliku, komentare, lajkove i obrazac za LIKE!
 * @param string $user Korisnik čiji se podaci ispisuju
 */
function showPictursAndComments($user) {
    $pictureNames = getPictureNames($user);
    echo '<table>';
    foreach ($pictureNames as $picName) {
        echo "<tr>";
            echo '<td rowspan="3">'; 
            showPicture($picName);
            echo '</td><td>';
            echo 'Komentari: <br>';
            showComments($picName);
            echo '</td>';
        echo "</tr><tr>";
            echo "<td>";
            echo "Lajkovi: <br>";
            showLikes($picName);
            echo "</td>";
        echo "</tr><tr>";
            echo "<td>";
            likePictureForm(whoIsLoggedIn(), $picName);
            echo "</td>";
        echo "</tr>";
    }
    echo '</table>';
    
}
/** Provjerava jesu li dvije osobe prijatelji.
 * @param string $user (NE)Registrirani korisnik
 * @param string $friend (NE)Registrani korisnik
 */
function isFriend($user, $friend) {
    return TRUE;
}
/** Provjerava postoje li zahtjevi za prijatestvom. Ako postoje ispisuje obrazac
 * za reakciju (prihvaćanje i odbijanje) zahtjeva.
 * @param string $user Osoba za koju se provjeravaju zahtjevi
 * @todo Ispisati više od jednog zahtjeva!
 */
function checkNewFriendRequests($user) {
    $db = unserialize(file_get_contents(OBAVIJESTI));
    if (is_array($db) and array_key_exists($user, $db)){
        echo '<form action="includes/app/helpers/answerFriendRequest.php"' .
                'method="post">';
        foreach ($db[$user] as $friend) {
            echo "Friend request from" . $friend . "<br>";
            echo '<input type="radio" name="answer" value="accept">Accept<br>';
            echo '<input type="radio" name="answer" value="decline">Decline<br>';
            echo "<input type='hidden' name='user' value='" .$user . "' />";
            echo "<input type='hidden' name='friend' value='" .$friend ."' />";
            echo "<input type='submit' value='Decide'>";
        }
        echo '</form>';
    }
    
}
/** Šalje zahtjev za prijeateljstvo korisniku
 *  verzija 0.1 Postalja samo ime u $user u listu od priajtelja $friends
 *  @param string $user Osoba koja šalje zahtjev za prijateljstvom
 *  @param string $friend Osoba koja prima zahtjev za prijateljstvom
 * @todo Umjesto "FALSE" pozovi funkciju za provjeru prijateljstva isFriend()
 */
function sendFriendRequest($user, $friend) {
    $arr = unserialize(file_get_contents(OBAVIJESTI));
    if(!userExists($friend) or FALSE){
        echo "User donesn't exist"; return;
    }
    if (is_array($arr) and array_key_exists($friend, $arr)){
        $arr[$friend] += array($user);
    }else{
        $arr[$friend] = array($user);
    }
    file_put_contents(OBAVIJESTI,serialize($arr));
}
/** Uspostavlja prijateljstvo između 2 osobe, rad s bazom
 *  @param string $user Korisnik koji dobiva prijatelja 
 *  @param string $friend osoba koja postaje prijatelj
 * 
 */
function makeFriends($user, $friend) {
    $arr = unserialize(file_get_contents(PRIJATELJI));
    if (array_key_exists($friend, $arr)){
        if(!array_value_exist($user, $arr[$friend])){
            array_push($arr[$friend], $user);   
        }
    } else {
        $arr[$friend] = array($user);
    }
    file_put_contents(PRIJATELJI,serialize($arr));
}
/** Uspostavljanje prijateljstva između dviju osoba
 * @param string $user Korisnik koji dobiva prijatelja
 * @param string $friend Korisnik koji dobiva prijatelja
 */
function acceptFriendRequest($user, $friend) {
    removeFriendRequest($user, $friend);
    makeFriends($user, $friend);
    makeFriends($friend, $user);
}

/** Briše poslani ali neprihvaćeni zahtjev za prijateljstvo
 * 
 * @param type $user Osoba koja briše/povlači zahtjev za prijateljstvo
 * @param type $friend Osoba za koju se povlači zahtjev za prijateljstvo 
 */
function removeFriendRequest($user, $friend){
    $arr = unserialize(file_get_contents(OBAVIJESTI)); 
    if (array_key_exists($user, $arr)){
        $key = array_search($friend, $arr[$user]);
        unset($arr[$user][$key]);
        if(empty($arr[$user])){
            unset($arr[$user]);
        }
    }
    file_put_contents(OBAVIJESTI,serialize($arr));}

/** Dohvaća imena osoba koje su kliknule LIKE
 * @param string $pictureName Ime slike bez ekstenzije
 * @return echo string Imena svi korisnika koji su Lajkali sliku
 */
function showLikes($pictureName) {
    $db = unserialize(file_get_contents(LIKES));
    if(is_array($db) and !empty($db[$pictureName])){
        echo arrayToString($db[$pictureName]);
    } else {
        echo "***Nema lajkova***";
    }
}
/** Stvara unos u datoteku koja postoji.
 *  array ( $key => array() ) 
 *  @param string $key Kulj po kojim će se polje pretraživati
 *  @param string $FILE Lokacija i naziv datoteke
 */
function createEntry($key, $FILE){
    $text = unserialize(file_get_contents($FILE));
    if (is_array($text)){
        $text[$key] = array();
    } else {
        $text = array($key => array());
    }
    file_put_contents($FILE, serialize($text));
}


/** Stvara obrazac (tipku) za LIKE! slike
 * @param string $user Korisnik
 * @param string $picture Ime slike, bez ekstenzije
 */
function likePictureForm($user, $picture) {
    echo '<form action="includes/app/helpers/like.php" method="post">';
        echo "<fieldset>";
        echo "<input type='submit' value='LIKE!' />";
        echo "<input type='hidden' name='user' value='" .$user . "' />";
        echo "<input type='hidden' name='picture' value='" .$picture ."' />";
        echo "</fieldset>";
    echo "</form>";
}

/** Handler za lajkanje slike, puni bazu podataka
 *  @param string $user Korisnik koji je lajkao sliku
 *  @param string $picture Naziv slike, bez ekstenzije
 */
function likePicture($user, $picture) {

    $db = unserialize(file_get_contents(LIKES));
    if (array_key_exists($picture, $db) and 
               !array_value_exist($user, $db[$picture])){
    
        array_push($db[$picture],$user);
        file_put_contents(LIKES, serialize($db));
    }
}

/** Handler za komentiranje slike, puni bazu podataka
 *  @param string $pictureName Naziv slike bez ekstenzije
 *  @param boolean $privilegije Dozvola za komentiranje slike
 *  @todo Ostovoir datoteku za slike i upiši komentar, postavi u "comment.php"
 */
function commentPicture($pictureName, $privilege = TRUE) {
}

/** Ispis obrasca za slanje upita za prijateljstvo
 * @param string $user Ime korisnika koji šalje zahtjev 
 */
function sendRequestForm($user){
    echo '<form action="includes/app/helpers/sendFriendRequest.php" method="post">';
        echo "<fieldset>";
        echo "<input type='submit' value='Request' />";
        echo "<input type='hidden' name='user' value='" . $user . "' />";
        echo "<input type='text' name='friend' />";
        echo "</fieldset>";
    echo "</form>";
}