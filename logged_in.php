<?php
/**
* This is ONLY for demonstration purposes
* Remove this page or modify it
*/
session_start();
if(isset($_SESSION['id'])){
	//Echo some info
    echo 'Welcome <strong>' . $_SESSION['username'] . '</strong>!<br>';
    echo 'Your session ID is: ' . $_SESSION['id'];
    include 'forms/log_out_form.php';
	echo '<br><a href="another_page.php"> Or go to another page!</a>';
    
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
