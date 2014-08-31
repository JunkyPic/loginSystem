<?php
session_start();

if(isset($_SESSION['id'])){
	include 'forms/change_password_form.php';
	require_once 'classes/ChangePassword.php';
	$changePassword = new ChangePassword();
} else {
	
    //if session is not set redirect
    header('Location: index.php' . $redirect);
}
