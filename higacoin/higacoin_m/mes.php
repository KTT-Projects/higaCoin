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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="shortcut icon" href="./logo.png">
  <title>higaCoinホーム</title>
</head>

<body>
  <script type="text/javascript">
    $(document).ready(function() {
      // 画面の高さを取得して高さを変える
      function height() {
        var windowHeight = window.innerHeight - 60;
        $('.mes_area').css('height', windowHeight);
        $('.mes_trade').css('height', windowHeight);
        $('.sub_area').css('height', windowHeight);
      }
      height();
      setInterval(() => {
        height();
      }, 3000);
    });
    $(function() {
      $("input").keydown(function(e) {
        if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
          return false;
        } else {
          return true;
        }
      });
    });
  </script>
  <?php
  // PHP初期設定
  session_start();
  // error_reporting(0);
  // 未ログインを弾く
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
$dsn = 'mysql:dbname=on294_higacoin;host=mysql90.conoha.ne.jp;charset=utf8';
// ユーザ名
$user = 'on294_higacoin';
// パスワード
$password = 'ktdevsPro406$';
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
  echo '<ul class="fixed mes_header"><h3><a href="./account.php">' . $_SESSION['NAME'];
  echo '</a></h3><br><li><a href="./ranking.php">' . number_format($higacoin_data) . ' hC</a></li></ul>';
  try {
    $dbh = new PDO($dsn, $user, $password);
    $sql = 'SELECT * FROM mes ORDER BY id DESC';
    $stmt = $dbh->query($sql);
    // 取得したデータを配列に格納
    while ($row = $stmt->fetchObject()) {
      $mes_data[] = array(
        'from' => $row->send_from, 'to' => $row->send_to, 'amount' => $row->amount, 'percentage' => $row->percentage, 'kind' => $row->what_kind, 'when' => $row->when_post, 'agree' => $row->agree, 'id' => $row->id
      );
      $number[] = $row->amount;
      $who[] = $row->send_from;
    }
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  try {
    $dbh = new PDO($dsn, $user, $password);
    $sql = 'SELECT user_name FROM userData ORDER BY id';
    $stmt = $dbh->query($sql);
    // 取得したデータを配列に格納
    while ($row = $stmt->fetchObject()) {
      $user_data[] = array(
        'user' => $row->user_name
      );
    }
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  if (!empty($_POST['submit_agree'])) {
    try {
      $agree = 1;
      $id = $_POST['id'];
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE mes SET agree = :agree WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':agree', $agree, PDO::PARAM_INT);
      $stmt->execute();
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    $for = $_POST['id_count'];
    $_SESSION['HIGACOIN'] += $number[$for];
    try {
      $amount = $_SESSION['HIGACOIN'];
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE user_name = :name');
      $stmt->bindParam(':name', $_SESSION['NAME'], PDO::PARAM_STR);
      $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: ./mes.php');
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
  if (!empty($_POST['submit_disagree'])) {
    $for = $_POST['id_count'];
    $how_much = $number[$for];
    $where = $who[$for];
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare("SELECT higacoin FROM userData WHERE user_name = :user_name");
      $stmt->bindValue(':user_name', $where, PDO::PARAM_STR);
      $stmt->execute();
      $higa = $stmt->fetch();
      $higa = $higa[0];
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    $amount = $higa + $how_much;
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE user_name = :name');
      $stmt->bindParam(':name', $where, PDO::PARAM_STR);
      $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
      $stmt->execute();
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    try {
      $agree = 3;
      $id = $_POST['id'];
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('UPDATE mes SET agree = :agree WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':agree', $agree, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: ./mes.php');
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
  // if (!empty($_POST['submit_agree_2'])) {
    
  // }
  if (!empty($_POST['send_s'])) :
    if (!empty($_POST['send_a']) && !empty($_POST['send_n'])) :
      if ($_POST['send_n'] == $_SESSION['NAME']) {
        echo '<script>alert("自分の名前を入力しないでください")</script>';
      } else {
        foreach ($user_data as $value) {
          if ($_POST['send_n'] == $value['user']) {
            $count = 1;
          }
        }
        if ($count != 1) {
          echo '<script>alert("送金者名が間違っています")</script>';
        } else {
          try {
            $date = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("insert into mes(send_from, send_to, amount, percentage, what_kind, when_post, agree) value(?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['NAME'], $_POST['send_n'], $_POST['send_a'], 0, 1, $date, 0]);
          } catch (\Exception $e) {
          }
          try {
            $amount = $_SESSION['HIGACOIN'] - $_POST['send_a'];
            $_SESSION['HIGACOIN'] = $amount;
            $pdo = new PDO(DSN, DB_USER, DB_PASS);
            $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE user_name = :name');
            $stmt->bindParam(':name', $_SESSION['NAME'], PDO::PARAM_STR);
            $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ./mes.php');
          } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
          }
        }
      }
  ?>
    <?php else : ?>
      <script>
        alert('送金者名または送る金額を入力していません');
      </script>
    <?php endif ?>
  <?php endif ?>
  <?php
  // if (!empty($_POST['lend_s'])) {
  //   if (!empty($_POST['lend_a']) && !empty($_POST['lend_n'] && !empty($_POST['lend_p']))) {
  //     if ($_POST['lend_n'] == $_SESSION['NAME']) {
  //       echo '<script>alert("自分の名前を入力しないでください")</script>';
  //     } else {
  //       foreach ($user_data as $value) {
  //         if ($_POST['lend_n'] == $value['user']) {
  //           $count = 1;
  //         }
  //       }
  //       if ($count != 1) {
  //         echo '<script>alert("送金者名が間違っています")</script>';
  //       } else {
  //         try {
  //           $date = date('Y-m-d H:i:s');
  //           $stmt = $pdo->prepare("insert into mes(send_from, send_to, amount, percentage, what_kind, when_post, agree) value(?, ?, ?, ?, ?, ?, ?)");
  //           $stmt->execute([$_SESSION['NAME'], $_POST['lend_n'], $_POST['lend_a'], $_POST['lend_p'], 2, $date, 0]);
  //         } catch (\Exception $e) {
  //         }
  //         try {
  //           $amount = $_SESSION['HIGACOIN'] - $_POST['lend_a'];
  //           $_SESSION['HIGACOIN'] = $amount;
  //           $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //           $stmt = $pdo->prepare('UPDATE userData SET higacoin = :higacoin WHERE user_name = :name');
  //           $stmt->bindParam(':name', $_SESSION['NAME'], PDO::PARAM_STR);
  //           $stmt->bindParam(':higacoin', $amount, PDO::PARAM_INT);
  //           $stmt->execute();
  //           header('Location: ./mes.php');
  //         } catch (\Exception $e) {
  //           echo $e->getMessage() . PHP_EOL;
  //         }
  //       }
  //     }
  //   } else {
  //     echo '<script>alert("入力していない項目があります")</script>';
  //   }
  // }
  ?>
  <a href="./"><p class="logo animation">higaCoin</p></a>
  <form class="mes_trade" method="post">
    <input type="text" name="send_n" class="send invite no_animation" placeholder="送金先ユーザー名">
    <input min="0" max="<?php echo $_SESSION['HIGACOIN'] ?>" type="number" name="send_a" class="send invite no_animation" placeholder="金額を入力">
    <input type="submit" value="送金" class="send_s invite send" name="send_s">
    <!-- <input type="text" name="lend_n" class="send invite no_animation" placeholder="対象ユーザー名">
    <input min="0" type="number" name="lend_a" class="send invite no_animation" placeholder="金額を入力">
    <input min="1" max="50" type="number" name="lend_p" class="send invite no_animation" placeholder="利子を入力(%)">
    <input type="submit" value="貸す" class="send_s invite send" name="lend_s"> -->
  </form>
  <div class="mes_area">
    <?php
    foreach ($mes_data as $value) {
      if ($value['kind'] == 1 && $value['agree'] == 0) {
        echo '<p class="log_mes">' . $value['when'] . '　：<span class="agree">承認待ち</span><br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hC送金しました。</p>';
      } elseif ($value['kind'] == 1 && $value['agree'] == 1) {
        echo '<p class="log_mes">' . $value['when'] . '　：<span class="agreed">承認済み</span><br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hC送金しました。</p>';
      } elseif ($value['kind'] == 2 && $value['agree'] == 0) {
        echo '<p class="log_mes">' . $value['when'] . '　：<span class="agree">承認待ち</span><br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hCを利子' . $value['percentage'] . '%で貸しました。</p>';
      } elseif ($value['kind'] == 2 && $value['agree'] == 1) {
        echo '<p class="log_mes">' . $value['when'] . '　：<span class="agreed">承認済み</span><br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hCを利子' . $value['percentage'] . '%で貸しました。</p>';
      } elseif ($value['kind'] == 1 && $value['agree'] == 3) {
        echo '<p class="log_mes">' . $value['when'] . '　：拒否されました<br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hC送金しました。</p>';
      } else {
        echo '<p class="log_mes">' . $value['when'] . '　：拒否されました<br>' . $value['from'] . 'が' . $value['to'] . 'に' . $value['amount'] . 'hCを利子' . $value['percentage'] . '%で貸しました。</p>';
      }
    }
    ?>
  </div>
  <div class="sub_area">
    <?php
    $id_count = 0;
    foreach ($mes_data as $value) {
      if ($value['agree'] == 0 && $value['to'] == $_SESSION['NAME'] && $value['kind'] == 1) {
        echo '<div class="waiting"><p class="wait_name">' . $value['from'] . '</p><form method="post" class="agree_form"><input type="submit" value="承認" class="submit_agree" name="submit_agree"><input type="submit" value="拒否" class="submit_disagree" name="submit_disagree"><input type="hidden" value="' . $value['id'] . '" name="id"><input type="hidden" value="' . $id_count . '" name="id_count"></form><p class="wait_name">' . $value['amount'] . 'hCの送金</p>' . '</div>';
      }
      if ($value['agree'] == 0 && $value['to'] == $_SESSION['NAME'] && $value['kind'] == 2) {
        echo '<div class="waiting"><p class="wait_name">' . $value['from'] . '</p><form method="post" class="agree_form"><input type="submit" value="承認" class="submit_agree" name="submit_agree_2"><input type="submit" value="拒否" class="submit_disagree" name="submit_disagree"><input type="hidden" value="' . $value['id'] . '" name="id"><input type="hidden" value="' . $id_count . '" name="id_count"></form><p class="wait_name">' . $value['amount'] . 'hC, 利子' . $value['percentage'] . '%の借金</p>' . '</div>';
      }
      $id_count++;
    }
    ?>
  </div>
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

<!-- コメントアウトされている箇所は借金用のコードです。借金については一度試験的にウェブサイトを運用したのちに追加するかどうか決定します。 -->