<?php
  // timeline.phpの処理を記載
        session_start();
    require('functions.php');
    require('dbconnect.php');

    $sql = 'SELECT * FROM `users`WHERE`id`=?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    $validations=[];
    if (!empty($_POST)) {
      $feed=$_POST['feed'];

      if ($feed =="") {
        $validations['feed']= 'blank';
      }else{
        $sql = 'INSERT INTO `feeds` SET `feed`=?,`user_id`=?,`created`= NOW()';
        $data =array($feed,$_SESSION['id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      unset($_SESSION['46_LearnSNS']);

      header('Location:timeline.php');
      exit();
      }

    }
    // SELECT*FROM`feeds` INNER JOIN `users` ON `feeds`.`user_id` = `users`.`id`
    //必要な絡むだけを指定して所得
    // SELECT `feeds`.*,`users`.`name`,`users`.`img_name`FROM `feeds` INNER JOIN `users` ON `feeds`.`user_id`=`users`.`id`
    //別名指定
    // SELECT `f`.*,`u`.`name`,`u`.`img_name` AS`profile_image`FROM `feeds`AS `f` INNER JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` ORDER BY `created` DESC


    //一覧データを所得するSELECT文を記述の所得
    //$sql = 'SELECT * FROM `feeds` ORDER BY`created` DESC'; //一覧データを所得するSELECT文を記述
    $sql='SELECT `f`.*,`u`.`name`,`u`.`img_name` AS`profile_image`FROM `feeds`AS `f` INNER JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` ORDER BY `created` DESC';
    //DESC 大きい数字から小さい数字に並べる
    //ASC 小さい数字から大きい数字に並べる
    //ORDER BY 特定にからむ順に出来る
    // 結合する理由
    // 実際のシステムでは複数のテーブルでデータを管理し、そのデータをユーザが扱いやすいように結合して表示したりするので、テーブルの結合は必須です。
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);

    $feeds = []; //配列データを全て格納する配列。

    while (true) {
      $feed = $stmt->fetch(PDO::FETCH_ASSOC);//データ一個分

      if ($feed == false) {
        //所得でーたは全て所得できているので、繰り返しを中断する
        break;
      }
      //$feedにファルスが入らないようにする為に下に
      $feeds[]= $feed;//[]は、配列の末尾にデータを追加する。空っぽの所に

    }
    // v($feeds,'$feeds');
    

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <style>
           .error_msg{
      color: red;
      font-size: 12px;
    }

  </style>
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background: #E4E6EB;">
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Learn SNS</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">タイムライン</a></li>
          <li><a href="#">一覧</a></li>
        </ul>
        <form method="GET" action="" class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" name="search_word" class="form-control" placeholder="投稿を検索">
          </div>
          <button type="submit" class="btn btn-default">検索</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <!-- https://placehold.jp/18x18. すごおく使われる-->
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="user_profile_img/<?php  echo $signin_user['img_name'];?>" width="18" class="img-circle"><?php echo $signin_user["name"]; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">マイページ</a></li>
              <li><a href="signout.php">サインアウト</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
          <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
          <!-- <li><a href="timeline.php?feed_select=follows">フォロー</a></li> -->
        </ul>
      </div>
      <div class="col-xs-9">
        <div class="feed_form thumbnail">
          <form method="POST" action="">
            <div class="form-group">
              <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
              <?php if(isset($validations["feed"])&& $validations["feed"]=='blank'): ?>
                <span class="error_msg">投稿データを入力してください。</span>
              <?php endif ?>
            </div>
            <input type="submit" value="投稿する" class="btn btn-primary">
          </form>
        </div>
          <?php foreach ($feeds as $feed_each) { ?>
            <!-- foreachデータを取り出したい配列　as 一個分を格納しえ起きたい変数  { }は繰り返したい文-->
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-1">
                <img src="user_profile_img/<?= h($feed_each["profile_image"]); ?>" width="40">
              </div>
              <div class="col-xs-11">
                <?php echo $feed_each["name"] ?><br>
                <a href="#" style="color: #7F7F7F;"><?php echo $feed_each["created"]; ?>
                  <!-- 時間 -->
                </a>
              </div>
            </div>
            <div class="row feed_content">
              <div class="col-xs-12" >
                <span style="font-size: 24px;"><?php echo $feed_each["feed"]; ?></span>
                <!-- 格ユーザーが書いたのを表示させる -->
              </div>
            </div>
            <div class="row feed_sub">
              <div class="col-xs-12">
                <form method="POST" action="" style="display: inline;">
                  <input type="hidden" name="feed_id" >
                  
                    <input type="hidden" name="like" value="like">
                    <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up" aria-hidden="true"></i>いいね！</button>
                </form>
                <span class="like_count">いいね数 : 100</span>
                <span class="comment_count">コメント数 : 9</span>
                <?php if($_SESSION['id'] == $feed_each["user_id"]): ?>
                  <a href="edit.php?feed_id=<?=$feed_each['id']; ?>" class="btn btn-success btn-xs">編集</a>
                  <a onclick="return confirm('本当に消すの？');" href="delete.php?feed_id=<?=$feed_each['id']; ?>" class="btn btn-danger btn-xs">削除</a>
                  <!-- ジャバスクリプト  # 飛ばす先未定-->
                <?php endif; ?>
              </div>
            </div>
          </div><!-- class="thumbnailタグ" --> 
        <?php } ?>

        <div aria-label="Page navigation">
          <ul class="pager">
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Newer</a></li>
            <li class="next"><a href="#">Older <span aria-hidden="true">&rarr;</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
