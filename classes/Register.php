<?php
/**
* Handles the register of the user
*/

/**
* TODO: Redesign this class. It's too bloated with functions and does waaay too many things for just one class!
*/
class Register
{
    private $errors = array();
	
    private $username = NULL;
    
    private $password = NULL;
    
    public function __construct(){
	
        require_once 'forms/register_form.php';
        
        if(isset($_POST['register'])){
            $this->doRegister();
        }
    }
    
    /**
    * @bool
    */
    private function isEmailValid($email){
        if (filter_var(trim($email), FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    
    /**
    * @bool regex match
    * The username must contain alphanumeric chars
    * and must be between 5 and 20 chars long
    * Example of valid username: thebrownfox
    */
    private function isUsernameValid($username){
        return (preg_match('/^[a-z\d_]{5,20}$/i', trim($username)));
    }
    
    /**
    * @bool regex match 
    * The password requires at least one uppercase latter, at least one lower case letter
    * at least one number and at least any of the following characters: ! @ # $
    * Length must be between 5 and 40 characters long.
	* Example of valid password: Thequickbrown200!
    */
    private function isPasswordValid($password){
        return (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,40}$/', trim($password)));
    }
    
    /**
    * Here we register the user
    * Add him to the database etc etc
    */
    private function doRegister(){
		
	if( ! empty($_POST['username']) &&
		! empty($_POST['password']) &&
		! empty($_POST['email'])	&&
		! empty($_POST['passwordAgain'])){

			/**
			* @bool
			*/
			if($this->isUsernameValid($_POST['username'])){
				$username = trim($_POST['username']);
			} else {
				$errors[] = '<p>The username must be between 5 and 20 characters long. And it can only contain numbers and letters!</p>';
			}
			
			/**
			* @bool
			*/
			if($this->isEmailValid($_POST['email'])){
				$email = trim($_POST['email']);
			} else {
				$errors[] = '<p>Email is invalid</p>';
			}
			/**
			* Check weather the password is valid
			*/
			if($this->isPasswordValid($_POST['password'])){
				$password = trim($_POST['password']);
				$passwordAgain = trim($_POST['passwordAgain']);
				
				if($password != $passwordAgain){
					$errors[] = '<p>The passwords do not match.<p>';
				}
				/**
				* PHP Version 5.4.31 doesn't support password_hash()
				* so I used an extension called password_compat
				* Link to lib - https://github.com/ircmaxell/password_compat
				*/
				require 'password_compat/lib/password.php';
				
				$password = password_hash($password, PASSWORD_BCRYPT);
			} else {
				$errors[] = '<p>The password must be between 5 and 40 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
			}
			

	} else {
		$errors[] = '<p>Some fields are empty.</p>';
	}
	
	/**
	* Check if there are any errors so far.
	* I can't check after the queries because if some fields
	* are empty PHP would slap me with an error
* Also this is bad coding, i need to split up this class
	*/
	if (!empty($errors)) {
		foreach($errors as $error){
			echo $error;
		}
		return;
	}
	
	require_once 'db/db_connect.php';
	require_once 'db/db_tables.php';
	
	/**
	* The queries below are repetitive
	* in order to display an error for
	* username or email
	* I think I could marked the columns in the DB
	* as Unique to make things easier however I didn't get around to trying that
	* and I'm not sure if it works
	*/
	
	$sqlQuery = $dbPDO->prepare("SELECT $loginUsername FROM $tableName WHERE $loginUsername=:username");
	$sqlQuery->execute(array(':username' => $username));
	$doesUsernameExist = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	
	if($doesUsernameExist['login_username'] == $username){
		$errors[] = '<p>That username is already registered!</p>';
	}
	
	$sqlQuery = $dbPDO->prepare("SELECT $loginEmail FROM $tableName WHERE $loginEmail=:email");
	$sqlQuery->execute(array(':email' => $email));
	$doesEmailExist = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	
	/**
	* Does email already exist?
	*/
	if($doesEmailExist['login_email'] == $email){
		$errors[] = '<p>That email is already registered!</p>';
	}
	
	/**
	* This foreach below is bad coding
	* I need to split up my code into several
	* classes, this class is doing too much
	*/
	if (!empty($errors)) {
		foreach($errors as $error){
			echo $error;
		}
		return;
	}
	
	/**
	* Here we actually register the user
	* He passed all the checks and we can safely
	* insert him into the database
	*/
	$sqlQuery = $dbPDO->prepare("INSERT INTO $tableName($loginUsername, $loginPassword, $loginEmail)
								 VALUES (:username, :password, :email)");
		if($sqlQuery->execute(array(':username' => $username,
									':password' => $password,
									':email'    => $email))){
			echo '<p>Registration successful!</p>';
		} else {
			die('<p> There was an error in the registration process.</p>');
		}                         
	}
} 
