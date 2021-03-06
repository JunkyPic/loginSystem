<?php
session_start();

if(isset($_SESSION['id'])){
	include 'views/change_password_form.php';
	require_once 'classes/ChangePassword.php';
    require_once 'classes/ValidateCredentials.php';
    
    if(isset($_POST['resetPassword'])){

        $credentials = (array('passwordCurrent' => $_POST['passwordCurrent'],
                               'passwordNew'     => $_POST['passwordNew'],
                               'passwordNewAgain'=> $_POST['passwordNewAgain']
                              )
                        );
                                                            
        $validateChangePassword = new ValidateCredentials($credentials, 'resetpassword');
        
        if(($validateChangePassword->doValidate()) != FALSE){
            $credentials = $validateChangePassword->doValidate();
            
            $ChangePassword = new ChangePassword($credentials);
            $ChangePassword->doResetPassword();
        }
    }
                                                    
} else {
    header('Location: index.php' . $redirect);
}
