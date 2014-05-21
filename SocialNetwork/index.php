<?php 
    session_start();
    require_once 'includes/app/helpers/reg_handler.php';
    //var_dump($_SESSION); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<meta name="description" content="social network images text" />

<meta name="keywords" content="social network media picture" />

<meta name="author" content="Josip Domsic" />

<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

<script type="text/javascript" src="includes/app/javascript/ajaxServer.js"></script>
<title> PUS </title>

</head>

	<body>

		<div id="wrapper">

<?php include('includes/header.php'); ?>

<?php include('includes/nav.php'); ?>

<div id="content">
    <div class="equal">
        <div class="row">
            <div class="one">
                <h2> Prijava </h2>
                <form action="includes/app/login.php" method="post">
                <fieldset>
                    <legend>Log in</legend>
                    <label for="user1"> username </label> 
                    <input type="text" name="user" id="user1"/>
                    <label for="pass1"> password </label>
                    <input type="password" name="pass" id="pass1"/>
                    <button type="submit" >LogIn </button>
                </fieldset>
                </form>
            </div>
            <div class="two">
                <h2> Registracija </h2>
                <form action="includes/app/register.php" method="post"> 
                <fieldset>
                <legend>Register</legend>
                    <label for="user2"> username </label>
                    <input type="text" name="user" id="user2"/>
                    <label for="pass2"> password </label>
                    <input type="password" name="pass" id="pass2"/>
                    <label for="email"> email </label>
                    <input type="text" name="email" id="email"/>
                    <button type="submit" >Register</button>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div> <!-- end #content -->

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>

		</div> <!-- End #wrapper -->
	</body>
</html>
