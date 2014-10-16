<?php
require 'views/recover_password_form.php';
require 'classes/RecoverPassword.php';
require_once 'classes/ValidateCredentials.php';

if(isset($_POST['recoverPassword'])){

    $credentials = (array('email' => $_POST['email']
                           )
                    );
    
    $validateLostPassword = new ValidateCredentials($credentials, 'recoverpassword');
    
    if(($validateLostPassword->doValidate()) != FALSE){
        $credentials = $validateLostPassword->doValidate();
        
        $recoverPassword = new RecoverPassword($credentials);
        $recoverPassword->doRecoverPassword();
    }
}


