<html>
<head><title>PDO CREATE</title></head>
<body>

<?php

$dsn = 'mysql:dbname=****************;host=localhost;charset=utf8';
$user = 'co-19-264.99sv-coco.c';
$password = '*********';


try {
	// DBへ接続
	$dbh = new PDO($dsn, $user, $password);

	// SQL作成
	$sql = 'CREATE TABLE contents (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(20)
	) engine=innodb default charset=utf8';

	// SQL実行
	$res = $dbh->query($sql);
	

} catch(PDOException $e) {

	echo $e->getMessage();
	die();
}

// 接続を閉じる
$dbh = null;
?>
