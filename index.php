<?php
session_start();
/**
* Author: Andrei Popa
* link: https://github.com/JunkyPic/loginSystem/tree/Test
*/
require_once 'classes\ValidateCredentials.php';
require_once 'classes\Login.php';

if(isset($_POST['login'])){
    $credentials = (array('username' => $_POST['username'], 
                          'password' => $_POST['password']
                         )
                   );
    $validateLogin = new ValidateCredentials($credentials, 'login');
    
    if($credentials = $validateLogin->doValidate()){
        $login = new Login($credentials);
        $login->doLogin();
    }
}



if ((isset($_SESSION['id'])) && (isset($_SESSION['username']))){
    header('Location: logged_in.php');
    die();
}

require_once 'views/login_form.php';

if(version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
}
