<?php
// 商品データ
$products = [
    [
        "name" => "きゅうり",
        "price" => 48,
        "classification" => "vegetable"
    ],
    [
        "name" => "トマト",
        "price" => 137,
        "classification" => "vegetable"
    ],
    [
        "name" => "豚バラ肉",
        "price" => 180,
        "classification" => "meat"
    ],
    [
        "name" => "ビール",
        "price" => 170,
        "classification" => "drink"
    ],
    [
        "name" => "コーヒー",
        "price" => 95,
        "classification" => "drink"
    ]
];

// compareScores関数（自作関数）にしたがってソート
usort($products, 'comparePrice');

// price（値段）にしたがってソートするためのコールバック関数
function comparePrice($a, $b) {
    if ($a['price'] > $b['price']) {
        return 1;  // 第1引数($a)が第2引数($b)よりを大きい場合には1を返す
    } elseif ($a['price'] < $b['price']) {
        return -1;  // 第1引数($a)が第2引数($b)よりを小さい場合には-1を返す
    } else {
        return 0;  // 第1引数($a)と第2引数($b)が等しい場合には0を返す
    }

    // 上の書き方だと冗長なので、宇宙演算子を使うと1行で記述できる（処理の内容は上と同じ）
    // return $a['price'] <=> $b['price'];

    // 降順（値段が高い順）にしたければ$aと$bを逆にするだけでよい
    // return $b['price'] <=> $a['price'];
}

// ソートしたデータを表示
foreach ($products as $product) {
    echo "<p>{$product['name']} : {$product['price']}円</p>";
}
