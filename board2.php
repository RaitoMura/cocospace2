<?php
$name = $_POST['name'];
$comment = $_POST['comment'];
//$contents = file("post.txt");
//mysql接続、データ読み込み
require 'pdo_connect.php';
$sql = 'SELECT content FROM contents';
$stmt = $dbh->query($sql);
$contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
$modify_flag = $_POST["modify_flag"];
$modify_number = $_POST["modify_number"];
$time = date("Y-m-d H:i");
$size = count($contents);
$pass = $_POST["pass"];
if($modify_flag == 1){
    if($name == NULL or $pass == NULL){//編集項目にて未入力項目がある場合
        header('Location: http://co-19-264.99sv-coco.com/modify.php?branknumber=3'); 
        exit;
    }


    //file_put_contents('post.txt',NULL); //ファイルデータ削除
    $dbh->query('DELETE FROM contents');
    $sql = 'INSERT INTO contents value (:content)';
    $stmt = $dbh->prepare($sql);
    for($i=0;$i <= $size - 1;$i++){ //ループ
        $content = explode("<>",$contents[$i]);
        if($content[0] == $modify_number){
            $save_content = $modify_number."<>". $name."<>".$comment."<>".$time."<>".$pass.PHP_EOL;
            $stmt->bindParam(':content',$save_content,PDO::PARAM_STR);
            $stmt->execute();
            //file_put_contents("post.txt",$modify_number."<>". $name."<>".$comment."<>".$time."<>".$pass.PHP_EOL, FILE_APPEND);
        }else{
            $stmt->bindParam(':content',$contents[$i],PDO::PARAM_STR);
            $stmt->execute();
            //file_put_contents("post.txt",$contents[$i],FILE_APPEND);

        }
    }

}else{ //未入力項目がある場合の分岐
    if($name == NULL){ 
        header('Location: http://co-19-264.99sv-coco.com/board.php?brank=1'); 
        exit;
    }
    if($comment == NULL){
        header('Location: http://co-19-264.99sv-coco.com/board.php?brank=2'); 
        exit;
    }
    if($pass == NULL){
        header('Location: http://co-19-264.99sv-coco.com/board.php?brank=3'); 
        exit;
    }
    if(strlen($comment)>=60){// 文字数が多い場合の分岐
        header('Location: http://co-19-264.99sv-coco.com/board.php?brank=4'); 
        exit;
    }
    //投稿番号の取得
    if($contents == NULL){
        $number = 0;
    }else{
        $numbers =NULL;
        for($i=0;$i <= $size - 1;$i++){ //投稿内の最大番号の取得
            $content = explode("<>",$contents[$i]);
            $numbers[$i] = $content[0];
        }
        $number =max($numbers);
    
    }
    $number += 1;
    
    $save_content = $number."<>". $name."<>".$comment."<>".$time."<>".$pass.PHP_EOL;

    //file_put_contents("post.txt",$number."<>". $name."<>".$comment."<>".$time."<>".$pass.PHP_EOL, FILE_APPEND);
    //mysqlのDBに挿入
    require 'pdo_connect.php';
    $sql = 'INSERT INTO contents value (:content)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':content',$save_content,PDO::PARAM_STR);
    $stmt->execute();


}

?>
<head>
<meta charset = "UFT-8">
<title>簡易掲示板</title>
</head>
<body>
    <h2>簡易掲示板</h2>
    <a href = "http://co-19-264.99sv-coco.com/delete.php">コメントを削除する</a><br>
    <a href = "http://co-19-264.99sv-coco.com/modify.php">コメントを編集する</a>
    <form action = "board2.php" method = "post">
        <p>名前：<br><input type="text" name = "name"></p>
        <p>コメント：<br>
            <input name="comment">    
            <input type = "hidden" name = "modify_flag" value = "0" >
            <input type = "hidden" name = "modify_number" value = "0" > 
            </p>
        <p>パスワード：<br><input type = "password" name = "pass"></p>
        <p><input type ="submit" value="投稿" ></p>
    </form>
    
    <?php //テキストファイルを読み込み、下に表示させる
    //$posts = file("post.txt");
    require 'pdo_connect.php';
    $sql = 'SELECT content FROM contents';
    $stmt = $dbh->query($sql);
    $contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach($contents as $post): //ループ
        $content = explode("<>",$post); //配列を"<>"でさらに分割
        echo $content[0]."名前：".$content[1]."　日時：".$content[3]."<br />".$content[2];
        echo "<br />";
    endforeach;
    ?>
    
</body>