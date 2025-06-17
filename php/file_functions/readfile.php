<pre>
<?php
/**
 * ファイルの読み込み方（4種類）
 * 1.fread()
 * 2.fgets()
 * 3.file()
 * 4.file_get_contents()
 */

 // 読み込むファイルのパス
$filePath = "readfile_sample.txt";

/**
 * 1.fread関数
 * fread(ファイルハンドル, ファイルサイズ)
 * ファイルの内容を文字列として返す
 * ファイル操作の基本に則って利用する関数（最初にファイルを開き、利用し終わったあと閉じる操作が必要という意味）
 * 
 */
$handle = fopen($filePath, "r");  // ファイルを読み込み専用で開く
$contents = fread($handle, filesize($filePath));  // 読み込み
print $contents;
fclose($handle);  // ファイルを閉じる

print "<hr>";

/**
 * 2.fgets関数
 * fgets(ファイルハンドル)
 * ファイルを行単位で読み込む
 * ファイル操作の基本に則って利用する関数（最初にファイルを開き、利用し終わったあと閉じる操作が必要という意味）
 * 1行ずつ読み込むので行ごとになんらかの処理を施したい場合に利用
 */
$handle = fopen($filePath, "r");  // ファイルを読み込み専用で開く
while ($line = fgets($handle)) {  // 1行ずつ読み込み
    print $line;
}
fclose($handle);  // ファイルを閉じる

print "<hr>";

/**
 * 3.file関数
 * file(ファイルのパス)
 * ファイル全体を読み込んで行ごとに配列に格納する
 * 行ごとに配列に格納したい場合に利用
 * ファイルを開く、閉じるという操作はfile関数内で実装してくれているので記述不要
*/
$contents = file($filePath);
print_r($contents);

print "<hr>";

/**
 * 4.file_get_contents関数
 * file_get_contents(ファイルのパス)
 * ファイルを読み込んで文字列として返す
 * ファイルを開く、閉じるという操作はfile_get_contents関数内で実装してくれているので記述不要
 */
$contents = file_get_contents($filePath);
print $contents;

print "<br>";

/**
 * 補足
 * file_get_contents関数はJSONファイルを読み込めたり、外部URLからデータを読み込むこともできる
 */
$contents = file_get_contents("https://zipcloud.ibsnet.co.jp/api/search?zipcode=9208217");
print $contents;
