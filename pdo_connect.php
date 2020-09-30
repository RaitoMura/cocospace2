<?php

$dsn = 'mysql:**********************;host=localhost';
$user = '************************';
$password = '***********';

try{
    $dbh = new PDO($dsn, $user, $password);
}catch(PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
}

?>
