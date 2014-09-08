<?php
/**
* Change the default timezone to suit your needs
*/
function writeToSwiftLog($message){
    date_default_timezone_set("Europe/Bucharest");
    $fileName = realpath(dirname(__FILE__) . '/..') . '/logFiles/SwfitMailerLog.log';
    $time = date('[d-m-Y H:i:s]: ', time());
    $message = $time . $message . PHP_EOL;
    file_put_contents($fileName, $message, FILE_APPEND);
}

function writeToMySqlLog($message){
    date_default_timezone_set("Europe/Bucharest");
    $fileName = realpath(dirname(__FILE__) . '/..') .  '/logFiles/MySQLLog.log';
    $time = date('[d-m-Y H:i:s]: ', time());
    $message = $time . $message . PHP_EOL;
    file_put_contents($fileName, $message, FILE_APPEND);
}