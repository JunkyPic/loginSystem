<?php

class ChangePassword{

    private $errors = array();
    private $credentials;
    
    public function __construct($credentials){
    
        require_once 'PasswordHash.php';
        require_once 'SqlQueryController.php';
        
        $this->credentials = $credentials;
    }

    public function doResetPassword(){
        
        $passwordHash = new PasswordHash();
        
        $hashedPassword = $passwordHash->hashPassword($this->credentials['passwordNew']);

        $usernameId = $_SESSION['id'];
        
        $sqlQueryController = new SqlQueryController();
        
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
