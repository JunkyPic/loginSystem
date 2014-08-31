<?php
/**
* Handles the password recovery
*/

/**
* TODO: Redesign this class. It's too bloated with functions and does waaay too many things for just one class!
*/
class RecoverPassword
{
    public function __construct(){
        if(isset($_POST['recoverPassword'])){
            $this->doRecover();
        }
    }
    
    /**
    * @bool
    * Note: This has some flaws
    * For example using numbers in the name of the email MAY give back some false negatives
    * For more details see this question: https://stackoverflow.com/questions/3722831/does-phps-filter-var-filter-validate-email-actually-work
    */
    private function isEmailValid($email){
        if (filter_var(trim($email), FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    
    private function doRecover(){
        if( ! empty($_POST['email'])){
            if($this->isEmailValid($_POST['email'])){
                $email = $_POST['email'];

                require_once 'db/db_connect.php';
                require_once 'db/db_tables.php';
                
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
                    echo 'The email exists. Currently the recover password email will not send due to not having a proper SMPT configured.';
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


