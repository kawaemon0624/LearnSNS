<?php
    session_start();
    require('functions.php');
    require('dbconnect.php');


    // v($_SESSION["id"],'$_SESSION["id"]');

    //ユーザー情報の所得
    $sql = 'SELECT * FROM `users`WHERE`id`=?';
    $data = array($_SESSION['id']);
    //ここでは関連性が無い
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    //いま欲しいのは所得
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);
    //->は要素がやれる事などを指定する。（出来ることを指定する）
    // v($signin_user,'$signin_user');
    //練習問題１
    //$validations連想配列を使って、投稿データが空文字の場合、入力欄下に『投稿でーたを入力してください』と表示。投稿データがある場合、メッセージは表示されないように


    $validations=[];
    if (!empty($_POST)) {
      $feed=$_POST['feed'];

      if ($feed =="") {
        $validations['feed']= 'blank';
      }else{
        //DBにデータベースを投稿したい
        $sql = 'INSERT INTO `feeds` SET `feed`=?,`user_id`=?,`created`= NOW()';
        $data =array($feed,$_SESSION['id']);
      //NOW()関数はSQLの関数
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      unset($_SESSION['46_LearnSNS']);
      //セッションの中を一度空に！　そのまま残ってしまう為、送りおわってるから。
      header('Location:timeline.php');
      exit();
      }

    }



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
  <style>
       .error_msg{
      color: red;
      font-size: 12px;
    }
  </style>
</head>
<body>
  ユーザー情報[<img width="30" src="user_profile_img/<?php  echo $signin_user['img_name'];?>" /> <?php echo $signin_user["name"]; ?>
  <!-- 画像と名前を表示する -->
  [<a href="signout.php">サインアウト</a>]
  <form method="POST" action="">
  <textarea row="5" name="feed"></textarea>
  <input type="submit" value="投稿">
  <br>
  <?php if(isset($validations["feed"])&& $validations["feed"]=='blank'): ?>
    <span class="error_msg">投稿データを入力してください。</span>
  <?php endif ?>
  </form>
</body>
</html>









