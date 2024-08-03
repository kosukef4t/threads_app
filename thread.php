<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <style>
        header{
            width: 100%;
            display: flex;
            margin: 20px 0 10px;
            background-color: #f0f0f0;
        }
        .title{
            font-family:serif;
            font-size: 30px;
            margin-left: 20px;
        }
        .change_thread{
            padding-right:30px;
            margin:auto 0 auto auto;
            text-decoration:none;
            color:black;
        }
        .thread{
            display:flex;
        }
        .thread_title{
            padding-top:30px;
            font-family:serif;
            font-size: 20px;
            margin-left: 20px;
        }
        .reply_list{
            padding-top:30px;
            font-family:serif;
            font-size: 15px;
            margin-left: 20px;
        }
        .reply_form{
            margin-left: 20px;
        }
        .reply_form li{
            margin-bottom:10px;
            list-style:none;
        }
    </style>
</head>
<body>
    <header>
        <h1 class='title'>スレッド一覧</h1>
        <a class='change_thread' href='thread_change_form.html'>Create or Change Threads</a>
    </header>
</body>
</html>

<?php
//データベースに接続
require_once('db_connect.php');

// スレッドを取得
$stmt = $db->prepare("SELECT * FROM threads");
$stmt->execute();
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    foreach ($threads as $thread) {
        echo "<div class='thread'>";
        echo "<h2 class='thread_title'>" . htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8') . "</h2>";

        // リプライを取得
        $stmt = $db->prepare("SELECT * FROM replies WHERE thread_id = ? ORDER BY created_at");
        $stmt->bindValue(1, $thread['id']);
        $stmt->execute();
        $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul class = 'reply_list'>";
        foreach ($replies as $reply) {
            echo "<li style = 'list-style: none;'>" . htmlspecialchars($reply['id'], ENT_QUOTES, 'UTF-8') . ", " . htmlspecialchars($reply['content'], ENT_QUOTES, 'UTF-8') ."</li>";
        }
        echo "</ul>";
        echo "</div>";

        // リプライフォーム
        echo '<div class="reply_form"><form action="reply.php" method="post">
            <li><input type="hidden" name="thread_id" value="' . $thread['id'] . '"></li>
            <li><label for="name">名前</label><br>
            <input type="text" name="name" required></li>
            <li><label for="content">テキスト入力</label><br>
            <textarea name="content" required></textarea></li>

            <li><input type="checkbox" name="is_reply" value="1">
            <label for="is_reply">リプライ</label>
            <input type="checkbox" name="is_update" value="1">
            <label for="is_update">更新</label>
            <input type="checkbox" name="is_delete" value="1">
            <label for="is_delete">削除</label></li>
            <li><label for="id">番号を選択</label><br>
            <input type="number" name="id"></li>
            <li><button type="submit">送信</button></li>
        </form></div>';
    }
} else {
    echo "スレッドがありません。";
}

?>
