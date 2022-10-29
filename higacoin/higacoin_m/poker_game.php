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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>higaCoinホーム</title>
</head>

<body>
  <script>
    $(document).ready(function() {
      var windowHeight = window.innerHeight;
      windowHeight = windowHeight * 0.5;
      $('.p1').css('height', windowHeight);
      $('.p2').css('height', windowHeight);
      $('.trump-cover').click(function() {
        $('.trump-cover').slideUp(500);
        setTimeout(() => {
          $('.user_trump').slideDown(500);
        }, 700);
      });
      $('.user_trump').click(function() {
        setTimeout(() => {
          $('.trump-cover').slideDown(500);
        }, 700);
        $('.user_trump').slideUp(500);
      });
      $('.trump-cover_2').click(function() {
        $('.trump-cover_2').slideUp(500);
        setTimeout(() => {
          $('.user_trump_2').slideDown(500);
        }, 700);
      });
      $('.user_trump_2').click(function() {
        setTimeout(() => {
          $('.trump-cover_2').slideDown(500);
        }, 700);
        $('.user_trump_2').slideUp(500);
      });
      $('.trump-cover_3').click(function() {
        $('.trump-cover_3').slideUp(500);
        setTimeout(() => {
          $('.user_trump_3').slideDown(500);
        }, 700);
      });
      $('.user_trump_3').click(function() {
        setTimeout(() => {
          $('.trump-cover_3').slideDown(500);
        }, 700);
        $('.user_trump_3').slideUp(500);
      });
      $('.trump-cover_4').click(function() {
        $('.trump-cover_4').slideUp(500);
        setTimeout(() => {
          $('.user_trump_4').slideDown(500);
        }, 700);
      });
      $('.user_trump_4').click(function() {
        setTimeout(() => {
          $('.trump-cover_4').slideDown(500);
        }, 700);
        $('.user_trump_4').slideUp(500);
      });
      $("input[type=checkbox]").click(function() {
        var $count = $("input[type=checkbox]:checked").length;
        var $not = $('input[type=checkbox]').not(':checked')
        if ($count >= 3) {
          $not.attr("disabled", true);
        } else {
          $not.attr("disabled", false);
        }
      });
    });
  </script>
  <?php
  session_start();
  error_reporting(0);
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['AMOUNT'] == null) {
    header('Location: ./poker_local.php');
  }
  if ($_SESSION['AMOUNT_2'] == null) {
    header('Location: ./poker_local.php');
  }
  if ($_SESSION['DONE'] == 1) {
    header('Location: ./poker_check.php');
  }
  $numbers = $_SESSION['NUMBER'];
  $count_js = $_SESSION['COUNT'];
  $count_js = json_encode($count_js);
  if (!empty($_POST['agree'])) {
    $_SESSION['AGREE'] = 1;
  }
  if ($_SESSION['RANDOM'] == 1) {
    $_SESSION['NUMBER'] = range(1, 52);
    shuffle($_SESSION['NUMBER']);
    $_SESSION['NO_R'] = 1;
    $_SESSION['COUNT'] = 0;
    $_SESSION['RANDOM'] = null;
    header('Location: ./poker_game.php');
  }
  if (!empty($_POST['submit_amount'])) {
    $_SESSION['AMOUNT'] += $_POST['amount'];
    $_SESSION['HIGACOIN'] -= $_POST['amount'];
  }
  if (!empty($_POST['submit_amount2'])) {
    $_SESSION['HIGACOIN_2'] -= $_POST['amount2'];
    $_SESSION['AMOUNT_2'] += $_POST['amount2'];
  }
  if (!empty($_POST['ok'])) {
    if ($_SESSION['COUNT'] == 0) {
      $_SESSION['COUNT']++;
      $_SESSION['AMOUNT_D'] = $_SESSION['AMOUNT'];
      $_SESSION['AMOUNT_D2'] = $_SESSION['AMOUNT_2'];
      header('Location: ./poker_game.php');
    } elseif ($_SESSION['COUNT'] != 4) {
      $difference = $_SESSION['AMOUNT'] - $_SESSION['AMOUNT_D'];
      $difference2 = $_SESSION['AMOUNT_2'] - $_SESSION['AMOUNT_D2'];
      $test = $_SESSION['AMOUNT'] - $_SESSION['AMOUNT_2'];
      if ($test < 0) {
        $test = abs($test);
      }
      if ($test > 500 && $_SESSION['AGREE'] == null) {
        echo '<p class="error_message">相手プレイヤーとの賭け金の差を500hC以内にしてください。</p>
        <form method="post">
        <input type="submit" class="invite ignore" value="無視する" name="agree">
        </form>';
      } else {
        if ($difference >= 100 && $difference2 >= 100) {
          $_SESSION['COUNT']++;
          $_SESSION['AMOUNT_D'] = $_SESSION['AMOUNT'];
          $_SESSION['AMOUNT_D2'] = $_SESSION['AMOUNT_2'];
          $_SESSION['AGREE'] = null;
          header('Location: ./poker_game.php');
        } else {
          echo '<p class="error_message">100hC以上を各ラウンド賭けてください。</p>';
        }
      }
    }
  }
  if (!empty($_POST['submit_ready'])) {
    if (isset($_POST['check_test']) && is_array($_POST['check_test'])) {
      $_SESSION['PAIRS'] = $_POST['check_test'];
      $_SESSION['PAIRS_N'] = count($_SESSION['PAIRS']);
      if ($_SESSION['PAIRS_N'] != 3) {
        echo '<p class="error_message">3つ選択してください。</p>';
      } else {
        $_SESSION['READY'] = 1;
      }
    } else {
      echo '<p class="error_message">項目を選択してください。</p>';
    }
  }
  if (!empty($_POST['submit_ready2'])) {
    if (isset($_POST['check_test2']) && is_array($_POST['check_test2'])) {
      $_SESSION['PAIRS2'] = $_POST['check_test2'];
      $_SESSION['PAIRS_N2'] = count($_SESSION['PAIRS2']);
      if ($_SESSION['PAIRS_N2'] != 3) {
        echo '<p class="error_message">3つ選択してください。</p>';
      } else {
        $_SESSION['READY'] = 2;
      }
    } else {
      echo '<p class="error_message">項目を選択してください。</p>';
    }
  }
  if ($_SESSION['READY'] == 2) {
    header('Location: ./poker_check.php');
  }
  ?>
  <script>
    $(document).ready(function() {
      var count_js = JSON.parse('<?php echo $count_js; ?>');
      if (count_js == 4) {
        $('.user_trump').show();
        $('.trump-cover').hide();
        $('.user_trump_2').show();
        $('.trump-cover_2').hide();
        $('.user_trump_3').show();
        $('.trump-cover_3').hide();
        $('.user_trump_4').show();
        $('.trump-cover_4').hide();
        $('.ok').hide();
        $('.bet').hide();
        $('.bet2').hide();
        $('.bet_s').hide();
        $('.bet_s2').hide();
        $('.fold').hide();
        $('.fold_2').hide();
      }
    });
  </script>
  <div class="area">
    <?php
    if ($_SESSION['COUNT'] >= 1) {
      echo '<img class="area_trump" src="../trump/torannpu-illust' . $numbers[4] . '.jpg">';
      echo '<img class="area_trump" src="../trump/torannpu-illust' . $numbers[5] . '.jpg">';
      echo '<img class="area_trump" src="../trump/torannpu-illust' . $numbers[6] . '.jpg">';
    }
    if ($_SESSION['COUNT'] >= 2) {
      echo '<img class="area_trump" src="../trump/torannpu-illust' . $numbers[7] . '.jpg">';
    }
    if ($_SESSION['COUNT'] >= 3) {
      echo '<img class="area_trump" src="../trump/torannpu-illust' . $numbers[8] . '.jpg">';
    }
    ?>
  </div>
  <div class="p1">
    <?php
    echo '<p class="error_message">' . $_SESSION['NAME'] . '</p>';
    echo '<p class="error_message amount_game">賭け金：' . $_SESSION['AMOUNT'] . '</p>';
    echo '<p class="error_message higacoin_game">所持金：' . $_SESSION['HIGACOIN'] . '</p>';
    echo '<img src="./logo.png" class="trump-cover"></img><img class="user_trump" src="../trump/torannpu-illust' . $numbers[0] . '.jpg">';
    echo '<img src="./logo.png" class="trump-cover_2"></img><img class="user_trump_2" src="../trump/torannpu-illust' . $numbers[1] . '.jpg">';
    if ($_SESSION['COUNT'] == 4 && $_SESSION['READY'] == null) :
    ?>
      <form method="post" class="pairs">
        <p class="error_message">組み合わせを選んでください。</p>
        <input type="checkbox" name="check_test[]" value="1" class="checks">
        <input type="checkbox" name="check_test[]" value="2" class="checks">
        <input type="checkbox" name="check_test[]" value="3" class="checks">
        <input type="checkbox" name="check_test[]" value="4" class="checks">
        <input type="checkbox" name="check_test[]" value="5" class="checks">
        <input type="submit" value="勝負‼︎" class="invite" name="submit_ready">
      </form>
    <?php elseif ($_SESSION['READY'] == 1) : ?>
      <p class="error_message pl1">相手を待っています。</p>
    <?php endif ?>
    <form action="./poker_check.php" method="post">
      <input type="submit" name="fold" value="フォールド" class="fold">
    </form>
    <form method="POST">
      <input type="number" name="amount" class="bet" placeholder="賭け金を入力" min="100" max="<?php echo $_SESSION['HIGACOIN'] - 500 ?>">
      <input type="submit" name="submit_amount" class="bet_s" value="賭ける">
    </form>
  </div>
  <div class="p2">
    <?php
    echo '<p class="error_message player_2_message">' . $_SESSION['NAME_2'] . '</p>';
    echo '<p class="error_message player_2_message amount_game_2">賭け金：' . $_SESSION['AMOUNT_2'] . '</p>';
    echo '<p class="error_message player_2_message higacoin_game_2">所持金：' . $_SESSION['HIGACOIN_2'] . '</p>';
    echo '<img src="./logo.png" class="trump-cover_4"></img><img class="user_trump_4" src="../trump/torannpu-illust' . $numbers[2] . '.jpg">';
    echo '<img src="./logo.png" class="trump-cover_3"></img><img class="user_trump_3" src="../trump/torannpu-illust' . $numbers[3] . '.jpg">';
    if ($_SESSION['READY'] == 1) :
    ?>
      <form method="post" class="pairs2">
        <p class="error_message2">組み合わせを選んでください。</p>
        <input type="checkbox" name="check_test2[]" value="1" class="checks2">
        <input type="checkbox" name="check_test2[]" value="2" class="checks2">
        <input type="checkbox" name="check_test2[]" value="3" class="checks2">
        <input type="checkbox" name="check_test2[]" value="4" class="checks2">
        <input type="checkbox" name="check_test2[]" value="5" class="checks2">
        <input type="submit" value="勝負‼︎" class="invite inv_2" name="submit_ready2">
      </form>
    <?php else : ?>
      <p class="error_message pl2">相手を待っています。</p>
    <?php endif ?>
    <form action="./poker_check.php" method="post">
      <input type="submit" name="fold_2" value="フォールド" class="fold_2">
    </form>
    <form method="POST">
      <input type="number" name="amount2" class="bet2" placeholder="賭け金を入力" min="100" max="<?php echo $_SESSION['HIGACOIN_2'] - 500 ?>">
      <input type="submit" name="submit_amount2" class="bet_s2" value="賭ける">
    </form>
    <form method="POST">
      <input type="submit" value="準備完了" name="ok" class="invite ok">
    </form>
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