<?php
/**
* Handles the register of the user
*/

class Register{
    private $_errors = array();
    
    public function __construct(){
	
        require_once 'forms/register_form.php';
        require_once 'SqlQueryController.php';
        require_once 'PasswordHash.php';
        require_once 'ValidateData.php';
        
        if(isset($_POST['register'])){
        
            /**
            * @param associative array
            * stripAllWhiteSpaces will remove ALL white spaces.
            * example: $stringBefore = ' this is an example';
            *          $stringAfter  = 'thisisanexample';
            */
            $credentials = ValidateData::stripAllWhiteSpaces(array('username'      => $_POST['username'],
                                                                   'password'      => $_POST['password'],
                                                                   'passwordAgain' => $_POST['passwordAgain'],
                                                                   'email'         => $_POST['email']
                                                                    )
                                                            );
            $this->doRegister($credentials);
        }
    }
    
    /**
    * Here we register the user
    * Add him to the database etc etc
    */
    public function doRegister($credentials){
		
        if( ! ValidateData::isEmpty($credentials)){

            /**
            * @bool regex match
            * The username must contain alphanumeric chars
            * and must be between 5 and 40 chars long
            * Example of valid username: thebrownfox_200
            */
            if( ! ValidateData::pregMatch('/^[a-z\d_]{5,40}$/i', $credentials['username'])){
                $this->_errors[] = '<p>The username must be between 5 and 20 characters long. And it can only contain numbers, letters and underscores!</p>';
            }
            
            if($credentials['password'] != $credentials['passwordAgain']){
                $this->_errors[] = '<p>The passwords do not match.<p>';
            }
            
            /**
            * Validate password
            * Example of valid password: Thequickbrown200!
            */
            if( ! ValidateData::pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $credentials['password'])){
                 $this->_errors[] = '<p>The password must be at least 5 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
            }
            
            /**
            * @bool 
            * check if email is valid
            */
            if( ! ValidateData::validateEmail($_POST['email'])){
                $this->_errors[] = '<p>Email is invalid.</p>';
            }
        
        } else {
            $this->_errors[] = '<p>Some fields are empty.</p>';
        }
        
        /**
        * Check if there are any errors so far.
        */
        if( ! empty($this->_errors)){
                foreach($this->_errors as $error){
                    echo $error;
                }
            return;
        }
       
        $passwordHash = new PasswordHash();
        
        $credentials['passwordHashed'] = $passwordHash->hashPassword($credentials['password']);
        
        $this->doInsert($credentials['username'],$credentials['passwordHashed'], $credentials['email']);
         
	}
    
    public function doInsert($username,$password, $email){

        /**
        * Require the database class that handles the connection
        */
        
        $sqlQueryController = new SqlQueryController();
        
        $query = "SELECT login_username
                  FROM login_table 
                  WHERE login_username=:username
                  OR login_email=:email LIMIT 1";
        $array = array(':username' => $username,
                        ':email'   => $email);
                                 
        $doCredentialsExist = $sqlQueryController->runQueryFetchAssoc($query, $array);

        if($doCredentialsExist['login_username'] == $username || $doCredentialsExist['login_email'] == $email){
            echo'<p>That username/email is already registered!</p>';
            return;
        }
       
        /**
        * Here we actually register the user
        * He passed all the checks and we can safely
        * insert him into the database
        */
        $query = "INSERT INTO login_table
                                       (login_username, 
                                        login_password, 
                                        login_email)
                  VALUES (:username, 
                          :password, 
                          :email)";
                          
        $array = array(':username' => $username,
                       ':password' => $password,
                       ':email'    => $email);
                                        
        if($sqlQueryController->runQueryExecute($query, $array)){
            echo '<p>Registration successful!</p>';
        } else {
            die('<p> There was an error in the registration process.</p>');
        }
    }

} 
