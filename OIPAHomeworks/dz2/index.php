<?php
        require_once 'app/reg_handler.php';
        session_start();
?> 
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OIPA Generator Kviza</title>
    </head>
    <body>
        <h1> Neregistrani korisnici:</h1>
        <a href="create.php" style="text-decoration: none"> Popis kvizova </a>
        <h1>Registracija novih korisnika:</h1>
        <form method="post" action="registracija.php">
            username:
            <input type="text" name="username" /><br>
            password:
            <input type="password" name="password" /><br>
            ime:
            <input type="text" name="ime" /><br>
            prezime:
            <input type="text" name="prezime" /><br>
            eMail:
            <input type="text" name="email" /><br>
            Web site:
            <input type="text" name="url" /><br>
            <input type="submit" value="Šalji" />
        </form>
        <h1> Prijava:        </h1>
        <form method="post" action="prijava.php">
            username:
            <input type="text" name="username" /><br>
            password:
            <input type="password" name="password" /><br>
            <input type="submit" value="Šalji" />
        </form> 
    </body>
</html>