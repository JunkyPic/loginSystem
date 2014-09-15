<?php
/**
* @staticvar MySql instance
* 
* @return new MySql connection
* Example usage:
* 
* $MysqlObject = MySql::getInstance();
* $MysqlObject->prepare($statement);
* $MysqlObject->execute();
*/
class MySqlSingleton{
    /**
    * @staticvar 
    * 
    * Fill these in with database credentials
    */
    private static $_dbHost = "127.0.0.1";
    private static $_dbName = "login_system";
    private static $_dbUser = "root";
    private static $_dbPass = "asadar";
    private static $_conn   = NULL;
    
    public static function getInstance(){
        if (self::$_conn == NULL) {
            try{
                self::$_conn = new PDO('mysql:host=' . self::$_dbHost . ';dbname=' . self::$_dbName, self::$_dbUser, self::$_dbPass);
            } catch (PDOException $e) {
                //User friendly message
                echo '<p>Something went wrong.</p>';
                /**
                * We should write this error to a log file
                */
                require_once realpath(dirname(__FILE__) . '/..') . '/classes/WriteToLog.php';
                $error = 'Error: ' . $e->getMessage();
                writeToMySqlLog($error);
                
                die(); 
            }
        }
        return self::$_conn;
    }
    
    /**
    * Prevent __construct from being created
    */
    protected function __construct(){
    }
    
    /**
    * Prevent __clone from being created
    */
    private function __clone(){
    }
    
    /**
    * Prevent __wakeup from being called
    */
    private function __wakeup(){
    }
}
