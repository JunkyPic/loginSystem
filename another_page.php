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
session_start();
/**
* Used to test things. Delete this at will.
*/

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    echo '<p>Session is set and you are logged in.</p>';
    echo '<p>Session ID is ' . $_SESSION['id'] . '.</p>';
	echo '<p><a href="index.php">Return to Index</a></p>';
	echo '<p>Since you are logged in, the index will redirect to the page logged_in.php</p>';
} else {
	echo '<p>You are not logged in.</p>';
    echo '<p>Session does not exist.</p>';
	echo '<p><a href="index.php">Return to Index</a></p>';
	echo '<p>Since you are NOT logged in, the index will NOT redirect to the page logged_in.php</p>';
}

?>
    </div>
    </body>
</html>
  