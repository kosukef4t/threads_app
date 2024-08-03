<?php
//データベース接続
require_once('db_connect.php');
If($_SERVER['REQUEST_METHOD'] === 'POST'){
    //スレッドを新しく作成するための情報
    $title = $_POST['title'];
    $new_name = $_POST['new_name'];
    $change_name = $_POST['change_name'];
    $original_title = $_POST['original_title'];
    $new_title = $_POST['new_title'];
    $is_create = $_POST['is_create'];
    $is_update = $_POST['is_update'];
    $is_delete = $_POST['is_delete'];
    
    //新規作成
    if($is_create === "on" && $is_update === null && $is_delete === null){ 
        //新規ユーザーIDを取得
        $stmt = $db->prepare("SELECT*FROM users WHERE name = ?");
        $stmt->bindValue(1, $new_name);
        $stmt->execute();
        $user_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        // スレッドを挿入
        $stmt1 = $db->prepare("INSERT INTO threads(title, user_id) VALUES (?, ?)");
        $stmt1->bindValue(1, $title);
        $stmt1->bindValue(2, $user_id);
        $stmt1->execute();
        echo "<script>alert('作成しました!');</script>";
        echo "<script>location.href='thread_change_form.html';</script>";
    }

    //変更・削除
    if($is_create === null && ($is_update === "on" or $is_delete === "on")){
        //変更者ユーザーIDを取得
        $get_id = $db->prepare("SELECT * FROM users WHERE name = ?");
        $get_id->bindValue(1, $change_name);
        $get_id->execute();
        $user_id = $get_id->fetch(PDO::FETCH_ASSOC)['id'];
        
        //元のタイトルを取得
        $get_title_id = $db->prepare("SELECT * FROM threads WHERE title = ?");
        $get_title_id->bindValue(1, $original_title);
        $get_title_id->execute();
        $original_title_id = $get_title_id->fetch(PDO::FETCH_ASSOC)['id'];

        if($get_title_id->rowCount() === 0){
            echo "<script>alert('正しいタイトルを入力してください');</script>";
            echo "<script>location.href='thread_change_form.html';</script>";
        }

        if($is_update === "on" && $is_delete === null){
            if($get_id->rowCount() > 0){
            $stmt = $db->prepare("UPDATE threads SET title = ?, user_id = ? WHERE id = ?");
            $stmt->bindValue(1, $new_title);
            $stmt->bindValue(2, $user_id);  
            $stmt->bindValue(3, $original_title_id);
            $stmt->execute();
            echo "<script>alert('更新しました!');</script>";
            echo "<script>location.href='thread_change_form.html';</script>";
            }else{
            echo "<script>alert('(更新)正しい名前を入力してください');</script>";
            echo "<script>location.href='thread_change_form.html';</script>";
            }
        }elseif($is_delete === "on" && $is_update === null){
            if($get_id->rowCount() > 0){
            $stmt = $db->prepare("DELETE FROM threads WHERE id = ?");
            $stmt->bindValue(1, $original_title_id);
            $stmt->execute();
            echo "<script>alert('削除しました!');</script>";
            echo "<script>location.href='thread_change_form.html';</script>";
            }else{
            echo "<script>alert('(削除)正しい名前を入力してください');</script>"; 
            echo "<script>location.href='thread_change_form.html';</script>";
            }   
        }else{
        echo "<script>alert('変更と削除はどちらかにしてください');</script>";
        echo "<script>location.href='thread_change_form.html';</script>";
        }
    }

    if($is_create === "on" && ($is_update === "on" or $is_delete === "on")){
        echo "<script>alert('どちらかにしてください');</script>";
        echo "<script>location.href='thread_change_form.html';</script>";
  }
}
?>


