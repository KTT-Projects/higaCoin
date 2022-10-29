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
    error_reporting(0);
    session_start();
    if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
      header('Location: ./poker_game.php');
    } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
      header('Location: ./poker_local.php');
    }
    // ログインしていない場合はリダイレクト
    if ($_SESSION['LOGIN'] == null) :
      header('Location: ./signup.php');
    elseif ($_SESSION['LOGIN'] == 1) :
    ?>
      <a class="invite" href="./final_signup.php">本登録はこちら</a><br>
      <a class="invite" href="./login.php">ログインはこちら</a>
    <?php elseif ($_SESSION['LOGIN'] == 2) :
      // データベース情報
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
      // データベース接続
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // higaCoinデータを取得
        $stmt = $pdo->prepare("SELECT higacoin FROM userData WHERE user_name = :user_name");
        $stmt->bindValue(':user_name', $_SESSION['NAME']);
        $stmt->execute();
        $higacoin_data = $stmt->fetch();
        $higacoin_data = $higacoin_data[0];
        $_SESSION['HIGACOIN'] = $higacoin_data;
      } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
      echo '<ul class="fixed"><h3><a href="./account.php">' . $_SESSION['NAME'];
      echo '</a></h3><br><li><a href="./ranking.php">' . number_format($higacoin_data) . ' hC</a></li></ul>';
    ?>
      <a class="invite games mes" href="./mes.php"><b>MES</b><br>ver 1.0</a>
      <a class="invite games bitcoin" href="./money.php">Bitcoin取引<br>ver 1.4</a>
      <a class="invite games" href="#">オンラインじゃんけん<br>ver 0.1</a>
      <a class="invite games" href="#">Casino War<br>ver 0.1</a>
      <a class="invite games" href="./poker_home.php">ポーカー<br>ver 1.2</a>
      <a class="invite games" href="#">スロット<br>ver 0.1</a>
      <a class="invite games" href="#">ブラックジャック<br>ver 0.1</a>
    <?php endif; ?>
    <p class="logo">higaCoin</p>
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