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
  <title>higaCoinホーム</title>
</head>

<body>
  <?php
  session_start();
  if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
    header('Location: ./poker_game.php');
  }
  if (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
    header('Location: ./poker_local.php');
  }
  // 未ログインを弾く
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
  echo '<p class="error_message poker_name">Welcome to poker, ' . $_SESSION['NAME'] . '.</p>';
  ?>
  <main>
    <a class="invite games" href="./poker_online.php">オンラインポーカー<br>ver 0.1</a>
    <a class="invite games" href="./poker_local.php">対面ポーカー<br>ver 1.2</a>
  </main>
  <main>
    <a class="invite" href="./">ホームに戻る</a>
  </main>
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