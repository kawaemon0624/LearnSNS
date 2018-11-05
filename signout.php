<?php 
    session_start();
    
    //SESSION変数の破棄
    $_SESSION = [];
    //サーバー内の＄SESSION変数のクリア
    session_destroy();
    //完全に消す
    //SESSIONだけunsetとは違いすベて消す
    //unsetは他のにも使える

    //signin.phpへの移動
    header("Location: signin.php");
    exit();
    //これ以降の処理を行なわない（ここで終了する）セットで


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>

</body>
</html>