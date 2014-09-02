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
    
    public function __construct(){
	
        require_once 'forms/register_form.php';
        
        if(isset($_POST['register'])){
            $this->doRegister();
        }
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
            
                require_once 'PasswordHash.php';
                $passwordHash = new PasswordHash();
                
                require_once 'ValidateData.php';
                $validateData = new ValidateData();

                /**
                * @bool regex match
                * The username must contain alphanumeric chars
                * and must be between 5 and 20 chars long
                * Example of valid username: thebrownfox
                */
                if($validateData->pregMatch('/^[a-z\d_]{5,20}$/i', $_POST['username'])){
                    $username = trim($_POST['username']);
                } else {
                    $errors[] = '<p>The username must be between 5 and 20 characters long. And it can only contain numbers and letters!</p>';
                }
                
                /**
                * Validate password
                * Example of valid password: Thequickbrown200!
                */
                if($validateData->pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $_POST['password'])){
                    $password       = trim($_POST['password']);
                    $passwordAgain  = trim($_POST['passwordAgain']);
                    
                    if($password != $passwordAgain){
                        $errors[] = '<p>The passwords do not match.<p>';
                    }
                    /**
                    * Hash the password
                    */
                    $password = $passwordHash->hashPassword($password);
                    
                } else {
                    $errors[] = '<p>The password must be at least 5 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
                }
                
                /**
                * @bool check if email is valid
                */
                if($validateData->validateEmail($_POST['email'])){
                    $email = trim($_POST['email']);
                } else {
                    $errors[] = '<p>Email is invalid</p>';
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
        
        require_once 'SqlQueries.php';
        $sqlQueries = new SqlQueries();

        $doesItExist = $sqlQueries->selectEmailUsernameForRegister($username, $email);
        
        if($doesItExist['login_username'] == $username || $doesItExist['login_email'] == $email){
            $errors[] = '<p>That username/email is already registered!</p>';
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

        $result = $sqlQueries->insertUsernameEmailPassForRegister($username, $email, $password);
        if($result){
            echo '<p>Registration successful!</p>';
        } else {
            die('<p> There was an error in the registration process.</p>');
        }                         
	}
} 
