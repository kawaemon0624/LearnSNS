<?php 
    session_start();
    //$sessionを使うには＄SEESSIONより上に書く
    require('../functions.php');

    //../ファイルを１個もどる
    v($_POST,'$_POST');

    echo "Aの処理<br>";
    //バリデーション格納配列
    $validations = array();
    //後でも使うから上に書く
    $name='';
    $email='';
    //最初に来た時にエラーが出るためif文よりも上で定義する。

    //!意味を反対にする
    if (!empty($_POST)) {
        echo "Bの処理<br>";

        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];


        //バリデーション
        if ($name ==''){
            //echo'ユーザー名を登録してください
            $validations['name']='blank';
            //上書きプログラム　箱　nameに何も履いてなかったら、空を追加
        }
        //メールアドレス
        if ($email ==''){
            $validations['email']='blank';
        }

        $c=strlen($password);
        //passwordの空

        if ($password ==''){
            
            $validations['password']='blank';
        }elseif ($c < 4 || 16 < $c) {
          $validations['password'] ='length';
        }
        //ifじゃないのは上書きするからelseifを使う

        //画像の選択
        $file_name = $_FILES['img_name']['name'];
        v($file_name,'$file_name');
        if ($file_name =='') {
          $validations['img_name']='blank';
          //ファイルの空チェク
        }

        //if ($_POST['name']!='') {
        //一致しなければおk
        if (empty($validations)) {
            //画像アップロード
            v($_FILES,'$_FILES');
            //$FILESはファイルデータ　HTDOG
            // 言葉で表せるように
            $tmp_file = $_FILES['img_name']['tmp_name'];


            //tmp仮置き
            $file_name = date('YmdHis') . $_FILES['img_name']['name'];
            //被らないようにするための↑
            //YmdHis時間
            $destination = '../user_profile_img/' . $file_name;
            //ディレクトリがないよというエラーが出る
            //パーミッション
            //このままだとかぶるので
            move_uploaded_file($tmp_file, $destination);

            $_SESSION['46_LearnSNS']['name'] = $name;

            $_SESSION['46_LearnSNS']['email'] = $email;

            $_SESSION['46_LearnSNS']['password'] = $password;

            $_SESSION['46_LearnSNS']['file_name'] = $file_name;
            //定義している

            //46っていう配列の中にあるnameをセッションする
            
            //スーパーグローバル変数

            //空だったらTuru
            header('Location: check.php');
            //ある時のタイミングで飛ぶ設定：phpでのAタグの役目＝データを持っていく関数
            exit();
        }
      
    }
    echo "Cの処理<br>";
?>

<!DOCTYPE html>
<html>
<head lang="ja">
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
  <h1>ユーザー登録</h1>
  <form method="POST" action="" enctype="multipart/form-data">
    <!-- enctype 何かしらのファイルを表示する -->
    

    <div>
      ユーザー名<br>
      <input type="text" name="name" value="<?=$name;?>">
      <?php if(isset($validations['name'])&& $validations['name']=='blank'): ?>
        <span class="error_msg">ユーザー名を入力してください</span>
        <!-- &&は左から読む。両方がTRueだったら実行 -->
        <!-- バリデーションの中が空だったら -->
        <!-- これだけだとエラーが出るので -->
      <?php endif; ?>
    </div>


    <div>
      メールアドレス<br>
      <input type="email" name="email" value="<?=$email?>">
      <?php if(isset($validations['email'])&& $validations['email']=='blank'): ?>
        <span class="error_msg">メールアドレスを入力してください</span>
      <?php endif?>
    </div>
    
    <div>
      パスワード<br>
      <input type="password" name="password" value="">
      <?php if(isset($validations['password'])&& $validations['password']=='blank'): ?>
        <span class="error_msg">パスワードを入力してください</span>
      <?php endif?>
            <?php if(isset($validations['password'])&& $validations['password']=='length'): ?>
        <span class="error_msg">パスワードは４〜１６文字で入力してください。</span>
      <?php endif?>
    </div>
    <div>
      プロフィール画像<br>
      <input type="file" name="img_name"  accept="image/*">
      <!-- *はワイルドカード　イメージだったらなんでも良いぞにする -->
      <!--name カラム名とあわせていると読みやすい -->
      <?php if(isset($validations['img_name'])&& $validations['img_name']=='blank'): ?>
        <span class="error_msg">画像を選択してください。</span>
      <?php endif?>
    </div>
    <input type="submit" name="確認">

  </form>
</body>
</html>





















