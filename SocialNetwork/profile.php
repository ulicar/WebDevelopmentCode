<?php
session_start();

require_once 'includes/app/helpers/profile_handler.php';
require_once 'includes/app/helpers/reg_handler.php'; 
if(NULL === whoIsLoggedIn()){
    redirect(HOMEPAGE);
}
?>

<?php //var_dump($_SESSION); ?>
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
    <?php $user = $profile = whoIsLoggedIn();
          if( isset($_GET["user"])){
              $profile = clean($_GET["user"]);
          }
    ?>
    <h3><?php echo "<i> profile <i>" . $profile?></h3>
    <table>
        <tr>
            <td> <!-- Opis -->
            Korisnik je gospodar svemira, svi mi se morate pokloniti. Ovo je
            generirano statički, kasnije treba učitati iz datoteke ili drugačije 
            dinamički odrediti iz datoteke.
            
            Prijatelji: <!-- Neindeksirana lista prijatelja-->
            <?php if(isFriend(whoIsLoggedIn(), $profile)){ ?>
            <ul><?php foreach (getAllFriends($profile) as $key){?>
            <li>
            <a href='http://localhost/Testiranja/DZ2/profile.php?user=<?=$key ?>'>
                 <?=$key?></a>    
            </li>
            <?php }?>
            </ul>
            <?php } ?>
            
            </td><td> <!-- Profilna slika -->
            <?php echo showProfilePicture($profile); ?>    
            </td>
        </tr>
    </table>
    <h3> Novi zahtjevi za prijateljstvo </h3>
    <?php if($user === $profile){
     //sendFriendRequest("Jaa", "Josip");
              checkNewFriendRequests($profile);
              sendRequestForm(whoIsLoggedIn());
    }?>
    <!-- Sve slike, s komentarima i lajkovima-->
    <h3> <i> slike korisnika</i> <?=$profile?> </h3>
    <?php echo showPictursAndComments($profile);?>

</div> <!-- end #content -->

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>

		</div> <!-- End #wrapper -->

	</body>

</html>
