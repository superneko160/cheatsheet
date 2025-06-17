<?php
session_start();

// ログイン状態のチェック
if (!isset($_SESSION['user_id'])) {
    die("ログインしていません。");
}

// POST送信されてきた場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // SESSIONのトークンとPOSTされてきたトークンが一致するかを確認
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // トークンが一致しない場合は不正なリクエストとして、以降の処理を拒否
        die("<h1>不正なリクエストです！ (CSRFトークンが一致しません)</h1><p><a href='index.php'>パスワード変更ページに戻る</a></p>");
    }

    // トークンが一度使われたら、セッションから削除することで二重送信や再攻撃を防ぐ（ワンタイムトークン）
    // ただし、ユーザがブラウザの戻るボタンなどで戻った場合にエラーになることがあるため、状況によっては削除しない場合もある
     unset($_SESSION['csrf_token']);

    // === 以降が本当にやりたいこと（パスワード変更処理） ===
    $new_password = $_POST['new_password'];

    // ここでデータベースにパスワードを保存する処理が行われると仮定する
    // 今回は表示のみで、実際の保存はしない
    echo "<h1>パスワード変更完了！</h1>";
    echo "<p>ユーザーID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>新しいパスワード: <span style='color: red; font-weight: bold;'>" . htmlspecialchars($new_password) . "</span> に変更されました。</p>";
    echo "<p><a href='index.php'>パスワード変更ページに戻る</a></p>";

} else {
    echo "<p>このページへの直接のアクセスは禁止されております。</p>";
    echo "<p><a href='index.php'>パスワード変更ページに戻る</a></p>";
}
