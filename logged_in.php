<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title> Logged in </title>
		<link href="css/style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
	<div id="header">
	
<?php	
include_once 'forms/header.php';
/**
* This is ONLY for demonstration purposes
* Remove this page or modify it
*/
session_start();

if(isset($_SESSION['id'])){
	//Echo some info
	echo '<p>Welcome <strong>' . $_SESSION['username'] . '</strong>!</p>';
	echo '<p>Your session ID is: ' . $_SESSION['id'];
	include 'forms/log_out_form.php';
	echo '<p><a href="another_page.php"> Check if you are logged in.</a></p>';

} else {
	//if session is not set redirect
	header('Location: index.php' . $redirect);
}

if(isset($_POST['logout'])){
	//Set the session array to empty
	$_SESSION = array();

	session_destroy();

	//Redirect
	header('Location: index.php');
} 

	?>
    </div>
    </body>
</html>
  
