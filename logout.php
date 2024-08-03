<?php
session_start();
$_SESSION = array(); //セッションの中身をすべて削除
session_destroy(); //セッションを破壊
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
            <h2>ログアウトしました！</h2>
            <a href="login_form.html">ログインへ</a>
        </div>    
    </body>
</html>