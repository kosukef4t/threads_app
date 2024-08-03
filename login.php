<?php
//mysqlに接続
require_once "db_connect.php";

//アドレスとパスワード情報をlogin_form.htmlから取得
$email=$_POST['email'];
$pass= $_POST['password'];

//mysqlからデータを取得
$sql = "SELECT * FROM users where (email = ?) and (password = ?)";
$stmt = $db->prepare($sql);
$stmt->bindValue(1, $email);
$stmt->bindValue(2, $pass);
$stmt->execute();


//指定したハッシュがパスワードにマッチしているかチェック
if ($stmt->rowCount() === 1){
    $msg = 'ログインしました。';
    $link = '<a href="thread.php">掲示板を見る</a>';
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="login_form.html">戻る</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
    <style>
        body{
            font:15px serif;
        }
        .wrapper{
            width: 400px;
            padding: 20px;
            margin: 0 auto;
        }
    </style>
</head>
    <body>
        <div class = "wrapper">
            <h2><?php echo $msg; ?></h2>
            <p><?php echo $link; ?></p>
        </div>    
    </body>
</html>

