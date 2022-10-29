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
  <title>higaCoinホーム</title>
</head>

<body>
  <script>
    $(document).ready(function() {
      var windowHeight = window.innerHeight;
      $('.player_1').css('height', windowHeight);
      $('.player_2').css('height', windowHeight);
      setInterval(() => {
        var windowHeight = window.innerHeight;
        $('.player_1').css('height', windowHeight);
        $('.player_2').css('height', windowHeight);
      }, 3000);
    });
  </script>
  <?php
  error_reporting(0);
  session_start();
  // 未ログインを弾く
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
  if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2']) && empty($_SESSION['NO_R'])) {
    header('Location: ./poker_game.php');
    $_SESSION['RANDOM'] = 1;
  }
  if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
    header('Location: ./poker_game.php');
  }
  ?>
  <div class="player_1">
    <?php
    echo '<p class="error_message">ようこそ' . $_SESSION['NAME'] . 'さん。所持金：' . $_SESSION['HIGACOIN'] . 'hC</p>';
    if (empty($_SESSION['HIGACOIN_DATA'])) :
    ?>
      <form action="./plus.php" method="post">
        <input class="invite no_animation black" type="number" name="amount" placeholder="掛け金を入力" min="100" max="<?php echo $_SESSION['HIGACOIN'] ?>">
        <input class="invite black black_s" type="submit" name="start" value="スタート">
      </form>
      <a class="invite home" href="./">ホームに戻る</a>;
    <?php else : ?>
      <p class="error_message">賭け金：<?php echo $_SESSION['AMOUNT'] ?>hC</p>
      <p class="error_message">相手を待っています...</p>
    <?php endif ?>
  </div>
  <div class="player_2">
    <?php if ($_SESSION['NAME_2'] == null) : ?>
      <p class="error_message player_2_message">ログインしてください。</p>
      <form action="./login_2.php" method="post">
        <input class="invite f no_animation" placeholder="ユーザー名を入力してください" name="user_name">
        <input class="invite f no_animation" type="password" placeholder="パスワードを入力してください" name="password">
        <input class="submit f_1" type="submit" value="ログイン" name="login">
      </form>
      <form action="./end.php" method="post">
        <input class="invite end" type="submit" name="end" value="終了">
      </form>
      <?php
    else :
      echo '<p class="error_message player_2_message">ようこそ' . $_SESSION['NAME_2'] . 'さん。所持金：' . $_SESSION['HIGACOIN_2'] . 'hC</p>';
      if (empty($_SESSION['AMOUNT_2'])) :
      ?>
        <form action="./plus.php" method="post">
          <input class="invite no_animation" type="number" name="amount" placeholder="掛け金を入力" min="100" max="<?php echo $_SESSION['HIGACOIN_2'] ?>">
          <input class="invite black_s" type="submit" name="plus" value="スタート">
        </form>
        <form action="./end.php" method="post">
          <input class="invite end" type="submit" name="end" value="終了">
        </form>
      <?php else : ?>
        <p class="error_message player_2_message">賭け金：<?php echo $_SESSION['AMOUNT_2'] ?>hC</p>
        <p class="error_message player_2_message">相手を待っています...</p>
        <form action="./end.php" method="post">
          <input class="invite end" type="submit" name="end" value="終了">
        </form>
      <?php endif; ?>
    <?php endif; ?>
  </div>
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