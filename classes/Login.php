<?php
/**
* Handles the login of the user
*/

/**
* TODO: Redesign this class. It's too bloated with functions and does waaay too many things for just one class!
*/
class Login
{
    
    public function __construct(){
        session_start();

		/**
		* TODO: Add remember me cookie
		* uncomment this when it's done
        if(isset($_POST['rememberMe'])){
            $_COOKIE['rememberMe'] = TRUE;
        }
		*/
		
        /**
		* If a session exists
        * Just redirect user to logged_in page.
        * Else, do login
	    */
        if((isset($_SESSION['id'])) && (isset($_SESSION['username']))){
            header('Location: logged_in.php');
        }

        if(isset($_POST['login'])){
            $this->doLogin();
        }
    }
    
    /**
    * log in with post data
    */
    private function doLogin(){

		if( ! empty($_POST['username']) &&
			! empty($_POST['password'])){
					
                $username = ($_POST['username']);
                $password = ($_POST['password']);
                
                require_once 'PasswordHash.php';
                $passwordHash = new PasswordHash();
                
                require_once 'SqlQueries.php';
                $sqlQueries = new SqlQueries();
                
                /**
                * $hash is the password stored in the database
                */
                $hash           = $sqlQueries->selectPasswordForLogin($username);
                
                /**
                * verifies password based on the $hash
                * and the password provided by the user
                */
                $passwordVerify = $passwordHash->verifyPassword($password, $hash['login_password']);
                
                /**
                * Compares the username input by the user
                * to the username stored in the database
                */
                $userVerify     = $sqlQueries->selectUsernameForLogin($username);

                
                if(($passwordVerify == 1) && ($userVerify['login_username'] == $username)){

                    /**
                    * Great, the user's logged in
                    * Time to set the session and redirect him
                    */
                    $_SESSION['id'] = $userVerify['login_id'];
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
