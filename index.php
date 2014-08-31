<?php
/**
* A simple (probably not so secure) Login Script
* Cookies are required for this form to work so please turn them on if they aren't already on
* 
* Author: Andrei Popa
* link: https://github.com/JunkyPic/login_system
* 
* A few things to note and some TODOs:
*   - SOON - Trademark - See this link for clarification - http://www.wowwiki.com/Soon
*   - First run the files in the _installation folder!
*       - Run create_db.php then create_tables.php. A more user friendly interface will come. SOON.
*   - Password hasing is set(for the moment) to sha1. I will use password_hash() once I upgrade to PHP 5.4.x. Currently using a lower version. SOON.
*   - Some parts of the code are repetitive(not so great, I know) I will change that SOON.
*   - In some parts of the script I use PDO::FETCH_ASSOC where I could have used rowCount(). There's no performance loss since it will always select
      one and only one row - in my particular case. I just find PDO::FETCH_ASSOC easier to work with.
*   - TODO: Add some form of ecryption to the Cookies used. Use SSL and HTTPS. Use a monkey to type in the cookie name...I dunno something. SOON.
*   - TODO: The Recover Password does not work for not. I intend on using SwiftMail to do that. I never got around to setting up a proper SMTP
*           because quite frankly I don't know how to set it up. Issues regarding firewall.
*/

require_once 'classes/Login.php';
require_once 'forms/login_form.php';
/**
* The construct in the Login class takes care of everything
*/
$login = new Login();
