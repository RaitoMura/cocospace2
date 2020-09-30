<?php

$dsn = 'mysql:dbname=co_19_264_99sv_coco_com;host=localhost';
$user = 'co-19-264.99sv-coco.c';
$password = 'gJ4TjKuF';

try{
    $dbh = new PDO($dsn, $user, $password);
}catch(PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
}

?>
