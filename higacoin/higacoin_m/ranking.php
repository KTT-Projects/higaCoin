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
  <h2 class="error_message">RANKING</h2>
  <ul>
    <?php
    session_start();
    if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
      header('Location: ./poker_game.php');
    } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
      header('Location: ./poker_local.php');
    }
    if ($_SESSION['LOGIN'] == null) {
      header('Location: ./signup.php');
    }
    if ($_SESSION['LOGIN'] == 1) {
      header('Location: ./signup.php');
    }
    error_reporting(0);
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
    $number = 0;
    $higacoin = array();
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM userData ORDER BY higacoin DESC";
      $higacoin = $pdo->query($sql);
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    echo '<div class="ranking_cover">';
    foreach ($higacoin as $value) {
      if ($value['user_name'] != 'ADMIN') {
        $number++;
        echo '<p class="error_message ranking">' . $number . '位  ' . $value['user_name'] . '：  ';
        echo $value['higacoin'] . 'hC</p>';
      }
    }
    echo '</div>';
    ?>
  </ul>
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