<?php
error_reporting(0);
session_start();
define('DSN', 'mysql:host=mysql90.conoha.ne.jp;dbname=on294_higacoin');
define('DB_USER', 'on294_higacoin');
define('DB_PASS', 'ktdevsPro406$');
if (!empty($_POST['end'])) {
  if (!empty($_POST['end'])) {
    if ($_SESSION['WIN'] == 3) {
      if (!empty($_SESSION['AMOUNT'])) {
        try {
          $id = $_SESSION['ID'];
          $amount = $_SESSION['HIGACOIN'] + $_SESSION['AMOUNT'];
          $_SESSION['HIGACOIN'] += $_SESSION['AMOUNT'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
      if (!empty($_SESSION['AMOUNT_2'])) {
        try {
          $id_1 = $_SESSION['ID_2'];
          $amount_1 = $_SESSION['HIGACOIN_2'] + $_SESSION['AMOUNT_2'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id_1, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount_1, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
    } elseif ($_SESSION['WIN'] == 1) {
      if (!empty($_SESSION['AMOUNT'])) {
        $_SESSION['AMOUNT'] += $_SESSION['AMOUNT_2'];
        try {
          $id = $_SESSION['ID'];
          $amount = $_SESSION['HIGACOIN'] + $_SESSION['AMOUNT'];
          $_SESSION['HIGACOIN'] += $_SESSION['AMOUNT'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
      if (!empty($_SESSION['AMOUNT_2'])) {
        try {
          $id_1 = $_SESSION['ID_2'];
          $amount_1 = $_SESSION['HIGACOIN_2'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id_1, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount_1, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
    } else {
      if (!empty($_SESSION['AMOUNT'])) {
        $_SESSION['AMOUNT_2'] += $_SESSION['AMOUNT'];
        try {
          $id = $_SESSION['ID'];
          $amount = $_SESSION['HIGACOIN'];
          $_SESSION['HIGACOIN'] += $_SESSION['AMOUNT'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
      if (!empty($_SESSION['AMOUNT_2'])) {
        try {
          $id_1 = $_SESSION['ID_2'];
          $amount_1 = $_SESSION['HIGACOIN_2'] + $_SESSION['AMOUNT_2'];
          $_SESSION['HIGACOIN_2'] += $_SESSION['AMOUNT_2'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id_1, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount_1, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
    }
    if ($_SESSION['WIN'] == null) {
      if ($_SESSION['AMOUNT'] != null) {
        try {
          $id = $_SESSION['ID'];
          $amount = $_SESSION['HIGACOIN'];
          $_SESSION['HIGACOIN'] += $_SESSION['AMOUNT'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
      if ($_SESSION['AMOUNT_2'] != null) {
        try {
          $id_1 = $_SESSION['ID_2'];
          $amount_1 = $_SESSION['HIGACOIN_2'] + $_SESSION['AMOUNT_2'];
          $_SESSION['HIGACOIN_2'] += $_SESSION['AMOUNT_2'];
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE id = :id');
          $stmt->bindParam(':id', $id_1, PDO::PARAM_INT);
          $stmt->bindParam(':higacoin', $amount_1, PDO::PARAM_INT);
          $stmt->execute();
        } catch (\Exception $e) {
          echo $e->getMessage() . PHP_EOL;
        }
      }
    }
    unset($_SESSION['NUMBER'], $_SESSION['NAME_2'], $_SESSION['HIGACOIN_2'], $_SESSION['HIGACOIN_DATA'], $_SESSION['ID_2'], $_SESSION['AMOUNT'], $_SESSION['AMOUNT_2'], $_SESSION['NO_R'], $_SESSION['COUNT'], $_SESSION['COUNT'], $_SESSION['AMOUNT_D'], $_SESSION['AMOUNT_D2'], $_SESSION['READY'], $_SESSION['AGREE'], $_SESSION['PAIRS'], $_SESSION['PAIRS_N'], $_SESSION['RANDOM'], $_SESSION['PAIRS2'], $_SESSION['PAIRS_N2'], $_SESSION['WIN'], $_SESSION['DONE']);
    header('Location: ./');
  }
}