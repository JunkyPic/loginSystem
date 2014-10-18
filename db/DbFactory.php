<?php

require_once 'MySQL.php';

class DbFactory{
    public static function getNew($class){
        if(class_exists($class)){
            return new $class;
        }
    }
}