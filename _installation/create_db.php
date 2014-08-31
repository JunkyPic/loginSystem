<?php
//READ THE README!

$host       = '127.0.0.1';
$root       = 'root';
$pass       = 'asadar';
$create_db  = 'login_system';

try {
    $db = new PDO("mysql:host=$host", $root, $pass);

    if($db->exec("CREATE DATABASE $create_db")){
        echo 'Database successfully created.';

    } else {
        die(print_r($db->errorInfo(), true));
    }
    
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}
