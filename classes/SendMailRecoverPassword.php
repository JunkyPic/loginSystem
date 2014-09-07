<?php
/**
* This file requires a valid SMTP to function
* @Setup:
*        - Set the $SMTPUsername
*        - Set the $SMTPPassword
*        - Set the $port
* @Optional:
*        - Modify the stuff in createMessage() function. They can be left as default. It won't affect the sending of the emails
* See http://swiftmailer.org/docs/sending.html for furher information 
* on how to set it up
*/

class SendMailRecoverPassword
{
    private $message;

    private $transport;
    private $SMTP;
    private $port = 25;
    private $SMTPUsername = 'USERNAME GOES HERE';
    private $SMTPPassword = 'PASSWORD GOES HERE';
    private $mailer;
    
    public function __construct(){

        /**
        * Require files for swift mailer
        * Create new instance of require class
        */
        require_once realpath(dirname(__FILE__) . '/..') . '/swiftmailer/lib/swift_required.php';
        require_once 'WriteToLog.php';
       
        $this->transport = Swift_SmtpTransport::newInstance($this->SMTP, $this->port);
        $this->transport->setUsername($this->SMTPUsername);
        $this->transport->setPassword($this->SMTPPassword);
        
        /**
        * Check the trasport here if it doesn't work
        * Kill the page and write to log file
        */
        $this->checkTransport();
        
        /**
        * Creates a new instance of Swift_Message
        * and assigns it to the $message variable
        */
        $this->message = Swift_Message::newInstance();
        
        $this->mailer = Swift_Mailer::newInstance($this->transport);
    }
    
    public function createMessage($newPassword, $email){
    
        $this->message->setSubject('Password reset');
        $this->message->setFrom(array('no-reply@domain.com'=> 'no-reply'));
        $this->message->setTo(array($email => 'User'));
        $this->message->setBody('Hello, You have requested a password reset. Your new password is: ' . $newPassword);
    
    }
    public function getMessage(){
        return $this->message;
    }
    
    
    public function checkTransport(){
        try{
            $this->transport->start();
        } catch (Swift_TransportException $e){
            //User friendly message
            echo '<p>Unable to send recovery email.</p>';
            
            $error = 'Error: ' . $e->getMessage();
            
            //Write the error to log file
            writeToSwiftLog($error);
            
            die(); 
        }
    }
    
    public function sendMessage($message){
        try{
            $this->mailer->send($message);
            }
        catch (Swift_TransportException $e){
            //User friendly message
            echo '<p>Unable to send recovery email.</p>';
            
            $error = 'Error: ' . $e->getMessage();
            
            //Write the error to log file
            writeToSwiftLog($error);
            
            die();
        }
        return true;
    }
}
