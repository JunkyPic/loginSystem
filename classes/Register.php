<?php

class Register{
    private $_errors = array();
    private $credentials;
    
    public function __construct($credentials){
	
        require_once 'SqlQueryController.php';
        require_once 'PasswordHash.php';
        require_once 'ValidateData.php';

        $this->credentials = $credentials;
    }
    
    public function doRegister(){
       
        $passwordHash = new PasswordHash();
        
        $this->credentials['passwordHashed'] = $passwordHash->hashPassword($this->credentials['password']);

        $sqlQueryController = new SqlQueryController();
        
        $query = "SELECT login_username
                  FROM users_table
                  WHERE login_username=:username
                  OR login_email=:email LIMIT 1";
        $array = array(':username' => $this->credentials['username'],
                        ':email'   => $this->credentials['email']);
                                 
        $doCredentialsExist = $sqlQueryController->executeQuery($query, $array, 'fetchAssoc');

        if(($doCredentialsExist['login_username'] == $this->credentials['username']) || ($doCredentialsExist['login_email'] == $this->credentials['email'])){
            echo'<p>That username/email is already registered!</p>';
            return;
        }
       
        $query = "INSERT INTO users_table
                                       (login_username, 
                                        login_password, 
                                        login_email)
                  VALUES (:username, 
                          :password, 
                          :email)";
                          
        $array = array(':username' => $this->credentials['username'],
                       ':password' => $this->credentials['passwordHashed'],
                       ':email'    => $this->credentials['email']);
                                        
        if($sqlQueryController->executeQuery($query, $array, 'execute')){
            echo '<p>Registration successful!</p>';
        } else {
            die('<p> There was an error in the registration process.</p>');
        }

    }
} 
