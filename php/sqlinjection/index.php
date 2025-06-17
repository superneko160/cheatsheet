<?php
/**
 * ■ プログラムの仕様
 * - ユーザ名とパスワードが一致していれば、ユーザ情報を表示する
 * - だが、SQLインジェクションに対する脆弱性がある
 * 
 * ■ SQLインジェクション
 * - 不正なSQLをWebフォームなどに入力、送信し、データベースを操作する攻撃
 * 
 * ■ SQLインジェクションを実行する方法
 * - パスワードの入力欄に' OR '1'='1を入れてログインボタン押下ですべての全ユーザのデータが表示される
 * 
 * ■ SQLインジェクションで全データが表示された理由
 * - 理由：入力された値と用意されていたSQLをつなげると下のようなSQLになるため
 *  SELECT name, tel, address FROM users WHERE name = '任意のユーザー名' AND password = '' OR '1'='1'
 * 「または（OR）、1が1ならば、ユーザの情報を表示せよ」とつないだことが重要
 *  上のSQL文では、'1'='1' の条件が常に真であるため、全ユーザーの情報が返される
 *  つまり、ユーザ名とパスワードが合致していたら情報を返すという条件は無視される
 * 
 * ■ SQLインジェクションの対策
 * - プレースホルダを利用する
 * （bindValue()やbindParam()で値をバインドしてSQLを実行する）
 *  プレースホルダを利用すると、自動でエスケープ処理を行ってくれるため
 */
require_once 'utils/Database.php';

// フォームからPOST送信されてきた場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DB取得
    $db = Database::getDb();

    // ユーザ名とパスワードが一致した場合、データ（ユーザ名＋TEL＋住所）取得
    // よくないSQLの書き方（プレースホルダを利用していない）
    $name = $_POST['name'];
    $password = $_POST['password'];
    $sql = "SELECT name, tel, address FROM users WHERE name = '$name' AND password = '$password'";
    
    // SQL準備
    $stmt = $db->prepare($sql);
    // SQL実行
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQLインジェクションデモ</title>
</head>
<body>
    <!-- ログインフォーム -->
    <form action="" method="post">
        ユーザ名：<input type="text" name="name" id="name"><br>
        パスワード：<input type="text" name="password" id="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <!-- ログインフォーム -->

    <!-- ユーザ情報表示欄 -->
    <?php if (isset($_POST['name'], $_POST['password'])): ?>
        <?php while ($user = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div style="background:#e6e6fa;padding:4px;margin:5px;">
                <p>ようこそ、<?=$user['name']?>さん！！</p>
                <p>TEL：<?=$user['tel']?></p>
                <p>住所：<?=$user['address']?></p>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    <!-- ユーザ情報表示欄 -->
</body>
</html>
