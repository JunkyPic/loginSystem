Login System
===========

A simple PHP login system using Sessions

This README contains a lot more things than it should. I will SOON modify it.

Requirements
===========
 - PHP 5.3.7+
 - MySQL 5 database - Older version have a bug that allows SQL Inject. See [here](https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection) for a more detailed description.
 - A working SMTP. This is required in order to send the recover email in case of a lost password.
   - Edit the settings in the [SendMailRecoverPassword.php](https://github.com/JunkyPic/loginSystem/blob/Test/classes/SendMailRecoverPassword.php) file. If a proper SMTP is not provided the sending of the email will fail with a user friendly message. More useful errors will be provided in the Log files.

Installation
===========
 - Access a MySql terminal. Copy+paste the stuff in create_db.php file and hit enter.
 - Next comes the create_tables.php file located in the same folder.
   - The default storage engine is set to InnoDB. Mostly for the sole reason that it supports Transactions. Feel free to modify it to your needs. The login system doesn't require transactions, but they're nice to have for the future.
 -  A more user-friendly interface to create the database and tables will come SOON.
 - Configure the ConnectionFactory.php, with your database credentials, located in the /db folder.
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
