<?php

class ChangePassword{

    private $errors = array();
    private $credentials;
    
    public function __construct($credentials){
    

        
        $this->credentials = $credentials;
    }

    public function doResetPassword(){
        require_once 'PasswordHash.php';
        require_once 'SqlQueryController.php';
        
        $passwordHash = new PasswordHash();
        
        $sqlQueryController = new SqlQueryController();
        
        $hashedPassword = $passwordHash->hashPassword($this->credentials['passwordNew']);

        $usernameId = $_SESSION['id'];
        
        $query = "UPDATE users_table
                 SET login_password=:passwordNew 
                 WHERE login_id=:usernameId";
                                          
        $array = array(':passwordNew' => $hashedPassword,
                       ':usernameId'  => $usernameId);

        if($sqlQueryController->executeQuery($query, $array, 'execute')){
            echo '<p>Successfully changed the password</p>';
        } else {
            echo '<p>An error occurred while changing the password</p>';
        }
		$_SESSION = array();
		session_destroy();
    }
    


}