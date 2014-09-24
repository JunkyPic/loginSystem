<?php

class SqlQueryController{
    
    private $_MySqlSingleton = NULL;
    
    public function __construct(){
        require_once realpath(dirname(__FILE__) . '/..') . '/db/MySqlSingleton.php';
        
        if($this->_MySqlSingleton == NULL){
            $this->_MySqlSingleton = MySqlSingleton::getInstance();
        }
    }
    /**
    * Returns the execute query based on the $method
    */
    public function executeQuery($query, $array = NULL, $method){
    
        switch ($method){
            case 'fetch':
                $sqlQuery = $this->_MySqlSingleton->prepare($query);
                $sqlQuery->execute($array);
                return $sqlQuery->fetch();
                
            case 'fetchAssoc':
                $sqlQuery = $this->_MySqlSingleton->prepare($query);
                $sqlQuery->execute($array);
                $sqlQuery = $sqlQuery->fetch(PDO::FETCH_ASSOC);
                return $sqlQuery;
                
            case 'fetchAllAssoc':
                if($array == NULL){
                    $sqlQuery->execute();
                    $sqlQuery = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
                    return $sqlQuery;
                }
                $sqlQuery->execute($array);
                $sqlQuery = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
                return $sqlQuery;
                
            case 'execute':
                $sqlQuery = $this->_MySqlSingleton->prepare($query);
                if($array == NULL){
                    $sqlQuery->execute();
                    return $sqlQuery;
                }
                $sqlQuery->execute($array);
                return $sqlQuery;
                
            default:
                die('Unable to execute query.');
        }
    }
}
