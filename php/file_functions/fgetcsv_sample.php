<?php
// ファイルのパス
$filepath = 'products.csv';

// products.csvを読み取り専用で開く
$file = fopen($filepath, 'r');

// 行ごとに取得し表示（fgetcsv関数は区切り文字指定なしの場合、カンマで区切るようになっている）
while ($row = fgetcsv($file, filesize($filepath), ",")) {
    var_dump($row);
    print "<hr>";
}

// ファイルを閉じる
fclose($file);
