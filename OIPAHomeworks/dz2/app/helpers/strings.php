<?php

/**
 * Vraca niz znakova dobiven uklanjanjem HTML tagova iz primljenog niza.
 *
 * @param string niz znakova koji je potrebno procistiti
 * @return string procisceni niz znakova
 */
function clean($string) {

    $newString = strip_tags($string);
    
    /*
    $pos = 0;

    while ($pos < strlen($string)):
        // skip through tags 
        if ( '<' == $string[$pos]){
            while ('>' != $string[$pos]){
                $pos++;
            }
            $pos++;
        }
        // append clear text
        $newString .= $string[$pos];
        $pos++;
    endwhile; */
return $newString;
    
}

/**
 * Ispisuje sadrzaj predanog niza znakova nakon uklanjanja HTML tagova.
 *
 * @param string niz znakova koji je potrebno ispisati
 */
function print_clean($string) {
    $newString = clean($string);
    echo $newString;
}