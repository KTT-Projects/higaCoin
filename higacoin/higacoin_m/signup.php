<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kaisei+HarunoUmi&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="./logo.png">
  <title>ようこそhigaCoinへ</title>
</head>

<body>
  <div class="background">
    <?php
    session_start();
    // ログイン済みを弾く
    if (!empty($_SESSION['LOGIN'])) {
      header('Location: ./');
    }
    // 招待コード照合
    if (!empty($_POST['signup'])) {
      $password_check = $_POST['password'];
      if ($_POST['password'] == 'HiGAcOIN110') {
        $_SESSION['LOGIN'] = 1;
        header('Location: ./');
      } else {
        // エラー時にリダイレクト
        header('Location: ./signup.php');
      }
    }
    ?>
    <main>
      <img src="./logo.png">
      <form method="post">
        <input class="invite no_animation" type="password" name="password" placeholder="招待コードを入力してください"><br>
        <input class="submit" type="submit" value="認証する" name="signup">
      </form>
    </main>
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