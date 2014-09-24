<?php	
session_start();

if(isset($_POST['logout'])){
	//Set the session array to empty
	$_SESSION = array();
	session_destroy();
	//Redirect
    header('Location: index.php');
    die();
} else if (isset($_SESSION['id'])){
	//Echo some info
    echo '<p><a href="change_password.php"> Change password.</a></p>';
	require_once 'views/log_out_form.php';
	
} else {
	//if session is not set redirect
	header('Location: index.php');
    die();
}
?>
