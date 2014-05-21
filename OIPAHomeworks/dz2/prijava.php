<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OIPA Generator Kviza</title>
    </head>
    <body>
    <?php
        require_once 'validate/validate.php';
        require_once 'app/reg_handler.php';

        //var_dump($_POST);
        if ($_POST){
            $data = $_POST;
            $rules = array(
                    'username' => 'required|min_length[5]',
                    'password' => 'required',
                );
                if (!validate($data, $rules)) {
                    //echo 'OK';
                    if(logIn($data["username"], $data["password"])){
                        echo "Logiran!";
                        //echo "<a href=\"index.php\"> Povratak </a>";
                        //var_dump($_SESSION);

                    }
                }
        }?>

        <?php if (isset($_SESSION["username"])): ?>
                <h2> Upload vlastite datoteke za generiranje kviza </h2>
                <form method="post" action="create.php" enctype="multipart/form-data">
                    <input type="file" name="datoteka" />
                    <input type="submit" value="Šalji" />
                </form>
        <?php else: ?>
            <a href="create.php" style="text-decoration: none"> Popis kvizova </a>
            <a href="index.php"> Povratak </a>
        <?php endif; ?>

     </body>
</html>