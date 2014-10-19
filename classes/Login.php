<?php

class Login{
    private $credentials;
    
    public function __construct($credentials){
        $this->credentials = $credentials; 
    }
    
    public function doLogin($credentials){
        
        require_once 'PasswordHash.php';
        require_once 'SqlQueryController.php';
        require_once 'ValidateData.php';
        
        if($this->credentials == FALSE){
            return;
        }
        
        $passwordHash = new PasswordHash();
        
        $sqlQueryController = new SqlQueryController();
        
        $query = "SELECT login_password 
                  FROM users_table 
                  WHERE login_username=:username 
                  LIMIT 1";
                      
        $array = array(':username' => $this->credentials['username']);

        $hash = $sqlQueryController->executeQuery($query, $array, 'fetch');


        $passwordVerify = $passwordHash->verifyPassword($this->credentials['password'], $hash['login_password']);
        
        $query = "SELECT login_username, login_id
                  FROM users_table
                  WHERE login_username=:username LIMIT 1";
                             
        $array = array(':username' => $this->credentials['username']);
        
        $userVerify = $sqlQueryController->executeQuery($query, $array, 'fetch');

        if(($passwordVerify == 1) && ($userVerify['login_username'] == $this->credentials['username'])){
            
            $_SESSION['id']       = $userVerify['login_id'];
            $_SESSION['username'] = $userVerify['login_username'];

            header('Location: logged_in.php');
            die();
        } else {
            echo '<p> The username or password do not match any registered users.</p>';
        }		
	}
}
