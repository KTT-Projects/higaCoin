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
  <title>higaCoin本登録</title>
</head>

<body>
  <main>
    <?php
    if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
      header('Location: ./poker_game.php');
    } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
      header('Location: ./poker_local.php');
    }
    // データベース情報
    define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
    define('DB_USER', 'on294_higacoin');
    define('DB_PASS', 'ktdevsPro406$');
    session_start();
    // 未ログインを弾く
    if ($_SESSION['LOGIN'] == null) {
      header('Location: ./signup.php');
      // 一段階認証の場合の処理
    } elseif ($_SESSION['LOGIN'] == 1) {
      // ログインを押した際の処理
      if (!empty($_POST['login'])) {
        // ユーザー名が空の場合
        if (empty($_POST['user_name'])) {
          echo '<p class="error_message">ユーザー名を入力してください。</p>';
          $error_message = 1;
        }
        // パスワードが空の場合
        if (empty($_POST['user_password'])) {
          echo '<p class="error_message">パスワードを入力してください。</p>';
          $error_message = 1;
        }
        // データベース接続
        try {
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
        // パスワードの暗号化・エラー
        if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['user_password'])) {
          $password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        } else {
          $error_message = 1;
          echo '<p class="error_message">パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください</p><br><a href="final_signup.php" class="invite">やりなおす</a>';
          return false;
        }
        // ユーザー名を変数に代入
        if (!empty($_POST['user_name'])) {
          $name = $_POST['user_name'];
        }
        if (empty($error_message)) {
          // データベースにユーザー情報を代入
          try {
            $stmt = $pdo->prepare("insert into userData(user_name, password, higacoin) value(?, ?, ?)");
            $stmt->execute([$name, $password, 10000]);
            header('location: ./login.php');
          } catch (\Exception $e) {
            echo '<p class="error_message">登録済みのユーザー名です。</p>';
          }
          // 完了後にエラーメッセージをリセット
          $error_message = null;
        }
      }
    }
    ?>
    <form method="post">
      <input class="invite f no_animation" name="user_name" placeholder="ユーザー名を入力してください">
      <input class="invite f no_animation" type="password" name="user_password" placeholder="ログイン用のパスワードを設定してください">
      <p class="error_message login_message">パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください</p>
      <input class="submit f_1" name="login" type="submit" value="登録">
    </form>
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