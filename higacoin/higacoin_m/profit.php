<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="./script.js"></script>
  <link rel="stylesheet" href="./stylesheet_p.css">
</head>

<body>
  <?php
  session_start();
  if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
    header('Location: ./poker_game.php');
  } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
    header('Location: ./poker_local.php');
  }
  // ログインしていない場合はリダイレクト
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
  ?>
  <div class="content"></div>
  <script>
    $(document).ready(function() {
      // 変数の登録
      var count = null;
      var normal_count = null;
      var param = JSON.parse('<?php echo $_SESSION['ID']; ?>');
      var length = null;
      var amount = null;
      var trade_bitcoin = null;
      var final = null;
      // ユーザーの取引情報を取得
      function get_higacoin() {
        // ajax開始
        $.ajax({
          type: "POST",
          url: "./json_p.php",
          dataType: "json",
        }).done(function(data, dataType) {
          var $content = $('.content');
          var normal_count = data.length;
          // bitcoinデータを取得して表示
          for (count = 0; count < normal_count;) {
            if (data[count].id == param) {
              amount = data[count].amount;
              trade_bitcoin = data[count].bitcoin;
            }
            count++;
          }
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
          // エラー時の処理
        });
      }
      // 損益を取得
      function get_profit() {
        final = last_bitcoin / trade_bitcoin;
        final = amount * final;
        final = final - amount;
        final = Math.round(final);
        if (final > 0) {
          $('.content').html('<p>+' + final + '</p>');
        } else if (final == 0) {
          $('.content').html('<p>+/−' + final + '</p>');
        } else if (final < 0) {
          $('.content').html('<p>' + final + '</p>');
        } else {
          $('.content').html('');
          $('*').css('background-color', '#5A0001');
        }
      }
      // 最初の実行
      get_bitcoin();
      get_higacoin();
      setTimeout(() => {
        get_profit();
      }, 800);
      // 2回目以降のインターバル実行
      setInterval(() => {
        get_bitcoin();
        get_higacoin();
        get_profit();
      }, 2000);
    });
  </script>
  <script type="text/javascript">
    $(function() {

      //input属性のものを一括で取得する
      var inputItem = document.getElementsByTagName("input");
      //全てオートコンプリートをOFFにする
      for (var i = 0; i < inputItem.length; i++) {
        inputItem[i].autocomplete = "off";
      }

    });
  </script>
</body>

</html>