<?php
/**
* Author: Andrei Popa
* link: https://github.com/JunkyPic/loginSystem/tree/Test
* 
*A few things to note and some TODOs:
*
*    SOON - Trademark - See this link for clarification - http://www.wowwiki.com/Soon
*    TODO: Split up classes. As it stands they are too bloated with functions. One class does way more than it needs to.
*    TODO: The Recover Password does not work for now. I intend on using SwiftMail to do that. I never got around to setting up a proper SMTP.
*
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
