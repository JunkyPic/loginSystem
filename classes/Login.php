<?php
/**
* Handles the login of the user
*/

class Login{

    public function __construct(){

        if((isset($_SESSION['id'])) && (isset($_SESSION['username']))){
            header('Location: logged_in.php');
        }

        require_once 'PasswordHash.php';
        require_once 'SqlQueryController.php';
        require_once 'ValidateData.php';
        
        session_start();
        
        if(isset($_POST['login'])){
            /**
            * @param associative array
            * stripAllWhiteSpaces will remove ALL white spaces.
            * example: $stringBefore = ' this is an example';
            *          $stringAfter  = 'thisisanexample';
            */
            $credentials = ValidateData::stripAllWhiteSpaces(array('username' => $_POST['username'], 
                                                                   'password' => $_POST['password']
                                                                  )
                                                            );
            
            $this->doLogin($credentials);
        }
    }
    
    /**
    * Log in with post data
    */
    public function doLogin($credentials){
		if( ! ValidateData::isEmpty($credentials)){
            
            $passwordHash = new PasswordHash();
            
            $sqlQueryController = new SqlQueryController();
            
            $query = "SELECT login_password 
                      FROM login_table 
                      WHERE login_username=:username 
                      LIMIT 1";
                          
            $array = array(':username' => $credentials['username']);
            /**
            * @param associative array
            * return an associative array using PDO's fetch();
            */
            $hash = $sqlQueryController->runQueryFetch($query, $array);

            /**
            * @bool
            * verifies password based on the $hash
            * and the password provided by the user
            */
            $passwordVerify = $passwordHash->verifyPassword($credentials['password'], $hash['login_password']);
            
            $query = "SELECT login_username, login_id
                      FROM login_table
                      WHERE login_username=:username LIMIT 1";
                                 
            $array = array(':username' => $credentials['username']);
            
            $userVerify = $sqlQueryController->runQueryFetch($query, $array);

            if(($passwordVerify == 1) && ($userVerify['login_username'] == $credentials['username'])){

                /**
                * Great, the user's logged in
                * Time to set the session and redirect him
                */
                $_SESSION['id']       = $userVerify['login_id'];
                $_SESSION['username'] = $userVerify['login_username'];
                header('Location: logged_in.php');
            } else {
                echo '<p> The username or password do not match any registered users.</p>';
            }
        } else {
            echo '<p> You must fill in all fields.</p>';
		}		
	}
}
