<?php
/**
* This class handles the MySQL queries
*/

class SqlQueryController{
    
    private $_connectionFactory = NULL;
    
    public function __construct(){
        require_once realpath(dirname(__FILE__) . '/..') . '/db/ConnectionFactory.php';
        
        if($this->_connectionFactory == NULL){
            $this->_connectionFactory = new ConnectionFactory();
        }
    }

    public function runQueryFetch($query, $array){
        $sqlQuery = $this->_connectionFactory->getDbConn()->prepare($query);
        $sqlQuery->execute($array);
        return $sqlQuery->fetch();
    }
    
    public function runQueryExecute($query, $array){
        $sqlQuery = $this->_connectionFactory->getDbConn()->prepare($query);
        $sqlQuery->execute($array);
        return $sqlQuery;
    }
    
    public function runQueryFetchAssoc($query, $array){
        $sqlQuery = $this->_connectionFactory->getDbConn()->prepare($query);
        $sqlQuery->execute($array);
        $sqlQuery = $sqlQuery->fetch(PDO::FETCH_ASSOC);
        return $sqlQuery;
    }
    
}
