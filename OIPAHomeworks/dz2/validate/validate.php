<?php

/**
 * Radi jednostavnosti i citljivosti, ovdje se navode primjeri polje s podacima,
 * pravilima i greskama.
 * $data = array(
 *     'username' => 'hg45399',
 *     'password' => 'jednostavnal0z1nka',
 *     'email' => '',
 *     'website' => 'http://php.fer.hr'
 * );
 *
 * $rules = array(
 *     'username' => 'required|max_length[20]',
 *     'password' => 'min_length[8]|max_length[15]',
 *     'email' => 'required|email',
 *     'website' => 'url'
 * );
 *
 * $errors = array(
 *     'password' => MAX_LEN_ERROR,
 *     'email' => REQUIRED_ERROR
 * );
 *
 * Uocite da polja $data i $rules imaju jednake kljuceve. Imena kljuceva
 * odredjuje sami, ali moraju se poklapati u oba polja kako biste znali za
 * koji podatak je definirano koje pravilo. Nadalje, dozvoljeno je da u polju
 * s pravilima neki kljuc ne postoji jer to znaci da nije potrebno validirati
 * polje.
 *
 * Sto se tice polja s greskama, ono takodjer preuzima imena kljuceva iz polja
 * $data, ali ni ovdje nije nuzno da svi kljucevi postoje. Stovise, u idealnom
 * slucaju polje $errors bit ce prazno (sve vrijednosti su ispravne).
 *
 * Vazno je i uociti da je moguce navesti vise pravila, pri cemu se pravila
 * odvajaju znakom |. Unutar uglatih zagrada navode se parametri koje pravilo
 * ocekuje. Moguce je postojanje pravila kod kojih se unutar uglatih zagrada
 * moze navesti vise vrijednosti odvojenih zarezima.
 *
 * Buduci da je moguce definirati vlastite funkcije za obradjivanje pravila, slijedi
 * format polja u koje se spremaju funkcije.
 *
 * $handlers = array(
 *     'in_range' => function ($bottom, $top) {
 *         ...
 *     },
 *     'equals' => function ($value) {
 *         ...
 *     }
 * );
 */


// Definiranje vrijednosti gresaka za pojedina pravila
define('EMAIL_ERROR', 'eMail not correct!');
define('MAX_LEN_ERROR', 'String too long!');
define('MIN_LEN_ERROR', 'String too short!');
define('NUMBER_ERROR', 'Not a number!');
define('REQUIRED_ERROR', 'Required!');
define('URL_ERROR', 'URL not correct!');


/**
 * Provjerava ispravnost svakog unosa u polju podataka na temelju zadanih
 * pravila.
 *
 * U polju $handlers nalaze se funkcije za obradu custom pravila koje
 * korisnici biblioteke mogu sami definirati. Primjerice, ako biblioteka
 * ne podrzava pravilo in_range[10,50], korisnik mora moci definirati funkciju
 * koja ce obraditi to pravilo te gresku koja se treba ispisati u slucaju da
 * polje ne sadrzi odgovarajucu vrijednost.
 *
 * Ako je korisnik definirao pravila koja ne postoje u biblioteci te nije sam
 * definirao funkcije za validiranje tih pravila, smatra se da je pravilo
 * zadovoljeno.
 *
 * Ako je za neko custom pravilo nije definirana greska, u slucaju pada pravila
 * potrebno je kreirati pogresku oblika 'Failed due to %s', gdje %s treba zamijeniti
 * nazivom pravila. 
 *
 * @param array $data polje s podacima
 * @param array $rules polje s pravilima
 * @param array $handlers polje s funkcijama za custom pravila
 * @param array $errors polje poruka za greske za custom pravila
 * @return array polje gresaka
 */
function validate($data, $rules, $handlers = array(), $errors = array()) {
    
    foreach ($data as $key => $value) {
        $user = explode("|", $rules[$key]);//var_dump($user);
        if(!isset($user)){
            return array();
        }
        // get handlers
        $arrHandlers = getRuleHandlers($user);//var_dump($arrHandlers);
        
        if(!isset($arrHandlers[0])){ 
            continue; // TODO
            for ($index = 0; index < count($user); $index++){
                $all = explode("[", $user[$index]);
                $fun = is_array($all) ? $all[0] : $all;
                $args = is_array($all) ? explode(",", substr($all[1], 0, -1)): array();
                //var_dump($all, $fun, $args);
                $arrHandlers[] = array($fun, $args);  
            }
        }
        
        
        // ALL ERRORS
        $errors[$key] = array();
        for($index = 0; $index < count($user); $index++){
            $errors[$key] = array_merge($errors[$key], 
                                        array(getRuleError($user[$index])));
        }

        // VALIDATE
        for ($index = 0; $index < count($arrHandlers); $index++){
            $fun = $arrHandlers[$index][0];
            $paramArray = $arrHandlers[$index][1];
            array_unshift($paramArray, $value); // TOP VALUE

            // CORRECT? remove:-;
            if(call_user_func_array($fun, $paramArray)){
                unset($errors[$key][$index]); 
            }
            // destroy last
            if (count($errors[$key]) === 0){
                unset($errors[$key]);
            }
        }
        //var_dump($errors);
    }
    return $errors;
}


/**
 * Za zadano ime pravila vraca njegov opis greske
 *
 * @param string $rule naziv pravila
 * @return string opis greske
 */
function getRuleError($rule) {
    if ($rule === "email") {
        return EMAIL_ERROR;  
    }
    elseif ($rule === "number") {
        return NUMBER_ERROR;
    }
    elseif ($rule === "url") {
        return URL_ERROR;
    }
    elseif ($rule === "required") {
        return REQUIRED_ERROR;
    }
    elseif (substr($rule, 0, 3) === "max") {
        return MAX_LEN_ERROR;
    }
    elseif (substr($rule, 0, 3) === "min") {
        return MIN_LEN_ERROR;
    }
    else {
        return ;
    }
}


/**
 * Za string koji sadrzi pravilo vraca naziv funkcije za obradu i parametre.
 *
 * @param string $rule niz znakova koji predstavljaju pravilo
 * @return array polje ciji je prvi element naziv funkcije, a drugi polje parametara
 */
function getRuleHandler($rule) {
    if ($rule === "email") {
        return array("isEmail",array());  
    }
    elseif ($rule === "number") {
        return array("isNumber",array());
    }
    elseif ($rule === "url") {
        return array("isUrl",array());
    }
    elseif ($rule === "required") {
        return array("isProvided", array());
    }
    elseif (substr($rule, 0, 3) === "max") {
        $num = explode("[", substr($rule, 0 , -1));
        return array("isMaxLength",array($num[1]));
    }
    elseif (substr($rule, 0, 3) === "min") {
        $num = explode("[", substr($rule, 0 , -1));
        return array("isMinLength", array($num[1]));
    }
    else {
        return ;
    }
}


/**
 * Vraca naziv funkcije i parametre funkcije za svako pravilo iz polja pravila.
 *
 * @param array $rules polje pravila
 * @return array polje s informacijama za svako pravilo
 */
function getRuleHandlers($rules) {
    if (!is_array($rules)){
        return array(array('', array()));
    }
    $arr = array();
    foreach ($rules as $rule) {
        $arr[] = getRuleHandler($rule);
    }
    //var_dump($arr);
    return $arr;
}


/**
 * Provjerava predstavlja li niz znakova email adresu.
 *
 * @param string $input vrijednost koju je potrebno provjeriti
 * @return boolean true ako je unos valjani email
 */
function isEmail($input) {
    if (preg_match("#^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}#u", $input)){
        return true;
    }
    return false;
}


/**
 * Provjerava sadrzi li niz znakova maksimalno $length znakova.
 * 
 * @param string $input vrijednost koju je potrebno provjeriti
 * @param integer $length maksimalna duljina stringa
 * @return boolean true ako predani string ima najvise $length znakova
 */
function isMaxLength($input, $length) {
    if (mb_strlen($input,'UTF-8') <= $length){
        return true;     
    }
    return false;
}


/**
 * Provjerava sadrzi li znakova barem $length znakova.
 *
 * @param string $input string koji je potrebno provjeriti
 * @param integer $length minimalna duljina stringa
 * @return boolean true ako predani string ima barem $length znakova
 */
function isMinLength($input, $length) {
    if (mb_strlen($input,'UTF-8') >= $length){
        return true;     
    }
    return false;
}


/**
 * Provjerava sadrzi li string barem jedan znak.
 *
 * @param string $input string koji je potrebno provjeriti
 * @return boolean true ako string sadrzi barem jedan znak
 */
function isProvided($input) {
    if (mb_strlen($input,'UTF-8') > 0){
        return true;     
    }
    return false;
}


/**
 * Provjerava je li niz znakova zapravo cijeli ili realni broj.
 *
 * Valjanim brojevima smatraju se samo nizovi znakova koji sadrze cijeli ili
 * realni broj, s time da je brojeve moguce zapisati i u znanstvenoj notaciji.
 * Kako bi se predani niz znakova smatrao brojem, ne smije sadrzavati nikakve
 * znakove koji nisu potrebni da bi se prikazao broj.
 *
 * @param string $input niz znakova koji potencijalno predstavlja broj
 * @return boolean true ako niz znakova predstavlja broj - integer ili float
 */
function isNumber($input) {
    if (preg_match("#^[+-]?[0-9]+(\.[0-9]+)?([eE][+-]?[0-9]*)?$#", $input)){
        return true;
    }
    return false;
}


/**
 * Provjerava predstavlja li niz znakova valjani URL.
 *
 * @param string $input niz znakova koji je potrebno provjeriti
 * @return boolean true ako je niz znakova valjdan URL
 */
function isUrl($input) {
    if (preg_match("%(^https?:\/\/)?[^\s]+(\.[^\s]+)%", $input)){
        return true;     
    }
    return false;
}
