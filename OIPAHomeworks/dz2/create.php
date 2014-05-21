<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OIPA Generator Kviza</title>
    </head>
    <body>
        <h1> Generiranje kviza pomoću ID-a </h1>
        <?php
        /**
        * Dohvaca datoteku koju je poslao korisnik te je sprema na sredisnje mjesto na
        * posluzitelju. Nakon sto je konfiguracija kviza spremljena, ispisuje poveznicu
        * do kviza.
        */
        require_once 'app/quiz_handler.php';
        $name = 'datoteka'; // same as in form on index.php
        //var_dump($_FILES);
        if (!empty($_FILES) &&
                $_FILES[$name]['error'] === UPLOAD_ERR_OK 
                && $_FILES[$name]["type"] === "text/plain"           
                && is_uploaded_file($_FILES[$name]['tmp_name'])){
            
            $randId = getRandomId();
            $location = $randId . ".txt" ;
            move_uploaded_file($_FILES[$name]['tmp_name'], QUIZ_MAP . $location);
            store_quiz($randId, $location);
            
        } else {
            //echo "Nothing was recieved!";
        }?>
        
        <h3> Kvizovi u ponudi: </h3>
        
        <ol>
        <?php 
            /*
             * Ispisuje sve sve kvizove u pobrojenoj listi
             */
            $kvizovi = get_quizzes(QUIZ_MAP);
           
            foreach ($kvizovi as $id => $ime){
                echo '<li>';
                //echo "<label>" .$ime. "</label>";
                echo "<a href='quiz.php?quizId=" . $id . "' STYLE='text-decoration: none' />" 
                            .$ime. "</a>";
                echo '</li>';
            }?>
        </ol>
    </body>
</html>