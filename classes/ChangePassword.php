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
            
            /**
            * See further down some notes about 
            * this function
            */
            if( ! $this->isPasswordValid($passwordNew)){
                $errors[] = '<p>The password must be between 5 and 40 characters long, must contain at least one number, at least one letter and at least one non Alphanumeric character.</p>';
            }
            
            if($passwordNew == $passwordCurrent){
                $errors[] = '<p>Your new password cannot be the same as your old password.</p>';
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
        * Go up one directory.
        * Conncatenate this var with paths from certain files
        */
        $upOneDir = realpath(__DIR__ . '/..');
        
        require_once $upOneDir . '/db/db_connect.php';
        require_once $upOneDir . '/db/db_tables.php';
        
        /**
        * PHP Version 5.4.31 doesn't support password_hash()
        * so I used an extension called password_compat
        * Link to lib - https://github.com/ircmaxell/password_compat
        */
        require $upOneDir . '/password_compat/lib/password.php';
        
        /**
        * NOTE: Hash strength is set to default(10)
        */
        $password = password_hash($passwordNew, PASSWORD_BCRYPT);
        
        /**
        * The username ID is dependent on the Session id
        * which is set to the username ID - in the database
        * you can find the username ID as equal to login_id
        * each ID is unique and each username is unique
        */
        $usernameId = $_SESSION['id'];
        
        $sqlQuery = $dbPDO->prepare("UPDATE $tableName SET $loginPassword=:passwordNew WHERE $loginId=:usernameId");
        $result = $sqlQuery->execute(array(':passwordNew' => $password,
                                           ':usernameId'  => $usernameId));
        if($result){
            echo '<p>Successfully changed the password</p>';
        } else {
            echo '<p>An error occurred while changing the password</p>';
        }

    }

    /**
    * @bool regex match 
    * The password requires at least one uppercase letter, at least one lower case letter
    * at least one number and at least any of the following characters: ! @ # $
    * Length must be between 5 and 40 characters long.
	* Example of valid password: Thequickbrown200!
    */
    private function isPasswordValid($password){
        return (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,40}$/', trim($password)));
    }

}