<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
if ($_SESSION['sell'] == null) {
  header('Location: ./money.php');
} else {
  if ($_SESSION['BUY'] == null) {
    header('Location: ./money.php');
  } else {
    $id = $_SESSION['ID'];
    error_reporting(0);
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT * FROM bitcoin ORDER BY id DESC LIMIT 1;');
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $bitcoin = $row['bitcoin'];
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      // ユーザーの持っているhigaCoinの量を取得し計算
      $stmt = $pdo->prepare('SELECT * from userData WHERE user_name = ?');
      $stmt->execute([$_SESSION['NAME']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $profit = $bitcoin / $row['trade_bitcoin'];
      $profit_c = $bitcoin / $row['trade_bitcoin'] * 100;
      $profit_c = round($profit_c);
      $profit_c1 = $row['trade_amount'] * $profit;
      $profit_c1 = round($profit_c1);
      $profit_c2 = $profit_c1 - $row['trade_amount'];
      $profit = $row['trade_amount'] * $profit;
      $profit = $row['higacoin'] + $profit;
      $profit = round($profit);
      $profit_c -= 100;
      if ($profit_c2 >= 0) {
        $_SESSION['LOG'] = '<p class="error_message log">' . date('Y-m-d H:i:s') . '<br>' . $row['trade_bitcoin'] . '円から' . $bitcoin . '円に変化したBitcoinを' . $profit_c1 . 'hC分の価格で売りました。購入時の価格は' . $row['trade_amount'] . 'hCで利益率は+' . $profit_c . '%、利益は+' . $profit_c2 . 'hCでした。</p>' . '<br>' . $_SESSION['LOG'];
      } else {
        $_SESSION['LOG'] = '<p class="error_message log">' . date('Y-m-d H:i:s') . '<br>' . $row['trade_bitcoin'] . '円から' . $bitcoin . '円に変化したBitcoinを' . $profit_c1 . 'hC分の価格で売りました。購入時の価格は' . $row['trade_amount'] . 'hCで損益率は' . $profit_c . '%、損益は' . $profit_c2 . 'hCでした。</p>' . '<br>' . $_SESSION['LOG'];
      }
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':higacoin', $profit, PDO::PARAM_INT);
      $stmt->execute();
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    try {
      $amount = 0;
      $bitcoin = 0;
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE userData SET trade_amount = :trade_amount, trade_bitcoin = :trade_bitcoin WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':trade_amount', $amount, PDO::PARAM_INT);
      $stmt->bindParam(':trade_bitcoin', $bitcoin, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: ./money.php');
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    $_SESSION['BUY'] = null;
  }
}