Login System
===========

Requirements
===========
 - PHP 5.3.7+
 - MySQL 5+
 - A working SMTP. This is required in order to send the recover email in case of a lost password.
   - Edit the settings in the [SendMailRecoverPassword.php](https://github.com/JunkyPic/loginSystem/blob/Test/classes/SendMailRecoverPassword.php) file. If a proper SMTP is not provided the sending of the email will fail with a user friendly message. More useful errors will be provided in the Log files.

Installation
===========
 - Use the queries in the _installation folder to create the database and tables
  - NOTE: If the files are not configured, the errors thrown are user friendly. Useful errors are logged in the logFiles folder.
 - Change the date_default_timezone_set() in the WriteToLog.php, located in the classes folder, to your default time zone.
  - NOTE: This is more of an Optional thing. Currently the timezone is GMT +2. If you're ok with that, you can leave it as default. It won't affect the logging of errors at all.

That's about it.

----

   - SOON - Trademark - See this link for clarification - http://www.wowwiki.com/Soon
