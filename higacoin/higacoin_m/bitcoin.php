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
  <title>bitcoin取引</title>
</head>

<body>
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
  // 管理者以外を弾く
  if ($_SESSION['NAME'] != 'ADMIN') {
    header('Location: ./signup.php');
  }
  if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
    header('Location: ./poker_game.php');
  } elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
    header('Location: ./poker_local.php');
  }
  // API接続
  $res = file_get_contents('https://bitflyer.jp/api/echo/price');
  $arr = json_decode($res, true);
  $bitcoin = $arr['ask'];
  // データベース情報
  define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
  define('DB_USER', 'on294_higacoin');
  define('DB_PASS', 'ktdevsPro406$');
  // データベース接続
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  // エラーがない場合の処理
  if (empty($error_message)) {
    // データベースにビットコインの価格を追加
    try {
      $stmt = $pdo->prepare("insert into bitcoin(bitcoin) value(?)");
      $stmt->execute([$bitcoin]);
    } catch (\Exception $e) {
      echo '<p class="error_message">エラー</p>';
    }
  }
  // 接続文字列 (PHP5.3.6から文字コードが指定できるようになりました)
$dsn = 'mysql:dbname=on294_higacoin;host=mysql90.conoha.ne.jp;charset=utf8';
// ユーザ名
$user = 'on294_higacoin';
// パスワード
$password = 'ktdevsPro406$';
  try {
    // DBに接続
    $dbh = new PDO($dsn, $user, $password);
    // bitcoinテーブルのデータを取得する
    $sql = 'SELECT * FROM bitcoin ORDER BY id DESC';
    $stmt = $dbh->query($sql);
    // 取得したデータを配列に格納
    while ($row = $stmt->fetchObject()) {
      $data_array[] = $row->id;
      $bitcoin_array[] = $row->bitcoin;
    }
  } catch (PDOException $e) {
    // 例外処理
    die('Error:' . $e->getMessage());
  }
  foreach ($data_array as $value) {
    $count++;
    if ($count >= 100) {
      $data[] = $data_array[$count - 1];
    }
  }
  foreach ($data as $value) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare("DELETE FROM bitcoin WHERE id = :id");
      $stmt->bindParam(':id', $value, PDO::PARAM_INT);
      $stmt->execute();
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }

  ?>
  <script>
    function reload() {
      location.reload(false);
    }
    setInterval("reload()", 10000);
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
  <pre class="a">
    <?php
    var_dump($data);
    var_dump($data_array);
    ?>
  </pre>
  <pre class="b">
    <?php
    var_dump($bitcoin_array);
    ?>
  </pre>
  <style>
    * {
      color: white;
    }

pre {
  float: left;
  margin-right: 10px;
  margin-left: 10px;
}
  </style>
</body>

</html>