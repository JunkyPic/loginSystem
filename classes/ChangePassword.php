<?php
/**
* Handles the password change
*/

/**
* TODO: Redesign this class. It's too bloated with functions and does waaay too many things for just one class!
*/

class ChangePassword
{
    /**
    * Instead of echoing each error on it's own
    * the errors are added to an array and iterate
    * thru the array before doing the updating
    * in the database. If the array is not empty
    * return to end the function essentially killing the script
    */
    private $errors = array();
    
    public function __construct(){
        
        if(isset($_POST['resetPassword'])){
            $this->doResetPassword();
        } 
    }

    private function doResetPassword(){

        require_once 'ValidateData.php';
        $validateData = new ValidateData();
        
        /**
        * Here nothing "interesting"
        * happends. Just some checks to make sure the user entered the right
        * information into the fields. If not add said errors to previously
        * mentioned array.
        */
        if(empty($_POST['passwordCurrent']) &&
           empty($_POST['passwordNew']) &&
           empty($_POST['passwordNewAgain'])){

            $errors[] = '<p>Some fields are empty</p>';
            
        } else {
            $passwordCurrent    = trim($_POST['passwordCurrent']);
            $passwordNew        = trim($_POST['passwordNew']);
            $passwordNewAgain   = trim($_POST['passwordNewAgain']);
            
            if($passwordNew != $passwordNewAgain){
                $errors[] = '<p>Passwords do not match.</p>';
            }   
            
            if($passwordNew == $passwordCurrent){
                $errors[] = '<p>Your new password cannot be the same as your old password.</p>';
            } 
            
            /**
            * Validate password
            * Example of valid password: Thequickbrown200!
            */
            if( ! $validateData->pregMatch('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,200}$/', $passwordNew)){
                $errors[] = '<p>The password must be between 5 and 200 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
            }

        }
        
        /**
        * If this array of errors is empty the user passed all the checks.
        * If not, a return happens, ending the script
        */
        if( ! empty($errors)){
            foreach($errors as $error){
                echo $error;
            }
            return;
        }
        
        /**
        * Here the user passed the checks
        * It's safe to update the database
        * with the new password
        */
        $this->insertPassword($passwordNew);
		$_SESSION = array();
		session_destroy();
    }
    
    private function insertPassword($passwordNew){

        /**
        * Hash the password
        */
        require_once 'PasswordHash.php';
        $passwordHash = new PasswordHash();
        
        $password = $passwordHash->hashPassword($passwordNew);

        /**
        * The username ID is dependent on the Session id
        * which is set to the username ID - in the database
        * you can find the username ID as equal to login_id
        * each ID is unique and each username is unique
        */
        $usernameId = $_SESSION['id'];
        
        require_once 'SqlQueries.php';
        $sqlQueries = new SqlQueries();
                
        $result = $sqlQueries->updateChangeForPassword($password, $usernameId);
        if($result){
            echo '<p>Successfully changed the password</p>';
        } else {
            echo '<p>An error occurred while changing the password</p>';
        }

    }

}