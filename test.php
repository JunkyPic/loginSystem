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
    

        
        if($this->dbPDO == NULL){
            try {
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


$dbConn = new ConnectionFactory;

for($i=0; $i<10000; $i++){
$string = str_shuffle('Android:anonymous:YW5kcm9pZF8FWw9IUzkita+KqzyztC5k');

$sql = $dbConn->getDbConn()->prepare("INSERT INTO login_table(login_username, login_password, login_email) VALUES (:string1, :string2, :string3)");
$sql->execute(array(':string1' => $string,
                    ':string2' => $string,
                    ':string3' => $string


                    ));

}


