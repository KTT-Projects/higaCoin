<?php
// Ajax通信ではなく、直接URLを叩かれた場合はエラーメッセージを表示
if (
    !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    && (!empty($_SERVER['SCRIPT_FILENAME']) && 'json.php' === basename($_SERVER['SCRIPT_FILENAME']))
) {
    die(header('Location: ./'));
}
// 接続文字列 (PHP5.3.6から文字コードが指定できるようになりました)
$dsn = 'mysql:dbname=on294_higacoin;host=mysql90.conoha.ne.jp;charset=utf8';
// ユーザ名
$user = 'on294_higacoin';
// パスワード
$password = 'ktdevsPro406$';
try {
    // nullで初期化
    $users = null;
    // DBに接続
    $dbh = new PDO($dsn, $user, $password);
    // bitcoinテーブルのデータを取得する
    $sql = 'SELECT * FROM bitcoin ORDER BY id DESC';
    $stmt = $dbh->query($sql);
    // 取得したデータを配列に格納
    while ($row = $stmt->fetchObject()) {
        $users[] = array(
            'name' => $row->bitcoin
        );
    }
} catch (PDOException $e) {
    // 例外処理
    die('Error:' . $e->getMessage());
}
header('Content-Type: application/json');
echo json_encode($users);