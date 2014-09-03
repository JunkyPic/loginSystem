<?php
/**
* Temporary file
* TODO: Create factory to replace this class
*/

class SqlQueries
{
    private $dbHost         = "127.0.0.1";
    private $dbName         = "login_system";
    private $dbUser         = "root";
    private $dbPass         = "asadar";
    
    private $tableName      = 'login_table';

    private $loginId        = 'login_id';
    private $loginUsername  = 'login_username';
    private $loginPassword  = 'login_password';
    private $loginEmail     = 'login_email';
    
    public $dbPDO = NULL;
      
    public  function __construct(){
        try {
           $this->dbPDO = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);
        }
         catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    
    public function selectPasswordForLogin($username){
        $sqlQuery = $this->dbPDO->prepare("SELECT $this->loginPassword 
                                    FROM $this->tableName 
                                    WHERE $this->loginUsername=:username");
        $sqlQuery->execute(array(':username' => $username));
        return $sqlQuery->fetch();
    }
    
    public function selectUsernameForLogin($username){
        $sqlQuery = $this->dbPDO->prepare("SELECT $this->loginUsername, $this->loginId  
                                    FROM $this->tableName 
                                    WHERE $this->loginUsername=:username");
                                     
        $sqlQuery->execute(array(':username' => $username));
        return $sqlQuery->fetch();
    }
    
    public function updateChangeForPassword($password, $usernameId){
        $sqlQuery = $this->dbPDO->prepare("UPDATE $this->tableName SET $this->loginPassword=:passwordNew WHERE $this->loginId=:usernameId");
        return $sqlQuery->execute(array(':passwordNew' => $password,
                                        ':usernameId'  => $usernameId));
    }
    
    public function selectLoginEmailForRecoverPassword($email){
        $sqlQuery = $this->dbPDO->prepare("SELECT $this->loginEmail FROM $this->tableName WHERE $this->loginEmail= :email");
        $sqlQuery->execute(array(':email' => $email));
        
        return $sqlQuery->fetch(PDO::FETCH_ASSOC);
    }
    
    public function selectEmailUsernameForRegister($username, $email){
        $sqlQuery = $this->dbPDO->prepare("SELECT $this->loginUsername FROM $this->tableName WHERE $this->loginUsername=:username OR $this->loginEmail=:email");
        $sqlQuery->execute(array(':username' => $username,
                                 ':email'    => $email));
        return $sqlQuery->fetch(PDO::FETCH_ASSOC);
    }
    
    public function insertUsernameEmailPassForRegister($username, $email, $password){
        $sqlQuery = $this->dbPDO->prepare("INSERT INTO $this->tableName($this->loginUsername, $this->loginPassword, $this->loginEmail)
                                     VALUES (:username, :password, :email)");
        return $sqlQuery->execute(array(':username' => $username,
                                        ':password' => $password,
                                        ':email'    => $email));
    }
    
}

 