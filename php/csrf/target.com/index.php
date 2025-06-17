<?php
session_start();

// ログイン（実際にはID/パスワード認証などを行う）
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 'user123';  // ダミーのユーザーID
    echo "<p>ログインしました。（ユーザーID: user123）</p>";
} else {
    echo "<p>すでにログインしています。（ユーザーID: " . $_SESSION['user_id'] . "）</p>";
}

// CSRFトークンがまだセッションにない、または古い場合は新しく生成
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // ランダム文字列を生成
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>攻撃対象サイト（target.com）</title>
</head>
<body>
    <h1>パスワード変更</h1>
    <p>現在のパスワードは仮で「old_password」となっております</p>

    <form action="change_password.php" method="POST">
        <label for="new_password">新しいパスワード:</label>
        <input type="password" id="new_password" name="new_password" required><br>

        <!-- ユーザには見えないようにして、以下のようにランダムな文字列トークンを同じサイトの別ページに送信する -->
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf_token)?>">
        <input type="submit" value="パスワード変更">
    </form>

    <p style="color: red;">※このサイトにはCSRF対策が施されていません。</p>
</body>
</html>
