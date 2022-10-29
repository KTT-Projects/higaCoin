<?php
error_reporting(0);
// DB情報
define('DSN', 'mysql:host=localhost;dbname=higacoin');
define('DB_USER', 'root');
define('DB_PASS', '');
session_start();
// 未ログインを弾く
if ($_SESSION['LOGIN'] == null) {
  header('Location: ./signup.php');
}
// ログイン処理
if (!empty($_POST['login'])) {
  if ($_POST['user_name'] != $_SESSION['NAME']) {
    try {
      // DB接続・データ取得
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('select * from userData where user_name = ?');
      $stmt->execute([$_POST['user_name']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (password_verify($_POST['password'], $row['password'])) {
        $_SESSION['NAME_2'] = $row['user_name'];
        $_SESSION['ID_2'] = $row['id'];
        $_SESSION['HIGACOIN_2'] = $row['higacoin'];
        header('location: ./poker_local.php');
      } else {
        // エラー時の処理
        header('Location: ./poker_local.php');
        return false;
      }
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  } else {
    header('location: ./poker_local.php');
  }
}
