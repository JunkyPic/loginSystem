<?php
/**
* This class handles the MySQL queries
*/

class SqlQueryController{
    
    private $_MySqlSingleton = NULL;
    
    public function __construct(){
        require_once realpath(dirname(__FILE__) . '/..') . '/db/MySqlSingleton.php';
        
        if($this->_MySqlSingleton == NULL){
            $this->_MySqlSingleton = MySqlSingleton::getInstance();
        }
    }
    
    public function runQueryExecute($query, $array){
        $sqlQuery = $this->_MySqlSingleton->prepare($query);
        $sqlQuery->execute($array);
        return $sqlQuery;
    }
    
    public function runQueryFetch($query, $array){
        $sqlQuery = $this->_MySqlSingleton->prepare($query);
        $sqlQuery->execute($array);
        return $sqlQuery->fetch();
    }

    
    public function runQueryFetchAssoc($query, $array){
        $sqlQuery = $this->_MySqlSingleton->prepare($query);
        $sqlQuery->execute($array);
        $sqlQuery = $sqlQuery->fetch(PDO::FETCH_ASSOC);
        return $sqlQuery;
    }
    
}
