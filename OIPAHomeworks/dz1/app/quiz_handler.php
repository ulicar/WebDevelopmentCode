<?php

/**
 * U datoteci QUIZ_MAP nalazi se popis svih parova (ID, PUTANJA) 
 * pri cemu ID predstavlja identifikator kviza, a PUTANJA je 
 * zapravo putanja do datoteke koja sadrzi konfiguraciju kviza.
 */
define('QUIZ_MAP', 'quizzes/');
define('QUIZ_FILE', 'quizzes_index.txt');
define('NAME_LENGTH', 20);


/**
 * Buduci da na vise mjesta moze biti vazan tip pitanja, definiraju
 * se konstante kako ne bi bilo potrebno hardkodirati vrijednosti u kodu
 */
define('SINGLE', 1);
define('MULTIPLE', 2);
define('CUSTOM', 3);



/**
 * Vraca HTML potreban za prikazivanje pitanja.
 *
 * @param array $question polje koje odredjuje pitanje
 * @param integer $type tip pitanja
 */
function display_question($question, $key, $type = SINGLE) {
        if ($type == SINGLE){
            return display_single_choice($question, $key);
        }
        elseif ($type == MULTIPLE) {
            return display_multiple_choice($question, $key);
        }
        elseif ($type == CUSTOM) {
            return display_custom_input($question, $key);
        }
        else{
            echo "<br>ERROR! [app/quiz_handler] display_question: type<br>";
        }
}       


/**
 * Vraca HTML za prikazivanje pitanja s mogucnoscu odabira jedne opcije (tip 1).
 *
 * @param array $question polje koje odredjuje pitanje
 */
function display_single_choice($question, $key) {
    echo "<br><br><label>" . $question['question'] . "</label><br>"; 
    foreach ($question['option'] as $option) {
         echo "<input type='radio' name='" . "$key" .  "' value=" . 
                 "'$option'>$option";
    }
   
}
    

/**
 * Vraca HTML za prikazivanje pitanja s visetrukim odabirom (tip 2).
 *
 * @param array $question polje koje odredjuje pitanje
 */
function display_multiple_choice($question, $key) {
    echo "<br><br><label>" . $question['question'] . "</label><br>"; 
    foreach ($question['option'] as $option) {
         echo "<input type='checkbox' name='" . "$key". "[]'" .  " value=" . 
                 "'$option'>$option";
    }
}


/**
 * Vraca HTML za prikazivanje pitanja s korisnickim unosom
 *
 * @param array $question polje koje odredjuje pitanje
 */
function display_custom_input($question, $key) {
    echo "<br><br><label>" . $question['question'] . "</label><br>";
    echo "<input type='text' name='" . "$key" . "'>";
}

/**
 * Dohvaca sva pitanja kviza.
 *
 * Cita datoteku koja sadrzi konfiguraciju kviza te vraca polje 
 * ciji je svaki element polje s tocno cetiri kljuca: question, 
 * options, answer i type. Vrijednost pod kljucem question predstavlja
 * tekst pitanja; pod kljucem options nalaze se odgovori koje korisnik
 * moze odabrati; kljuc answer sadrzi tocan odgovor, a kljuc type odnosi se na
 * jedan od tri tipa pitanja. Ako je pitanje takvo da korisnik sam mora upisati 
 * odgovor, onda je vrijednost pod kljucem options prazno polje. Ako je vise 
 * odgovora tocno, onda je answer polje s vise od jednim elementom, inace je 
 * polje s tocno jednim elementom.
 *
 * Primjer:
 *
 * array(
 *     array(
 *         'question' => 'Tekst pitanja',
 *         'options' => array('opcija1', ..., 'opcijaN'),
 *         'answer' => array('odgovor'),
 *         'type' => SINGLE
 *     ),
 *     ...
 * )
 *
 * @param string identifikator kviza
 * @return array polje koje sadrzi pitanja i odgovore
 */
function get_questions($quizName) {
    
    $quiz = array();
    $txt_file = file_get_contents(QUIZ_MAP . $quizName);
    $rows = explode("\n", $txt_file);
    
    foreach ($rows as $line) {
        
        if (strlen(trim($line)) <= 4 || $line[0] == "#"   || $line[0] == "!"){
            //var_dump($line);
        }
        else {
            // Real question: 
            // 'Drugi tekst pitanja{2}:odgovor1,odgovor2,odgovor3,...,odgovorN;odgovorA,odgovorB,...,odgovorK
            //var_dump($line);
            $line = explode(":", $line);
            if (!is_array($line)){
                continue;
            }
            
            $first = explode("{", $line[0]);
            if (!is_array($first)){
                continue;
            }
            
            $question = $first[0];
            //var_dump($first);
            $type  = (int) substr($first[1], 0, 1);
            if (!is_numeric($type) || $type < 1 || $type > 3){
                continue;
            }
           
            $second = explode(";", $line[1]);
            if (!is_array($second)){
                continue;
            }
            
            $options  = explode(",", $second[0]);
            if (!is_array($options)){
                continue;
            }
            $answer   = explode(",", $second[1]);
            if (!is_array($answer)){
                continue;
            }
            foreach ($answer as $key => $value) {
                $answer[$key] = rtrim($value);
            }
            if ($type == SINGLE || $type == CUSTOM){
                $answer = $answer[0];
            }
            
            //var_dump($question, $type, $options, $answer);
            $quiz[] = array( "question" => $question, "option" => $options,
                                "answer" => $answer, "type" => $type);
        }
            
    }
   //var_dump($quiz);
   return $quiz;
}

/**
 * Dohvaca naslov kviza.
 *
 * @param string $quizId identifikator kviza
 * @return string naslov kviza
 */
function get_title($quizId) {
    
    // Promijeniti kasnije u Fopen.
    $txt_file = file_get_contents(QUIZ_MAP . $quizId . ".txt");
    if (!$txt_file){
        return "None";
    }

    $rows = explode("\n", $txt_file);
    if (!$rows){
        return "None";
    }

    $title = "None";
    foreach ($rows as $line) {
        if ( strlen($line) > 1 && $line[0] === "!"){
            $title = substr(trim($line), 1);
            break;
            
        }
    }
    
    return $title;
}

/**
 * Dohvaca sve kvizove 
 * 
 * @param string $location identifikator vrste kviza
 * @return array naziv kviza => putanja
 */
function get_quizzes($location) {
    
    $sve = scandir($location);
    $kvizovi = array();
    foreach ($sve as $NUM => $kviz) {
        if ($kviz != "." and $kviz != ".." and $kviz !== QUIZ_FILE){
            $quizId = substr($kviz, 0, strlen($kviz)-4);
            //var_dump($quizId);
            $name = get_title($quizId);
            $kvizovi[$quizId]= $name;
            }
        }
    return $kvizovi;
}

/**
 * Provjerava jesu li korisnikovi odgovori na pitanje tocni.
 *
 * U slucaju pitanja u kojem je potrebno odabrati vise opcija, odgovor
 * je tocan samo ako su odabrane sve opcije.
 *
 * @param mixed tocan odgovor kao string ili tocni odgovori kao polje
 * @param mixed korisnikov odgovor ili polje s korisnikovim odgovorima
 * @return boolean true ili false, ovisno o tocnosti odgovora
 */
function is_correct($expected, $received) {
    //var_dump($expected, $received);
    if (is_string($expected) && is_string($received)){
        //echo "str_str";
        return mb_strtoupper(trim($expected), "UTF-8") === mb_strtoupper(trim($received), "UTF-8");
    }
    
    elseif (is_array($expected) && is_array($received)) {
        if (!array_diff($received, $expected) && !array_diff($expected, $received)){
            
            return TRUE;
        }
        return FALSE;
    }
    else{
        //echo "nesto bzvz";
        return FALSE;
    }
}

/**
 * Dohvaca putanja do datoteke s konfiguracijom kviza.
 *
 * @param string identifikator kviza
 * @return string putanja do datoteke koja sadrzi konfiguraciju kviza
 */
function find_file($quizId) {
    $txt_file = file_get_contents(QUIZ_MAP.QUIZ_FILE);
    $rows = explode("\n", $txt_file);

    foreach ($rows as $value){
        $value = explode(" ",$value);
        if ($quizId === $value[0]){
            return $value[1];
        }
    }
}


/**
 * U datoteku QUIZ_MAP sprema novi unos oblika (ID, putanja).
 *
 * @param string $quizId identifikator kviza
 * @param string $quizLocation putanja do datoteke s konfiguracijom kviza
 */
function store_quiz($quizId, $quizLocation) {
    $file = fopen(QUIZ_MAP . QUIZ_FILE, "a+");
    
    if (isset($file)){
        fprintf($file, "%s %s\n", $quizId, $quizLocation);
        fclose($file);
    }
}

function remove_quiz($quizId){
    //echo $quizId;
    $txt_file = file_get_contents(QUIZ_MAP.QUIZ_FILE);
    $rows = explode("\n", $txt_file);
    $file = fopen(QUIZ_MAP.QUIZ_FILE, "w");
    
    foreach ($rows as $row){
        $value = explode(" ",$row);
        if ($quizId === $value[0]){
            //echo "OK";
            echo QUIZ_MAP.$quizId.".txt";
            unlink(QUIZ_MAP . $quizId . ".txt");
            continue;
        }
        fprintf($file, "%s\n", $row);
        
    }
    //print "ok";
    fclose($file);
}

function getRandomId (){
    $name = "";
    $asciiA = ord("a");
    $asciiZ = ord("z");    
    for ($i = 0; $i < NAME_LENGTH; $i++) {
        $randomZnak = rand($asciiA, $asciiZ);
        $name .= chr($randomZnak);
    }
    return $name;
}