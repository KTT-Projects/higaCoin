<?php
// session開始
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
// sessionに購入量を代入して処理ページへ
if (!empty($_POST['submit_amount'])) {
  $_SESSION['amount'] = $_POST['amount'];
  header('location: ./buy.php');
}
error_reporting(0);
// データベース設定
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
// データベース接続
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // 所持しているhigaCoinの量を取得
  $stmt = $pdo->prepare("SELECT higacoin FROM userData WHERE user_name = :user_name");
  $stmt->bindValue(':user_name', $_SESSION['NAME']);
  $stmt->execute();
  $higacoin_data = $stmt->fetch();
  $higacoin_data = $higacoin_data[0];
  $_SESSION['HIGACOIN'] = $higacoin_data;
  echo '<a href="./"><p class="money">所持金<br>' . number_format($higacoin_data) . ' hC</p></a>';
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
// 取引状態か否か確認するためにデータベースから取引中の値を取得
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->prepare("SELECT trade_amount FROM userData WHERE user_name = :user_name");
  $stmt->bindValue(':user_name', $_SESSION['NAME']);
  $stmt->execute();
  $trade_data = $stmt->fetch();
  $trade_data = $trade_data[0];
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
// 売る場合の処理
if (!empty($_POST['submit_sell'])) {
  $_SESSION['sell'] = 1;
  header('Location: ./trade.php');
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kaisei+HarunoUmi&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="./logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- <script src="script.js"></script> -->
  <title>bitcoin取引</title>
</head>

<body>
  <div class="bitcoin_log">
    <?php
    echo '<div class=log_message>' . $_SESSION['LOG'] . '</div>';
    ?>
  </div>
  <div id="content"></div>
  <div class="stats">
    <form method="post">
      <div class="buy">
        <!-- 取引状態でない場合 -->
        <?php if ($trade_data == 0) : ?>
          <input type="button" id="open_buy" value="購入画面を開く">
          <input type="number" name="amount" class="amount" onkeydown="return event.keyCode !== 69" min="1" max="<?php echo $higacoin_data ?>">
          <input type="submit" name="submit_amount" class="submit_amount" value="hCで購入">
      </div>
    </form>
    <!-- 取引状態の場合 -->
  <?php
        else :
          $_SESSION['BUY'] = 1;
  ?>
    <form method="post">
      <div class="sell">
        <input type="submit" name="submit_sell" class="submit_sell" value="全て売却">
      </div>
    </form>
  <?php endif ?>
  </div>
  <div id="profit"></div>
  <script>
    $(document).ready(function() {
      var last_bitcoin = null;
      var trade_bitcoin = null;
      var amount = null;
      var final = null;

      function get_bitcoin() {
        var count = 0;
        var normal_count = null;
        var length = null;
        var output = null;
        var dfd = $.Deferred();
        $.ajax({
            type: "POST",
            url: "./json.php",
            dataType: "json",
          })
          .done(function(data) {
            var $content = $('#content');
            var normal_count = data.length;
            count = 0;
            last_bitcoin = data[0].name;
            // bitcoinデータを取得して表示
            for (count = count; count < normal_count;) {
              if (output != null) {
                output = output + '<p class="bitcoin_data">○' + data[count].name + "</p>";
              } else {
                output = '<p class="bitcoin_data">○' + data[count].name + "</p>";
              }
              count++;
            }
            $content.html(output);
            // 返ってくるのに時間が掛かる処理
            dfd.resolve();
          })
          .fail(function(data){
            console.log(data);
          })

        // fail()は省略
        return dfd.promise();
      }

      function get_higacoin() {
        var count = null;
        var normal_count = null;
        var param = JSON.parse('<?php echo $_SESSION['ID']; ?>');
        var length = null;
        var dfd = $.Deferred();
        $.ajax({
            type: "POST",
            url: "./json_p.php",
            dataType: "json",
          })
          .done(function(data, dataType) {
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
            dfd.resolve();
          });
        // fail()は省略
        return dfd.promise();
      }

      get_bitcoin()
        .then(get_higacoin)
        .then(get_profit);
      setInterval(() => {
        // $('#content').empty();
        get_bitcoin()
          .then(get_higacoin)
          .then(get_profit);
      }, 3000);

      function get_profit() {
        final = last_bitcoin / trade_bitcoin;
        final = amount * final;
        final = final - amount;
        final = Math.round(final);
        if (final > 0) {
          $('#profit').html('<p class="profit_number">+' + final + '</p>');
          $('#profit').slideDown();
        } else if (final == 0) {
          $('#profit').html('<p class="profit_number">+/−' + final + '</p>');
          $('#profit').slideDown();
        } else if (final < 0) {
          $('#profit').html('<p class="profit_number">' + final + '</p>');
          $('#profit').slideDown();
        }
      }
      // 購入画面を開くスクリプト
      var close_count = null;
      $('#open_buy').click(function() {
        if (close_count == null) {
          $('.amount').slideDown(300);
          $('.submit_amount').slideDown(300);
          $('#open_buy').val('購入画面を閉じる');
          close_count = 1;
        } else {
          $('.amount').slideUp(300);
          $('.submit_amount').slideUp(300);
          $('#open_buy').val('購入画面を開く');
          close_count = null;
        }
      });
      var windowHeight = window.innerHeight;
      $('#content').css('height', windowHeight);
      $('.bitcoin_log').css('height', windowHeight - 150);
      // 5秒のインターバル
      setInterval(() => {
        var windowHeight = window.innerHeight;
        $('#content').css('height', windowHeight);
      }, 5000);
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