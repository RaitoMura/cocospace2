<head>
<meta charset = "UFT-8">
<title>掲示板編集</title>
</head>
<body>
    <h2>編集フォーム</h2>
    <form action = "board.php" method = "post">
        <p>編集対象番号：<br><input type="text" name = "modifynumber"></p>
        <p>パスワード：<br><input type = "password" name = "modifypass">
        <input type = "hidden" name = "modify_flag" value = 1>
        </p>
        <p><input type ="submit" value="編集" ></p>
    </form>
</body>
<?php

if(!empty($_GET['status'])){//未入力項目時の警告
    
    $status = $_GET['status']; //GETにてboard.phpからのメッセージを取得

    if($status == 0){
        echo "番号が未入力です。<br>";
    }
    if($status == 1){
        echo "パスワードが未入力です。<br>";
    }
    if($status == 2){
        echo "パスワードが間違っています。<br>";
    }
    if($status == 3){
        echo "未入力項目があります。最初からやり直してください。<br>";
    }
    if($status == 4){
        echo "番号が存在しません。<br>";
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