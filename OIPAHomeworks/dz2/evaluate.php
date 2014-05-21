<!doctype html>

<html>

    <head>
        <meta charset="utf-8">
        <title> Evaluacija </title>
    </head>
    <body>
        <?php
        /**
         * Prima odgovore iz kviza te provjerava njihovu tocnost. Dodatno, ispisuje 
         * svako pitanje, tocan odgovor, korisnik odgovor te je li odgovor tocan. Na
         * kraju ispisuje i sliku koja predstavlja ukupnu statistiku kviza.
         */
        require_once 'app/stats_handler.php';
        require_once 'app/quiz_handler.php';
        require_once 'app/helpers/strings.php';

        if( isset($_POST['quizId']) && strlen($_POST['quizId']) === NAME_LENGTH){

           $questions = get_questions($_POST['quizId'] . ".txt");
           if (!$questions){
              echo "Ne mogu ti pomoci.";
              die();
           }
                //var_dump($questions);
                $total = sizeof($questions);
                $answered = 0;
                $correct = 0;
                $wrong = $total;
                
                echo "TOČNI ODGOVORI:<br>";
                for ($index = 0; $index < $total; $index++) {
                    // Ispiši sve točne
                    if (is_string($questions[$index]["answer"])){
                         echo print_clean($questions[$index]["answer"]) . "<br>";
                    }else{
                          foreach ($questions[$index]["answer"] as $value) {
                                echo print_clean($value) . "; ";
                          }
                           echo "<br>";
                    }
               }
               
               echo "<br>PONUĐENI ODGOVORI:<br>"; 
               for ($index = 0; $index < $total; $index++) {
                    if (empty($_POST[$index])){
                        continue;
                    }
                    if ( is_string($_POST[$index]) && strlen($_POST[$index]) === 0){
                        continue;
                    }
                    if (is_string($_POST[$index])){
                         echo print_clean($_POST[$index]);
                    }else {
                         //echo "Vaši odgovori: ";
                         foreach ($_POST[$index] as $value) {
                             echo print_clean($value) . "; ";
                         }
                    }
                   
                    $answered += 1;
                    if (is_correct($questions[$index]["answer"], $_POST[$index])){
                        $correct += 1;
                        $wrong -= 1;
                        echo "    TOČNO!<br>";
                    }else {
                        echo "    KRIVO!<br>";
                    }
               }
            }
            echo "STATISTIKA: <br>";
            
            
            remove_quiz($_POST["quizId"]);
?>
    <img src="<?php echo generate_stats($correct + $wrong,$correct, $wrong)?>"
         alt="NISAM DOHVATIO SLIKU">
    </body>
</html>