$(function() {

    //$('.js-like').on('click', function() {
      //DBに接続
      //jsクラス名　オブジェクト
    $(document).on('click', '.js-like', function(){
     //この書き方じゃないとバージョン的な意味合いで作動うしない為
      //user_id,feed_id 所得できているか確認
      //$(this) 今のイベントを発動させた部品

      var feed_id = $(this).siblings('.feed-id').text();
      var user_id = $('#signin-user').text();

      var like_btn = $(this);//押されたボタンそのもの
      var like_count = $(this).siblings('.like_count').text();//クラス名like_countと指定されているテキスト
      //兄弟要素siblings

      console.log(feed_id);
      console.log(user_id);
        //ajaxで動作させたい処理を記述
        $.ajax({
        //{}内はやりたいこと
        //送信先、送信するデータなどを記述（目的の処理）
        url:'like.php', //実行したいプログラム
        type:'POST',//送信方法
        datatype: 'json',//受信されてくるデータの形式
        data:{
          'feed_id':feed_id,
          'user_id':user_id,
          'is_liked':true
        }
        })
        .done(function(data){
          //目的の処理が成功した時の処理
          console.log(data);//trueが出る
          if (data =='true') {
            like_count++;//like_count+1と同じ意味
            like_btn.siblings('.like_count').text(like_count);//プラス１した数字を上書き

            
            like_btn.removeClass('js-like'); //ボタンからLikeボタンの目印であるクラスjs-likeを削除する
            like_btn.addClass('js-unlike'); //ボタンにいいねを取り消すボタンの目印であるクラスjs-unlikeを削除する
            like_btn.children('span').text('いいねを取り消す');　//ボタンの表記を変更
            //likeからunlikeに変わった時にいいねを取り消すに表示変更する

          }
        })
        .fail(function(err){
          //目的の処理が失敗した時の処理
          console.log('error');
    })


    });
    //いいね取り消す
     $('.js-unlike').on('click', function() {
        var feed_id = $(this).siblings('.feed-id').text();
        var user_id = $('#signin-user').text();

        var like_btn = $(this);//押されたボタンそのもの
        var like_count = $(this).siblings('.like_count').text();

        console.log(feed_id);
        console.log(user_id);

        $.ajax({
        //{}内はやりたいこと
        //送信先、送信するデータなどを記述（目的の処理）
        url:'like.php', //実行したいプログラム
        type:'POST',//送信方法
        datatype: 'json',//受信されてくるデータの形式
        data:{
          'feed_id':feed_id,
          'user_id':user_id,
          // 'is_liked':false こっちには無い
          }
        })

        .done(function(data){
          //目的の処理が成功した時の処理
          console.log(data);//trueが出る
          if (data =='true') {
            like_count--;//like_count-1と同じ意味
            like_btn.siblings('.like_count').text(like_count);//プラス１した数字を上書き

            like_btn.removeClass('js-ulike'); 
            like_btn.addClass('js-like'); 
            like_btn.children('span').text('いいね!');//ボタンの表記を変更
            //unlikeからlikeに変更した時にいいねに変わる
          }
        })
        .fail(function(err){
          //目的の処理が失敗した時の処理
          console.log('error');
        })


      })



});





















