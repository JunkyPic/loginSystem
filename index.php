<?php
/**
* Author: Andrei Popa
* link: https://github.com/JunkyPic/loginSystem
*/

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
      exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else {
      require_once 'classes/Login.php';
      require_once 'forms/login_form.php';
      /**
      * The construct in the Login class takes care of everything
      */
      
      $login = new Login();
}
