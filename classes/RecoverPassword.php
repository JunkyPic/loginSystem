<?php
/**
* Handles the password recovery
*/

/**
* TODO: Redesign this class. It's too bloated with functions 
* and does waaay too many things for just one class!
*/
class RecoverPassword
{
    public function __construct(){
        if(isset($_POST['recoverPassword'])){
            $this->doRecover();
        }
    }
    
    public function doRecover(){
        if( ! empty($_POST['email'])){
        
            require_once 'ValidateData.php';
            $validateData = new ValidateData();
                
            if($validateData->validateEmail($_POST['email'])){
                $email = $_POST['email'];

                /**
                * Require the database class that handles the connection
                */
                require_once 'SqlQueryController.php';
                $sqlQueryController = new SqlQueryController();
                
                $query = "SELECT login_email
                          FROM login_table
                          WHERE login_email=:email LIMIT 1";
                $array = array(':email' => $email);
                
                $doesEmailExist = $sqlQueryController->runQueryFetchAssoc($query, $array);
                
                /**
				* Does the email exist?
				*/
                if($doesEmailExist){
                    /**
                    * Require and instantiate the class here
                    * If a proper SMTP is not configured, the password
                    * will not be changed and the page will die
                    * with a user friendly error.
                    * A more useful error can be found in the log fiels
                    * WARNING: The __construct() of the class is built
                    * in such a way that it will throw the exception and die
                    * after. Point is, don't move this further down the page
                    * or the password WILL be changed but the email will NOT
                    * be sent if the SMTP is not configured!
                    */
                    require_once 'SendMailRecoverPassword.php';
                    $swift = new SendMailRecoverPassword();
                    
                    /**
                    * Require the password hash file
                    * Instantiate the class
                    */
                    require_once 'PasswordHash.php';
                    $passwordHash = new PasswordHash();
                    
                    /*
                    * Create a random string of letteres and numbesr
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
                                   ':email'    => $email);
                                   
                    $sqlQueryController->runQueryExecute($query, $array);
                    
                    /**
                    * Create the message
                    */
                    $swift->createMessage($randomPassword, $email);
                    
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
            
        } else {
            echo ('<p>Email field is empty!</p>');
        }
    }
}


