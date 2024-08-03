<?php
//データベース接続
require_once('db_connect.php');

$thread_id = $_POST['thread_id'];
$content = $_POST['content'];
$name = $_POST['name'];
$is_update = $_POST['is_update'];
$is_delete = $_POST['is_delete'];
$is_reply = $_POST['is_reply'];
$reply_id = $_POST['id'];

//ユーザーIDを取得
$stmt = $db->prepare("SELECT * FROM users WHERE name = ?");
$stmt->bindValue(1, $name);
$stmt->execute();
$user_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
var_dump($user_id);

//ユーザーIDを取得
$stmt = $db->prepare("SELECT * FROM replies WHERE id = ?");
$stmt->bindValue(1, $reply_id);
$stmt->execute();
$reply_user_id = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];

//保存されているリプライIDを取得
$stmt = $db->prepare("SELECT * FROM replies WHERE id = ?");
$stmt->bindValue(1, $reply_id);
$stmt->execute();
var_dump($stmt->rowCount());

if($is_update){
    if($stmt->rowCount() > 0 && $user_id === $reply_user_id){
    $stmt = $db->prepare("UPDATE replies SET content = ? WHERE id = ?");
    $stmt->bindValue(1, $content);
    $stmt->bindValue(2, $reply_id);
    $stmt->execute();
    }else{
        echo "<script>alert('他者のリプライまたはリプライ番号が間違っています');</script>";
        echo "<script>location.href='thread.php';</script>";
        exit();
    }
}


if($is_delete){
    if($stmt->rowCount() > 0 && $user_id === $reply_user_id){
        $stmt = $db->prepare("DELETE FROM replies WHERE id = ?");
        $stmt->bindValue(1, $reply_id);
        $stmt->execute();
    }else{
        echo "<script>alert('他者のリプライまたはリプライ番号が間違っています');</script>"; 
        echo "<script>location.href='thread.php';</script>";
        exit();
    }
}

if($is_reply && $user_id !== null){
    // リプライを挿入
    $stmt = $db->prepare("INSERT INTO replies (thread_id, content, user_id) VALUES (?, ?, ?)");
    $stmt->bindValue(1, $thread_id);
    $stmt->bindValue(2, $content);
    $stmt->bindValue(3, $user_id);
    $stmt->execute();
}
header('Location: thread.php');
exit();
?>
