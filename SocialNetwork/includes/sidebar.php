<div id="sidebar">
<h3> User </h3>
    <?php echo whoIsLoggedIn(); ?>
    <form action="includes/app/logout.php" method="post">
    <input type='submit' value='logout' />
    <input type='hidden' name='user' value='<?php echo whoIsLoggedIn()?>' />
    </form>
    
<h3>Navigation</h3>
    <ul>
        <li><a href="index.php">Home</a></li>
	<li><a href="about.php">About Us</a></li>
	<li><a href="#">Links</a></li>
	<li><a href="#">Portfolio</a></li>
	<li><a href="#">Contact</a></li>
    </ul>
<h3> Search People</h3>
<form onclick="searchPeople(this['username'].value);">
    <fieldset>
        <input type="text" name="username" maxlength="5"/>
        <input type="button" value="Search"/>
    </fieldset>
</form>

<h3> Results </h3>

<p id="resultTextArea"> <i>Type in "Search People" to  get usernames. </i></p>

<!--
<h3>Box Two</h3>
    <ul>
        <li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
    </ul>

<h3>Box Three</h3>
    <ol>
        <li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
	<li><a href="#">Link Here</a></li>
    </ol>
-->
</div> <!-- end #sidebar -->
