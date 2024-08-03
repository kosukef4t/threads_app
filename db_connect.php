<?php
//サーバー&データベースに関しての値
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "thread_app";

//localhostに接続
try{
  $db = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
}catch(PDOException $e){
  echo $e->getMessage();
  exit();
}
?>