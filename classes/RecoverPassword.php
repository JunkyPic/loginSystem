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
    

    private function doRecover(){
        if( ! empty($_POST['email'])){
        
            require_once 'ValidateData.php';
            $validateData = new ValidateData();
            
            require_once 'db/db_connect.php';
            require_once 'db/db_tables.php';
                
            if($validateData->validateEmail($_POST['email'])){
                $email = $_POST['email'];

                /**
                * Note that the variables used here
                * come from the db_tables.php file
                * not from user input
                */
                $sqlQuery = $dbPDO->prepare("SELECT $loginEmail FROM $tableName WHERE $loginEmail= :email");
                $sqlQuery->execute(array(':email' => $email));
                
                $doesEmailExist = $sqlQuery->fetch(PDO::FETCH_ASSOC);
                
                /**
				* Does the email exist?
				*/
                if($doesEmailExist){
                    //echo $doesEmailExist['login_email'];
                    echo '<p>The email exists. Currently the recover password email will not send due to not having a proper SMPT configured.</p>';
					/**
					* TODO: Make this work. Configure SMTP server -> SwitfMail
                    * Swift Mailer is downloaded and configured now.
                    * Uncomment this when I get a chance to test
                    * require_once 'SendMailRecoverPassword.php';
                    * $swift = new RecoverPasswordFunctions();
					*/
                    
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


