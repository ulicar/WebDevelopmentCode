<?php
        require_once '/dz/dz2/req_handler.php';
        var_dump($_SESSION);
?> 

<!doctype html>

<html>

    <head>
        <meta charset="utf-8">
        <title>OIPA Generator Kviza</title>
    </head>

    <body>
        
        <h2> Upload vlastite datoteke za generiranje kviza </h2>
        <form method="post" action="create.php" enctype="multipart/form-data">
            <input type="file" name="datoteka" />
            <input type="submit" value="Šalji" />
        </form>
        <a href="create.php" style="text-decoration: none"> Popis kvizova </a>
    </body>
    
</html>