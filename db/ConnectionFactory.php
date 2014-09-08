<?php
/**
* Returns a new connection to the database
* This could potentially be modified to create 
* a connection to any database. Currently 
* MySQL is used
*/

class ConnectionFactory{

    private $dbHost = "127.0.0.1";
    private $dbName = "login_system";
    private $dbUser = "root";
    private $dbPass = "asadar";
    private $dbPDO  = NULL;

    public function __construct(){
    
        require_once realpath(dirname(__FILE__) . '/..') . '/classes/WriteToLog.php';
        
        if($this->dbPDO == NULL){
            try{
                $this->dbPDO = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);

            }
             catch (PDOException $e) {
                //User friendly message
                echo '<p>Something went wrong.</p>';
                //Write the error to log file
                
                $error = 'Error: ' . $e->getMessage();
                
                //Write the error to log file
                writeToMySqlLog($error);
                
                die(); 
            }
        }
    }
    
    public function getDbConn(){
        return $this->dbPDO;
    }
}