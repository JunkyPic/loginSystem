<?php

class Login{
    public function __construct(){

        require_once 'PasswordHash.php';
        require_once 'SqlQueryController.php';
        require_once 'ValidateData.php';
        
        if(isset($_POST['login'])){

            $credentials = ValidateData::stripAllWhiteSpaces(array('username' => $_POST['username'], 
                                                                   'password' => $_POST['password']
                                                                  )
                                                            );
            
            $this->doLogin($credentials);
        }
    }
    
    public function doLogin($credentials){
		if( ! ValidateData::isEmpty($credentials)){
            
            $passwordHash = new PasswordHash();
            
            $sqlQueryController = new SqlQueryController();
            
            $query = "SELECT login_password 
                      FROM users_table 
                      WHERE login_username=:username 
                      LIMIT 1";
                          
            $array = array(':username' => $credentials['username']);

            $hash = $sqlQueryController->executeQuery($query, $array, 'fetch');


            $passwordVerify = $passwordHash->verifyPassword($credentials['password'], $hash['login_password']);
            
            $query = "SELECT login_username, login_id
                      FROM users_table
                      WHERE login_username=:username LIMIT 1";
                                 
            $array = array(':username' => $credentials['username']);
            
            $userVerify = $sqlQueryController->executeQuery($query, $array, 'fetch');

            if(($passwordVerify == 1) && ($userVerify['login_username'] == $credentials['username'])){
                
                $_SESSION['id']       = $userVerify['login_id'];
                $_SESSION['username'] = $userVerify['login_username'];

                header('Location: logged_in.php');
                die();
            } else {
                echo '<p> The username or password do not match any registered users.</p>';
            }
        } else {
            echo '<p> You must fill in all fields.</p>';
		}		
	}
}
