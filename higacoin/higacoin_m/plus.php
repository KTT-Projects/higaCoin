<?php
session_start();
// データベース情報
      define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
      define('DB_USER', 'on294_higacoin');
      define('DB_PASS', 'ktdevsPro406$');
if ($_SESSION['LOGIN'] == null) {
  header('Location: ./signup.php');
}
if ($_SESSION['LOGIN'] == 1) {
  header('Location: ./signup.php');
}
if ($_POST['amount'] == null) {
  header('Location: ./poker_local.php');
} else {
  if (!empty($_POST['plus'])) {
    $id = $_SESSION['ID_2'];
    $amount = 0;
    $bitcoin = 0;
    $total = $_SESSION['HIGACOIN_2'] - $_POST['amount'];
    if ($total >= 0) {
      $_SESSION['HIGACOIN_2'] = $total;
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        // 計算した後の値をデータベースに代入
        $stmt = $pdo->prepare('UPDATE userData SET higacoin = :total where id = :id');
        $stmt->bindParam(':total', $total, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['AMOUNT_2'] = $_POST['amount'];
        header('Location: ./poker_local.php');
      } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
    } else {
      $total = null;
    }
    if ($total == null) {
      header('Location: ./poker_local.php');
    }
  }
  if (!empty($_POST['start'])) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare("SELECT higacoin FROM userData WHERE user_name = :user_name");
      $stmt->bindValue(':user_name', $_SESSION['NAME']);
      $stmt->execute();
      $higacoin_data = $stmt->fetch();
      $higacoin_data = $higacoin_data[0];
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    $id_1 = $_SESSION['ID'];
    $amount_1 = 0;
    $bitcoin_1 = 0;
    $total_1 = $higacoin_data - $_POST['amount'];
    if ($total_1 >= 0) {
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        // 計算した後の値をデータベースに代入
        $stmt = $pdo->prepare('UPDATE userData SET higacoin = :total where id = :id');
        $stmt->bindParam(':total', $total_1, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id_1, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['HIGACOIN_DATA'] = '所持金：' . $total_1;
        $_SESSION['HIGACOIN'] = $total_1;
        $_SESSION['AMOUNT'] = $_POST['amount'];
        header('Location: ./poker_local.php');
      } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
    } else {
      $total_1 = null;
    }
    if ($total_1 == null) {
      header('Location: ./poker_local.php');
    }
  }
}