<!doctype html>
<?php

/**
 * Na temelju identifikatora kviza dobivenoga iz URL-a, dohvaca konfiguraciju
 * kviza te generira HTML kviza. Rezultati kviza salju se skripti evaluate.php.
 */
    require_once 'app/quiz_handler.php';
    if( isset($_GET['quizId']) && strlen($_GET['quizId']) === NAME_LENGTH){
        
         $quizId = $_GET['quizId'];
         echo "<h3>" . get_title($quizId) . "</h3>";
         
         $questions = get_questions($quizId . ".txt");
    
         
    }
 else {
        die();
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Kviz znanja</title>
</head>      

<body>
    <form method="post" action="evaluate.php">
        
        <?php    
        foreach ($questions as $key => $value) {
            display_question($value, $key, $value['type']);}?>
        
        <input type="hidden" name="quizId" value="<?php echo $quizId?>">
        <br><br><input type="submit" value="Ocijeni kviz!" >
    </form> 
</body>
    
</html>
