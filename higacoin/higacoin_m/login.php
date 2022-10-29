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
  <title>higaCoinログイン</title>
</head>

<body>
  <main>
    <form method="post">
      <input class="invite f no_animation" placeholder="ユーザー名を入力してください" name="user_name">
      <input class="invite f no_animation" type="password" placeholder="パスワードを入力してください" name="password">
      <input class="submit f_1" type="submit" value="ログイン" name="login">
    </form>
    <a href="./index.php" class="invite">ホームに戻る</a>
    <?php
    error_reporting(0);
    // DB情報
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
    session_start();
    if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
      header('Location: ./poker_game.php');
    } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
      header('Location: ./poker_local.php');
    }
    // 未ログインを弾く
    if ($_SESSION['LOGIN'] == null) {
      header('Location: ./signup.php');
    }
    // ログイン処理
    if (!empty($_POST['login'])) {
      try {
        // DB接続・データ取得
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('select * from userData where user_name = ?');
        $stmt->execute([$_POST['user_name']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
      // 照合処理・情報登録
      if (password_verify($_POST['password'], $row['password'])) {
        $_SESSION['NAME'] = $row['user_name'];
        $_SESSION['ID'] = $row['id'];
        $_SESSION['LOGIN'] = 2;
        header('location: ./');
      } else {
        // エラー時の処理
        echo '<p class="error_message">ユーザー名又はパスワードが間違っています。</p>';
        return false;
      }
    }
    ?>
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