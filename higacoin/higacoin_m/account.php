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
  <main>
    <?php
    session_start();
    error_reporting(0);
    // 未ログインを弾く
    if ($_SESSION['LOGIN'] == null) {
      header('Location: ./signup.php');
    }
    if ($_SESSION['LOGIN'] == 1) {
      header('Location: ./signup.php');
    }
    if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
      header('Location: ./poker_game.php');
    } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
      header('Location: ./poker_local.php');
    }
    // ログアウトボタンを押した時の処理
    if (!empty($_POST['logout'])) {
      // セッション削除
      $_SESSION = array();
      // リダイレクト
      header('Location: ./');
    }
    ?>
    <form method="post">
      <input class="submit" name="logout" type="submit" value="ログアウト">
    </form>
    <p class="error_message logout_message">※ログアウト時に取引ログが削除されます</p>
    <a href="./index.php" class="invite">ホームに戻る</a>
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