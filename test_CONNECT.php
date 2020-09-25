<html>
<head><title>PDO CONNECT</title></head>
<body>

<?php

$dsn = 'mysql:dbname=**************;host=localhost;charset=utf8';
$user = 'co-19-264.99sv-coco.c';
$password = '************';

try{
    $dbh = new PDO($dsn, $user, $password);

    print('<br>');

    if ($dbh == null){
        print('接続に失敗しました。<br>');
    }else{
        print('接続に成功しました。<br>');
    }

    $dbh->query('SET NAMES sjis');

    print('追加前のデータ一覧：<br>');

    $sql = 'select id, name from contents';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        print($result['id']);
        print($result['name'].'<br>');
    }

    $sql = 'insert into contents (id, name) values (?, ?)';
    $stmt = $dbh->prepare($sql);
    $flag = $stmt->execute(array(1, '太郎'));

    if ($flag){
        print('データの追加に成功しました<br>');
    }else{
        print('データの追加に失敗しました<br>');
    }

    print('追加後のデータ一覧：<br>');

    $sql = 'select id, name from contents';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        print($result['id']);
        print($result['name'].'<br>');
    }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

</body>
</html>
