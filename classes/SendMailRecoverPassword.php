<?php

class RecoverPasswordFunctions
{
    /**
    * Require files for swift mailer
    * Create new instance of require class
    */
    public function __construct(){
        require_once '../swiftmailer/lib/swift_required.php';
        $message = Swift_Message::newInstance();
    }
    
    private function mailSubject(){
        return $subject = $this->$message->setSubject('Password reset');
    }
    
    private function mailFrom(){
        return $from = $this->$message->setFrom(array('no-reply@domain.com'=> 'no-reply'));
    }
    
    private function mailTo(){
        //TODO
    }
    
    private function mailBody(){
        return $mailMessage = $this-$message->setBody('Hello, You have requested a password reset.');
    }
}

