<?php

class MySQL{
    /**
    * Fill these in with database credentials
    */
    private $dbHost = "localhost";
    private $dbName = "login_db";
    private $dbUser = "root";
    private $dbPass = "asadar";
    private $conn   = NULL;
    
    public function getInstance(){
        if ($this->conn == NULL) {
            try{
                $this->conn = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);
            } catch (PDOException $e) {
                //User friendly message
                echo '<p>Something went wrong.</p>';

                //Write this error to a log file
                require_once realpath(dirname(__FILE__) . '/..') . '/classes/WriteToLog.php';
                $error = 'Error: ' . $e->getMessage();
                writeToMySqlLog($error);
                
                die(); 
            }
        }
        return $this->conn;
    }
}
