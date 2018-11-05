<?php 
// DBに接続
    require('dbconnect.php');
    require('functions.php');

    //http://localhost/LearnSNS/delete.php?feed_i=d10
    //というURLでここのファイルにアクセスすると、？以降のfeed_idがGET送信されてくる
    //$_GET["feed_id"]には１０が格納されている
    v($_GET['feed_id'],"feed_id");
    // 削除したいFEEDのIDを所得
    $feed_id = $_GET['feed_id'];
    //delete文を作成する
    $sql = "DELETE FROM `feeds` WHERE `feeds`.`id`=?";
    //演習　これ以降の処理部分をつかって、削除機能を完成させましょう
    //delete実行
    $data = array($feed_id);
    // 必ず配列で定義
    $stmt = $dbh->prepare($sql);//SQLインジェクションを防ぐ
    $stmt ->execute($data);
    //タイムライン一覧に戻る
    header('Location:timeline.php');
    exit();



?>