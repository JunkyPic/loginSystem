<?php
/**
* Handles the password recovery
*/

class RecoverPassword{

    public function __construct(){
    
        require_once 'PasswordHash.php';
        require_once 'SendMailRecoverPassword.php';
        require_once 'ValidateData.php';
        require_once 'SqlQueryController.php';
        
        if(isset($_POST['recoverPassword'])){
            /**
            * @param associative array
            * stripAllWhiteSpaces will remove ALL white spaces.
            * example: $stringBefore = ' this is an example';
            *          $stringAfter  = 'thisisanexample';
            */
            $credentials = ValidateData::stripAllWhiteSpaces(array('email' => $_POST['email']
                                                                   )
                                                            );
            $this->doRecoverPassword($credentials);
        }
    }
    
    public function doRecoverPassword($credentials){
        
        if(ValidateData::validateEmail($credentials['email'])){

            $sqlQueryController = new SqlQueryController();
            
            $query = "SELECT login_email
                      FROM login_table
                      WHERE login_email=:email LIMIT 1";
            $array = array(':email' => $credentials['email']);
            
            $emailExist = $sqlQueryController->runQueryFetchAssoc($query, $array);
            
            if($emailExist){
            
                /**
                * If a proper SMTP is not configured, the password
                * will not be changed and the page will die
                * with a user friendly error.
                * A more useful error can be found in the log fiels
                * The __construct() of the class is built
                * in such a way that it will throw the exception and die
                * after. Point is, don't move this further down the page
                * or the password WILL be changed but the email will NOT
                * be sent if the SMTP is not configured!
                */
                $swift = new SendMailRecoverPassword();
                
                $passwordHash = new PasswordHash();
                
                /*
                * Create a random string of letteres and numbers
                * This will be the users new password
                */
                $randomPassword = str_shuffle('abcdefghijklmnopqrstqwxz0123456789ABCDEFGHIJKLMNOPQRSTWXZ');
                
                /**
                * Hash the random string
                */
                $newPassword = $passwordHash->hashPassword($randomPassword);

                /**
                * Update the new hashed password
                * replacing the old password
                */
                $query = "UPDATE login_table
                          SET login_password=:password
                          WHERE login_email=:email LIMIT 1";
                $array = array(':password' => $newPassword,
                               ':email'    => $credentials['email']);
                               
                $sqlQueryController->runQueryExecute($query, $array);
                
                /**
                * Create the message
                */
                $swift->createMessage($randomPassword, $credentials['email']);
                
                /**
                * Return the newly created message
                */
                $message = $swift->getMessage();
                
                /**
                * Send the message
                */
                if($swift->sendMessage($message)){
                    echo '<p>Check your inbox for the new password. Your old password will no longer work</p>';
                }
                
            } else {
                echo '<p>Email doesn\'t exist!</p>';
            }
              
        } else {
            echo '<p>Email is invalid</p>';
        }

    }
}


