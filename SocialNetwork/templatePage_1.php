<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<meta name="description" content="" />

<meta name="keywords" content="" />

<meta name="author" content="" />

<link rel="stylesheet" type="text/css" href="templateCSS.css" media="screen" />

<title>1stWebDesigner PHP Template About Page</title>

</head>

	<body>

		<div id="wrapper">

<?php include('includes/header.php'); ?>

<?php include('includes/nav.php'); ?>
<?php require_once 'includes/app/helpers/profile_handler.php'?>;

<div id="content">
<?php var_dump(getAllFriends("Josip"));?>

</div> <!-- end #content -->

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>

		</div> <!-- End #wrapper -->

	</body>

</html>
