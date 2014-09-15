<?php
/**
* Handles the password change
*/

class ChangePassword{

    private $_errors = array();
    
    public function __construct(){
    
        require_once 'PasswordHash.php';
        require_once 'ValidateData.php';
        require_once 'SqlQueryController.php';
        
        if(isset($_POST['resetPassword'])){
            /**
            * @param associative array
            * stripAllWhiteSpaces will remove ALL white spaces.
            * example: $stringBefore = ' this is an example';
            *          $stringAfter  = 'thisisanexample';
            */
            $credentials = ValidateData::stripAllWhiteSpaces(array('passwordCurrent' => $_POST['passwordCurrent'],
                                                                   'passwordNew'     => $_POST['passwordNew'],
                                                                   'passwordNewAgain'=> $_POST['passwordNewAgain']
                                                                  )
                                                            );
            $this->doResetPassword($credentials);
        } 
    }

    public function doResetPassword($credentials){
        /**
        * @bool
        * Loops thru the array if a value is empty returns true
        */
        if(ValidateData::isEmpty($credentials)){
        
            $_errors[] = '<p>Some fields are empty</p>';  
            
        } else {
            
            if($credentials['passwordNew'] != $credentials['passwordNewAgain']){
                $_errors[] = '<p>Passwords do not match.</p>';
            }   
            
            if($credentials['passwordNew'] == $credentials['passwordCurrent']){
                $_errors[] = '<p>Your new password cannot be the same as your old password.</p>';
            } 
            
            /**
            * @bool
            * Example of valid password: Thequickbrown200!
            */
            if( ! ValidateData::pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $credentials['passwordNew'])){
                $_errors[] = '<p>The password must be between 5 and 200 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
            }

        }
        
        if( ! empty($_errors)){
                foreach($_errors as $error){
                    echo $error;
            }
            return;
        }
        
        $this->insertPassword($credentials);
		$_SESSION = array();
		session_destroy();
    }
    
    public function insertPassword($credentials){
        
        $passwordHash = new PasswordHash();
        
        $hashedPassword = $passwordHash->hashPassword($credentials['passwordNew']);

        $usernameId = $_SESSION['id'];
        
        $sqlQueryController = new SqlQueryController();
        
        $query = "UPDATE login_table
                 SET login_password=:passwordNew 
                 WHERE login_id=:usernameId";
                                          
        $array = array(':passwordNew' => $hashedPassword,
                       ':usernameId'  => $usernameId);

        if($sqlQueryController->runQueryExecute($query, $array)){
            echo '<p>Successfully changed the password</p>';
        } else {
            echo '<p>An error occurred while changing the password</p>';
        }

    }

}