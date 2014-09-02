<?php
/**
* 
*/

class PasswordHash
{
    public function __construct(){
        /**
        * PHP Version 5.4.31 doesn't support password_hash()
        * so I used an extension called password_compat
        * Link to lib - https://github.com/ircmaxell/password_compat
        */
        require_once 'password_compat/lib/password.php';
    }
    
    public function hashPassword($password){
        /**
        * The encryption strenght is set to default(10)
        */
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    public function verifyPassword($password, $hash){
        return password_verify($password, $hash);
    }

}