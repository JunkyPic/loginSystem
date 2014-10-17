<?php
/**
* This file requires a valid _SMTP to function
* @Setup:
*        - Set the $_SMTPUsername
*        - Set the $_SMTPPassword
*        - Set the $_port
* @Optional:
*        - Modify the stuff in createMessage() function. They can be left as default. It won't affect the sending of the emails
* See http://swiftmailer.org/docs/sending.html for furher information on how to set it up
*/

class SendMailRecoverPassword
{
    private $message;

    private $transport;
    private $SMTP = 'localhost';
    private $port = 25;
    private $mailer;
    
    public function __construct(){

        require_once  realpath(dirname(__FILE__) . '/..') . '/swiftmailer/lib/swift_required.php';
        require_once 'WriteToLog.php';
       
        $this->_transport = Swift_SmtpTransport::newInstance($this->SMTP, $this->port);
        
        /**
        * Check the trasport here if it doesn't work
        * Kill the page and write to log file
        */
        $this->checkTransport();
        
        /**
        * Creates a new instance of Swift_Message
        * and assigns it to the $_message variable
        */
        $this->_mailer = Swift_Mailer::newInstance($this->transport);
        $this->_message = Swift_Message::newInstance();

    }
    
    public function createMessage($newPassword, $email){
    
        $this->_message->setSubject('Password reset');
        $this->_message->setFrom(array('no-reply@domain.com'=> 'no-reply'));
        $this->_message->setTo(array($email => 'User'));
        $this->_message->setBody(
"DO NOT REPLY. THIS IS AN AUTOMATED MESSAGE.

Hello,
You have requested a password reset. 
Your new password is:

$newPassword

Please note that your old password will no longer work.

It is highly recommended that you do not leave this password as your default password.
");
    
    }
    public function getMessage(){
        return $this->message;
    }
    
    
    public function checkTransport(){
        try{
            $this->transport->start();
        } catch (Swift_TransportException $e){
            //User friendly _message
            echo '<p>Unable to send recovery email.</p>';
            
            $error = 'Error: ' . $e->getMessage();
            
            //Write the error to log file
            writeToSwiftLog($error);
            
            die(); 
        }
    }
    
    public function sendMessage($_message){
        try{
            $this->mailer->send($_message);
            }
        catch (Swift_TransportException $e){
            //User friendly _message
            echo '<p>Unable to send recovery email.</p>';
            
            $error = 'Error: ' . $e->getMessage();
            
            //Write the error to log file
            writeToSwiftLog($error);
            
            die();
        }
        return true;
    }
}
