<?php

    require_once("dbconnect.php");
    //一回だけ処理する書き方

    $feed_id = $_POST["feed_id"];
    $user_id = $_POST["user_id"];
    // $is_liked = $_POST["is_liked"];

    if (isset($_POST["is_liked"])) {
      //いいねボタンを押された時
      //どの記事を誰がいいねしたか、likesテーブルに保存
      //いいねを押した時にDBにいいね数が反映される
      $sql = "INSERT INTO `likes` (`user_id`, `feed_id`) VALUES (?, ?);";

    }else{
      //いいねを取り消すボタンを押した時
      //保存されているlike情報をLikesテーブルから削除
      $sql = "DELETE FROM `likes` WHERE`user_id`=? AND`feed_id`=?";
    }

    $data = [$user_id, $feed_id];
    $stmt = $dbh->prepare($sql);
    $res = $stmt->execute($data);




     echo json_encode($res);