<?php

require 'db/MySqlSingleton.php';

$mysql = MySqlSingleton::getInstance();

$query = "SELECT * FROM post WHERE id=:id";
$query = $mysql->prepare($query);
$query->execute(array('id' => 1));
$res = $query->fetch();

echo $res[0];