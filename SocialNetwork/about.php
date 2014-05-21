<?php session_start();
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

<h3>About page</h3>

<p>
    Stranica je nastala kao rješenje jedne laboratorijske vježbe na FERu. 
    Zadatak za vježbu je bio izrada DRUŠTVENE MREŽE.
    Zahtjevi ukratko:
</p>
    <ol>
        <li> Registracija korisnika <?="&#10004"?></li>
        <li> Prijava korisnika      <?="&#10004"?> </li>
        <li> Prikaz korisnikove stranice i slika <?="&#10004"?></li>
        <li> Prikaz korisnikih prijatelja <?="&#10004"?></li>
        <li> Dohvat svih korisnika na mreži <?="&#10004"?></li>
        <li> Slanje zahtjeva zaprijateljstvo <?="&#10004"?></li>
        <li> Prihvaćanje ili odbijanje zahtjeva <?="&#10004"?></li>
        <li> Komentiranje i lajkanje slika <?="&#10004"?></li>
        <li> Postavljanje razina privatnosti fotografija - </li>
        <li> Prikaz komentara, tagiranja, lajkova <?="&#10004"?></li>
        <li> Povlačanje akcije (npr. dislike) <?="&#10004"?> </li>
    </ol>
<?php //echo serialize(array("Josip" => array("Marko", "Ivan")));?>

<a href="#" onclick="window.open('includes/files/2LAB_2014.pdf')">Zadatak.pdf</a>

</div> <!-- end #content -->

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>

		</div> <!-- End #wrapper -->

	</body>

</html>
