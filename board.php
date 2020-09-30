<?php
// Mysql接続、データ読み込み
require 'pdo_connect.php';
$sql = 'SELECT content FROM contents';
$stmt = $dbh->query($sql);
$contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
$size = count($contents); //投稿数
$flag = 0;
$modify_data = NULL;
//編集フォームからの流入分岐
if(!empty($_POST['modify_flag'])){
    
    $flag = 1;
    $number = $_POST['modifynumber'];
    $pass = $_POST['modifypass'];
    if($number == NULL){ //番号が存在しない場合
        header('Location: http://co-19-264.99sv-coco.com/modify.php?status=0'); 
        exit;
    }elseif($pass == NULL){ //パスワードが存在しない場合 
        header('Location: http://co-19-264.99sv-coco.com/modify.php?status=1'); 
        exit;
    }
    //$posts = file('post.txt'); 
    

    for($i=0;$i <= $size - 1;$i++){ //ループ
        $content = explode("<>",$contents[$i]);
        $numbers[$i] = $content[0];
        if($content[0] == $number){ //編集対象データの抽出
            $modify_data = $content;
        }
    }
    if(!in_array($number, $numbers)){ //番号が存在しない場合
        header('Location: http://co-19-264.99sv-coco.com/modify.php?status=4'); 
        exit;
    }
    $modify_pass = str_replace(PHP_EOL, '', $modify_data[4]);
    
    if($modify_pass != $pass){ //パスワードが正しくない場合
        header('Location: http://co-19-264.99sv-coco.com/modify.php?status=2'); 
        exit;
    } 
}elseif(!empty($_POST["delete_flag"])){ // 削除フォームからの流入分岐
    $number = $_POST["deletenumber"]; // 削除番号の取得
    
    //$posts = file('post.txt');
    $pass = $_POST["deletepass"]; //パスワードの取得
    $size = count($contents);
    if($number == NULL){ //番号が空白の場合
        header('Location: http://co-19-264.99sv-coco.com/delete.php?status=1');
        exit;
    }
    if($pass == NULL){ //パスワードが空白の場合
        header('Location: http://co-19-264.99sv-coco.com/delete.php?status=2');
        exit;
    }
    for($i=0;$i <= $size - 1;$i++){ //ループ
        $content = explode("<>",$contents[$i]);
        $numbers[$i] = $content[0];
        if($number == $content[0]){
            $delete_data = $content;
        }
    }
    $delete_pass = str_replace(PHP_EOL, '', $delete_data[4]); 
    if(!in_array($number,$numbers)){ //番号が存在しない場合
        header('Location: http://co-19-264.99sv-coco.com/delete.php?status=3'); 
        exit;
    }

    if($delete_pass != $pass){ //パスワードが正しくない場合
        header('Location: http://co-19-264.99sv-coco.com/delete.php?pass=wrong');
        exit;
    }

    /*
    $number:指定番号
    $contents:掲示板メッセージの配列

    */
    $size = count($contents);
    //file_put_contents('post.txt',NULL); 
    //データを一旦全削除
    $stmt = $dbh->query('DELETE FROM contents');
    $sql = 'INSERT INTO contents value (:content)';
    $stmt = $dbh->prepare($sql);
    for($i=0;$i <= $size - 1;$i++){ //削除データ以外の再追加
        $content = explode("<>",$contents[$i]);
        if($content[0] != $number){
            //file_put_contents("post.txt",$posts[$i],FILE_APPEND);
            $stmt->bindParam(':content',$contents[$i],PDO::PARAM_STR);
            $stmt->execute();

        }
    }

}

?>

<!DOCTYPE html> 
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<title>簡易掲示板</title>
</head>
<body>
    <h2>簡易掲示板</h2>
    <a href = "http://co-19-264.99sv-coco.com/delete.php">コメントを削除する</a><br>
    <a href = "http://co-19-264.99sv-coco.com/modify.php">コメントを編集する</a>
    <form action = "board2.php" method = "post">
        <p>名前：<br><input type="text" name = "name" value = <?php if($flag == 1){echo $modify_data[1];}?>></p>
        <p>コメント：<br>
            <input name="comment" value = <?php if($flag == 1){echo $modify_data[2];}?>> </p>
        <p>パスワード：<br><input type = "password" name = "pass"></p>
        <p>
            <input type = "hidden" name = "modify_flag" value = <?php if($flag==1){echo 1;}?> >
            <input type = "hidden" name = "modify_number" value = <?php if($flag==1){echo $number;}?> >
            <input type ="submit" value="投稿" >
        </p>
    </form>
    <?php
    if(!empty($_GET['brank'])){

        $brank =$_GET['brank'];
        switch($brank){ //未入力項目がある場合の分岐
            case 1:
                echo "名前が未入力です。<br>";
            break;
            case 2:
                echo "コメントが未入力です。<br>";
            break;
            case 3:
                echo "パスワードが未入力です。<br>";
            break;
            case 4:
                echo "文字数が多すぎます。<br>";
            break;
            
            default:
            break;

        }
    }
    
    

    ?>
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
