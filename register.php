<?php
//mysqlに接続
require_once "db_connect.php";

//フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['password'];

//フォームに入力されたemailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->bindValue(1, $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $msg = '同じメールアドレスが存在します!';
    $link = '<a href="page.html">戻る</a>';
} else {
    //登録されていなければinsert 
    $sql = "INSERT INTO users(name, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $name);
    $stmt->bindValue(2, $email);
    $stmt->bindValue(3, $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="login_form.html">ログインページ</a>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登録後ページ</title>
    <style>
        body{
            font:14px sans-serif;
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

