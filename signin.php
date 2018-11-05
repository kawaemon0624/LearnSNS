<?php
    session_start();
    require('functions.php');
    require('dbconnect.php');
    v($_POST,'$_POST');
    //この四行h最初に書くと良い

    $validatins = [];

    //POST送信
    if (!empty($_POST)) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      //空バリデーション
      if ($email != '' && $password !='') {
        //からじゃなければ、データベースに問い合わせ
          $sql='SELECT * FROM `users` WHERE `email`=?';
          $stmt = $dbh->prepare($sql);
          $data = [$email];
          $stmt->execute($data);
          //object-> arrayに関数
          $record=$stmt->fetch(PDO::FETCH_ASSOC);
          v($record,'$record');
      //一致しなかったらの動作
          if ($record == false) {
            $validatins['signin']='failed';
          }else{
            //パスワードの照合
            $verify = password_verify($password,$record['password']);//一致してたらtrue
            if ($verify ==true) {
              //サインいん成功
              $_SESSION["id"] = $record["id"];//タイムラインでも使う
              header('Location: timeline.php');
              exit();
            }else{
              //パスワードミス
              $validatins['signin'] = 'failed';
            }
        }

      }else{
        //そうじゃなければblank
        $validatins['signin'] = 'blank';
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
    }
  </style>
</head>
<body>
  <h1>サインイン</h1>
  <form method="POST" action="">
    <div>
      メールアドレス<br>
      <input type="email" name="email" value="">
      <?php if(isset($validatins['signin'])&&$validatins['signin']=='blank'): ?>
        <span class="error_msg">メールアドレスとパスワードは正しく入力してください</span>
      <?php endif;?>
       <?php if(isset($validatins['signin'])&&$validatins['signin']=='failed'): ?>
        <span class="error_msg">サインインに失敗しました</span>
      <?php endif;?>
    </div>
    <div>
      パスワード<br>
      <input type="password" name="password" value="">
    </div>

    <input type="submit" value="サインイン">
  </form>
</body>
</html>