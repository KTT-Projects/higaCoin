<?php
// session開始
session_start();
date_default_timezone_set('Asia/Tokyo');
if (!empty($_SESSION['AMOUNT']) && !empty($_SESSION['AMOUNT_2'])) {
  header('Location: ./poker_game.php');
} elseif (!empty($_SESSION['NAME_2']) || !empty($_SESSION['AMOUNT'])) {
  header('Location: ./poker_local.php');
}
// 購入していない場合はリダイレクト
if ($_SESSION['amount'] == null) {
  header('Location: ./money.php');
} elseif ($_SESSION['amount'] == 0) {
  header('Location: ./money.php');
} else {
  // sessionを変数に代入
  $amount = $_SESSION['amount'];
  $id = $_SESSION['ID'];
  $bitcoin = null;
  error_reporting(0);
  // データベース情報
  define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
  define('DB_USER', 'on294_higacoin');
  define('DB_PASS', 'ktdevsPro406$');
  // データベース接続
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    // ユーザーの持っているhigaCoinの量を取得し計算
    $stmt = $pdo->prepare('select * from userData where user_name = ?');
    $stmt->execute([$_SESSION['NAME']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $row['higacoin'] - $_SESSION['amount'];
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  // 最新のビットコイン価格を取得
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('SELECT * FROM bitcoin ORDER BY id DESC LIMIT 1;');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bitcoin = $row['bitcoin'];
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  // データベース接続
  if ($total >= 0) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      // 計算した後の値をデータベースに代入
      $stmt = $pdo->prepare('UPDATE userData SET higacoin = :total, trade_amount = :trade_amount, trade_bitcoin = :trade_bitcoin where id = :id');
      $stmt->bindParam(':total', $total, PDO::PARAM_INT);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':trade_amount', $amount, PDO::PARAM_INT);
      $stmt->bindParam(':trade_bitcoin', $bitcoin, PDO::PARAM_INT);
      $stmt->execute();
      // ログをセッションに保存
      $_SESSION['LOG'] = '<p class="error_message log">' . date('Y-m-d H:i:s') . '<br>' . $bitcoin . '円のBitcoinを' . $_SESSION['amount'] . 'hC分購入しました。</p>' . '<br>' . $_SESSION['LOG'];
      header('Location: ./money.php');
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  } else {
    header('Location: ./money.php');
  }
  $_SESSION['amount'] = null;
}