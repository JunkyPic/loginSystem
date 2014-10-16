<?php

class ValidateCredentials{
    
    private $credentials = array();
    private $type;
    private $errors = array();
    
    public function __construct($credentials, $type){
    
        require_once 'ValidateData.php';
    
        $this->credentials  = ValidateData::stripAllWhiteSpaces($credentials);
        $this->type         = strtolower($type);
        
    }
    
    public function doValidate(){
        switch($this->type){
            case 'login':
                    
                    if( ! ValidateData::isEmpty($this->credentials)){
                        return $this->credentials;
                    } else {
                        echo'<p> You must fill in all fields.</p>';
                        return false;
                    }
            
            case 'register':
            
                    if(ValidateData::isEmpty($this->credentials)){
                        $this->errors[] = '<p>Some fields are empty.</p>';
                    }
                    /**
                    * @bool regex match
                    * The username must contain alphanumeric chars
                    * and must be between 5 and 40 chars long
                    * Example of valid username: thebrownfox_200
                    */
                    if( ! ValidateData::pregMatch('/^[a-z\d_]{5,40}$/i', $this->credentials['username'])){
                        $this->errors[] = '<p>The username must be between 5 and 20 characters long. And it can only contain numbers, letters and underscores!</p>';
                    }
                    
                    if($this->credentials['password'] != $this->credentials['passwordAgain']){
                        $this->errors[] = '<p>The passwords do not match.<p>';
                    }
                    
                    /**
                    * Validate password
                    * Example of valid password: Thequickbrown2!
                    */
                    if( ! ValidateData::pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $this->credentials['password'])){
                         $this->errors[] = '<p>The password must be at least 5 characters long, must contain at least one number, at least one letter and at least one of the following characters: ! @ # $ or %.</p>';
                    }
                    
                    if( ! ValidateData::validateEmail($_POST['email'])){
                        $this->errors[] = '<p>Email is invalid.</p>';
                    }

                    if( ! empty($this->errors)){
                            foreach($this->errors as $error){
                                echo $error;
                            }
                        $error = array();
                        return FALSE;
                    }
                    
                    return $this->credentials;
                    
            case 'resetpassword':
            
                    if(ValidateData::isEmpty($this->credentials)){
                    
                        $errors[] = '<p>Some fields are empty</p>';  
                        
                    } else {
                        
                        if($this->credentials['passwordNew'] != $this->credentials['passwordNewAgain']){
                            $errors[] = '<p>Passwords do not match.</p>';
                        }   
                        
                        if($this->credentials['passwordNew'] == $this->credentials['passwordCurrent']){
                            $errors[] = '<p>Your new password cannot be the same as your old password.</p>';
                        } 
                        
                        /**
                        * @bool
                        * Example of valid password: Thequickbrown200!
                        */
                        if( ! ValidateData::pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $this->credentials['passwordNew'])){
                            $errors[] = '<p>The password must be between 5 and 200 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
                        }

                    }
                    
                    if( ! empty($errors)){
                            foreach($errors as $error){
                                echo $error;
                        }
                        $error = array();
                        return FALSE;
                    }
                    
                    return $this->credentials;
                    
            case 'recoverpassword':
                    if( ! ValidateData::validateEmail($this->credentials['email'])){
                        $this->errors[] = '<p>Email is invalid</p>';
                    }
                    
                    if( ! empty($this->errors)){
                            foreach($this->errors as $error){
                                echo $error;
                            }
                        $error = array();
                        return FALSE;
                    }
                    
                    return $this->credentials;
                    
        }
        
    }
    
}