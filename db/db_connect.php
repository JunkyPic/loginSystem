<?php
define("DB_HOST", "127.0.0.1");
define("DB_NAME", "login_system");
define("DB_USER", "root");
define("DB_PASS", "asadar");

/**
* If it properly connects, life's good, if not return an error
*/
try {
    $dbPDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }
 catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

