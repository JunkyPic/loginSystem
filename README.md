Login System
===========

A simple PHP login system using Sessions

This README contains a lot more things than it should. I will SOON modify it.

Requirements
===========
 - PHP 5.3.7+
 - MySQL 5 database - Older version have a bug that allows SQL Inject. See [here](https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection) for a more detailed description.
 - Optional:
	- A working STMP server - The functionality of sending emails for password recovery is not yet implemented. SOON.

Installation
===========
 - Modifty the create_db.php file, located in the _installation folder, with your DB credentials and access.
 - Next comes the  create_tables.php file located in the same folder.
 -  OR simply create the tables yourself using SQL.
 -  A more user-friednly iterface to create the database and tables will come SOON.
That's about it.

----

A few things to note and some TODOs:
   - SOON - Trademark - See this link for clarification - http://www.wowwiki.com/Soon
   - TODO: Split up classes. As it stands they are too bloated with functions. One class does way more than it needs to.
My Responsability Separation is not good at all.
   - TODO: The Recover Password does not work for now. I intend on using SwiftMail to do that. I never got around to setting up a proper SMTP.
   - TODO: Implement a repository pattern(and probably other stuff) - tutorial [here](http://code.tutsplus.com/tutorials/the-repository-design-pattern--net-35804)
   - TODO: Rewrite CSS. It's all manner of wrong.
