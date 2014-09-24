<?php

class Register{
    private $_errors = array();
    
    public function __construct(){
	
        require_once 'views/register_form.php';
        require_once 'SqlQueryController.php';
        require_once 'PasswordHash.php';
        require_once 'ValidateData.php';
        
        if(isset($_POST['register'])){
        
            $credentials = ValidateData::stripAllWhiteSpaces(array('username'      => $_POST['username'],
                                                                   'password'      => $_POST['password'],
                                                                   'passwordAgain' => $_POST['passwordAgain'],
                                                                   'email'         => $_POST['email']
                                                                    )
                                                            );
            $this->doRegister($credentials);
        }
    }
    
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
                 $this->_errors[] = '<p>The password must be at least 5 characters long, must contain at least one number, at least one letter and at least one of the following characters: ! @ # $ or %.</p>';
            }
            
            if( ! ValidateData::validateEmail($_POST['email'])){
                $this->_errors[] = '<p>Email is invalid.</p>';
            }
        
        } else {
            $this->_errors[] = '<p>Some fields are empty.</p>';
        }
        
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
        
        $sqlQueryController = new SqlQueryController();
        
        $query = "SELECT login_username
                  FROM users_table
                  WHERE login_username=:username
                  OR login_email=:email LIMIT 1";
        $array = array(':username' => $username,
                        ':email'   => $email);
                                 
        $doCredentialsExist = $sqlQueryController->executeQuery($query, $array, 'fetchAssoc');

        if($doCredentialsExist['login_username'] == $username || $doCredentialsExist['login_email'] == $email){
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
                          
        $array = array(':username' => $username,
                       ':password' => $password,
                       ':email'    => $email);
                                        
        if($sqlQueryController->executeQuery($query, $array, 'execute')){
            echo '<p>Registration successful!</p>';
        } else {
            die('<p> There was an error in the registration process.</p>');
        }
    }

} 
