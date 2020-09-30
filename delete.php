<head>
<meta charset = "UFT-8">
<title>掲示板削除</title>

</head>
<body>
    <h2>削除フォーム</h2>
    <form action = "board.php" method = "post">
        <p>削除対象番号：<br><input type="text" name = "deletenumber"></p>
        <p>パスワード：<br><input type = "password" name = "deletepass">
        <input type = "hidden" name = "delete_flag" value = 1> </p>
        <p><input type ="submit" value="削除"　name = "btn" ></p>
    </form>
    <script default_mimetype = "text/javascript">
    document.myform.btn.addEventListener('click', function() {
    var result = window.confirm('本当に削除しますか？');
    if( result ) {
 
        //「true」の処理
 
    }
    else {

        header('Location: http://co-19-264.99sv-coco.com/delete.php');
        exit;
 
    }
})
</script>
</body>
<?php
if(!empty($_GET['status'])){
    $status = $_GET['status'];
    switch($status){
        case 1:
            echo "番号が未入力です。<br>";
        break;
        case 2:
            echo "パスワードが未入力です。<br>";
        break;
        case 3:
            echo "番号が存在しません。<br>";
        break;
        default:
        break;
        
    }
}
if(!empty($_GET['pass'])){
    if($_GET['pass']=="wrong"){
        echo "パスワードが間違っています。<br>";
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




