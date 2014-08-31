<?php
//READ THE README!

$host       = '127.0.0.1';
$root       = 'root';
$pass       = 'asadar';
$create_db  = 'login_system';

try {
    $db = new PDO("mysql:host=$host;dbname=$create_db", $root, $pass);

    $sqlQuery = "CREATE TABLE IF NOT EXISTS login_table 
    (login_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    login_username VARCHAR(60) NOT NULL, 
    login_password VARCHAR(255) NOT NULL, 
    login_email VARCHAR(256) NOT NULL)";
	/**
	* the login_password is 255 chars long due to the fact
	* that I'm using password_hash() as the default algorithm
	* currently it produces a 60 chars result, but it may change over time
	*/
	
    $result = $db->query($sqlQuery);
    /**
    * This will return true even though the table exists...I can't pin-point the error
    */
    if ($result) {
        echo 'Succesfully created login_table table.';
    } else {
        echo 'Unable to create table. Table already exists.';
    }
    
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}
