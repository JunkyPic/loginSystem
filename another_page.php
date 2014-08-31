<?php
session_start();
/**
* Used to test things. Delete this at will.
*/

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    echo 'Session is set.<br>';
    echo 'Session ID is ' . $_SESSION['id'] . '<br>';
} else if(isset($_COOKIE['rememberMe'])){
    echo 'Session was set based on cookie';
} else {
    echo 'Session does not exist.';
}
echo '<br><a href="index.php">Go to Index</a>';