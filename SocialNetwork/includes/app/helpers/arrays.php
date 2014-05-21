<?php

/**
 * Vraca vrijednost pod kljucem $needle iz polja $haystack.
 *
 * Funkcija pokusava u polju predanom putem drugog parametra pronaci
 * kljuc naziva $key. Ako takav element postoji, vratit ce njegovu
 * vrijednost, a ako ne postoji, vratit ce vrijednost definiranu
 * trecim parametrom, koji nije nuzno poslati funkciji.
 *
 * @param string $needle naziv kljuca koji se trazi u polju
 * @param array $haystack polje u kojem se trazi kljuc
 * @param mixed $default vrijednost koja ce biti vracena ako kljuc nije pronadjen
 * @return mixed vrijednost elementa pod kljucem $needle ako kljuc postoji, inace $default
 */
function element($needle, $haystack, $default = NULL) {
    if (key_exists($needle, $haystack)){
        return $haystack[$needle];
    }
    else {
        return $default;
    }
        

}

/**
 * Iz predanog polja izvlaci vrijednosti za definirane kljuceve.
 *
 * Funkcija provjerava postoje li u polju $haystack kljucevi koji su navedeni
 * u polju $needles. Stvara se novo polje ciji su kljucevi jednaki predanim
 * kljucevima, a vrijednosti koje ti kljucevi indeksiraju u novom polju jednake
 * su vrijednostima iz polja $haystack. Ako u polju $haystack nije postojao neki
 * kljuc, onda on svejedno postoji u novom polju, ali vrijednost koju indeksira
 * jednaka je $default.
 *
 * @param array $needles 1D polje koje sadrži popis kljuceva koji se traze
 * @param array $haystack polje u kojem se traze predani kljucevi
 * @param mixed vrijednost elementa ako kljuc ne postoji
 * @return array polje koje sadrzi trazene kljuceve i vrijednosti
 */
function elements($needles, $haystack, $default = NULL) {
    $newHaystack = array();
    foreach ($needles as $ned){
        $newHaystack[$ned] = element($ned, $haystack, $default);
    }
    return $newHaystack;
}

function arrayToString($arr){
    $string = "";
    foreach ($arr as $value) {
           $string .= $value . "; ";
        }
    return $string;
}

function array_value_exist($needle, $haystack) {
    foreach ($haystack as $key => $value) {
        if ($needle === $value){
            return TRUE;
        }
    }
    return FALSE;
}