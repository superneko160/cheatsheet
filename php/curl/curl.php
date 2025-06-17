<?php
/**
 * ■前提知識
 * curl：ターミナル上で使うコマンドの一つ
 * 下の例のようにcurlというコマンドに続けてURLやオプションを記述して実行すると、そのURLにアクセスして結果を取得したりできる
 * 
 * 例）curl https://zipcloud.ibsnet.co.jp/api/search?zipcode=7830060
 * （上のコマンドをターミナル上で実行すると高知県の住所がJSON形式で返ってくる）
 * 
 * ■curl系組み込み関数
 * PHPからcurlコマンドを実行してくれる関数
 * 
 * ■実行手順
 * 実行手順はファイル処理と似ている
 * ファイル処理：ファイルを開く→ファイルの処理→ファイルを閉じる
 * curl処理：cURLリソース作成→URLやオプション設定→curlを実行してコンテンツ取得→cURLリソースを閉じる
 * 
 * 1. curl_init()でcURLリソースを作成
 * ファイル処理で$handle = fopen("sample.txt", "r")のように書くと$handleにはリソース型と呼ばれるデータが格納されていたがそれと同じようなもの
 * 2~3で使うcurl系関数の引数には、このリソースを渡す
 * 
 * 2. curl_setopt()でURLやオプションを設定
 * 
 * 3. curl_exec()でコンテンツを取得
 * 
 * 4. curl_close()でリソースを閉じる
 */

// 1. cURLリソースを作成
$ch = curl_init();

// 2. URLやオプションを設定
curl_setopt($ch, CURLOPT_URL, "https://zipcloud.ibsnet.co.jp/api/search?zipcode=7830060");

// 3. コンテンツ取得（curl実行）
curl_exec($ch);

// 補足）curl_getinfo()はリクエストに関する情報を配列にして返す。中にはデータはもちろん、ダウンロードにかかった時間やサイズなどが書かれている（exec()実行後に実行）
// $info = curl_getinfo($ch);
// var_dump($info);  // 多様な情報が配列に格納されている

// 4. cURLリソースを閉じる
curl_close($ch);

/**
 * ■curl_setopt()の補足
 * curl_setopt(ハンドル, オプション, 値)
 * ハンドル：$ch = curl_init()で作成した$chのこと
 * オプション：今からこの情報の値を設定しますという設定。上の例ではURLを指定しているので定数CURLOPT_URLを設定（これらの定数はすべてPHP側で用意されているもの。どんな定数があるかは黒本p158参照）
 * 値：そのままの意味。URLを指定する場合はURLを書いてあげる
 */
