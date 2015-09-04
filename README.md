Login System
===========

DO NOT USE THIS. REALLY. IT WAS MADE FOR PRACTICE A REALLY LONG TIME AGO.

==========
 

Requirements
===========
 - PHP 5.3.7+
 - MySQL 5+
 - A working SMTP. This is required in order to send the recover email in case of a lost password.
   - Edit the settings in the [SendMailRecoverPassword.php](https://github.com/JunkyPic/loginSystem/blob/Test/classes/SendMailRecoverPassword.php) file. If a proper SMTP is not provided the sending of the email will fail with a user friendly message. More useful errors will be provided in the Log files.

Installation
===========
 - Use the queries in the _installation folder to create the database and tables
 - Configure the ConnectionFactory.php, with your database credentials, located in the db/ folder.
 - Configure the SendMailRecoverPassword.php file with your SMTP credentials.
  - NOTE: If the files are not configured, the errors thrown are user friendly. Useful errors are logged in the logFiles folder.
 - Change the date_default_timezone_set() in the WriteToLog.php, located in the classes folder, to your default time zone.
  - NOTE: This is more of an Optional thing. Currently the timezone is GMT +2. If you're ok with that, you can leave it as default. It won't affect the logging of errors at all.

That's about it.

----

A few things to note and some TODOs:
   - SOON - Trademark - See this link for clarification - http://www.wowwiki.com/Soon
   - TODO: Split up classes. As it stands they are too bloated with functions. One class does way more than it needs to.
My Responsability Separation is not good at all.
   - TODO: Implement a repository pattern(and probably other stuff) - tutorial [here](http://code.tutsplus.com/tutorials/the-repository-design-pattern--net-35804)
   - TODO: Rewrite CSS. It's all manner of wrong.
