<?php
require_once 'classes/Register.php';
require_once 'views/register_form.php';
require_once 'classes/ValidateCredentials.php';

if(isset($_POST['register'])){

    $credentials = (array('username'      => $_POST['username'],
                           'password'      => $_POST['password'],
                           'passwordAgain' => $_POST['passwordAgain'],
                           'email'         => $_POST['email']
                         )
                    );
                                                    
    $validateRegister = new ValidateCredentials($credentials, 'register');
    
    if(($validateRegister->doValidate()) != FALSE){
        $credentials = $validateRegister->doValidate();
        
        $register = new Register($credentials);
        $register->doRegister();
    }
}